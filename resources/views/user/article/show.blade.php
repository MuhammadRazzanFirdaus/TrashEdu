@extends('templates.app')

@push('style')
<style>
    /* Article Content Styling */
    .article-content .content-body p {
        text-align: justify;
        line-height: 1.8;
    }

    .article-content .lead {
        font-size: 1.25rem;
        color: #495057;
        border-left: 4px solid #198754;
        padding-left: 1.5rem;
        font-style: italic;
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Card hover effect for related articles */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(25, 135, 84, 0.1) !important;
    }

    /* Button hover effects */
    .btn-outline-success:hover {
        background-color: #198754;
        color: white;
        transform: translateY(-1px);
    }

    .btn-success:hover {
        background-color: #157347;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        h1.display-5 {
            font-size: 2.2rem;
        }

        .article-content .content-body {
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <!-- Article Header -->
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <!-- Category Badge -->
            @if($article->category)
                <div class="mb-4">
                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">
                        <i class="bi bi-tag me-1"></i>{{ $article->category->name }}
                    </span>
                </div>
            @endif

            <!-- Article Title -->
            <h1 class="display-5 fw-bold text-dark mb-3">{{ $article->title }}</h1>

            <!-- Article Meta -->
            <div class="d-flex flex-wrap align-items-center gap-3 mb-5">
                <div class="d-flex align-items-center text-muted">
                    <i class="bi bi-calendar3 me-2"></i>
                    <span>Dipublikasikan: {{ $article->created_at->format('d F Y') }}</span>
                </div>
                <div class="d-flex align-items-center text-muted">
                    <i class="bi bi-arrow-repeat me-2"></i>
                    <span>Diperbarui: {{ $article->updated_at->format('d F Y') }}</span>
                </div>
            </div>

            <!-- Optional Featured Image -->
            @if($article->image_url)
                <div class="mb-5">
                    <img src="{{ $article->image_url }}"
                         alt="{{ $article->title }}"
                         class="img-fluid rounded-3 shadow-sm"
                         style="max-height: 400px; width: 100%; object-fit: cover;">
                </div>
            @endif

            <!-- Article Content -->
            <div class="article-content mb-5">
                <div class="lead mb-4 text-muted">
                    {{ Str::limit(strip_tags($article->content), 200) }}
                </div>

                <div class="content-body fs-5 lh-lg">
                    {!! $article->content !!}
                </div>
            </div>

            <!-- Article Footer -->
            <div class="border-top border-bottom py-4 my-5">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-person-circle text-success fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Penulis</small>
                                <span class="fw-semibold">{{ $article->author ?? 'Admin' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-md-end gap-2">
                            <a href="{{ route('user.articles.index') }}"
                               class="btn btn-outline-success px-4">
                                <i class="bi bi-list-ul me-2"></i>Semua Artikel
                            </a>
                            <button class="btn btn-success px-4" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                                <i class="bi bi-arrow-up me-2"></i>Ke Atas
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
