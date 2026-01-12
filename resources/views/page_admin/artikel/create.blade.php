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
                <li class="breadcrumb-item"><a href="{{ route('artikel.index') }}">Artikel</a></li>
                <li class="breadcrumb-item" aria-current="page">Form Tambah Artikel</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Form Tambah Artikel</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- Form Kolom Kiri -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0">Form Tambah Artikel</h5>
            </div>
            <div class="card-body">
              <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data" id="formArtikel">
                @csrf
                <div class="form-group mb-3">
                  <label for="judul" class="form-label">Judul</label>
                  <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                  @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label for="penulis" class="form-label">Penulis</label>
                  <input type="text" class="form-control @error('penulis') is-invalid @enderror" id="penulis" name="penulis" value="{{ old('penulis') }}" required>
                  @error('penulis')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label for="kategori_artikel_id" class="form-label">Kategori</label>
                  <select class="form-select @error('kategori_artikel_id') is-invalid @enderror" id="kategori_artikel_id" name="kategori_artikel_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriArtikels as $kategori)
                      <option value="{{ $kategori->id }}" {{ old('kategori_artikel_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->kategori_artikel }}
                      </option>
                    @endforeach
                  </select>
                  @error('kategori_artikel_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label for="gambar" class="form-label">Gambar</label>
                  <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*" required>
                  <small class="text-muted">Format: jpeg, png, jpg, gif, svg. Maksimal 7MB</small>
                  @error('gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label for="isi" class="form-label">Isi</label>
                  <textarea class="form-control @error('isi') is-invalid @enderror" id="isi" name="isi">{{ old('isi') }}</textarea>
                  @error('isi')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label for="catatan" class="form-label">Catatan</label>
                  <input type="text" class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" value="{{ old('catatan') }}">
                  @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Pilih Status</option>
                    <option value="Publik" {{ old('status') == 'Publik' ? 'selected' : '' }}>Publik</option>
                    <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                  </select>
                  @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary me-2" id="btnSimpan">Submit</button>
                  <a href="{{ route('artikel.index') }}" class="btn btn-light">Batal</a>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Live Preview Kolom Kanan -->
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h5 class="card-title mb-0">Live Preview</h5>
            </div>
            <div class="card-body">
              <div id="livePreview" class="article-preview">
                <div class="text-center text-muted py-5">
                  <i class="fas fa-eye fa-3x mb-3"></i>
                  <p>Mulai mengetik untuk melihat preview artikel</p>
                </div>
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
    <style>
        .article-preview {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            max-height: 600px;
            overflow-y: auto;
        }

        .article-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .article-image {
            margin-bottom: 1rem;
        }

        .article-image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .article-meta {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .article-meta span {
            display: flex;
            align-items: center;
        }

        .article-meta i {
            margin-right: 5px;
        }

        .article-category {
            background: #e3f2fd;
            color: #1976d2;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .article-content {
            font-size: 1rem;
            color: #2c3e50;
        }

        .article-content p {
            margin-bottom: 1rem;
        }

        .article-content h2,
        .article-content h3,
        .article-content h4 {
            margin: 1.5rem 0 0.75rem;
            color: #2c3e50;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1rem 0;
        }

        .article-content blockquote {
            border-left: 4px solid #3498db;
            padding-left: 1rem;
            margin: 1.5rem 0;
            font-style: italic;
            color: #666;
        }

        .article-content ul {
            list-style-type: disc;
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .article-content ol {
            list-style-type: decimal;
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .article-content li {
            margin-bottom: 0.5rem;
        }

        .preview-placeholder {
            text-align: center;
            color: #999;
            padding: 3rem 1rem;
        }

        .preview-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
    </style>
      <!-- [Page Specific JS] start -->
    <!-- Ckeditor js -->
    <script src="{{ asset('admin/assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
    <script>
      let editor;
      
      (function () {
        ClassicEditor.create(document.querySelector('#isi'))
          .then(editorInstance => {
            editor = editorInstance;
            
            // Event listener untuk CKEditor
            editor.model.document.on('change:data', () => {
              updatePreview();
            });
          })
          .catch((error) => {
            console.error(error);
          });
      })();

      // Fungsi untuk update preview
      function updatePreview() {
        const judul = document.getElementById('judul').value;
        const penulis = document.getElementById('penulis').value;
        const kategoriSelect = document.getElementById('kategori_artikel_id');
        const kategoriText = kategoriSelect.options[kategoriSelect.selectedIndex].text;
        const gambar = document.getElementById('gambar').files[0];
        const isi = editor ? editor.getData() : document.getElementById('isi').value;
        
        const previewContainer = document.getElementById('livePreview');
        
        // Cek apakah ada konten untuk ditampilkan
        if (!judul && !penulis && !kategoriText && !gambar && !isi) {
          previewContainer.innerHTML = `
            <div class="preview-placeholder">
              <i class="fas fa-eye"></i>
              <p>Mulai mengetik untuk melihat preview artikel</p>
            </div>
          `;
          return;
        }
        
        let previewHTML = '';
        
        // Judul
        if (judul) {
          previewHTML += `<h1 class="article-title">${judul}</h1>`;
        }
        
        // Gambar
        if (gambar) {
          const imageUrl = URL.createObjectURL(gambar);
          previewHTML += `
            <div class="article-image">
              <img src="${imageUrl}" alt="${judul || 'Preview Image'}" />
            </div>
          `;
        }
        
        // Meta informasi (Penulis dan Kategori)
        if (penulis || kategoriText !== 'Pilih Kategori') {
          previewHTML += '<div class="article-meta">';
          
          if (penulis) {
            previewHTML += `
              <span>
                <i class="fas fa-user"></i>
                ${penulis}
              </span>
            `;
          }
          
          if (kategoriText !== 'Pilih Kategori') {
            previewHTML += `
              <span class="article-category">
                <i class="fas fa-tag"></i>
                ${kategoriText}
              </span>
            `;
          }
          
          previewHTML += '</div>';
        }
        
        // Isi artikel
        if (isi) {
          previewHTML += `<div class="article-content">${isi}</div>`;
        }
        
        previewContainer.innerHTML = previewHTML;
      }

      // Event listeners untuk form inputs
      document.addEventListener('DOMContentLoaded', function() {
        const inputs = ['judul', 'penulis', 'kategori_artikel_id'];
        
        inputs.forEach(inputId => {
          const element = document.getElementById(inputId);
          if (element) {
            element.addEventListener('input', updatePreview);
            element.addEventListener('change', updatePreview);
          }
        });
        
        // Event listener untuk file input
        const gambarInput = document.getElementById('gambar');
        if (gambarInput) {
          gambarInput.addEventListener('change', updatePreview);
        }
        
        // Event listener untuk textarea (fallback jika CKEditor tidak load)
        const isiTextarea = document.getElementById('isi');
        if (isiTextarea) {
          isiTextarea.addEventListener('input', updatePreview);
        }
      });
    </script>
    <!-- [Page Specific JS] end -->
@endsection