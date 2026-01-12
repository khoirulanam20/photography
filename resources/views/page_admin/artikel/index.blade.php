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
                <li class="breadcrumb-item"><a href="javascript: void(0)">Artikel</a></li>
                <li class="breadcrumb-item" aria-current="page">Tabel Data Artikel</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Tabel Data Artikel</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="row">
        <div class="col-sm-12 mb-4">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Tabel Data Artikel</h5>
              <a href="{{ route('artikel.create') }}" class="btn btn-primary">Tambah Artikel</a>
            </div>
            <div class="card-body">
              <div class="dt-responsive table-responsive">
                <table id="simpletable" class="table table-striped table-bordered nowrap">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Gambar</th>
                      <th>Judul</th>
                      <th>Penulis</th>
                      <th>Kategori</th>
                      <th>Isi</th>
                      <th>Catatan</th>
                      <th>Komentar</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($artikels as $index => $artikel)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>
                        @if ($artikel->gambar)
                          <img src="{{ asset('upload/artikel/' . $artikel->gambar) }}" alt="Gambar {{ $artikel->judul }}" class="img-thumbnail" style="max-height: 100px;">
                        @else
                          <div class="bg-light rounded p-2 text-center"><i class="bx bx-user" style="font-size: 2rem;"></i></div>
                        @endif
                      </td>
                      <td>{{ $artikel->judul }}</td>
                      <td>{{ $artikel->penulis }}</td>
                      <td>{{ $artikel->kategoriArtikel->kategori_artikel }}</td>
                      <td>{!! Str::limit($artikel->isi, 50) !!}</td>
                      <td>{{ $artikel->catatan }}</td>
                      <td>{{ $artikel->komentar }}</td>
                      <td>
                        <span class="badge bg-{{ $artikel->status == 'Publik' ? 'success' : 'danger' }}">{{ $artikel->status }}</span>
                      </td>
                      <td>
                        <a href="{{ route('artikel.show', $artikel->id) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('artikel.edit', $artikel->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('artikel.destroy', $artikel->id) }}" method="POST" style="display:inline;" class="delete-form">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                      </td>
                    </tr>
                  
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Gambar</th>
                      <th>Judul</th>
                      <th>Penulis</th>
                      <th>Kategori</th>
                      <th>Isi</th>
                      <th>Catatan</th>
                      <th>Komentar</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ Main Content ] end -->
    </div>
  </section>
@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-form').forEach(function(form){
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: 'Data ini akan dihapus secara permanen!',
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
@endsection