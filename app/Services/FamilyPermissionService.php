<?php

namespace App\Services;

use App\Models\FamilyPermission;
use App\Models\FamilyPermissionType;
use App\Models\PatientFamilyMember;
use Illuminate\Support\Facades\DB;

class FamilyPermissionService
{
    public function update(PatientFamilyMember $patientFamilyMember, array $permissions): PatientFamilyMember
    {

        return DB::transaction(function () use ($patientFamilyMember, $permissions) {

            $permissionTypeIds = FamilyPermissionType::query()
                ->whereIn('name', $permissions)
                ->pluck('id');

            FamilyPermission::query()->where('patient_family_member_id', $patientFamilyMember->id)->delete();

            foreach ($permissionTypeIds as $permissionTypeId) {
                FamilyPermission::create([
                      'patient_family_member_id' => $patientFamilyMember->id,
                      'permission_type_id'       => $permissionTypeId,
                ]);
            }

            return $patientFamilyMember->load(['familyMember.user', 'permissions.permissionType']);
        });
    }


    public function revoke(PatientFamilyMember $patientFamilyMember): PatientFamilyMember {

        return DB::transaction(function () use ($patientFamilyMember) {

            FamilyPermission::query()->where('patient_family_member_id', $patientFamilyMember->id)->delete();

            $patientFamilyMember->update(['status' => 'revoked']);

            return $patientFamilyMember->load(['familyMember.user']);
        });
    }
}
