<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CertificateController extends Controller
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
            ['name' => "Certificates"]
        ];
        $reference = $this->database->getReference('certificates');
        $certificatesData = $reference->getValue();

        return view('/content/certificates/index', ['breadcrumbs' => $breadcrumbs, 'certificates' => $certificatesData]);
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $certificatesRef = $this->database->getReference('certificates');
            $certificates = $certificatesRef->getValue();

            $data = [];
            if ($certificates) {
                foreach ($certificates as $key => $certificate) {
                    $data[] = [
                        'id' => $key,
                        'name' => $certificate['name'],
                        'photo' => $certificate['photo'] ?? null,
                        'actions' => '<a href="' . route('certificates.edit', $key) . '" class="btn btn-warning btn-sm">Edit</a> <button type="button" class="btn btn-danger btn-sm" onclick="deleteCertificate(\'' . $key . '\')">Delete</button>',
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
            ['link' => "certificates", 'name' => "Certificates"],
            ['name' => "Add"]
        ];

        return view('/content/certificates/add', ['breadcrumbs' => $breadcrumbs]);
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
        $reference = $this->database->getReference('certificates');

        // Ambil data yang ada dari Firebase
        $existingData = $reference->getValue();

        if ($request['file']) {
            $fileName = time() . '_' . $request['file']->getClientOriginalName();
            $filePath = $request['file']->storeAs('certificates', $fileName, 'public');
            // $request['file']->move(public_path('certificates'), $fileName);

            $newCertificateId = $reference->push()->getKey();

            // Data yang akan disimpan
            $reference->getChild($newCertificateId)->set([
                'name' => $request->input('name'),
                'photo' => $filePath,
            ]);

            return redirect()->route('certificates')->with('success', 'Data berhasil ditambahkan!');
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
        // Ambil data certificate berdasarkan ID dan return ke view edit
        $certificate = $this->database->getReference('certificates/' . $id)->getValue();
        return view('/content/certificates/edit', compact('certificate', 'id'));
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
        // Validasi dan update data certificate
        $validatedData = $request->validate([
            'name' => 'required',
            'photo' => 'nullable|image',
        ]);

        $updates = [
            'name' => $request->input('name'),
        ];

        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $updates['photo'] = $filePath;
        }

        $this->database->getReference('certificates/' . $id)->update($updates);

        return redirect()->route('certificates')->with('success', 'Certificate updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Hapus data certificate berdasarkan ID
        $this->database->getReference('certificates/' . $id)->remove();
        return response()->json(['success' => 'Certificate deleted successfully.']);
    }
}
