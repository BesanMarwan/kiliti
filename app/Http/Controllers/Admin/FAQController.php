<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\FAQ;
use App\Rules\ValidString;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exceptions\ItemNotFound;
use App\Rules\ValidStringArabic;
use App\Http\Requests\Admin\FAQRequest;
use App\Models\ClientConsult;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class FAQController
 * @package App\Http\Controllers\Admin
 */
class FAQController extends Controller
{

    public function index(Request $request)
    {
        $out = FAQ::latest()
                   ->filter($request)
                   ->paginate(20)
                   ->appends(\request()->all());

        return view('admin.faq.index', compact('out'));
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {

        Faq::create([
            'question' => ['ar' => $request->question_ar, 'en' => $request->question_en],
            'answer' => ['ar' => $request->answer_ar, 'en' => $request->answer_en],
        ]);
        return ['done'=>1];


    }

    public function showUpdateView($id)
    {
        $faq = FAQ::findOrFail($id);
        return view('admin.faq.update', compact('faq'));
    }


    public function Update(FAQRequest $request, $id)
    {

        $item = FAQ::findOrfail($id);

        $item->update([
            'question' => ['ar' => $request->question_ar, 'en' => $request->question_en],
            'answer'   => ['ar' => $request->answer_ar, 'en' => $request->answer_en],
        ]);
        return ['done'=>1];


    }


    public function delete(Request $request)
    {
        $ids = [];
        if (is_array($request->id)) {
            $ids = $request->id;
        } else {
            $ids[] = $request->id;
        }

       FAQ::destroy($ids);

        return ['done' => 1];

    }
}
