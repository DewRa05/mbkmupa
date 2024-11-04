<?php

namespace App\Http\Controllers;

use App\Models\Lsp;
use App\Models\KategoriPelatihan;
use App\Models\Pelatihan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class PelatihanController extends Controller
{
    public function index(Request $request)
    {
        // Cek apakah permintaan adalah AJAX
        if ($request->ajax()) {
            $pelatihans = Pelatihan::with(['kategori', 'lsp'])->get();
            return DataTables::of($pelatihans)
                ->addIndexColumn()
                ->make(true);
        }

        // Render view index jika tidak AJAX
        return view('admin.data.pelatihan.index');
    }

    public function create()
    {
        // Ambil data LSP dan Kategori
        $lsps = Lsp::all();
        $kategoris = KategoriPelatihan::all();

        // Render view untuk form tambah pelatihan
        return view('admin.data.pelatihan.create', compact('lsps', 'kategoris'));
    }

    public function detail($id)
    {
        // Ambil data Pelatihan
        $pelatihan = Pelatihan::findOrFail($id); // Get the pelatihan by ID
        $lsps = Lsp::all(); // Ambil data LSP
        $kategoris = KategoriPelatihan::all(); // Ambil data Kategori
        $users = $pelatihan->users; // Get participants associated with the pelatihan

        // Render view untuk form detail pelatihan
        return view('admin.data.pelatihan.detail', compact('pelatihan', 'lsps', 'kategoris', 'users'));
    }


    public function store(Request $request)
    {
        // Validasi input form
        $request->validate(
            [
                'nama' => 'required|string|max:125',
                'jenis_pelatihan' => 'required|string|max:125',
                'deskripsi' => 'required|string',
                'tanggal_pendaftaran' => 'required|date',
                'berakhir_pendaftaran' => 'required|date',
                'harga' => 'required|numeric',
                'kuota' => 'required|integer',
                'lsp_id' => 'required|exists:lsp,id', // pastikan lsp yang dipilih ada di database
                'kategori_id' => 'required|exists:kategori,id', // pastikan kategori yang dipilih ada di database
                'gambar' => 'nullable|image|mimes:jpg,png|max:2048',
            ],
            [
                'nama.required' => 'Nama pelatihan harus diisi.',
                'nama.max' => 'Nama pelatihan maksimal 125 karakter.',
                'jenis_pelatihan.required' => 'Jenis pelatihan harus diisi.',
                'jenis_pelatihan.max' => 'Jenis pelatihan maksimal 125 karakter.',
                'deskripsi.required' => 'Deskripsi harus diisi.',
                'tanggal_pendaftaran.required' => 'Tanggal pendaftaran harus diisi.',
                'berakhir_pendaftaran.required' => 'Tanggal berakhir pendaftaran harus diisi.',
                'harga.required' => 'Harga harus diisi.',
                'harga.numeric' => 'Harga harus berupa angka.',
                'kuota.required' => 'Kuota harus diisi.',
                'kuota.integer' => 'Kuota harus berupa angka.',
                'lsp_id.required' => 'LSP harus dipilih.',
                'kategori_id.required' => 'Kategori harus dipilih.',
                'gambar.image' => 'File harus berupa gambar.',
                'gambar.mimes' => 'Gambar harus dalam format jpg atau png.',
                'gambar.max' => 'Gambar maksimal 2MB.',
            ]
        );

        $data = $request->all();

        // Menghandle upload file gambar
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarNama = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('img/pelatihan'), $gambarNama);
            $data['gambar'] = $gambarNama;
        }

        // Simpan data pelatihan
        Pelatihan::create($data);

        return redirect()->route('admin.pelatihan.index')->with('tambah_success', true);
    }

    public function edit($id)
    {
        // Cari pelatihan berdasarkan ID
        $pelatihan = Pelatihan::findOrFail($id);
        $lsps = Lsp::all();  // Ambil data LSP
        $kategoris = KategoriPelatihan::all(); // Ambil data Kategori

        // Render view untuk form edit pelatihan
        return view('admin.data.pelatihan.edit', compact('pelatihan', 'lsps', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        // Cari pelatihan berdasarkan ID
        $pelatihan = Pelatihan::findOrFail($id);

        // Validasi input form
        $request->validate(
            [
                'nama' => 'required|string|max:125',
                'jenis_pelatihan' => 'required|string|max:125',
                'deskripsi' => 'required|string',
                'tanggal_pendaftaran' => 'required|date',
                'berakhir_pendaftaran' => 'required|date',
                'harga' => 'required|numeric',
                'kuota' => 'required|integer',
                'lsp_id' => 'required|exists:lsp,id',
                'kategori_id' => 'required|exists:kategori,id',
                'gambar' => 'nullable|image|mimes:jpg,png|max:2048',
            ],
            [
                'nama.required' => 'Nama pelatihan harus diisi.',
                'nama.max' => 'Nama pelatihan maksimal 125 karakter.',
                'jenis_pelatihan.required' => 'Jenis pelatihan harus diisi.',
                'jenis_pelatihan.max' => 'Jenis pelatihan maksimal 125 karakter.',
                'deskripsi.required' => 'Deskripsi harus diisi.',
                'tanggal_pendaftaran.required' => 'Tanggal pendaftaran harus diisi.',
                'berakhir_pendaftaran.required' => 'Tanggal berakhir pendaftaran harus diisi.',
                'harga.required' => 'Harga harus diisi.',
                'harga.numeric' => 'Harga harus berupa angka.',
                'kuota.required' => 'Kuota harus diisi.',
                'kuota.integer' => 'Kuota harus berupa angka.',
                'lsp_id.required' => 'LSP harus dipilih.',
                'kategori_id.required' => 'Kategori harus dipilih.',
                'gambar.image' => 'File harus berupa gambar.',
                'gambar.mimes' => 'Gambar harus dalam format jpg atau png.',
                'gambar.max' => 'Gambar maksimal 2MB.',
            ]
        );

        $data = $request->all();

        // Menghandle upload file gambar
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($pelatihan->gambar && file_exists(public_path('img/pelatihan/' . $pelatihan->gambar))) {
                unlink(public_path('img/pelatihan/' . $pelatihan->gambar));
            }
            $gambar = $request->file('gambar');
            $gambarNama = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('img/pelatihan'), $gambarNama);
            $data['gambar'] = $gambarNama;
        }

        // Update data pelatihan
        $pelatihan->update($data);

        return redirect()->back()->with('edit_success', 'Pelatihan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Hapus pelatihan berdasarkan ID
        $pelatihan = Pelatihan::findOrFail($id);

        try {
            // Hapus file gambar jika ada
            if ($pelatihan->gambar && file_exists(public_path('img/pelatihan/' . $pelatihan->gambar))) {
                unlink(public_path('img/pelatihan/' . $pelatihan->gambar));
            }

            $pelatihan->delete();
            return response()->json(['success' => true, 'message' => 'Pelatihan berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus pelatihan'], 500);
        }
    }
    public function getParticipants($id)
    {
        $pelatihan = Pelatihan::find($id);
        $users = $pelatihan->users; // Assuming there is a relationship defined

        return response()->json($users);
    }
}
