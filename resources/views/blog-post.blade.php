<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>{{ $post->title }} | GRAFIUM</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $post->meta_description ?? $post->summary ?? Str::limit(strip_tags($post->text), 150) }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet" />

    <style>
        /* ===== RESET & BASE ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --deep-navy: #0a1628;
            --navy-800: #0f1f33;
            --navy-700: #132238;
            --navy-600: #1a2f4a;
            --gold: #d4a373;
            --gold-dark: #b8874a;
            --gold-light: #f0d5b0;
            --gold-gradient: linear-gradient(135deg, #d4a373, #b8874a);
            --navy-gradient: linear-gradient(135deg, #0a1628, #1a2f4a);
            --bg-body: #f5f7fa;
            --bg-card: #ffffff;
            --bg-soft: #fafbfc;
            --text: #0a1628;
            --text-muted: #6b7a8a;
            --border: #e4e7ec;
            --shadow-sm: 0 2px 8px rgba(10, 22, 40, 0.04);
            --shadow: 0 8px 30px rgba(10, 22, 40, 0.08);
            --shadow-lg: 0 20px 60px rgba(10, 22, 40, 0.15);
            --shadow-gold: 0 20px 50px rgba(212, 163, 115, 0.25);
            --radius: 24px;
            --radius-sm: 16px;
            --font: "Vazirmatn", "Inter", sans-serif;
        }

        [data-theme="dark"] {
            --bg-body: #0a1628;
            --bg-card: #0f1f33;
            --bg-soft: #132238;
            --text: #f0f0f0;
            --text-muted: #94a3b8;
            --border: #1a2f4a;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.2);
            --shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font);
            background: var(--bg-body);
            color: var(--text);
            direction: rtl;
            transition: background 0.4s, color 0.4s;
            line-height: 1.7;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        ::selection { background: var(--gold); color: #fff; }
        a { text-decoration: none; color: inherit; }
        ul { list-style: none; }
        img { max-width: 100%; display: block; }

        .container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }

        /* ============================================================
        ARTICLE SECTION
        ============================================================ */
        .article-section {
            padding: 40px 0 60px;
            background: var(--bg-body);
        }

        .article-container {
            max-width: 900px;
            margin: 0 auto;
            background: var(--bg-card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        /* ===== HERO IMAGE ===== */
        .article-hero {
            height: 380px;
            position: relative;
            overflow: hidden;
            background: var(--navy-gradient);
        }
        .article-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .article-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(10, 22, 40, 0.85) 100%);
            pointer-events: none;
        }

        .article-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--gold-gradient);
            color: #fff;
            padding: 6px 18px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.4);
        }

        /* ===== TITLE OVERLAY ===== */
        .article-title-overlay {
            position: absolute;
            bottom: 0;
            right: 0;
            left: 0;
            padding: 40px 48px 32px;
            z-index: 2;
            color: #fff;
        }
        .article-title {
            font-size: 32px;
            font-weight: 900;
            line-height: 1.3;
            margin-bottom: 14px;
            letter-spacing: -0.5px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        .article-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            align-items: center;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.85);
        }
        .article-meta span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .article-meta i {
            color: var(--gold);
            font-size: 12px;
        }

        /* ===== BODY ===== */
        .article-body {
            padding: 48px 56px;
        }

        /* ===== EXCERPT ===== */
        .article-excerpt {
            font-size: 17px;
            line-height: 2;
            color: var(--text);
            margin-bottom: 32px;
            padding: 24px 28px;
            background: var(--bg-soft);
            border-radius: var(--radius-sm);
            border-right: 4px solid var(--gold);
            font-weight: 500;
            position: relative;
        }
        [data-theme="dark"] .article-excerpt {
            background: var(--navy-700);
        }

        /* ============================================================
        ARTICLE CONTENT — STYLED (این مهم‌ترین بخشه)
        ============================================================ */
        .article-content {
            font-size: 16px;
            line-height: 2.1;
            color: var(--text);
            text-align: justify;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            max-width: 100%;
            overflow: hidden;
        }

        /* پاراگراف‌ها */
        .article-content p {
            margin-bottom: 20px;
            line-height: 2.1;
            text-align: justify;
        }

        /* هدینگ‌ها */
        .article-content h1,
        .article-content h2,
        .article-content h3,
        .article-content h4,
        .article-content h5,
        .article-content h6 {
            color: var(--text);
            font-weight: 800;
            margin-top: 36px;
            margin-bottom: 16px;
            line-height: 1.4;
            position: relative;
            padding-right: 20px;
        }
        .article-content h1 {
            font-size: 28px;
        }
        .article-content h2 {
            font-size: 24px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--border);
        }
        .article-content h2::before,
        .article-content h3::before {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 60%;
            background: var(--gold-gradient);
            border-radius: 3px;
        }
        .article-content h3 {
            font-size: 20px;
        }
        .article-content h4 {
            font-size: 18px;
        }

        /* لیست‌ها */
        .article-content ul,
        .article-content ol {
            margin: 20px 0;
            padding-right: 28px;
        }
        .article-content ul li,
        .article-content ol li {
            margin-bottom: 10px;
            line-height: 2;
            position: relative;
        }
        .article-content ul {
            list-style: none;
            padding-right: 0;
        }
        .article-content ul li {
            padding-right: 28px;
        }
        .article-content ul li::before {
            content: '';
            position: absolute;
            right: 8px;
            top: 14px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--gold-gradient);
            box-shadow: 0 0 8px rgba(212, 163, 115, 0.5);
        }
        .article-content ol {
            list-style: none;
            counter-reset: list-counter;
            padding-right: 0;
        }
        .article-content ol li {
            counter-increment: list-counter;
            padding-right: 44px;
        }
        .article-content ol li::before {
            content: counter(list-counter);
            position: absolute;
            right: 0;
            top: 6px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--gold-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            box-shadow: 0 4px 12px rgba(212, 163, 115, 0.35);
        }

        /* تصاویر */
        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: var(--radius-sm);
            margin: 28px auto;
            box-shadow: var(--shadow);
            display: block;
        }

        /* بلاک‌کوت */
        .article-content blockquote {
            margin: 28px 0;
            padding: 24px 32px;
            background: var(--bg-soft);
            border-radius: var(--radius-sm);
            border-right: 4px solid var(--gold);
            font-style: italic;
            color: var(--text-muted);
            font-size: 16px;
            line-height: 2;
            position: relative;
        }
        [data-theme="dark"] .article-content blockquote {
            background: var(--navy-700);
        }
        .article-content blockquote::before {
            content: '"';
            position: absolute;
            top: -20px;
            right: 20px;
            font-size: 80px;
            color: rgba(212, 163, 115, 0.15);
            font-family: Georgia, serif;
            line-height: 1;
        }

        /* لینک‌ها */
        .article-content a {
            color: var(--gold-dark);
            font-weight: 600;
            text-decoration: underline;
            text-decoration-color: rgba(212, 163, 115, 0.4);
            text-underline-offset: 4px;
            transition: all 0.3s;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .article-content a:hover {
            color: var(--gold);
            text-decoration-color: var(--gold);
        }

        /* کد */
        .article-content code {
            background: var(--bg-soft);
            color: var(--gold-dark);
            padding: 2px 8px;
            border-radius: 6px;
            font-family: 'Consolas', 'Monaco', monospace;
            font-size: 14px;
            direction: ltr;
            display: inline-block;
            word-wrap: break-word;
            max-width: 100%;
        }
        [data-theme="dark"] .article-content code {
            background: var(--navy-700);
        }
        .article-content pre {
            background: var(--navy-800);
            color: #f0f0f0;
            padding: 20px 24px;
            border-radius: var(--radius-sm);
            overflow-x: auto;
            margin: 24px 0;
            font-size: 14px;
            line-height: 1.8;
            direction: ltr;
            text-align: left;
            max-width: 100%;
        }
        .article-content pre code {
            background: transparent;
            color: inherit;
            padding: 0;
        }

        /* جداول */
        .article-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 24px 0;
            border-radius: var(--radius-sm);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            font-size: 14px;
        }
        .article-content table thead {
            background: var(--navy-gradient);
            color: #fff;
        }
        .article-content table th {
            padding: 14px 16px;
            text-align: right;
            font-weight: 700;
            font-size: 13px;
        }
        .article-content table td {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            text-align: right;
        }
        .article-content table tbody tr:last-child td {
            border-bottom: none;
        }
        .article-content table tbody tr:nth-child(even) {
            background: var(--bg-soft);
        }
        [data-theme="dark"] .article-content table tbody tr:nth-child(even) {
            background: var(--navy-700);
        }

        /* جداکننده */
        .article-content hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 40px 0;
            opacity: 0.5;
        }

        /* متن bold و italic */
        .article-content strong,
        .article-content b {
            color: var(--text);
            font-weight: 800;
        }
        .article-content em,
        .article-content i {
            font-style: italic;
            color: var(--text-muted);
        }

        /* iframe (ویدیو) */
        .article-content iframe {
            max-width: 100%;
            width: 100%;
            border-radius: var(--radius-sm);
            margin: 24px 0;
            box-shadow: var(--shadow);
        }

        /* ============================================================
        TAGS
        ============================================================ */
        .article-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 40px;
            padding-top: 32px;
            border-top: 2px dashed var(--border);
        }
        .article-tags-title {
            font-size: 13px;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }
        .article-tags-title i { color: var(--gold); }

        .article-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            transition: all 0.3s;
        }
        [data-theme="dark"] .article-tag {
            background: var(--navy-700);
        }
        .article-tag:hover {
            background: var(--gold-gradient);
            color: #fff;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.3);
        }
        .article-tag i {
            color: var(--gold);
            font-size: 11px;
        }
        .article-tag:hover i { color: #fff; }

        /* ============================================================
        BACK LINK
        ============================================================ */
        .back-wrapper {
            margin-top: 40px;
            padding-top: 28px;
            border-top: 1px solid var(--border);
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            border-radius: 14px;
            font-weight: 700;
            font-size: 14px;
            color: var(--text);
            transition: all 0.3s;
        }
        [data-theme="dark"] .back-link {
            background: var(--navy-700);
        }
        .back-link:hover {
            background: var(--gold-gradient);
            color: #fff;
            border-color: transparent;
            transform: translateX(-6px);
            box-shadow: 0 10px 25px rgba(212, 163, 115, 0.35);
        }
        .back-link i {
            transition: transform 0.3s;
        }
        .back-link:hover i {
            transform: translateX(-6px);
        }

        /* ============================================================
        RELATED POSTS
        ============================================================ */
        .related-section {
            margin-top: 60px;
            padding: 40px 0;
        }
        .related-header {
            text-align: center;
            margin-bottom: 36px;
        }
        .related-header h3 {
            font-size: 26px;
            font-weight: 800;
            color: var(--text);
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }
        .related-header h3 i { color: var(--gold); }
        .related-header h3 .gold-line {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .related-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            display: block;
        }
        .related-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: var(--shadow-gold);
        }

        .related-image {
            height: 160px;
            overflow: hidden;
            position: relative;
            background: var(--navy-gradient);
        }
        .related-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s;
        }
        .related-card:hover .related-image img {
            transform: scale(1.1);
        }

        .related-content {
            padding: 20px;
        }
        .related-content h4 {
            font-size: 15px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 8px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color 0.3s;
        }
        .related-card:hover .related-content h4 {
            color: var(--gold-dark);
        }
        [data-theme="dark"] .related-card:hover .related-content h4 {
            color: var(--gold);
        }
        .related-content p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.7;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ============================================================
        CTA
        ============================================================ */
        .cta {
            background: var(--navy-gradient);
            color: #fff;
            padding: 100px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-top: 2px solid var(--gold);
        }
        .cta::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 50%, rgba(212, 163, 115, 0.08), transparent 60%);
        }
        .cta::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 80% 50%, rgba(212, 163, 115, 0.06), transparent 60%);
        }
        .cta .container { position: relative; z-index: 1; }
        .cta h2 {
            font-size: 40px;
            font-weight: 800;
            margin-bottom: 16px;
            line-height: 1.3;
        }
        .cta h2 .gold-line {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .cta p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto 36px;
        }
        .cta-buttons {
            display: flex;
            gap: 18px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 32px;
            border-radius: 60px;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid transparent;
        }
        .cta-btn.gold {
            background: var(--gold-gradient);
            color: #fff;
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.35);
        }
        .cta-btn.gold:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(212, 163, 115, 0.55);
        }
        .cta-btn.gold:hover i { transform: translateX(-5px); }
        .cta-btn.gold i { transition: transform 0.3s; }
        .cta-btn.white {
            background: #fff;
            color: var(--deep-navy);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.15);
        }
        .cta-btn.white:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(255, 255, 255, 0.3);
        }

        /* ============================================================
        RESPONSIVE
        ============================================================ */
        @media (max-width: 992px) {
            .related-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .article-hero { height: 280px; }
            .article-title-overlay { padding: 28px 24px 24px; }
            .article-title { font-size: 22px; }
            .article-meta { font-size: 11px; gap: 12px; }
            .article-body { padding: 32px 24px; }
            .article-excerpt { font-size: 15px; padding: 18px 20px; }
            .article-content { font-size: 15px; }
            .article-content h1 { font-size: 22px; }
            .article-content h2 { font-size: 19px; }
            .article-content h3 { font-size: 17px; }
            .related-grid { grid-template-columns: 1fr; }
            .cta h2 { font-size: 26px; }
            .cta { padding: 60px 0; }
        }
        @media (max-width: 480px) {
            .article-hero { height: 240px; }
            .article-title { font-size: 19px; }
            .article-body { padding: 24px 18px; }
            .article-excerpt { font-size: 14px; padding: 16px; }
            .article-content { font-size: 14px; }
            .article-content h2::before,
            .article-content h3::before { width: 4px; }
            .cta-buttons { flex-direction: column; }
            .cta-btn { width: 100%; justify-content: center; }
        }
    </style>
