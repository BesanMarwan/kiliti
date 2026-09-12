<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CityRequest;
use App\Http\Requests\CategoryRequest;
use App\Models\City;
use App\Models\PaymentType;
use App\Rules\ValidString;
use App\Rules\ValidStringArabic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function index(Request $request){

        $out =  PaymentType::orderByDESC('id')
                 ->paginate(20);

        $activeLink ='payments';

        return view('admin.payments.index',compact('out','activeLink'));
    }



    public function activate(Request $request)
    {

        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

        PaymentType::query()->whereIn('id',$ids)->update(['status' =>'enabled']);

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


        PaymentType::query()->whereIn('id',$ids)->update(['status' =>'disabled']);

        return ['done' => 1];
    }



    public function showUpdateView($id){
        $payment    = PaymentType::findOrFail($id);
        $activeLink = 'payments';
        return view('admin.payments.update',compact('activeLink','payment'));
    }
    public function update(Request $request,$id)
    {

        $request->validate([
            'name_ar' => ['required', Rule::unique('payment_types', 'name->ar')->ignore($request->id), new ValidStringArabic()],
            'name_en' => ['required', Rule::unique('payment_types', 'name->en')->ignore($request->id), new ValidString()]
        ]);

        PaymentType::findOrFail($id)->update([
            'name' => ['ar' => $request->name_ar, 'en' => $request->name_en],
            'icon' => $request->image,
        ]);

        return ['done' => 1];


    }
}

