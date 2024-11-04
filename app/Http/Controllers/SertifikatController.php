<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SertifikatController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Sertifikat::all(); // Fetch the data from the Sertifikat model
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '
                        <a class="btn btn-success btn-sm mx-1" href="' . route('admin.sertifikat.detail', $row->id) . '">
                            <i class="fas fa-certificate"></i> Lihat Sertifikat
                        </a>
                        <a class="btn btn-primary btn-sm mx-1" href="' . route('admin.sertifikat.edit', $row->id) . '">
                            <i class="fas fa-pen"></i> 
                        </a>
                        <form action="' . route('admin.sertifikat.destroy', $row->id) . '" method="POST" class="d-inline delete-form">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="btn btn-danger btn-sm delete-button" data-id="' . $row->id . '">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.sertifikat.index'); // Return the Blade view
    }

    public function show($id)
    {
        // Logic to show a specific certificate by ID
        $sertifikat = Sertifikat::findOrFail($id);
        return view('admin.sertifikat.show', compact('sertifikat'));
    }

    public function edit($id)
    {
        // Logic to edit a specific certificate by ID
        $sertifikat = Sertifikat::findOrFail($id);
        return view('admin.sertifikat.edit', compact('sertifikat'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update a specific certificate
        $sertifikat = Sertifikat::findOrFail($id);
        $sertifikat->update($request->all());
        return redirect()->route('admin.sertifikat.index')->with('success', 'Sertifikat updated successfully.');
    }

    public function destroy($id)
    {
        // Logic to delete a specific certificate
        $sertifikat = Sertifikat::findOrFail($id);
        $sertifikat->delete();
        return response()->json(['success' => true, 'message' => 'Sertifikat deleted successfully.']);
    }
}
