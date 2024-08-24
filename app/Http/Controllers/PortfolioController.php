<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PortfolioController extends Controller
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
            ['name' => "Portfolio"]
        ];
        $reference = $this->database->getReference('portfolio');
        $portfolioData = $reference->getValue();

        return view('/content/portfolio/index', ['breadcrumbs' => $breadcrumbs, 'portfolio' => $portfolioData]);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $portfolioRef = $this->database->getReference('portfolio');
            $portfolio = $portfolioRef->getValue();

            $data = [];
            if ($portfolio) {
                foreach ($portfolio as $key => $portfolio) {
                    $data[] = [
                        'id' => $key,
                        'name' => $portfolio['name'],
                        'link' => $portfolio['link'],
                        'photo' => $portfolio['photo'] ?? null,
                        'actions' => '<a href="' . route('portfolio.edit', $key) . '" class="btn btn-warning btn-sm">Edit</a> <button type="button" class="btn btn-danger btn-sm" onclick="deleteCertificate(\'' . $key . '\')">Delete</button>',
                    ];
                }
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('photo', function ($row) {
                    return $row['photo'] ? '<img src="' . asset('storage/' . $row['photo']) . '" height="150"/>' : 'No Image';
                })
                ->rawColumns(['photo', 'actions'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "portfolio", 'name' => "Portfolio"],
            ['name' => "Add"]
        ];

        return view('/content/portfolio/add', ['breadcrumbs' => $breadcrumbs]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        // Path ke mana data akan disimpan
        $reference = $this->database->getReference('portfolio');

        // Ambil data yang ada dari Firebase
        $existingData = $reference->getValue();

        if ($request['file']) {
            $fileName = time() . '_' . $request['file']->getClientOriginalName();
            $filePath = $request['file']->storeAs('portfolio', $fileName, 'public');

            $newCertificateId = $reference->push()->getKey();

            // Data yang akan disimpan
            $reference->getChild($newCertificateId)->set([
                'name' => $request->input('name'),
                'link' => $request->input('link'),
                'photo' => $filePath,
            ]);

            return redirect()->route('portfolio')->with('success', 'Data berhasil ditambahkan!');
        }

        return back()->with('error', 'Gagal Update Data.');
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
        // Ambil data portfolio berdasarkan ID dan return ke view edit
        $portfolio = $this->database->getReference('portfolio/' . $id)->getValue();
        return view('/content/portfolio/edit', compact('portfolio', 'id'));
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
        // Validasi dan update data portfolio
        $validatedData = $request->validate([
            'name' => 'required',
            'link' => 'required',
            'photo' => 'nullable|image',
        ]);

        $updates = [
            'name' => $request->input('name'),
            'link' => $request->input('link'),
        ];

        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $updates['photo'] = $filePath;
        }

        $this->database->getReference('portfolio/' . $id)->update($updates);

        return redirect()->route('portfolio')->with('success', 'portfolio updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Hapus data portfolio berdasarkan ID
        $this->database->getReference('portfolio/' . $id)->remove();
        return response()->json(['success' => 'portfolio deleted successfully.']);
    }
}
