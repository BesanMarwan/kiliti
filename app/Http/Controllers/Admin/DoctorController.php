<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CenterRequest;
use App\Models\DialysisCenter;
use App\Models\Doctor;
use Illuminate\Http\Request;



class DoctorController extends Controller
{


    public function index(Request $request)
    {
        $doctors = Doctor::filter($request)
                                  ->with(['user','dialysisCenter'])
                                  ->withCount('patients')
                                  ->latest('id')
                                  ->paginate(20)
                                  ->appends(\request()->all());

        return view('admin.doctors.index', compact('doctors'));
    }

    public function details($id){

      $doctor =  Doctor::with(['user','dialysisCenter'])->findOrFail($id);
      return view('admin.doctors.details',compact('doctor'));
    }

//    public function delete(Request $request)
//    {
//        $ids=[];
//        if(is_array($request->id)){
//            $ids=$request->id;
//        }else{
//            $ids[]=$request->id;
//        }
//
////        SMS::whereIn('user_id',$ids)->delete();
//
//        User::destroy($ids);
//
//        return ['done'=>1];
//    }



    public function activate(Request $request)
    {

        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        $doctors  = Doctor::query()->whereIn('id',$ids);
        User::query()->whereIn('id',$ids)->update(['status' =>'enabled']);

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

        DialysisCenter::query()->whereIn('id',$ids)->update(['status' =>'disabled']);

        return ['done' => 1];
    }

    public function temporarilyClosed (Request $request)
    {
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        DialysisCenter::query()->whereIn('id',$ids)->update(['status' =>'temporarily_closed']);

        return ['done' => 1];
    }


    public function showCreateView()
    {
        return view('admin.centers.create');
    }

    public function store(CenterRequest $request)
    {
        $center                    = new DialysisCenter();
        $center->name              = $request->name;
        $center->phone             = $request->phone;
        $center->governorate       = $request->governorate;
        $center->city              = $request->city;
        $center->address           = $request->address;
        $center->total_machines    = $request->total_machines;
        $center->working_machines  = $request->working_machines;
        $center->status            = $request->status;
        $center->save();

        flash('تم اضافة مركز غسيل الكلى بنجاح');
        return redirect()->route('system.centers.index');

    }
    public function showUpdateView($id)
    {
        $center = DialysisCenter::findOrFail($id);
        return view('admin.centers.update',compact('center'));
    }

    public function update(CenterRequest $request,$id)
    {

        $center = DialysisCenter::findOrFail($id);
        $center->update([
            'name'              => $request->name,
            'phone'             => $request->phone,
            'governorate'       => $request->governorate,
            'city'              => $request->city,
            'address'           => $request->address,
            'total_machines'    => $request->total_machines,
            'working_machines'  => $request->working_machines,
            'status'            => $request->status
        ]);
        flash('تم تعديل مركز تشغيل الكلى بنجاح');
        return redirect()->route('system.centers.index');
    }


}
