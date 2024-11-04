@extends('admin.layouts.app')

@section('title', 'Pelatihan')

@section('content')

    <style>
        /* Limit the width of the Deskripsi column */
        .table th.text-nowrap,
        .table td.text-nowrap {
            white-space: nowrap;
            max-width: 150px; /* Adjust max width as needed */
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Add horizontal scrolling for the table */
        .table-responsive {
            overflow-x: auto;
        }

        /* Specific styling for the Deskripsi column */
        .table td.deskripsi {
            max-width: 100px; /* Set a smaller max width for the Deskripsi column */
            min-width: 80px; /* Set a minimum width if necessary */
        }

        @media (max-width: 768px) {
            .table th,
            .table td {
                font-size: 12px; /* Ukuran font lebih kecil */
                padding: 5px; /* Padding lebih kecil */
            }

            .btn {
                padding: 2px 5px; /* Kurangi padding pada tombol */
            }

            .delete-button {
                margin-left: 5px;
            }
        }
    </style>

    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Sertifikat</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="/" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item">Sertifikat</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> Data User
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="sertifikatTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th>Sertifikat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    @push('script')
        <script>
            $(document).ready(function() {
                var table = $('#sertifikatTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.sertifikat.index') }}",
                    responsive: true,
                    columns: [
                        { data: 'id', name: 'id' },
                        { data: 'user.nama', name: 'user.nama' },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `
                                    <a class="btn btn-success btn-sm mx-1" href="{{ route('admin.sertifikat.detail', '') }}/${row.id}">
                                        <i class="fas fa-certificate"></i> Lihat Sertifikat
                                    </a>`;
                            }
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return `
                                    <a class="btn btn-primary btn-sm mx-1" href="{{ route('admin.sertifikat.edit', '') }}/${row.id}">
                                        <i class="fas fa-pen"></i> 
                                    </a>
                                    <form action="{{ route('admin.sertifikat.destroy', '') }}/${row.id}" method="POST" class="d-inline delete-form">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="button" class="btn btn-danger btn-sm delete-button" data-id="${row.id}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>`;
                            }
                        }
                    ]
                });

                // Handle delete
                $(document).on('click', '.delete-button', function(e) {
                    e.preventDefault();
                    var form = $(this).closest('form');
                    var url = form.attr('action');
                    var deleteId = $(this).data('id');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Hapus Mahasiswa ini? ID=" + deleteId,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {
                                    _method: 'DELETE',
                                    _token: '{{ csrf_token() }}',
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire('Terhapus!', response.message, 'success');
                                        table.ajax.reload(null, false);
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>
    @endpush

@endsection
