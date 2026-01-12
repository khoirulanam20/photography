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
                            <li class="breadcrumb-item" aria-current="page">Detail Artikel</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Detail Artikel</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center bg-gradient-primary">
                        <div class="d-flex align-items-center">
                            <div class="article-icon me-3">
                                <i class="fas fa-newspaper fa-2x text-white"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 text-white">Detail Artikel</h5>
                                <small class="text-white-50">Kelola dan lihat detail artikel</small>
                            </div>
                        </div>
                        <div class="btn-group">
                            <a href="{{ route('artikel.edit', $artikel->id) }}" class="btn btn-warning btn-sm shadow-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('artikel.index') }}" class="btn btn-light btn-sm shadow-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Artikel Content dengan susunan seperti live preview -->
                        <div class="article-preview">
                            <!-- Judul dengan efek visual -->
                            <div class="article-title-container mb-4">
                                <h1 class="article-title">{{ $artikel->judul }}</h1>
                                <div class="title-underline"></div>
                            </div>
                            
                            <!-- Gambar dengan overlay -->
                            @if($artikel->gambar)
                                <div class="article-image-container mb-4">
                                    <div class="image-wrapper">
                                        <img src="{{ asset('upload/artikel/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="article-image" />
                                        <div class="image-overlay">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Meta informasi dengan card design -->
                            <div class="article-meta-container mb-4">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="meta-card">
                                            <div class="meta-icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="meta-content">
                                                <small class="meta-label">Penulis</small>
                                                <div class="meta-value">{{ $artikel->penulis }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="meta-card">
                                            <div class="meta-icon category-icon">
                                                <i class="fas fa-tag"></i>
                                            </div>
                                            <div class="meta-content">
                                                <small class="meta-label">Kategori</small>
                                                <div class="meta-value">{{ $artikel->kategoriArtikel->kategori_artikel }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="meta-card">
                                            <div class="meta-icon status-icon">
                                                <i class="fas fa-{{ $artikel->status == 'Publik' ? 'eye' : 'eye-slash' }}"></i>
                                            </div>
                                            <div class="meta-content">
                                                <small class="meta-label">Status</small>
                                                <div class="meta-value status-{{ strtolower($artikel->status) }}">{{ $artikel->status }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="meta-card">
                                            <div class="meta-icon date-icon">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                            <div class="meta-content">
                                                <small class="meta-label">Dibuat</small>
                                                <div class="meta-value">{{ $artikel->created_at->format('d/m/Y H:i') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Isi artikel dengan styling yang lebih baik -->
                            <div class="article-content-container">
                                <div class="content-header">
                                    <h3 class="content-title">
                                        <i class="fas fa-align-left"></i> Konten Artikel
                                    </h3>
                                </div>
                                <div class="article-content">
                                    {!! $artikel->isi !!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Komentar Section -->
                @if($artikel->komentarArtikel->count() > 0)
                <div class="card mt-4 shadow-lg">
                    <div class="card-header bg-gradient-info">
                        <div class="d-flex align-items-center">
                            <div class="comment-icon me-3">
                                <i class="fas fa-comments fa-2x text-white"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 text-white">
                                    Komentar Pembaca
                                </h5>
                                <small class="text-white-50">{{ $artikel->komentarArtikel->count() }} komentar</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @foreach($artikel->komentarArtikel as $index => $komentar)
                            <div class="comment-item mb-4">
                                <div class="comment-card">
                                    <div class="comment-header">
                                        <div class="comment-avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="comment-info">
                                            <h6 class="comment-author">{{ $komentar->nama_komentar }}</h6>
                                            <small class="comment-meta">
                                                <i class="fas fa-phone me-1"></i>{{ $komentar->no_hp_komentar }}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-envelope me-1"></i>{{ $komentar->email_komentar }}
                                            </small>
                                        </div>
                                        <div class="comment-number">
                                            #{{ $index + 1 }}
                                        </div>
                                    </div>
                                    <div class="comment-body">
                                        <div class="comment-text">
                                            <i class="fas fa-quote-left quote-icon"></i>
                                            {{ $komentar->komentar }}
                                            <i class="fas fa-quote-right quote-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="card mt-4 shadow-lg">
                    <div class="card-body text-center py-5">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h5 class="empty-title">Belum ada komentar</h5>
                            <p class="empty-description">Artikel ini belum memiliki komentar dari pembaca.</p>
                            <div class="empty-action">
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-share"></i> Bagikan artikel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</section>
@endsection

@push('styles')
    <style>
        /* Import Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        /* Base Styles */
        .article-preview {
            font-family: 'Inter', sans-serif;
            line-height: 1.7;
        }

        /* Gradient Backgrounds */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
            border: none;
        }

        /* Article Title */
        .article-title-container {
            position: relative;
            text-align: center;
            padding: 2rem 0;
        }

        .article-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .title-underline {
            width: 100px;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0 auto;
            border-radius: 2px;
        }

        /* Image Styling */
        .article-image-container {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
        }

        .image-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .article-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .image-wrapper:hover .image-overlay {
            opacity: 1;
        }

        .image-wrapper:hover .article-image {
            transform: scale(1.05);
        }

        .image-overlay i {
            font-size: 3rem;
            color: white;
        }

        /* Meta Cards */
        .meta-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
            height: 100%;
        }

        .meta-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .meta-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .category-icon {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        }

        .status-icon {
            background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
        }

        .date-icon {
            background: linear-gradient(135deg, #fdcb6e 0%, #e17055 100%);
        }

        .meta-label {
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.75rem;
        }

        .meta-value {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1rem;
            margin-top: 0.25rem;
        }

        .status-publik {
            color: #00b894;
            font-weight: 700;
        }

        .status-draft {
            color: #fdcb6e;
            font-weight: 700;
        }

        /* Content Section */
        .article-content-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
        }

        .content-header {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }

        .content-title {
            color: #2c3e50;
            font-weight: 600;
            margin: 0;
        }

        .content-title i {
            color: #667eea;
            margin-right: 0.5rem;
        }

        .article-content {
            font-size: 1.1rem;
            color: #2c3e50;
            line-height: 1.8;
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .article-content h2,
        .article-content h3,
        .article-content h4 {
            margin: 2rem 0 1rem;
            color: #2c3e50;
            font-weight: 600;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 1.5rem 0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .article-content blockquote {
            border-left: 4px solid #667eea;
            padding: 1.5rem;
            margin: 2rem 0;
            font-style: italic;
            color: #6c757d;
            background: #f8f9fa;
            border-radius: 0 10px 10px 0;
        }

        .article-content ul,
        .article-content ol {
            margin-left: 2rem;
            margin-bottom: 1.5rem;
        }

        .article-content li {
            margin-bottom: 0.75rem;
        }

        /* Comment Styling */
        .comment-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .comment-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .comment-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .comment-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin-right: 1rem;
        }

        .comment-info {
            flex: 1;
        }

        .comment-author {
            font-weight: 600;
            color: #2c3e50;
            margin: 0 0 0.25rem 0;
        }

        .comment-meta {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .comment-number {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .comment-text {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 4px solid #667eea;
            font-style: italic;
            line-height: 1.6;
            position: relative;
        }

        .quote-icon {
            color: #667eea;
            font-size: 1.2rem;
            margin: 0 0.5rem;
        }

        /* Empty State */
        .empty-state {
            padding: 3rem 2rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ddd6fe 0%, #c4b5fd 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: #8b5cf6;
        }

        .empty-title {
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-description {
            color: #adb5bd;
            margin-bottom: 2rem;
        }

        /* Button Styling */
        .btn-group .btn {
            margin-left: 0.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-group .btn:first-child {
            margin-left: 0;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .article-title {
                font-size: 2rem;
            }
            
            .article-image {
                height: 250px;
            }
            
            .meta-card {
                margin-bottom: 1rem;
            }
            
            .comment-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .comment-avatar {
                margin-bottom: 0.5rem;
            }
            
            .btn-group {
                flex-direction: column;
                width: 100%;
            }
            
            .btn-group .btn {
                margin-left: 0;
                margin-bottom: 0.5rem;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .article-preview > * {
            animation: fadeInUp 0.6s ease-out;
        }

        .comment-item {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
@endpush