</head>

<body>

    @include('partials.header')

    <!-- ============================================================
    ARTICLE SECTION
    ============================================================ -->
    <section class="article-section">
        <div class="container">
            <article class="article-container">

                <!-- ===== HERO ===== -->
                <div class="article-hero">
                    <img
                        src="{{ $post->media ? asset('storage/' . $post->media) : 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=1200&h=600&fit=crop' }}"
                        alt="{{ $post->title }}"
                        onerror="this.style.display='none'"
                    />

                    <span class="article-badge">
                        <i class="fas fa-folder"></i>
                        {{ $post->category->name ?? 'عمومی' }}
                    </span>

                    <!-- Title overlay -->
                    <div class="article-title-overlay">
                        <h1 class="article-title">{{ $post->title }}</h1>
                        <div class="article-meta">
                            <span>
                                <i class="fas fa-calendar-alt"></i>
                                {{ $post->created_at ? $post->created_at->format('Y/m/d') : '—' }}
                            </span>
                            <span>
                                <i class="fas fa-eye"></i>
                                {{ number_format($post->views ?? 0) }} بازدید
                            </span>
                            @if($post->author)
                            <span>
                                <i class="fas fa-user"></i>
                                {{ $post->author->name }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- ===== BODY ===== -->
                <div class="article-body">

                    <!-- Excerpt -->
                    @if($post->summary)
                        <div class="article-excerpt">
                            {{ $post->summary }}
                        </div>
                    @endif

                    <!-- Content (متن مقاله) -->
                    <div class="article-content">
                        {!! $post->text !!}
                    </div>

                    <!-- Tags -->
                    @if($post->tags)
                        <div class="article-tags">
                            <div class="article-tags-title">
                                <i class="fas fa-tags"></i>
                                برچسب‌ها
                            </div>
                            @foreach(explode(',', $post->tags) as $tag)
                                <a href="{{ route('blog.search', ['q' => trim($tag)]) }}" class="article-tag">
                                    <i class="fas fa-tag"></i>
                                    {{ trim($tag) }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <!-- Back link -->
                    <div class="back-wrapper">
                        <a href="{{ route('blog') }}" class="back-link">
                            <i class="fas fa-arrow-right"></i>
                            <span>بازگشت به مقالات</span>
                        </a>
                    </div>

                </div>

            </article>

            <!-- ===== RELATED POSTS ===== -->
            @if(isset($relatedPosts) && $relatedPosts->count() > 0)
                <div class="related-section">
                    <div class="related-header">
                        <h3>
                            <i class="fas fa-book-open"></i>
                            <span class="gold-line">مقالات مرتبط</span>
                        </h3>
                    </div>

                    <div class="related-grid">
                        @foreach($relatedPosts as $related)
                            <a href="{{ route('blog.post', $related->id) }}" class="related-card">
                                <div class="related-image">
                                    <img
                                        src="{{ $related->media ? asset('storage/' . $related->media) : 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=600&h=400&fit=crop' }}"
                                        alt="{{ $related->title }}"
                                        onerror="this.style.display='none'"
                                    />
                                </div>
                                <div class="related-content">
                                    <h4>{{ $related->title }}</h4>
                                    <p>{{ Str::limit(strip_tags($related->summary ?? $related->text), 80) }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta">
        <div class="container">
            <h2>
                فضای کاری <span class="gold-line">خود را امروز رزرو کنید</span>
            </h2>
            <p>
                به جامعه طراحان حرفه‌ای بپیوندید و از امکانات ممتاز گرافیوم لذت ببرید.
            </p>
            <div class="cta-buttons">
                <a href="{{ route('services') }}" class="cta-btn gold">
                    <i class="fas fa-rocket"></i>
                    <span>رزرو میز</span>
                </a>
                <a href="{{ route('contact') }}" class="cta-btn white">
                    <i class="fas fa-headset"></i>
                    <span>تماس با ما</span>
                </a>
            </div>
        </div>
    </section>

</body>

</html>
