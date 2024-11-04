@extends('admin.layouts.app')

@section('title', 'Tambah Dosen')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Mahasiswa</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('admin.mahasiswa.index') }}"
                        class="text-decoration-none">Mahasiswa</a></li>
                <li class="breadcrumb-item">Tambah Mahasiswa</li>
            </ol>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Tambah Mahasiswa</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Profile -->
                                <div class="mb-3">
                                    <label for="profile" class="form-label">Profile</label>
                                    <input type="file" class="form-control" name="profile" id="profile"
                                        placeholder="Upload Profile">
                                    <div class="form-text text-danger">Png, Jpg, Maksimal : 2 mb.</div>
                                    @error('profile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Nama Mhasiswa -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Mahasiswa</label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        placeholder="Masukan Nama Mahasiswa" required>
                                    @error('nama')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Nim Mahasiswa -->
                                <div class="mb-3">
                                    <label for="nim" class="form-label">Nim Mahasiswa</label>
                                    <input type="text" class="form-control" name="nim" id="nim"
                                        placeholder="Masukan Nim Mahasiswa" required>
                                    @error('nim')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                id="jenis_kelamin_l" value="L" required>
                                            <label class="form-check-label" for="jenis_kelamin_l">Laki-laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                id="jenis_kelamin_p" value="P" required>
                                            <label class="form-check-label" for="jenis_kelamin_p">Perempuan</label>
                                        </div>
                                    </div>
                                    @error('jenis_kelamin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Prodi -->
                                <div class="mb-3">
                                    <label for="prodi_id" class="form-label">Jurusan</label>
                                    <select class="form-select" name="prodi_id" id="prodi_id" required>
                                        <option value="">Pilih Prodi</option>
                                        @foreach ($prodi as $prodi)
                                            <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                    @error('prodi_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- No HP -->
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No HP</label>
                                    <input type="text" class="form-control" name="no_hp" id="no_hp"
                                        placeholder="Masukan No HP">
                                    @error('no_hp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                        placeholder="Masukan Email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                        Simpan</button>
                                    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary ms-2"><i
                                            class="fas fa-arrow-left"></i> Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
