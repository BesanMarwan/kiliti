<?php

namespace App\Services;

use App\Actions\ApiActions;
use App\Constants\ResponseCode;
use App\Enums\FamilyInvitationStatus;
use App\Models\FamilyInvitation;
use App\Models\FamilyMember;
use App\Models\FamilyPermission;
use App\Models\PatientFamilyMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FamilyInvitationService
{
    /**
     * Register a new family user and accept the invitation.
     */
    public function register(FamilyInvitation $invitation, string $name, string $password): array
    {
        $result = DB::transaction(function () use ($invitation,$name,$password) {

            DB::beginTransaction();
            /*
             * 1. Create User
             */
            $user = User::create([
                'name' => $name,
                'mobile' => $invitation->mobile,
                'password' => Hash::make($password),
                'role' => 'family',
                'status' => 'enabled',
                'register_step' => 'finish',
                'is_register_end' => true,
            ]);


            /*
             * 2. Create FamilyMember
             */
            $familyMember = FamilyMember::create([
                'user_id'      => $user->id,
                'relationship' => $invitation->relationship,

            ]);

            /*
             * 3. Create relation between patient and family member
             */
            $patientFamilyMember = PatientFamilyMember::create([
                'patient_id'       => $invitation->patient_id,
                'family_member_id' => $familyMember->id,
                'relationship'     => $invitation->relationship,
                'status'           => 'active',
            ]);

            /*
             * 4. Copy invitation permissions
             */
            foreach ($invitation->permissions as $invitationPermission) {
                FamilyPermission::create([
                    'patient_family_member_id' => $patientFamilyMember->id,
                    'permission_type_id'       => $invitationPermission->permission_type_id,
                ]);
            }

            /*
             * 5. Mark invitation as accepted
             */
            $invitation->update([
                'status'              => FamilyInvitationStatus::ACCEPTED,
                'accepted_at'         => now(),
                'accepted_by_user_id' => $user->id,
            ]);

            /*
             * 6. Create Sanctum token
             */
            $user->accessToken = $user->createToken('User_' . $user->id . '_' . Carbon::now()->toDateTimeString())->plainTextToken;

            $user->save();
            DB::commit();

            return [
                'user' => $user,
                'family_member' => $familyMember,
                'patient_family_member' => $patientFamilyMember,
            ];
        });
        return $result;
    }

    /**
     * Accept invitation for an existing family user.
     */
    public function accept(FamilyInvitation $invitation, User $user)
    {

        $result = DB::transaction(function () use ($user, $invitation) {

            /*
             * 6. Get or create FamilyMember.
             */
            $familyMember = FamilyMember::firstOrCreate([
                'user_id' => $user->id,
            ]);

            /*
             * 7. Make sure this relationship
             * does not already exist.
             */
            $existingRelation = PatientFamilyMember::where('patient_id', $invitation->patient_id)
                ->where('family_member_id', $familyMember->id)
                ->first();

            if ($existingRelation) {
                return ApiActions::generateResponse(null, 'This_family_member_is_already_connected_to_this_patient', ResponseCode::CONFLICT_ERROR);
            }

            /*
             * 8. Create patient-family relationship.
             */
            $patientFamilyMember = PatientFamilyMember::create([
                'patient_id' => $invitation->patient_id,
                'family_member_id' => $familyMember->id,
                'relationship' => $invitation->relationship,
                'status' => 'active',
            ]);

            /*
             * 9. Copy invitation permissions.
             */
            foreach ($invitation->permissions as $invitationPermission) {

                FamilyPermission::create([
                    'patient_family_member_id' => $patientFamilyMember->id,
                    'permission_type_id' => $invitationPermission->permission_type_id,
                ]);
            }

            /*
             * 10. Mark invitation as accepted.
             */
            $invitation->update([
                'status' => FamilyInvitationStatus::ACCEPTED,
                'accepted_at' => now(),
                'accepted_by_user_id' => $user->id,
            ]);
            return $patientFamilyMember;

//            return [
//                'patient_id' => $patientFamilyMember->patient_id,
//                'family_member_id' => $patientFamilyMember->family_member_id,
//                'relationship' => $patientFamilyMember->relationship,
//            ];
        });
        return $result;

    }
}
