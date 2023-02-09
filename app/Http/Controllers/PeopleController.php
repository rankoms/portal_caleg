<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseFormatSame;
use Yajra\DataTables\Facades\DataTables;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('people.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => ['required'],
            'nik' => ['required', 'unique:people,nik'],
            'alamat' => ['nullable'],
            'no_telp' => ['nullable'],
            'email' => ['nullable', 'email'],
        ]);
        $user_id = Auth::user()->id;
        $name = $request->name;
        $nik = $request->nik;
        $alamat = $request->alamat;
        $no_telp = $request->no_telp;
        $email = $request->email;
        $people = new People();
        $people->name = $name;
        $people->nik = $nik;
        $people->alamat = $alamat;
        $people->no_telp = $no_telp;
        $people->email = $email;
        $people->user_id = $user_id;
        $people->save();
        return ResponseFormatter::success(null, __('Success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function show(People $people)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function edit(People $people)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, People $people)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function destroy(People $people)
    {
        //
    }

    public function list(Request $request)
    {
        $job_position = People::orderBy('id', 'desc');
        // $job_position = JobPosition::has('line_business')->with('line_business');
        return Datatables::of($job_position)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return "<div class='d-flex'>
                <a class='dropdown-item btn-edit' data-id='$row->id' data-name='$row->name'><i class='bx bx-edit-alt me-1'></i> Edit</a>
                <a class='dropdown-item btn-hapus' data-id='$row->id' data-name='$row->name'><i class='bx bx-trash me-1'></i> Delete</a>
            </div>";
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
