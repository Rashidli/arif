<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-translates|create-translates|edit-translates|delete-translates', ['only' => ['index','show']]);
        $this->middleware('permission:create-translates', ['only' => ['create','store']]);
        $this->middleware('permission:edit-translates', ['only' => ['edit']]);
        $this->middleware('permission:delete-translates', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $search = $request->get('search');

        $words = Word::when($search, function($query) use ($search) {
            $query->where('key', 'like', "%{$search}%")
                  ->orWhereTranslationLike('title', "%{$search}%");
        })->orderBy('key')->get();

        return view('admin.words.index', compact('words', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.words.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'az_title'=>'required',
            'en_title'=>'required',
            'ru_title'=>'required',
            'key'=>'required|unique:words',
        ]);


        Word::create([
            'key' => $request->key,
            'az'=>[
                'title'=>$request->az_title,
            ],
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]
        ]);

        return redirect()->route('words.index')->with('message','Tərcümə uğurla əlavə edildi');

    }

    /**
     * Display the specified resource.
     */
    public function show(Word $word)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Word $word)
    {

        return view('admin.words.edit', compact('word'));

    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Word $word)
    {

        $request->validate([
            'az_title'=>'required',
            'en_title'=>'required',
            'ru_title'=>'required',
        ]);


        $word->update( [
            'az'=>[
                'title'=>$request->az_title,
            ],
            'en'=>[
                'title'=>$request->en_title,
            ],
            'ru'=>[
                'title'=>$request->ru_title,
            ]

        ]);

        return redirect()->back()->with('message','Tərcümə uğurla yeniləndi');

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Word $word)
    {
        $word->delete();

        return redirect()->route('words.index')->with('message', 'Tərcümə uğurla silindi');

    }
}
