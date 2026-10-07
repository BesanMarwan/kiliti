<?php

namespace App\Http\Controllers\Admin\MedicationManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MedicationRequest;
use App\Models\GeneralData;
use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function index(Request $request){
        $out =  Medication::orderByDESC('id')
                      ->filter($request)
                      ->paginate(20)
                      ->appends(\request()->all());

        $activeLink ='medications';

        return view('admin.medicationManagement.medications.index',compact('out','activeLink'));
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
        $activeLink      = 'medications';
        $general_item    = GeneralData::where('uuid','drug_categories')->first();
        $drug_categories = GeneralData::where('parent_id',$general_item->id)->get();
        return view('admin.medicationManagement.medications.create',compact('activeLink','drug_categories'));
    }

    public function store(MedicationRequest $request){

        Medication::create([
            'name'            => ['ar'=>$request->name_ar,'en'=>$request->name_en],
            'image'           => $request->image,
            'description'     => $request->description,
            'important_alert' => $request->important_alert,
            'category_id'     => $request->category_id,
        ]);
        return ['done'=>1];

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
