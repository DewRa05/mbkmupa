@extends('admin.layouts.app')

@section('title', 'Tambah Dosen')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Dosen</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('admin.dosen.index') }}"
                        class="text-decoration-none">Dosen</a></li>
                <li class="breadcrumb-item">Tambah Dosen</li>
            </ol>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Tambah Dosen</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.dosen.store') }}" method="POST" enctype="multipart/form-data">
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

                                <!-- Nama Dosen -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Dosen</label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        placeholder="Masukan Nama Dosen" required>
                                    @error('nama')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Nidn Dosen -->
                                <div class="mb-3">
                                    <label for="nidn" class="form-label">NIDN Dosen</label>
                                    <input type="text" class="form-control" name="nidn" id="nidn"
                                        placeholder="Masukan NIDN Dosen" required>
                                    @error('nidn')
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

                                <!-- Jurusan -->
                                <div class="mb-3">
                                    <label for="jurusan_id" class="form-label">Jurusan</label>
                                    <select class="form-select" name="jurusan_id" id="jurusan_id" required>
                                        <option value="">Pilih Jurusan</option>
                                        @foreach ($jurusans as $jurusan)
                                            <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                    @error('jurusan_id')
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

                                <!-- No HP -->
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No HP</label>
                                    <input type="text" class="form-control" name="no_hp" id="no_hp"
                                        placeholder="Masukan No HP">
                                    @error('no_hp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                        Simpan</button>
                                    <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary ms-2"><i
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
