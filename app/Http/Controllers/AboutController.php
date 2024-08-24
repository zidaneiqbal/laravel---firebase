<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    protected $database;

    public function __construct()
    {
        // $this->database = \App\Services\FirebaseService::connect();
        $this->database = app('firebase')->createDatabase();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['name' => "About"]
        ];
        $reference = $this->database->getReference('about');
        $aboutData = $reference->getValue();

        return view('/content/about', ['breadcrumbs' => $breadcrumbs, 'about' => $aboutData]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'description' => 'required',
        ]);

        // Path ke mana data akan disimpan
        $reference = $this->database->getReference('about');

        // Ambil data yang ada dari Firebase
        $existingData = $reference->getValue();

        if ($request['file']) {
            $fileName = time().'_'.$request['file']->getClientOriginalName();
            $filePath = $request['file']->storeAs('uploads', $fileName, 'public');

            $reference->set([
                'description' => $request['description'],
                'file_photo' => $filePath,
            ]);

            return back()->with('success', 'Sukses Update Data.');
        } else {
            // Data yang akan disimpan
            $reference->set([
                'description' => $request['description'],
                'file_photo' => $existingData['file_photo']
            ]);

            return back()->with('success', 'Sukses Update Data.');
        }

        return back()->with('error', 'Gagal Update Data.');

        // return response()->json('Updated');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
