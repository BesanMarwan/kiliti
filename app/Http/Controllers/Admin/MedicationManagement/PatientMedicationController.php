<?php

namespace App\Http\Controllers\Admin\MedicationManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MedicationRequest;
use App\Http\Requests\Admin\StorePatientMedicationRequest;
use App\Models\Doctor;
use App\Models\GeneralData;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\PatientMedication;
use App\Services\MedicationScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PatientMedicationController extends Controller
{
    public function index(Request $request){
        $out =  PatientMedication::latest()
                      ->with(['doctor','patient.user','medication'])
                      ->filter($request)
                      ->paginate(20)
                      ->appends(\request()->all());


        $activeLink ='patient_medications';


        return view('admin.medicationManagement.patientMedications.index',compact('out','activeLink'));
    }


    public function delete(Request $request)
    {
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }


        $deleted_count = PatientMedication::query()->whereIn('id',$ids)->delete();

        return ['done' => 1];
    }

    public function stopped(Request $request)
    {

        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        PatientMedication::query()->whereIn('id',$ids)->update(['status' =>'stopped']);

        return ['done' => 1];
    }


    public function activate(Request $request)
    {

        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        PatientMedication::query()->whereIn('id',$ids)->update(['status' =>'active']);

        return ['done' => 1];
    }

    public function create(){
        $patients = Patient::query()
            ->with('user:id,name')
            ->whereHas('user', function ($query) {
                $query->where('status', 'enabled');
            })
            ->get()
            ->sortBy(
                fn ($patient) => $patient->user?->name
            )
            ->values();

        $medications = Medication::query()
            ->where('status', 'enabled')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'status',
            ]);

        $doctors = Doctor::query()
            ->with('user:id,name')
            ->whereHas('user', function ($query) {
                $query->where('status', 'enabled');
            })
            ->get()
            ->sortBy(
                fn ($doctor) => $doctor->user?->name
            )
            ->values();
        $activeLink ='patient_medications';
        return view('admin.medicationManagement.patientMedications.create',compact('activeLink','patients','doctors','medications'));
    }



    public function store(StorePatientMedicationRequest $request, MedicationScheduleService $medicationScheduleService) {

        $data = $request->validatedData();

        $patientMedication = PatientMedication::create($data);

        if ($patientMedication->status === 'active' && $patientMedication->reminder_enabled && !empty($patientMedication->reminder_times)) {
            $from = Carbon::parse(
                $patientMedication->start_date,
                'Asia/Gaza'
            );

            $to = $patientMedication->end_date
                ? Carbon::parse(
                    $patientMedication->end_date,
                    'Asia/Gaza'
                )
                : now('Asia/Gaza')->addDays(7);

            $medicationScheduleService->generateForPeriod($patientMedication, $from, $to);
        }

        flash('تمت إضافة الدواء وجدولة مواعيد الجرعات بنجاح.');
        return redirect()->route('system.patient_medications.index');
    }

    public function show(PatientMedication $patientMedication)
    {

        $patientMedication->load(['patient.user', 'medication', 'doctor.user']);

        return view('admin.patient-medications.show', compact('patientMedication'));

    }

    public function showUpdateView($id){
        $medication      = Medication::findOrFail($id);
        $general_item    = GeneralData::where('uuid','drug_categories')->first();
        $drug_categories = GeneralData::where('parent_id',$general_item->id)->get();
        $activeLink ='patient_medications';
        return view('admin.medications.update',compact('activeLink','drug_categories','medication'));
    }
    public function update(MedicationRequest $request,$id){

        Medication::findOrFail($id)->update([
            'name'            => ['ar'=>$request->name_ar,'en'=>$request->name_en],
            'image'           => $request->image,
            'description'     => ['ar'=>$request->description_ar,'en'=>$request->description_en],
            'important_alert' => ['ar'=>$request->important_alert_ar,'en'=>$request->important_alert_en],
            'category_id'     => $request->category_id,
        ]);

        return ['done'=>1];


    }
}
