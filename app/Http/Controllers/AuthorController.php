<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Validator;

class AuthorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authors = $request->sort ? Author::orderBy('surname')->get() : Author:: all();
       // $authors = Author::all();
       if ('name' == $request->sort) {
           $authors = Author::orderBy('name')->get();
        } elseif ('surname' == $request->sort) {
            $authors = Author::orderBy('surname')->get();
        } else {
            $authors = Author::all();
        }

       $authors = Author::orderBy('surname', 'desc')->get(); //rusiavimo metodas
        //desc rusiuoja atvirksciai
// dd($authors);


       return view('author.index', ['authors' => $authors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('author.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//VALIDACIJA
       $validator = Validator::make(
        $request->all(),
       [
           'author_name' => ['required', 'min:2', 'max:64', 'alpha'],
           'author_surname' => ['required', 'min:3', 'max:64', 'alpha'],
       ],

       [
        'author_surname.required' => 'idek pavarde',
        'author_surname.min' => 'per trumpa pavarde',
        'author_name.alpha' => 'only letters'
        ]
       );

       if ($validator->fails()) {
           $request->flash();
           return redirect()->back()->withErrors($validator);
       }

        Author::create($request);
        return redirect()->route('author.index')->with('success_message', 'The Author has been created. Nice job!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        return view('author.edit', ['author' => $author]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        // VALIDACIJA
        $validator = Validator::make(
            $request->all(),
           [
               'author_name' => ['required', 'min:2', 'max:64'],
               'author_surname' => ['required', 'min:3', 'max:64'],
           ],
    
           [
            'author_surname.required' => 'idek pavarde',
            'author_surname.min' => 'per trumpa pavarde'
            ]
           );
    
           if ($validator->fails()) {
               $request->flash();
               return redirect()->back()->withErrors($validator);
           }


        $author->edit($request);
        return redirect()->route('author.index')->with('success_message', 'The Author was renamed.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        if($author->authorBooksList->count() !== 0) { //kolekcija su knygom
            return redirect()->back()->with('info_message', 'The author is immortal. You cant delete him');
        }

        $author->delete();
        return redirect()->route('author.index')->with('info_message', 'The author has been killed');
    }
}
