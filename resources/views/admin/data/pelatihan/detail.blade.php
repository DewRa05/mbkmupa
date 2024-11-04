@extends('admin.layouts.app')

@section('title', 'Detail Pelatihan')

@section('content')

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Detail Pelatihan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.pelatihan.index') }}">Pelatihan</a></li>
            <li class="breadcrumb-item">Detail</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-info-circle me-1"></i> Detail Pelatihan
            </div>
            <div class="card-body d-flex">
                <div class="me-3">
                    <img src="{{ asset('img/pelatihan/' . $pelatihan->gambar) }}" alt="Gambar Pelatihan" class="img-fluid" style="max-height: 500px; object-fit: cover;">
                </div>
                <div>
                    <h5>Nama Pelatihan: <strong>{{ $pelatihan->nama }}</strong></h5>
                    <p><strong>Jenis Pelatihan:</strong> {{ $pelatihan->jenis_pelatihan }}</p>
                    <p><strong>Deskripsi:</strong> {{ $pelatihan->deskripsi }}</p>
                    <p><strong>Mulai Pendaftaran:</strong> {{ \Carbon\Carbon::parse($pelatihan->tanggal_pendaftaran)->format('d/m/Y') }}</p>
                    <p><strong>Berakhir Pendaftaran:</strong> {{ \Carbon\Carbon::parse($pelatihan->berakhir_pendaftaran)->format('d/m/Y') }}</p>
                    <p><strong>Harga:</strong> Rp. {{ number_format($pelatihan->harga, 0, ',', '.') }}</p>
                    <p><strong>Kuota:</strong> {{ $pelatihan->kuota }}</p>
                    <p><strong>LSP:</strong> {{ $pelatihan->lsp->nama }}</p>
                    <p><strong>Kategori:</strong> {{ $pelatihan->kategori->nama }}</p>
                    <button id="loadParticipants" class="btn btn-primary">Peserta</button>
                </div>
            </div>
        </div>

        <div class="card mb-4" id="participantsCard" style="display:none;">
            <div class="card-header">
                <i class="fas fa-users me-1"></i> Peserta Pelatihan
            </div>
            <div class="card-body">
                <div id="spinner" style="display:none;" class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="participantsTable" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama User</th>
                                <th>Pelatihan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <a href="{{ route('admin.pelatihan.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
</main>

@endsection

@section('scripts')
@push('script')
<script>
    $(document).ready(function() {
        // Menampilkan spinner saat AJAX loading
        $(document).ajaxStart(function() {
            $('#spinner').show();
        }).ajaxStop(function() {
            $('#spinner').hide();
        });

        // DataTable setup for participants
        let table;

        $('#loadParticipants').click(function() {
            const pelatihanId = {{ $pelatihan->id }}; // Get the ID of the pelatihan

            // Initialize DataTable
            if ($.fn.dataTable.isDataTable('#participantsTable')) {
                table.ajax.reload(null, false); // Reload the existing table without resetting paging
            } else {
                table = $('#participantsTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ url("admin/pelatihan") }}/' + pelatihanId + '/participants',
                        type: 'GET',
                    },
                    columns: [
                        { data: 'user.nama', name: 'user.nama' },
                        { data: 'pelatihan.nama', name: 'pelatihan.nama' },
                        { data: 'status', name: 'status', render: function(data) {
                            return data ? 'Lulus' : 'Tidak Lulus';
                        }}
                    ]
                });
            }
            $('#participantsCard').show(); // Show participants card
        });
    });
</script>
@endpush
@endsection
