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
                <li class="breadcrumb-item"><a href="javascript: void(0)">Testimoni</a></li>
                <li class="breadcrumb-item" aria-current="page">Detail Data Testimoni</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Detail Data Testimoni</h2>
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
              <h5 class="mb-0">Detail Data Testimoni</h5>
              <div>
                <a href="{{ route('testimoni.edit', $testimoni->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('testimoni.index') }}" class="btn btn-light">Kembali</a>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  @if ($testimoni->gambar)
                    <img src="{{ asset('upload/testimoni/' . $testimoni->gambar) }}" alt="Gambar {{ $testimoni->nama }}" class="img-fluid rounded">
                  @else
                    <div class="bg-light rounded p-5 text-center">
                      <i class="bx bx-user" style="font-size: 5rem;"></i>
                    </div>
                  @endif
                </div>
                <div class="col-md-8">
                  <table class="table">
                    <tr>
                      <th style="width: 200px;">Nama</th>
                      <td>{{ $testimoni->nama }}</td>
                    </tr>
                    <tr>
                      <th>Jabatan</th>
                      <td>{{ $testimoni->jabatan }}</td>
                    </tr>
                    <tr>
                      <th>Testimoni</th>
                      <td>{{ $testimoni->testimoni }}</td>
                    </tr>
                    <tr>
                      <th>Rating</th>
                      <td>
                        @for ($i = 1; $i <= 5; $i++)
                          <i class="fa fa-star {{ $i <= $testimoni->rating ? 'text-warning' : 'text-muted' }}"></i>
                        @endfor
                        ({{ $testimoni->rating }}/5)
                      </td>
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