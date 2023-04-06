<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class WordController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Dictionary', [
            'words' => Word::query()
            ->orderBy('id', 'desc')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('italian', 'like', "%{$search}%")
                      ->orWhere('english', 'like', "%{$search}%");
            })
            ->paginate(6)
            ->withQueryString()
            ->through(fn ($dictionary) => [
                    'id' => $dictionary->id,
                    'italian' => $dictionary->italian,
                    'english' => $dictionary->english,
                    'description' => $dictionary->description,
            ]),
            'filters' => $request->input('search'),

        ]);
    }
    public function create()
    {
        return Inertia::render('Dictionary/Create');
    }

    public function store(Request $request)
    {
        
        $data = $request->validate([
            'italian' => 'required|unique:words',
            'english' => 'required',
            'description' => '',
        ]);
        Word::create($data);
        return redirect()->back();
    }

    public function edit(Word $word)
    {
       
        return Inertia::render('Dictionary/Edit', [
            'words' => $word
        ]);
    }

    public function update(Request $request)
    {        
        $word = Word::findOrFail($request->id);
        if ($word->italian !== $request->italian) {
            $data = $request->validate([
                'italian' => 'required|unique:words',
                'english' => 'required',
                'description' => '',
            ]);
        } else {
            $data = $request->validate([
                'italian' => '',
                'english' => 'required',
                'description' => '',
            ]);
        }
    
        $word->update($data);
        return Redirect::route('index');
    }
    
    public function destroy(Word $word)
    {
        $word->delete();
    }
}
