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
                <li class="breadcrumb-item" aria-current="page">Form Edit Artikel</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Form Edit Artikel</h2>
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
              <h5 class="card-title mb-0">Form Edit Artikel</h5>
            </div>
            <div class="card-body">
              <form action="{{ route('artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data" id="formArtikel">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                  <label for="judul" class="form-label">Judul</label>
                  <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ $artikel->judul }}" required>
                  @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label for="penulis" class="form-label">Penulis</label>
                  <input type="text" class="form-control @error('penulis') is-invalid @enderror" id="penulis" name="penulis" value="{{ $artikel->penulis }}" required>
                  @error('penulis')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label for="kategori_artikel_id" class="form-label">Kategori</label>
                  <select class="form-select @error('kategori_artikel_id') is-invalid @enderror" id="kategori_artikel_id" name="kategori_artikel_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriArtikels as $kategori)
                      <option value="{{ $kategori->id }}" {{ $artikel->kategori_artikel_id == $kategori->id ? 'selected' : '' }}>
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
                  @if($artikel->gambar)
                    <div class="mb-2">
                        <img src="{{ asset('upload/artikel/' . $artikel->gambar) }}" alt="Preview" class="img-thumbnail" style="max-width: 200px;" id="currentImage">
                    </div>
                  @endif
                  <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar">
                  <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                  @error('gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label for="isi_artikel" class="form-label">Isi</label>
                  <textarea class="form-control @error('isi') is-invalid @enderror" id="isi_artikel" name="isi" required>{{ $artikel->isi }}</textarea>
                  @error('isi')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label for="catatan" class="form-label">Catatan</label>
                  <input type="text" class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" value="{{ $artikel->catatan }}">
                  @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Pilih Status</option>
                    <option value="Publik" {{ $artikel->status == 'Publik' ? 'selected' : '' }}>Publik</option>
                    <option value="Draft" {{ $artikel->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                  </select>
                  @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary me-2">Submit</button>
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
                <!-- Preview akan diisi oleh JavaScript -->
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
    <script src="{{ asset('admin/assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
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
    <script>
      let editor;
      let currentImageUrl = '{{ $artikel->gambar ? asset("upload/artikel/" . $artikel->gambar) : "" }}';
      
      (function () {
        ClassicEditor.create(document.querySelector('#isi_artikel'))
          .then(editorInstance => {
            editor = editorInstance;
            
            // Event listener untuk CKEditor
            editor.model.document.on('change:data', () => {
              updatePreview();
            });
            
            // Load preview awal dengan data existing
            updatePreview();
          })
          .catch((error) => {
            console.error(error);
            // Fallback jika CKEditor tidak load
            updatePreview();
          });
      })();

      // Fungsi untuk update preview
      function updatePreview() {
        const judul = document.getElementById('judul').value;
        const penulis = document.getElementById('penulis').value;
        const kategoriSelect = document.getElementById('kategori_artikel_id');
        const kategoriText = kategoriSelect.options[kategoriSelect.selectedIndex].text;
        const gambar = document.getElementById('gambar').files[0];
        const isi = editor ? editor.getData() : document.getElementById('isi_artikel').value;
        
        const previewContainer = document.getElementById('livePreview');
        
        // Cek apakah ada konten untuk ditampilkan
        if (!judul && !penulis && !kategoriText && !gambar && !currentImageUrl && !isi) {
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
        
        // Gambar - prioritas gambar baru, fallback ke gambar existing
        if (gambar) {
          const imageUrl = URL.createObjectURL(gambar);
          previewHTML += `
            <div class="article-image">
              <img src="${imageUrl}" alt="${judul || 'Preview Image'}" />
            </div>
          `;
        } else if (currentImageUrl) {
          previewHTML += `
            <div class="article-image">
              <img src="${currentImageUrl}" alt="${judul || 'Preview Image'}" />
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
          gambarInput.addEventListener('change', function() {
            // Reset current image URL jika ada gambar baru
            if (this.files[0]) {
              currentImageUrl = '';
            }
            updatePreview();
          });
        }
        
        // Event listener untuk textarea (fallback jika CKEditor tidak load)
        const isiTextarea = document.getElementById('isi_artikel');
        if (isiTextarea) {
          isiTextarea.addEventListener('input', updatePreview);
        }
      });
    </script>
@endsection