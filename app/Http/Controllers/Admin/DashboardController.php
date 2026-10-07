<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdherenceRecord;
use App\Models\Admin;
use App\Models\Category;
use App\Models\DialysisCenter;
use App\Models\DialysisSession;
use App\Models\Doctor;
use App\Models\FluidAlert;
use App\Models\FluidLog;
use App\Models\Patient;
use App\Models\PatientFamilyMember;
use App\Models\PatientMedication;
use App\Models\PatientSymptom;
use App\Models\Symptom;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {

        if(request()->get('mode') == 'dark'){
            session(['mode'=>'dark']);
        }
        if(request()->get('mode') == 'light'){
            session(['mode'=>'light']);
        }
        $today = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | Main Statistics
        |--------------------------------------------------------------------------
        */

        $totalPatients = Patient::count();

        $activePatients = Patient::whereHas('user', function ($query) {
            $query->where('status', 'enabled');
        })->count();

        $inactivePatients = $totalPatients - $activePatients;

        $totalDoctors = Doctor::count();

        $totalCenters = DialysisCenter::count();

        $totalCenterStaff = User::where('role', 'center_staff')->count();

        $totalDialysisSessions = DialysisSession::count();

        $totalMedications = PatientMedication::count();

        $totalNotifications = auth()->user()->new_notifications()->count();

        $totalFamilyMembers = PatientFamilyMember::count();


        /*
        |--------------------------------------------------------------------------
        | Today's Statistics
        |--------------------------------------------------------------------------
        */

        $todayDialysisSessions = DialysisSession::whereDate(
            'scheduled_at',
            $today
        )->count();

        $todayScheduledMedications = PatientMedication::whereDate(
            'start_date',
            '<=',
            $today
        )->count();

        $todayMedicationTaken = DB::table('medication_logs')
            ->whereDate('scheduled_at', $today)
            ->where('status', 'taken')
            ->count();

        $todayMedicationMissed = DB::table('medication_logs')
            ->whereDate('scheduled_at', $today)
            ->where('status', 'missed')
            ->count();

        $todayFluidAlerts = FluidAlert::whereDate('created_at', $today)->count();

        $todaySymptoms = PatientSymptom::whereDate(
            'recorded_at',
            $today
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Patients Requiring Follow Up
        |--------------------------------------------------------------------------
        */

        $patientsNeedingFollowUp = Patient::with([
            'user',
            'doctors.user',
            'centers',
        ])
            ->where(function ($query) {
                $query
                    ->whereHas('adherenceRecords', function ($q) {
                        $q->where('overall_score', '<', 60);
                    })
                    ->orWhereHas('fluidAlerts')
                    ->orWhereHas('dialysisSessions', function ($q) {
                        $q->where('status', 'missed');
                    });
            })
            ->latest()
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Adherence Chart - Last 7 Days
        |--------------------------------------------------------------------------
        */

        $adherenceLabels = [];
        $adherenceData = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::today()->subDays($i);

            $adherenceLabels[] = $date->format('D');

            $score = AdherenceRecord::whereDate(
                'date',
                $date
            )->avg('overall_score');

            $adherenceData[] = round($score ?? 0, 1);
        }


        /*
        |--------------------------------------------------------------------------
        | Dialysis Sessions - Last 7 Days
        |--------------------------------------------------------------------------
        */

        $dialysisLabels = [];
        $dialysisData = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::today()->subDays($i);

            $dialysisLabels[] = $date->format('D');

            $dialysisData[] = DialysisSession::whereDate(
                'scheduled_at',
                $date
            )->count();
        }


        /*
        |--------------------------------------------------------------------------
        | Medication Statistics
        |--------------------------------------------------------------------------
        */

        $medicationTaken = DB::table('medication_logs')
            ->where('status', 'taken')
            ->count();

        $medicationMissed = DB::table('medication_logs')
            ->where('status', 'missed')
            ->count();

        $medicationUpcoming = DB::table('medication_logs')
            ->where('status', 'pending')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Patient Status
        |--------------------------------------------------------------------------
        */

        $patientStatus = [
            'active' => $activePatients,
            'inactive' => $inactivePatients,
        ];


        /*
        |--------------------------------------------------------------------------
        | Recent Dialysis Sessions
        |--------------------------------------------------------------------------
        */

        $recentDialysisSessions = DialysisSession::with([
            'patient.user',
            'doctor.user',
            'center',
        ])
            ->latest('scheduled_at')
            ->limit(8)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Symptoms
        |--------------------------------------------------------------------------
        */

//        $recentSymptoms = Symptom::with([
//            'patientSymptoms.patient.user',
//        ])
//            ->latest()
//            ->limit(8)
//            ->get();

        $recentSymptoms = PatientSymptom::with([
            'patient.user',
            'symptom',
        ])
            ->latest('recorded_at')
            ->limit(8)
            ->get();


        return view('admin.dashboard', compact(

        // Main statistics
            'totalPatients',
            'activePatients',
            'inactivePatients',
            'totalDoctors',
            'totalCenters',
            'totalCenterStaff',
            'totalDialysisSessions',
            'totalMedications',
            'totalNotifications',
            'totalFamilyMembers',

            // Today
            'todayDialysisSessions',
            'todayScheduledMedications',
            'todayMedicationTaken',
            'todayMedicationMissed',
            'todayFluidAlerts',
            'todaySymptoms',

            // Follow up
            'patientsNeedingFollowUp',

            // Charts
            'adherenceLabels',
            'adherenceData',
            'dialysisLabels',
            'dialysisData',

            // Medication
            'medicationTaken',
            'medicationMissed',
            'medicationUpcoming',

            // Patient status
            'patientStatus',

            // Recent
            'recentDialysisSessions',
            'recentSymptoms',
        ));

    }



    public function changeLanguage($lang){

        app()->setLocale($lang);
        return redirect()->back();


    }



}

