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
                <li class="breadcrumb-item"><a href="javascript: void(0)">Tim</a></li>
                <li class="breadcrumb-item" aria-current="page">Detail Data Tim</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Detail Data Tim</h2>
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
              <h5 class="mb-0">Detail Data Tim</h5>
              <div>
                <a href="{{ route('tim.edit', $tim->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('tim.index') }}" class="btn btn-light">Kembali</a>
              </div>
            </div>
            <div class="card-body">
              <table class="table">
                <tr>
                  <th style="width: 200px;">Nama</th>
                  <td>{{ $tim->nama }}</td>
                </tr>
                <tr>
                  <th>Alamat</th>
                  <td>{{ $tim->alamat }}</td>
                </tr>
                <tr>
                  <th>No. HP</th>
                  <td>{{ $tim->no_hp }}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection