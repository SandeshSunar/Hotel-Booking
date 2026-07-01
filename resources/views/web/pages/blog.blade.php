@extends('web.layouts.master')

@section('title', 'Blog')

@section('content')
    <style>
        .blog-page {
            position: relative;
            overflow: hidden;
            padding: 5rem 0;
            background:
                radial-gradient(circle at top left, rgba(246, 203, 122, 0.24), transparent 28%),
                radial-gradient(circle at top right, rgba(12, 74, 110, 0.15), transparent 24%),
                linear-gradient(180deg, #f8fafc 0%, #eef4f8 100%);
        }

        .blog-page::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(255, 255, 255, 0.35) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.35) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.4), transparent 65%);
            pointer-events: none;
        }

        .blog-shell {
            position: relative;
            z-index: 1;
        }

        .blog-hero {
            text-align: center;
            margin-bottom: 3rem;
        }

        .blog-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            background: rgba(17, 24, 39, 0.08);
            color: #0f172a;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .blog-title {
            font-size: clamp(2.4rem, 5vw, 4.5rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #0f172a;
            margin-bottom: 1rem;
        }

        .blog-lead {
            max-width: 760px;
            margin: 0 auto;
            color: #475569;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .blog-card-link {
            display: block;
            text-decoration: none;
            color: inherit;
            height: 100%;
        }

        .blog-card {
            height: 100%;
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 24px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(14px);
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08);
            transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
        }

        .blog-card-link:hover .blog-card {
            transform: translateY(-8px);
            box-shadow: 0 26px 60px rgba(15, 23, 42, 0.14);
            border-color: rgba(15, 23, 42, 0.12);
        }

        .blog-media {
            position: relative;
            overflow: hidden;
            aspect-ratio: 16 / 10;
        }

        .blog-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.45s ease;
        }

        .blog-card-link:hover .blog-media img {
            transform: scale(1.05);
        }

        .blog-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            padding: 0.45rem 0.8rem;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.8);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .blog-body {
            padding: 1.5rem;
        }

        .blog-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 0.9rem;
        }

        .blog-meta span {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .blog-card-title {
            color: #0f172a;
            font-size: 1.35rem;
            font-weight: 700;
            line-height: 1.35;
            margin-bottom: 0.85rem;
        }

        .blog-card-text {
            color: #475569;
            margin-bottom: 0;
            line-height: 1.75;
        }

        .blog-readmore {
            margin-top: 1.25rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #0f172a;
            font-weight: 700;
        }
    </style>

    <div class="blog-page">
        <div class="container blog-shell">
            <div class="blog-hero">
                <div class="blog-kicker">Stories, guides, and hotel moments</div>
                <h1 class="blog-title">Our Blog</h1>
                <p class="blog-lead">Explore travel tips, dining inspiration, and hotel experiences designed to help guests
                    plan a better stay.</p>
            </div>

            <div class="row g-4">
                @foreach ($posts as $post)
                    <div class="col-md-6">
                        <a href="{{ route('blog.details', $post['slug']) }}" class="blog-card-link">
                            <article class="blog-card">
                                <div class="blog-media">
                                    <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}">
                                    <div class="blog-badge">{{ $post['category'] }}</div>
                                </div>
                                <div class="blog-body">
                                    <div class="blog-meta">
                                        <span>{{ $post['date'] }}</span>
                                        <span>{{ $post['read_time'] }}</span>
                                    </div>
                                    <h2 class="blog-card-title">{{ $post['title'] }}</h2>
                                    <p class="blog-card-text">{{ $post['excerpt'] }}</p>
                                    <div class="blog-readmore">Read story <span aria-hidden="true">→</span></div>
                                </div>
                            </article>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
