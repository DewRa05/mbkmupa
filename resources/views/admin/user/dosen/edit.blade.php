@extends('admin.layouts.app')

@section('title', 'Edit Dosen')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Dosen</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('admin.dosen.index') }}"
                        class="text-decoration-none">Dosen</a></li>
                <li class="breadcrumb-item">Edit Dosen</li>
            </ol>

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-edit"></i> Edit Dosen</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.dosen.update', $dosen->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <!-- Profile Dosen -->
                                <div class="mb-3">
                                    <label for="profile" class="form-label">Profile Dosen</label>
                                    <div class="mb-3">
                                        <img id="imagePreview" src="{{ asset('img/user/dosen/' . $dosen->profile) }}"
                                            alt="Profile Dosen" style="max-width: 200px; max-height: 200px;">
                                    </div>
                                    <input type="file" class="form-control @error('profile') is-invalid @enderror"
                                           name="profile" id="profile" accept="image/*" onchange="previewImage()">
                                    @error('profile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Nama Dosen -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Dosen</label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        value="{{ old('nama', $dosen->nama) }}" required>
                                    @error('nama')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Nidn Dosen -->
                                <div class="mb-3">
                                    <label for="nidn" class="form-label">NIDN Dosen</label>
                                    <input type="text" class="form-control" name="nidn" id="nidn"
                                        value="{{ old('nidn', $dosen->nidn) }}" required>
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
                                                id="jenis_kelamin_l" value="L"
                                                {{ old('jenis_kelamin', $dosen->jenis_kelamin) == 'L' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="jenis_kelamin_l">Laki-laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                id="jenis_kelamin_p" value="P"
                                                {{ old('jenis_kelamin', $dosen->jenis_kelamin) == 'P' ? 'checked' : '' }}>
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
                                            <option value="{{ $jurusan->id }}"
                                                {{ old('jurusan_id', $dosen->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                                                {{ $jurusan->nama_jurusan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jurusan_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        value="{{ old('email', $dosen->email) }}" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- No HP -->
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No HP</label>
                                    <input type="text" class="form-control" name="no_hp" id="no_hp"
                                        value="{{ old('no_hp', $dosen->no_hp) }}">
                                    @error('no_hp')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
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
