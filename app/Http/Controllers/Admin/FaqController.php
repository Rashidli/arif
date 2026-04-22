<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-faqs|create-faqs|edit-faqs|delete-faqs', ['only' => ['index','show']]);
        $this->middleware('permission:create-faqs', ['only' => ['create','store']]);
        $this->middleware('permission:edit-faqs', ['only' => ['edit']]);
        $this->middleware('permission:delete-faqs', ['only' => ['destroy']]);
    }

    public function index()
    {
        $faqs = Faq::latest()->paginate(10);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'az_question' => 'required',
            'en_question' => 'required',
            'ru_question' => 'required',
            'az_answer' => 'required',
            'en_answer' => 'required',
            'ru_answer' => 'required',
        ]);

        Faq::create([
            'is_active' => $request->boolean('is_active', true),
            'az' => [
                'question' => $request->az_question,
                'answer' => $request->az_answer,
            ],
            'en' => [
                'question' => $request->en_question,
                'answer' => $request->en_answer,
            ],
            'ru' => [
                'question' => $request->ru_question,
                'answer' => $request->ru_answer,
            ],
        ]);

        return redirect()->route('faqs.index')->with('message', 'FAQ uğurla əlavə edildi');
    }

    public function show(Faq $faq)
    {
        //
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'az_question' => 'required',
            'en_question' => 'required',
            'ru_question' => 'required',
            'az_answer' => 'required',
            'en_answer' => 'required',
            'ru_answer' => 'required',
        ]);

        $faq->update([
            'is_active' => $request->boolean('is_active'),
            'az' => [
                'question' => $request->az_question,
                'answer' => $request->az_answer,
            ],
            'en' => [
                'question' => $request->en_question,
                'answer' => $request->en_answer,
            ],
            'ru' => [
                'question' => $request->ru_question,
                'answer' => $request->ru_answer,
            ],
        ]);

        return redirect()->back()->with('message', 'FAQ uğurla yeniləndi');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('faqs.index')->with('message', 'FAQ uğurla silindi');
    }
}
