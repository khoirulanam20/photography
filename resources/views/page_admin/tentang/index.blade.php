@extends('template_admin.layout')

@section('content')
    <section class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard-asisten">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Tentang</a></li>
                                <li class="breadcrumb-item" aria-current="page">Tabel Data Tentang</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Tabel Data Tentang</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- Zero config table start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Tabel Data Tentang</h5>
                            @if (!$tentang || $tentang->count() == 0)
                                <a href="{{ route('tentang.create') }}" class="btn btn-primary">Tambah Data Tentang</a>
                            @endif
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>Hitungan</th>
                                            <th>Keterangan Hitungan</th>
                                            {{-- <th>Keterangan Memilih</th> --}}
                                            <th>Gambar About</th>
                                            <th>Keterangan About</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($tentang && $tentang->count() > 0)
                                            @foreach ($tentang as $e => $item)
                                                <tr>
                                                    <td>{{ $e + 1 }}</td>
                                                    <td>
                                                        @if ($item->gambar)
                                                            <img src="{{ asset('upload/tentang/' . $item->gambar) }}"
                                                                alt="Gambar {{ $item->judul }}" class="img-thumbnail"
                                                                style="max-height: 100px;">
                                                        @else
                                                            <div class="bg-light rounded p-2">
                                                                <i class="bx bx-image" style="font-size: 2rem;"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->judul }}</td>
                                                    <td>{!! Str::limit($item->deskripsi, 50) !!}</td>
                                                    <td>
                                                        @if (is_array($item->hitungan))
                                                            {{ implode(', ', $item->hitungan) }}
                                                        @else
                                                            {{ $item->hitungan }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (is_array($item->keterangan_hitungan))
                                                            {{ implode(', ', $item->keterangan_hitungan) }}
                                                        @else
                                                            {{ $item->keterangan_hitungan }}
                                                        @endif
                                                    </td>
                                                    {{-- <td>{{ $item->keterangan_memilih }}</td> --}}
                                                    <td>
                                                        @if ($item->gambar_nilai)
                                                            <img src="{{ asset('upload/tentang/' . $item->gambar_nilai) }}"
                                                                alt="Gambar Nilai" class="img-thumbnail"
                                                                style="max-height: 100px;">
                                                        @else
                                                            <div class="bg-light rounded p-2">
                                                                <i class="bx bx-image" style="font-size: 2rem;"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->keterangan_nilai }}</td>
                                                    <td>
                                                        <a href="{{ route('tentang.show', $item->id) }}"
                                                            class="btn btn-sm btn-info">Detail</a>
                                                        <a href="{{ route('tentang.edit', $item->id) }}"
                                                            class="btn btn-sm btn-warning">Edit</a>
                                                        <form action="{{ route('tentang.destroy', $item->id) }}"
                                                            method="POST" style="display:inline;" class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>Hitungan</th>
                                            <th>Keterangan Hitungan</th>
                                            {{-- <th>Keterangan Memilih</th> --}}
                                            <th>Gambar About</th>
                                            <th>Keterangan About</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Zero config table end -->
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#simpletable').DataTable();
        });
    </script>
@endsection
