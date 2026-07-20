@extends('web.layouts.master')

@section('title', $post['title'])

@section('content')
    <style>
        .blog-details-page {
            padding: 3rem 0;
            background:
                radial-gradient(circle at top left, rgba(246, 203, 122, 0.22), transparent 26%),
                linear-gradient(180deg, #f8fafc 0%, #eef4f8 100%);
        }

        .blog-details-hero {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            max-width: 560px;
            margin: 0 auto 1.5rem;
            min-height: 140px;
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.12);
            background: #0f172a;
        }

        .blog-details-hero img {
            width: 100%;
            height: 100%;
            min-height: 140px;
            object-fit: cover;
            opacity: 0.72;
        }

        .blog-details-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: flex-end;
            padding: 1rem;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.08) 0%, rgba(15, 23, 42, 0.85) 100%);
        }

        .blog-details-content {
            color: #fff;
            max-width: 520px;
        }

        .blog-details-badge {
            display: inline-flex;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .blog-details-title {
            font-size: clamp(1.5rem, 2.4vw, 2.1rem);
            line-height: 1.08;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 0.75rem;
        }

        .blog-details-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            color: rgba(255, 255, 255, 0.85);
            font-weight: 500;
        }

        .blog-details-card {
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(148, 163, 184, 0.18);
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
            padding: 1.5rem;
            backdrop-filter: blur(14px);
        }

        .blog-details-card p {
            color: #475569;
            line-height: 1.8;
            font-size: 1rem;
        }

        .blog-details-list {
            list-style: none;
            padding: 0;
            margin: 1rem 0 0;
            display: grid;
            gap: 0.6rem;
        }

        .blog-details-list li {
            padding: 0.75rem 0.9rem;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.15);
            color: #0f172a;
            font-weight: 600;
        }

        .blog-sidebar-card {
            border-radius: 22px;
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.18);
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
            padding: 1.25rem;
        }

        .blog-sidebar-title {
            font-weight: 800;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: #0f172a;
        }

        .related-link {
            display: block;
            text-decoration: none;
            color: inherit;
            padding: 0.9rem 0;
            border-top: 1px solid rgba(148, 163, 184, 0.16);
        }

        .related-link:first-of-type {
            border-top: 0;
            padding-top: 0;
        }

        .related-link strong {
            display: block;
            color: #0f172a;
            margin-bottom: 0.25rem;
        }

        .related-link span {
            color: #64748b;
            font-size: 0.95rem;
        }
    </style>

    <div class="blog-details-page">
        <div class="container">
            <div class="blog-details-hero">
                <img src="{{ Str::startsWith($post['image'] ?? '', 'http') ? $post['image'] : asset('storage/' . ($post['image'] ?? '')) }}" alt="{{ $post['title'] ?? '' }}">
                <div class="blog-details-overlay">
                    <div class="blog-details-content">
                        <div class="blog-details-badge">{{ $post['category'] }}</div>
                        <h1 class="blog-details-title">{{ $post['title'] }}</h1>
                        <div class="blog-details-meta">
                            <span>{{ $post['date'] }}</span>
                            <span>{{ $post['read_time'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="blog-details-card">
                        <p>{{ $post['excerpt'] }}</p>
                        @if(is_iterable($post['content']))
                            @foreach ($post['content'] as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        @elseif(!empty($post['content']))
                            <p>{{ $post['content'] }}</p>
                        @endif

                        @if(!empty($post['highlights']) && is_iterable($post['highlights']) && count($post['highlights']) > 0)
                        <h3 class="mt-4 mb-3" style="color: #0f172a; font-weight: 800;">Highlights</h3>
                        <ul class="blog-details-list">
                            @foreach ($post['highlights'] as $highlight)
                                <li>{{ $highlight }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="blog-sidebar-card mb-4">
                        <div class="blog-sidebar-title">More Stories</div>
                        @foreach ($relatedPosts as $relatedPost)
                            <a href="{{ route('blog.details', $relatedPost['slug']) }}" class="related-link">
                                <strong>{{ $relatedPost['title'] }}</strong>
                                <span>{{ $relatedPost['category'] }} · {{ $relatedPost['read_time'] }}</span>
                            </a>
                        @endforeach
                    </div>

                    <div class="blog-sidebar-card">
                        <div class="blog-sidebar-title">Plan Your Stay</div>
                        <p class="mb-0">Pair your trip with the right room, dining, and wellness options for a more
                            memorable experience.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
