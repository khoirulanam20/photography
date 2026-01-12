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
                <li class="breadcrumb-item" aria-current="page">Detail Data Tentang</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Detail Data Tentang</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="row justify-content-center">
        <div class="col-sm-10">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Detail Data Tentang</h5>
              <div>
                <a href="{{ route('tentang.edit', $tentang->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('tentang.index') }}" class="btn btn-light">Kembali</a>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 mb-4">
                  <h6 class="fw-bold">Gambar</h6>
                  @if ($tentang->gambar)
                    <img src="{{ asset('upload/tentang/' . $tentang->gambar) }}" alt="Gambar {{ $tentang->judul }}" class="img-fluid rounded" style="max-height: 300px;">
                  @else
                    <div class="bg-light rounded p-4 text-center">
                      <i class="bx bx-image" style="font-size: 3rem;"></i>
                      <p class="mt-2 mb-0">Tidak ada gambar</p>
                    </div>
                  @endif
                </div>

                <div class="col-md-6 mb-4">
                  <h6 class="fw-bold">Judul</h6>
                  <p class="mb-3">{{ $tentang->judul }}</p>

                  <h6 class="fw-bold">Deskripsi</h6>
                  <div class="border rounded p-3 mb-3 bg-light">
                    {!! $tentang->deskripsi !!}
                  </div>

                  <h6 class="fw-bold">Hitungan</h6>
                  <div class="row mb-3">
                    @if(is_array($tentang->hitungan))
                      @foreach($tentang->hitungan as $index => $nilai)
                        <div class="col-md-6 mb-2">
                          <div class="card border-primary">
                            <div class="card-body text-center">
                              <h4 class="text-primary mb-0">{{ $nilai }}</h4>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    @else
                      <div class="col-12">
                        <div class="card border-primary">
                          <div class="card-body text-center">
                            <h4 class="text-primary mb-0">{{ $tentang->hitungan }}</h4>
                          </div>
                        </div>
                      </div>
                    @endif
                  </div>

                  <h6 class="fw-bold">Keterangan Hitungan</h6>
                  <div class="row mb-3">
                    @if(is_array($tentang->keterangan_hitungan))
                      @foreach($tentang->keterangan_hitungan as $index => $keterangan)
                        <div class="col-md-6 mb-2">
                          <div class="card border-info">
                            <div class="card-body text-center">
                              <p class="mb-0 text-info">{{ $keterangan }}</p>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    @else
                      <div class="col-12">
                        <div class="card border-info">
                          <div class="card-body text-center">
                            <p class="mb-0 text-info">{{ $tentang->keterangan_hitungan }}</p>
                          </div>
                        </div>
                      </div>
                    @endif
                  </div>
                </div>

                <div class="col-md-12 mb-4">
                  <h6 class="fw-bold">Keterangan Memilih</h6>
                  <div class="border rounded p-3 bg-light">
                    {!! $tentang->keterangan_memilih !!}
                  </div>
                </div>

                <div class="col-md-6 mb-4">
                  <h6 class="fw-bold">Gambar Nilai</h6>
                  @if ($tentang->gambar_nilai)
                    <img src="{{ asset('upload/tentang/' . $tentang->gambar_nilai) }}" alt="Gambar Nilai" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                  @else
                    <div class="bg-light rounded p-4 text-center border">
                      <i class="bx bx-image text-muted" style="font-size: 3rem;"></i>
                      <p class="mt-2 mb-0 text-muted">Tidak ada gambar nilai</p>
                    </div>
                  @endif
                </div>

                <div class="col-md-6 mb-4">
                  <h6 class="fw-bold">Keterangan Nilai</h6>
                  <div class="border rounded p-3 bg-light">
                    {!! $tentang->keterangan_nilai !!}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection