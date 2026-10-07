<?php

namespace App\Http\Controllers\Admin\DialysisSessionManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MedicationRequest;
use App\Http\Requests\Admin\StoreDialysisSessionScheduleRequest;
use App\Http\Requests\Admin\StoreDialysisSessionsRequest;
use App\Models\DialysisCenter;
use App\Models\DialysisSession;
use App\Models\Doctor;
use App\Models\GeneralData;
use App\Models\Medication;
use App\Models\Patient;
use App\Services\DialysisSessionGenerationService;
use Illuminate\Http\Request;

class DialysisSessionController extends Controller
{
    public function index(Request $request){
        $out =  DialysisSession::orderByDESC('id')
                           ->with(['patient','doctor','center'])
                           ->filter($request)
                           ->paginate(20)
                          ->appends(\request()->all());

        $activeLink ='dialysis_sessions';

        return view('admin.dialysisSessionManagement.sessions.index',compact('out','activeLink'));
    }


    public function delete(Request $request)
    {
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }


        $deleted_count = Medication::query()->whereIn('id',$ids)->delete();

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

        Medication::query()->whereIn('id',$ids)->update(['status' =>'enabled']);

        return ['done' => 1];
    }
    public function deactivate (Request $request)
    {
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }


        Medication::query()->whereIn('id',$ids)->update(['status' =>'disabled']);

        return ['done' => 1];
    }

    public function create(){
        $activeLink  = 'dialysis_sessions';
//        $patients    = Patient::with('user')->orderBy('id', 'desc')->get();

        $patients = Patient::with(['user', 'centers', 'doctors.user'])
            ->withCount([
                'dialysisSessions as active_sessions_count' => function ($query) {
                    $query->where('status', '!=', 'cancelled');
                }
            ])
            ->orderByDesc('id')
            ->get();
        return view('admin.dialysisSessionManagement.sessions.create',compact('activeLink','patients'));
    }


    public function store(StoreDialysisSessionScheduleRequest $request, DialysisSessionGenerationService $generationService) {
//        try {

            $created = $generationService->generate($request->all());

            return redirect()->route('system.dialysis_sessions.index')->with('success', "تم إنشاء {$created} جلسة غسيل بنجاح.");

//        } catch (\Illuminate\Validation\ValidationException $e) {
//            dd($e);
//
//            return back()->withErrors($e->errors())->withInput();
//
//        } catch (\Throwable $e) {
//            report($e);
//            return back()->withInput()->with('error', 'حدث خطأ أثناء إنشاء جلسات الغسيل، يرجى المحاولة مرة أخرى.');
//        }
    }
    public function showUpdateView($id){
        $medication      = Medication::findOrFail($id);
        $general_item    = GeneralData::where('uuid','drug_categories')->first();
        $drug_categories = GeneralData::where('parent_id',$general_item->id)->get();
        $activeLink ='medications';
        return view('admin.medicationManagement.medications.update',compact('activeLink','drug_categories','medication'));
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
