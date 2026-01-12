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
                <li class="breadcrumb-item"><a href="javascript: void(0)">Kategori Gambar</a></li>
                <li class="breadcrumb-item" aria-current="page">Detail Data Kategori Gambar</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Detail Data Kategori Gambar</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="row justify-content-center">
        <div class="col-sm-8">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Detail Data Kategori Gambar</h5>
              <div>
                <a href="{{ route('kategoriGambar.edit', $kategoriGambar->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('kategoriGambar.index') }}" class="btn btn-light">Kembali</a>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 200px;">Kategori Gambar</th>
                      <td>{{ $kategoriGambar->kategori_gambar }}</td>
                    </tr>
                    <tr>
                      <th>Slug</th>
                      <td>{{ $kategoriGambar->slug }}</td>
                    </tr>
                    <tr>
                      <th>Deskripsi</th>
                      <td>{{ $kategoriGambar->deskripsi ?? '-' }}</td>
                    </tr>
                    <tr>
                      <th>Dibuat Pada</th>
                      <td>{{ $kategoriGambar->created_at->format('d F Y H:i') }}</td>
                    </tr>
                    <tr>
                      <th>Diperbarui Pada</th>
                      <td>{{ $kategoriGambar->updated_at->format('d F Y H:i') }}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection







