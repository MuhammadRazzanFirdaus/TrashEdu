@extends('templates.app')

@push('style')
    <style>
        /* Card Hover Effect */
        .hover-card-green {
            transition: all 0.3s ease;
            border: 1px solid #e8f5e9;
            border-radius: 12px;
        }

        .hover-card-green:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(25, 135, 84, 0.1) !important;
            border-color: #198754;
        }

        /* Line Clamp untuk judul */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Button Hover Effect */
        .btn-outline-success:hover {
            background-color: #198754;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2);
        }

        /* Card Badge Styling */
        .badge.bg-success.bg-opacity-10 {
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        /* Pagination Styling */
        .page-link.text-success {
            background: white;
        }

        .page-link.text-success:hover {
            background-color: #198754;
            color: white !important;
            border-color: #198754;
        }

        .page-item.active .page-link {
            background-color: #198754 !important;
            border-color: #198754 !important;
            color: white !important;
        }

        /* Smooth transitions */
        .card,
        .btn,
        .badge {
            transition: all 0.2s ease;
        }

        /* Card footer styling */
        .card-footer {
            background: linear-gradient(to bottom, transparent, rgba(25, 135, 84, 0.02));
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-12">
                <h1 class="fw-bold text-success mb-3">
                    <i class="bi bi-journal-text me-2"></i>Artikel Terbaru
                </h1>
                <p class="text-muted">Temukan artikel informatif dan bermanfaat untuk menambah wawasan Anda</p>
            </div>
        </div>

        @if ($articles->count())
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($articles as $article)
                    <div class="col mb-5">
                        <div class="card h-100 border-0 shadow-lg hover-card-green">
                            <!-- Card Body Utama -->
                            <div class="card-body d-flex flex-column p-4">
                                <!-- Kategori Badge -->
                                @if ($article->category)
                                    <div class="mb-3">
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill">
                                            <i class="bi bi-tag me-1"></i>{{ $article->category->name }}
                                        </span>
                                    </div>
                                @endif

                                <!-- Tanggal -->
                                <div class="mb-2">
                                    <small class="text-success">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $article->created_at->format('d M Y') }}
                                    </small>
                                </div>

                                <!-- Judul Artikel -->
                                <h5 class="card-title fw-bold text-dark mb-3 line-clamp-2">
                                    {{ $article->title }}
                                </h5>

                                <!-- Konten Ringkas -->
                                <p class="card-text text-secondary mb-4 flex-grow-1">
                                    {{ Str::limit(strip_tags($article->content), 120, '...') }}
                                </p>

                                <!-- Divider -->
                                <hr class="text-success opacity-25 my-3">

                                <!-- Footer dengan tombol dan info -->
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <a href="{{ route('user.articles.show', $article->id) }}"
                                        class="btn btn-outline-success btn-sm px-4">
                                        <i class="bi bi-book"></i>Baca
                                    </a>
                                    <div class="card-footer bg-white border-top-0  px-4 ">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-success">
                                                <i class="bi bi-arrow-repeat me-1"></i>
                                                Updated: {{ $article->updated_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($articles->hasPages())
                <div class="row mt-5">
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item {{ $articles->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link text-success border-success"
                                        href="{{ $articles->previousPageUrl() }}">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>

                                @foreach (range(1, $articles->lastPage()) as $i)
                                    <li class="page-item {{ $articles->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link {{ $articles->currentPage() == $i ? 'bg-success border-success' : 'text-success border-success' }}"
                                            href="{{ $articles->url($i) }}">
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endforeach

                                <li class="page-item {{ !$articles->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link text-success border-success" href="{{ $articles->nextPageUrl() }}">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6 mx-auto">
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-journal-x display-1 text-success opacity-25"></i>
                        </div>
                        <h4 class="text-success fw-semibold mb-3">Belum ada artikel tersedia</h4>
                        <p class="text-muted mb-4">
                            Kami sedang mempersiapkan konten terbaik untuk Anda.
                            Silakan kembali nanti untuk membaca artikel menarik.
                        </p>
                        <a href="{{ url('/') }}" class="btn btn-success px-4">
                            <i class="bi bi-house me-2"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
