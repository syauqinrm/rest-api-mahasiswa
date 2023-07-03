<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// import models mahasiswa
use App\Models\mahasiswaModel;

// import resource mahasiswa
use App\Http\Resources\mahasiswaResource;

// import Facade Validator
use Illuminate\Support\Facades\Validator;

class Mahasiswa extends Controller
{
    public function index()
    {
        // get all mahasiswa
        $mahasiswa = mahasiswaModel::latest()->paginate(5);
        return new mahasiswaResource(true, 'List data Mahasiswa', $mahasiswa);
    }

    public function store(Request $request)
    {
        // define validate rules
        $validator = Validator::make(
            $request->all(),
            [
                'nim' => 'required|max:10',
                'nama' => 'required',
                'angkatan' => 'required|max:4',
                'semester' => 'required|max:2',
                'ipk' => 'required',
                'email' => 'required|email',
                'telepon' => 'required'
            ]
        );

        // check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // create mahasiswa
        $mahasiswa = mahasiswaModel::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'angkatan' => $request->angkatan,
            'semester' => $request->semester,
            'ipk' => $request->ipk,
            'email' => $request->email,
            'telepon' => $request->telepon
        ]);

        // return response
        return new mahasiswaResource(true, 'Data mahasiswa berhasil ditambahkan!', $mahasiswa);
    }

    public function show($nim)
    {
        // find mahasiswa by nim
        $mahasiswa = mahasiswaModel::where('nim', $nim)->first();

        // check if mahasiswa exists
        if (!$mahasiswa) {
            return new mahasiswaResource(false, 'Data mahasiswa tidak ditemukan', null);
        }

        // return single mahasiswa as a resource
        return new mahasiswaResource(true, 'Detail data mahasiswa!', $mahasiswa);
    }

    public function update(Request $request, $nim)
    {
        // define validate rules
        $validator = Validator::make(
            $request->all(),
            [
                'nim' => 'required|max:10',
                'nama' => 'required',
                'angkatan' => 'required|max:4',
                'semester' => 'required|max:2',
                'ipk' => 'required',
                'email' => 'required|email',
                'telepon' => 'required'
            ]
        );

        // check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // find mahasiswa by nim
        $mahasiswa = mahasiswaModel::where('nim', $nim)->first();

        // Check if mahasiswa exists
        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan'], 404);
        }

        // update mahasiswa
        $mahasiswa->update(
            [
                'nim' => $request->nim,
                'nama' => $request->nama,
                'angkatan' => $request->angkatan,
                'semester' => $request->semester,
                'ipk' => $request->ipk,
                'email' => $request->email,
                'telepon' => $request->telepon
            ]
        );

        // return single mahasiswa as a resource
        return new mahasiswaResource(true, 'Data mahasiswa berhasil diubah!', $mahasiswa);
    }

    public function destroy($nim)
    {
        // find mahasiswa by nim
        $mahasiswa = mahasiswaModel::where('nim', $nim)->first();

        // Check if mahasiswa exists
        if (!$mahasiswa) {
            return response()->json(['message' => 'Data mahasiswa tidak ditemukan'], 404);
        }


        //delete post
        $mahasiswa->delete();

        //return response
        return new mahasiswaResource(true, 'Data mahasiswa berhasil dihapus!', null);
    }
}