<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>GRAFIUM | سالن کار اشتراکی گرافیکی</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap" rel="stylesheet" />

    <style>
        /* ===== تمام CSS در اینجا ===== */
        @font-face {
            font-family: 'Vazirmatn';
            src: url('Vazir_p30download.com.eot') format('woff2');
            font-weight: 400;
            font-style: normal;
        }
        @font-face {
            font-family: 'Vazirmatn';
            src: url('Vazir_p30download.com.eot') format('woff2');
            font-weight: 700;
            font-style: normal;
        }
        @font-face {
            font-family: 'Vazirmatn';
            src: url('Vazir_p30download.com.eot') format('woff2');
            font-weight: 800;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --deep-navy: #0a1628;
            --deep-navy-light: #132238;
            --gold: #d4a373;
            --gold-dark: #b8874a;
            --gold-light: #f0d5b0;
            --gold-gradient: linear-gradient(135deg, #d4a373, #b8874a);
            --navy-gradient: linear-gradient(135deg, #0a1628, #1a2f4a);
            --bg-body: #f5f7fa;
            --bg-card: #ffffff;
            --text: #0a1628;
            --text-muted: #6b7a8a;
            --border: #e4e7ec;
            --shadow: 0 4px 30px rgba(10, 22, 40, 0.08);
            --radius: 16px;
            --radius-sm: 12px;
            --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font: "Vazirmatn", "Inter", sans-serif;
        }

        [data-theme="dark"] {
            --bg-body: #0a1628;
            --bg-card: #132238;
            --text: #f0f0f0;
            --text-muted: #a0a0a0;
            --border: #1a2f4a;
            --shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font);
            background: var(--bg-body);
            color: var(--text);
            direction: rtl;
            transition: background 0.4s, color 0.4s;
            line-height: 1.7;
            overflow-x: hidden;
        }

        ::selection {
            background: var(--gold);
            color: #fff;
        }

        a {
            text-decoration: none;
            color: inherit;
        }
        ul {
            list-style: none;
        }
        img {
            max-width: 100%;
            display: block;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ===== TEXT & BADGE ===== */
        .gold-text {
            background: var(--gold-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .purple-text {
            color: var(--deep-navy);
        }
        [data-theme="dark"] .purple-text {
            color: #f0f0f0;
        }

        .gradient-badge {
            display: inline-block;
            background: var(--gold-gradient);
            color: #fff;
            padding: 4px 16px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
            cursor: pointer;
            border: 2px solid transparent;
            background: var(--gold-gradient);
            color: #fff;
        }
        .btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.3);
        }
        .btn-gold {
            background: var(--gold-gradient);
            border-color: var(--gold);
            box-shadow: 0 4px 20px rgba(212, 163, 115, 0.2);
        }
        .btn-gold:hover {
            border-color: var(--gold-light);
            box-shadow: 0 8px 35px rgba(212, 163, 115, 0.35);
        }
        .btn-gold-outline {
            background: transparent;
            color: var(--gold);
            border: 2px solid var(--gold);
        }
        .btn-gold-outline:hover {
            background: var(--gold-gradient);
            color: #fff;
            border-color: transparent;
        }

        /* ===== SECTION HEADER ===== */
        .section {
            padding: 25px 0;
        }
        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 50px;
        }
        .section-header h2 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 12px;
        }
        .section-header p {
            color: var(--text-muted);
            font-size: 16px;
        }

        /* ===== HEADER ===== */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(10, 22, 40, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(212, 163, 115, 0.15);
            padding: 8px 0;
            transition: background 0.4s, border-color 0.4s;
        }
        [data-theme="dark"] .header {
            background: rgba(10, 22, 40, 0.95);
        }
        [data-theme="light"] .header {
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid var(--border);
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 22px;
            font-weight: 800;
        }
        .logo-img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .nav-desktop ul {
            display: flex;
            gap: 28px;
        }
        .nav-desktop a {
            font-weight: 500;
            font-size: 15px;
            position: relative;
            transition: color 0.3s;
            color: rgba(255, 255, 255, 0.7);
        }
        [data-theme="light"] .nav-desktop a {
            color: var(--deep-navy);
        }
        .nav-desktop a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            right: 0;
            width: 0;
            height: 2px;
            background: var(--gold-gradient);
            transition: width 0.3s;
        }
        .nav-desktop a:hover::after {
            width: 100%;
        }
        .nav-desktop a:hover {
            color: var(--gold);
        }
        .nav-desktop a.active {
            color: var(--gold);
        }
        .nav-desktop a.active::after {
            width: 100%;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: transparent;
            color: #fff;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }
        [data-theme="light"] .theme-toggle {
            border-color: var(--border);
            color: var(--deep-navy);
        }
        .theme-toggle:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        .menu-toggle {
            display: none;
            font-size: 24px;
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
        }
        [data-theme="light"] .menu-toggle {
            color: var(--deep-navy);
        }

        /* ===== MOBILE MENU ===== */
        .mobile-menu {
            display: none;
            flex-direction: column;
            gap: 16px;
            padding: 20px;
            background: var(--bg-card);
            border-top: 1px solid var(--border);
        }
        .mobile-menu.open {
            display: flex;
        }
        .mobile-menu ul {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .mobile-menu a {
            font-weight: 500;
            font-size: 16px;
        }
        .mobile-auth {
            display: flex;
            gap: 12px;
        }

        /* ===== HERO SLIDER ===== */
        .hero-slider {
            padding: 0;
            position: relative;
        }
        .hero-slide {
            height: 620px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            color: #fff;
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
        }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(10, 22, 40, 0.65);
            z-index: 1;
        }
        .hero-content {
            position: relative;
            z-index: 2;
            text-align: right;
            margin-right: 35px;
            margin-left: auto;
            max-width: 700px;
            width: 100%;
            padding-right: 40px;
        }
        .hero-content h1 {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            font-size: 52px;
            font-weight: 900;
            margin-bottom: 16px;
            line-height: 1.3;
            color: #f0d5b0;
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .hero-content p {
            text-align: right;
            font-size: 20px;
            max-width: 600px;
            margin: 0 0 28px 0;
            color: #e0e0e0;
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .hero-content .btn {
            align-self: flex-start;
            background: var(--gold-gradient);
            color: #fff;
            border: none;
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .hero-content h1.animate-in,
        .hero-content p.animate-in,
        .hero-content .btn.animate-in {
            opacity: 1;
            transform: translateY(0);
            color: inherit;
        }
        .hero-content h1.animate-in {
            color: #f0d5b0 !important;
        }
        .hero-content p.animate-in {
            color: #e0e0e0 !important;
        }
        .hero-slide::before {
            content: '';
            position: absolute;
            inset: 0;
            background: inherit;
            background-size: cover;
            background-position: center;
            transform: scale(1);
            transition: transform 6s ease;
            z-index: 0;
        }
        .swiper-slide-active .hero-slide::before {
            transform: scale(1.08);
        }

        .swiper-button-next,
        .swiper-button-prev {
            background: rgba(255, 255, 255, 0.08) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(212, 163, 115, 0.3) !important;
            border-radius: 50% !important;
            width: 50px !important;
            height: 50px !important;
            transition: all 0.4s ease !important;
            color: var(--gold) !important;
        }
        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: var(--gold-gradient) !important;
            border-color: var(--gold) !important;
            color: #fff !important;
            box-shadow: 0 0 30px rgba(212, 163, 115, 0.3) !important;
        }
        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 18px !important;
            font-weight: 700 !important;
        }

        .swiper-pagination-bullet {
            width: 12px !important;
            height: 12px !important;
            background: rgba(212, 163, 115, 0.3) !important;
            opacity: 1 !important;
            border: 2px solid rgba(255, 255, 255, 0.2) !important;
            transition: all 0.4s ease !important;
        }
        .swiper-pagination-bullet-active {
            background: var(--gold) !important;
            border-color: var(--gold) !important;
            width: 28px !important;
            border-radius: 6px !important;
            box-shadow: 0 0 20px rgba(212, 163, 115, 0.3) !important;
        }

        .swiper-progress-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: rgba(255, 255, 255, 0.15);
            z-index: 10;
            border-radius: 0;
            overflow: hidden;
        }
        .swiper-progress-fill {
            display: block;
            height: 100%;
            width: 0%;
            background: var(--gold-gradient);
            transition: width 0.1s linear;
            border-radius: 0;
        }

        /* ===== 3D PARTICLE SPHERE ===== */
        #particleSphere {
            position: absolute;
            top: 50%;
            left: 5%;
            transform: translateY(-50%);
            width: 500px;
            height: 500px;
            z-index: 2;
            pointer-events: none;
            opacity: 0;
            animation: fadeInSphere 2s ease forwards;
            animation-delay: 0.5s;
        }
        @keyframes fadeInSphere {
            0% {
                opacity: 0;
                transform: translateY(-50%) scale(0.8);
            }
            100% {
                opacity: 1;
                transform: translateY(-50%) scale(1);
            }
        }

        /* ===== TRUST BAR ===== */
        .trust-bar {
            background: var(--bg-card);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 24px 0;
            overflow: hidden;
            position: relative;
        }
        .trust-bar::before,
        .trust-bar::after {
            content: '';
            position: absolute;
            top: 0;
            width: 80px;
            height: 100%;
            z-index: 2;
            pointer-events: none;
        }
        .trust-bar::before {
            right: 0;
            background: linear-gradient(270deg, var(--bg-card), transparent);
        }
        .trust-bar::after {
            left: 0;
            background: linear-gradient(90deg, var(--bg-card), transparent);
        }
        .trust-track {
            display: flex;
            gap: 60px;
            animation: scrollTrust 25s linear infinite;
            width: max-content;
        }
        .trust-track .trust-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 14px;
            white-space: nowrap;
        }
        .trust-track .trust-item i {
            color: var(--gold);
            font-size: 20px;
        }
        @keyframes scrollTrust {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        /* ===== SERVICES GRID ===== */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
        }
        .service-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 32px 24px;
            text-align: center;
            border: 1px solid var(--border);
            transition: var(--transition);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gold-gradient);
            transform: scaleX(0);
            transition: transform 0.5s;
        }
        .service-card:hover::before {
            transform: scaleX(1);
        }
        .service-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
        }
        .service-icon {
            font-size: 44px;
            color: var(--gold);
            margin-bottom: 16px;
        }
        .service-card h3 {
            font-size: 20px;
            margin-bottom: 8px;
        }
        .service-card p {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 16px;
        }
        .service-links {
            display: flex;
            justify-content: center;
            gap: 16px;
        }
        .service-links a {
            font-size: 14px;
            font-weight: 600;
            color: var(--gold);
        }
        .service-links a:hover {
            color: var(--gold-dark);
            text-decoration: underline;
        }

        /* ===== FAQ ===== */
        .faq-list {
            max-width: 800px;
            margin: 52px auto 0;
        }
        .faq-item {
            border-bottom: 1px solid var(--border);
            padding: 8px 0;
            transition: all 0.3s ease;
        }
        .faq-item:first-child {
            border-top: 1px solid var(--border);
        }
        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 17px;
            color: var(--text);
            transition: color 0.3s ease;
            user-select: none;
        }
        .faq-question:hover {
            color: var(--gold);
        }
        .faq-question i {
            transition: transform 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            font-size: 18px;
            color: var(--gold);
        }
        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.23, 1, 0.32, 1), padding 0.3s ease;
            padding: 0 4px;
            color: var(--text-muted);
            font-size: 15px;
            line-height: 1.8;
        }
        .faq-item.active .faq-answer {
            max-height: 300px;
            padding: 0 4px 20px;
        }

        /* ===== BLOG ===== */
        .blog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .blog-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
            transition: var(--transition);
        }
        .blog-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow);
        }
        .blog-image {
            position: relative;
            height: 200px;
            overflow: hidden;
            background-size: cover;
            background-position: center;
        }
        .blog-badge {
            position: absolute;
            top: 12px;
            right: 12px;
        }
        .blog-content {
            padding: 20px;
            text-align: center;
        }
        .blog-content h3 {
            font-size: 18px;
            margin-bottom: 8px;
        }
        .blog-content p {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 12px;
        }
        .blog-footer {
            text-align: center;
            margin-top: 32px;
        }
        .gold-link {
            color: var(--gold);
            font-weight: 600;
            transition: color 0.3s;
        }
        .gold-link:hover {
            color: var(--gold-dark);
        }

        /* ===== NEWSLETTER ===== */
        .newsletter-box {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 60px 50px;
            text-align: center;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
        }
        .newsletter-box::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 40%, rgba(212, 163, 115, 0.03), transparent 60%);
            pointer-events: none;
        }
        .newsletter-box h3 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
            position: relative;
        }
        .newsletter-box p {
            color: var(--text-muted);
            font-size: 16px;
            margin-bottom: 24px;
            position: relative;
        }
        .newsletter-form {
            display: flex;
            gap: 12px;
            max-width: 480px;
            margin: 0 auto;
            position: relative;
        }
        .newsletter-form input {
            flex: 1;
            padding: 14px 20px;
            border: 2px solid var(--border);
            border-radius: 60px;
            font-size: 14px;
            font-family: var(--font);
            background: var(--bg-body);
            transition: all 0.3s ease;
            outline: none;
            color: var(--text);
        }
        .newsletter-form input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(212, 163, 115, 0.08);
        }
        .newsletter-form input::placeholder {
            color: var(--text-muted);
        }
        .newsletter-form .btn {
            flex-shrink: 0;
            padding: 14px 34px;
        }

        /* ===== STATS ===== */
        .stats {
            background: var(--navy-gradient);
            color: #fff;
            padding: 60px 0;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            text-align: center;
        }
        .stat-number {
            font-size: 48px;
            font-weight: 900;
            display: block;
        }
        .stat-label {
            font-size: 16px;
            opacity: 0.85;
        }

        /* ===== TESTIMONIALS ===== */
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }
        .testimonial-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 28px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
        }
        .testimonial-card:hover {
            transform: translateY(-4px);
            border-color: var(--gold);
        }
        .testimonial-stars {
            color: var(--gold);
            margin-bottom: 12px;
        }
        .testimonial-card p {
            font-size: 16px;
            margin-bottom: 16px;
            color: var(--text-muted);
        }
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 14px;
            justify-content: center;
        }
        .testimonial-author img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .testimonial-author strong {
            display: block;
        }
        .testimonial-author span {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* ===== CONTACT ===== */
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 50px;
        }
        .contact-info {
            text-align: center;
        }
        .contact-item {
            display: flex;
            gap: 16px;
            margin-bottom: 28px;
            justify-content: center;
        }
        .contact-item i {
            font-size: 24px;
            color: var(--gold);
            margin-top: 4px;
        }
        .contact-item h4 {
            font-size: 16px;
            font-weight: 600;
        }
        .contact-item p {
            color: var(--text-muted);
        }
        .contact-form .form-group {
            margin-bottom: 20px;
        }
        .contact-form label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            text-align: center;
        }
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            background: var(--bg-body);
            color: var(--text);
            font-family: inherit;
            font-size: 14px;
            transition: var(--transition);
            text-align: center;
        }
        .contact-form input:focus,
        .contact-form textarea:focus {
            outline: none;
            border-color: var(--gold);
        }
        .contact-form .btn {
            display: block;
            margin: 0 auto;
        }

        /* ===== CTA ===== */
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
            background: radial-gradient(circle at 20% 50%, rgba(212, 163, 115, 0.04), transparent 60%);
        }
        .cta .section-title {
            color: #fff;
        }
        .cta .section-subtitle {
            color: rgba(255, 255, 255, 0.35);
            margin: 0 auto 36px;
        }
        .cta .btn-group {
            display: flex;
            gap: 18px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }
        .btn-white {
            background: #fff;
            color: var(--deep-navy);
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);
        }
        .btn-white:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(255, 255, 255, 0.2);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--deep-navy);
            color: #c8c8d4;
            padding: 60px 0 20px;
            margin-top: 40px;
            border-top: 2px solid var(--gold);
        }
        [data-theme="light"] .footer {
            background: var(--deep-navy);
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            text-align: center;
        }
        .footer-brand .logo {
            justify-content: center;
        }
        .footer-brand p {
            font-size: 14px;
            max-width: 300px;
            margin: 0 auto 16px;
            color: rgba(255, 255, 255, 0.5);
        }
        .footer-social {
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        .footer-social a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #c8c8d4;
            transition: var(--transition);
        }
        .footer-social a:hover {
            background: var(--gold);
            color: #fff;
        }
        .footer-links h4,
        .footer-contact h4,
        .footer-trust h4 {
            color: #fff;
            font-size: 16px;
            margin-bottom: 16px;
        }
        .footer-links ul,
        .footer-contact ul {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }
        .footer-links a,
        .footer-contact li {
            font-size: 14px;
            color: #94a3b8;
        }
        .footer-links a:hover {
            color: var(--gold);
        }
        .footer-contact li {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .footer-contact li i {
            color: var(--gold);
            width: 20px;
        }
        .trust-icons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .trust-icons span {
            background: rgba(255, 255, 255, 0.04);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            color: #94a3b8;
        }
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            font-size: 14px;
            color: #64748b;
        }

        /* ===== MODAL ===== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 22, 40, 0.85);
            backdrop-filter: blur(16px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.4s;
        }
        .modal-overlay.active {
            display: flex;
            opacity: 1;
        }
        .modal {
            background: var(--bg-card);
            border-radius: 24px;
            padding: 40px 36px;
            max-width: 480px;
            width: 100%;
            border: 2px solid var(--gold);
            box-shadow: 0 0 40px rgba(212, 163, 115, 0.15);
            position: relative;
            transform: scale(0.9) translateY(30px);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .modal-overlay.active .modal {
            transform: scale(1) translateY(0);
        }
        .modal-close {
            position: absolute;
            top: 14px;
            left: 18px;
            background: none;
            border: none;
            font-size: 22px;
            color: var(--text-muted);
            cursor: pointer;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }
        .modal-close:hover {
            color: var(--gold);
            background: rgba(212, 163, 115, 0.1);
            transform: rotate(90deg);
        }
        .modal-tabs {
            display: flex;
            gap: 6px;
            background: var(--bg-body);
            padding: 4px;
            border-radius: 12px;
            border: 1px solid var(--border);
            margin-bottom: 28px;
        }
        .modal-tab {
            flex: 1;
            padding: 10px 16px;
            border: none;
            background: transparent;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            color: var(--text-muted);
            cursor: pointer;
            transition: 0.3s;
        }
        .modal-tab.active {
            background: var(--gold-gradient);
            color: #fff;
        }
        .modal-tab:hover:not(.active) {
            color: var(--gold);
        }
        .modal-form.hidden {
            display: none;
        }
        .modal-form .form-group {
            margin-bottom: 18px;
        }
        .modal-form label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }
        .modal-form input {
            width: 100%;
            padding: 13px 18px;
            border: 2px solid var(--border);
            border-radius: 12px;
            background: var(--bg-body);
            color: var(--text);
            font-family: var(--font);
            font-size: 14px;
            transition: all 0.4s;
            outline: none;
        }
        .modal-form input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(212, 163, 115, 0.15);
        }
        .modal-form .btn {
            width: 100%;
            background: var(--gold-gradient);
            border-color: var(--gold);
        }

        /* ============================================================ */
        /* RESPONSIVE */
        /* ============================================================ */
        @media (max-width: 1024px) {
            #particleSphere {
                position: relative;
                top: auto;
                left: auto;
                transform: none;
                width: 100%;
                height: 400px;
                margin-top: 20px;
                animation: fadeInSphere 2s ease forwards;
                animation-delay: 0.5s;
            }
        }

        @media (max-width: 992px) {
            .blog-grid,
            .testimonials-grid {
                grid-template-columns: 1fr 1fr;
            }
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .nav-desktop {
                display: none;
            }
            .menu-toggle {
                display: block;
            }
            .hero-slide {
                height: 450px;
            }
            .hero-content h1 {
                font-size: 32px;
            }
            .hero-content p {
                font-size: 16px;
            }
            .services-grid {
                grid-template-columns: 1fr 1fr;
            }
            .blog-grid,
            .testimonials-grid {
                grid-template-columns: 1fr;
            }
            .contact-grid {
                grid-template-columns: 1fr;
            }
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
            .footer-grid {
                grid-template-columns: 1fr;
            }
            .newsletter-form {
                flex-direction: column;
            }
            .newsletter-form .btn {
                width: 100%;
                justify-content: center;
            }
            .swiper-button-next,
            .swiper-button-prev {
                display: none !important;
            }
            .swiper-pagination-bullet {
                width: 8px !important;
                height: 8px !important;
            }
            .swiper-pagination-bullet-active {
                width: 20px !important;
            }
            #particleSphere {
                height: 300px;
            }
        }

        @media (max-width: 480px) {
            .hero-slide {
                height: 380px;
            }
            .hero-content h1 {
                font-size: 26px;
            }
            .services-grid {
                grid-template-columns: 1fr;
            }
            #particleSphere {
                height: 220px;
            }
        }
    </style>
</head>
<body>

    <!-- ===== HEADER ===== -->
    <header class="header" id="header">
        <div class="container header-inner">
            <a href="index.html" class="logo">
                <img src="Aug 2, 2026, 03_28_58 PM.png" alt="Grafium Logo" class="logo-img" />
            </a>
            <nav class="nav-desktop" id="navDesktop">
                <ul>
                    <li><a href="index.html" class="active">خانه</a></li>
                    <li><a href="{{ route('about') }}">درباره ما</a></li>
                    <li><a href="{{ route('services') }}">خدمات</a></li>
                    <li><a href="{{ route('blog') }}">بلاگ</a></li>
                    <li><a href="contact.html">تماس</a></li>
                </ul>
            </nav>
            <div class="header-actions">
                <button class="theme-toggle" id="themeToggle"><i class="fas fa-moon"></i></button>
                <a href="#" class="btn btn-gold" id="openModalBtn">ورود</a>
                <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
            </div>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <ul>
                <li><a href="index.html">خانه</a></li>
                <li><a href="{{ route('about') }}">درباره ما</a></li>
                <li><a href="{{ route('services') }}">خدمات</a></li>
                <li><a href="{{ route('blog') }}">بلاگ</a></li>
                <li><a href="contact.html">تماس</a></li>
            </ul>
            <div class="mobile-auth">
                <a href="#" class="btn btn-gold" id="openModalBtnMobile">ورود</a>
            </div>
        </div>
    </header>

    <!-- ===== MODAL ===== -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <button class="modal-close" id="modalClose"><i class="fas fa-times"></i></button>
            <div class="modal-tabs">
                <button class="modal-tab active" data-tab="login">ورود</button>
                <button class="modal-tab" data-tab="register">ثبت‌نام</button>
            </div>
            <form class="modal-form" id="loginForm">
                <div class="form-group">
                    <label for="loginEmail">ایمیل</label>
                    <input type="email" id="loginEmail" placeholder="ایمیل خود را وارد کنید" />
                </div>
                <div class="form-group">
                    <label for="loginPassword">رمز عبور</label>
                    <input type="password" id="loginPassword" placeholder="رمز عبور خود را وارد کنید" />
                </div>
                <button type="submit" class="btn btn-gold">ورود</button>
            </form>
            <form class="modal-form hidden" id="registerForm">
                <div class="form-group">
                    <label for="regName">نام و نام خانوادگی</label>
                    <input type="text" id="regName" placeholder="نام خود را وارد کنید" />
                </div>
                <div class="form-group">
                    <label for="regEmail">ایمیل</label>
                    <input type="email" id="regEmail" placeholder="ایمیل خود را وارد کنید" />
                </div>
                <div class="form-group">
                    <label for="regPassword">رمز عبور</label>
                    <input type="password" id="regPassword" placeholder="رمز عبور خود را وارد کنید" />
                </div>
                <div class="form-group">
                    <label for="regPasswordConfirm">تکرار رمز عبور</label>
                    <input type="password" id="regPasswordConfirm" placeholder="رمز عبور را تکرار کنید" />
                </div>
                <button type="submit" class="btn btn-gold">ثبت‌نام</button>
            </form>
        </div>
    </div>

    <!-- ===== HERO SLIDER با کره ۳بعدی ===== -->
    <section class="hero-slider" id="home">
        <div class="swiper heroSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?w=1400&h=800&fit=crop');">
                    <div class="hero-overlay"></div>
                    <div class="container hero-content">
                        <h1 class="gold-text">اولین سالن کار اشتراکی گرافیکی</h1>
                        <p>فضایی برای خلاقیت، هم‌افزایی و رشد حرفه‌ای</p>
                        <a href="services.html" class="btn btn-gold">مشاهده خدمات</a>
                    </div>
                </div>
                <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=1400&h=800&fit=crop');">
                    <div class="hero-overlay"></div>
                    <div class="container hero-content">
                        <h1 class="gold-text">سیستم‌های قدرتمند در دسترس شما</h1>
                        <p>اجاره سیستم‌های گران‌قیمت برای اجرای پروژه‌های سنگین گرافیکی</p>
                        <a href="services.html" class="btn btn-gold">مشاهده خدمات</a>
                    </div>
                </div>
                <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=1400&h=800&fit=crop');">
                    <div class="hero-overlay"></div>
                    <div class="container hero-content">
                        <h1 class="gold-text">جامعه‌ای از هنرمندان و طراحان</h1>
                        <p>همکاری، تبادل ایده و رشد در کنار بهترین‌ها</p>
                        <a href="#contact" class="btn btn-gold">تماس با ما</a>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <!-- کره ۳بعدی -->
        <canvas id="particleSphere"></canvas>
    </section>

    <!-- ===== TRUST BAR ===== -->
    <section class="trust-bar">
        <div class="container" style="overflow:hidden;">
            <div class="trust-track">
                <span class="trust-item"><i class="fas fa-check-circle"></i> ۱۰۰+ عضو فعال</span>
                <span class="trust-item"><i class="fas fa-star"></i> ۹۸٪ رضایت</span>
                <span class="trust-item"><i class="fas fa-wifi"></i> اینترنت پرسرعت</span>
                <span class="trust-item"><i class="fas fa-coffee"></i> نوشیدنی رایگان</span>
                <span class="trust-item"><i class="fas fa-clock"></i> دسترسی ۲۴/۷</span>
                <span class="trust-item"><i class="fas fa-print"></i> چاپ حرفه‌ای</span>
                <span class="trust-item"><i class="fas fa-check-circle"></i> ۱۰۰+ عضو فعال</span>
                <span class="trust-item"><i class="fas fa-star"></i> ۹۸٪ رضایت</span>
                <span class="trust-item"><i class="fas fa-wifi"></i> اینترنت پرسرعت</span>
                <span class="trust-item"><i class="fas fa-coffee"></i> نوشیدنی رایگان</span>
                <span class="trust-item"><i class="fas fa-clock"></i> دسترسی ۲۴/۷</span>
                <span class="trust-item"><i class="fas fa-print"></i> چاپ حرفه‌ای</span>
            </div>
        </div>
    </section>

    <!-- ===== ABOUT ===== -->
    <section class="section about" id="about">
        <div class="container">
            <div class="section-header">
                <span class="badge gradient-badge">درباره ما</span>
                <h2 class="purple-text">چرا <span class="purple-text">GRAFIUM</span>؟</h2>
                <p>ما اولین سالن کار اشتراکی گرافیکی در شهر هستیم. فضایی که در آن طراحان، هنرمندان و علاقه‌مندان به گرافیک می‌توانند با اجاره سیستم‌های قدرتمند، پروژه‌های خود را بدون محدودیت اجرا کنند.</p>
                <p>از میزهای کار ارگونومیک تا سیستم‌های i9 و کارت‌های گرافیک حرفه‌ای، همه چیز برای خلق آثار بی‌نظیر فراهم است.</p>
            </div>
        </div>
    </section>

    <!-- ===== SERVICES ===== -->
    <section class="section services" id="services">
        <div class="container">
            <div class="section-header">
                <span class="badge gradient-badge">خدمات ما</span>
                <h2 class="purple-text">چه خدمات  ارائه می‌دهیم؟</h2>
                <p>خدمات متنوع برای رفع نیازهای گرافیکی شما</p>
            </div>
            <div class="services-grid">
                <div class="service-card"><div class="service-icon"><i class="fas fa-desktop"></i></div><h3>اجاره سیستم</h3><p>سیستم‌های i9 و RTX</p><div class="service-links"><a href="#" class="gold-link">معرفی</a><a href="services.html" class="gold-link">رزرو</a></div></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-couch"></i></div><h3>فضای کار اشتراکی</h3><p>میز ارگونومیک و اینترنت پرسرعت</p><div class="service-links"><a href="#" class="gold-link">معرفی</a><a href="#" class="gold-link">رزرو</a></div></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-users"></i></div><h3>کارگاه‌های آموزشی</h3><p>دوره‌های فتوشاپ و ایلوستریتور</p><div class="service-links"><a href="#" class="gold-link">معرفی</a><a href="#" class="gold-link">رزرو</a></div></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-print"></i></div><h3>چاپ و تکثیر</h3><p>چاپ با کیفیت بالا</p><div class="service-links"><a href="#" class="gold-link">معرفی</a><a href="#" class="gold-link">رزرو</a></div></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-coffee"></i></div><h3>کافه &amp; استراحت</h3><p>فضایی آرام برای تبادل ایده</p><div class="service-links"><a href="#" class="gold-link">معرفی</a><a href="#" class="gold-link">رزرو</a></div></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-video"></i></div><h3>تدوین و انیمیشن</h3><p>خدمات تدوین و موشن گرافیک</p><div class="service-links"><a href="#" class="gold-link">معرفی</a><a href="#" class="gold-link">رزرو</a></div></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-paint-brush"></i></div><h3>طراحی گرافیک</h3><p>لوگو، پوستر و هویت بصری</p><div class="service-links"><a href="#" class="gold-link">معرفی</a><a href="#" class="gold-link">رزرو</a></div></div>
                <div class="service-card"><div class="service-icon"><i class="fas fa-photo-video"></i></div><h3>عکاسی و نورپردازی</h3><p>استودیو با تجهیزات حرفه‌ای</p><div class="service-links"><a href="#" class="gold-link">معرفی</a><a href="#" class="gold-link">رزرو</a></div></div>
            </div>
        </div>
    </section>

    <!-- ===== FAQ ===== -->
    <section class="section faq" id="faq">
        <div class="container">
            <div class="section-header">
                <span class="badge gradient-badge">سوالات متداول</span>
                <h2 class="purple-text">سوالات متداول</h2>
                <p>هر آنچه باید درباره گرافیوم بدانید.</p>
            </div>
            <div class="faq-list">
                <div class="faq-item active">
                    <div class="faq-question"><span>گرافیوم چیست؟</span><i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer">گرافیوم یک فضای کار اشتراکی ممتاز است که به‌طور تخصصی برای طراحان گرافیک، هنرمندان و حرفه‌ای‌های خلاق طراحی شده است. ما محیطی حرفه‌ای و الهام‌بخش با امکانات مدرن ارائه می‌دهیم.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question"><span>چگونه می‌توانم میز رزرو کنم؟</span><i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer">شما می‌توانید میز را مستقیماً از طریق سیستم رزرو آنلاین ما رزرو کنید. کافی است میزهای موجود را مرور کنید، تاریخ و شیفت مورد نظر را انتخاب کرده و رزرو خود را تایید کنید. این فرآیند سریع و آسان است.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question"><span>ساعات کاری چگونه است؟</span><i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer">ساعات کاری ما از شنبه تا پنجشنبه، ۸ صبح تا ۹ شب است. اعضای طرح‌های حرفه‌ای و سازمانی از دسترسی ۲۴/۷ برخوردار هستند.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question"><span>آیا پارکینگ وجود دارد؟</span><i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer">بله، ما پارکینگ اختصاصی برای اعضای خود داریم. پارکینگ برای تمام اعضا در طول بازدید رایگان است.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question"><span>آیا می‌توانم اتاق جلسات را جداگانه رزرو کنم؟</span><i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer">بله، اتاق‌های جلسات حتی اگر عضو نباشید نیز قابل رزرو هستند. اعضای طرح‌های حرفه‌ای و سازمانی اعتبار اتاق جلسات را در طرح خود دریافت می‌کنند.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question"><span>چه روش‌های پرداختی را می‌پذیرید؟</span><i class="fas fa-chevron-down"></i></div>
                    <div class="faq-answer">ما تمام کارت‌های اعتباری اصلی، انتقالات بانکی و روش‌های پرداخت دیجیتال را می‌پذیریم. همچنین برنامه‌های پرداخت منعطف برای عضویت‌های بلندمدت ارائه می‌دهیم.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== BLOG ===== -->
    <section class="section blog" id="blog">
        <div class="container">
            <div class="section-header">
                <span class="badge gradient-badge">اخبار و مقالات</span>
                <h2 class="purple-text">آخرین مطالب</h2>
                <p>جدیدترین اخبار و مقالات آموزشی را دنبال کنید</p>
            </div>
            <div class="blog-grid">
                <article class="blog-card featured">
                    <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?w=600&h=400&fit=crop');"><span class="blog-badge gradient-badge">ویژه</span></div>
                    <div class="blog-content"><h3>افتتاح رسمی GRAFIUM</h3><p>اولین سالن کار اشتراکی گرافیکی با حضور هنرمندان و طراحان برتر افتتاح شد.</p><a href="#" class="gold-link">ادامه مطلب</a></div>
                </article>
                <article class="blog-card">
                    <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1561070791-2526d30994b5?w=600&h=400&fit=crop');"><span class="blog-badge gradient-badge">پربازدید</span></div>
                    <div class="blog-content"><h3>آموزش رایگان فتوشاپ</h3><p>دوره‌های آموزشی رایگان برای علاقه‌مندان به گرافیک و طراحی دیجیتال.</p><a href="#" class="gold-link">ادامه مطلب</a></div>
                </article>
                <article class="blog-card">
                    <div class="blog-image" style="background-image: url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=600&h=400&fit=crop');"><span class="blog-badge gradient-badge">آخرین</span></div>
                    <div class="blog-content"><h3>سیستم‌های جدید به GRAFIUM آمدند</h3><p>ارتقاء سیستم‌ها با جدیدترین پردازنده‌ها و کارت‌های گرافیک برای تجربه بهتر.</p><a href="#" class="gold-link">ادامه مطلب</a></div>
                </article>
            </div>
            <div class="blog-footer"><a href="#" class="btn btn-gold-outline">مشاهده همه اخبار</a></div>
        </div>
    </section>

    <!-- ===== NEWSLETTER ===== -->
    <section class="section newsletter" id="newsletter">
        <div class="container">
            <div class="newsletter-box reveal">
                <h3>در جریان <span style="color:var(--gold);">بمانید</span></h3>
                <p>در خبرنامه ما عضو شوید و آخرین به‌روزرسانی‌ها، رویدادها و پیشنهادات را دریافت کنید.</p>
                <form class="newsletter-form" onsubmit="event.preventDefault(); alert('از ثبت‌نام شما متشکریم!');">
                    <input type="email" placeholder="آدرس ایمیل خود را وارد کنید" required />
                    <button type="submit" class="btn btn-gold">عضویت <i class="fas fa-arrow-left"></i></button>
                </form>
            </div>
        </div>
    </section>

    <!-- ===== STATS ===== -->
    <section class="section stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item"><span class="stat-number" data-target="120">0</span><span class="stat-label">پروژه انجام شده</span></div>
                <div class="stat-item"><span class="stat-number" data-target="85">0</span><span class="stat-label">طراح حرفه‌ای</span></div>
                <div class="stat-item"><span class="stat-number" data-target="15">0</span><span class="stat-label">سیستم قدرتمند</span></div>
                <div class="stat-item"><span class="stat-number" data-target="100">0</span><span class="stat-label">مشتری راضی</span></div>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->
    <section class="section testimonials">
        <div class="container">
            <div class="section-header"><span class="badge gradient-badge">نظرات مشتریان</span><h2 class="purple-text">آنها چه می‌گویند؟</h2></div>
            <div class="testimonials-grid">
                <div class="testimonial-card"><div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div><p>“فضای فوق‌العاده، سیستم‌های قدرتمند و محیطی الهام‌بخش.”</p><div class="testimonial-author"><img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" alt="کاربر" /><div><strong>مهدی کریمی</strong><span>طراح گرافیک</span></div></div></div>
                <div class="testimonial-card"><div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div><p>“سیستم‌های باورنکردنی، اینترنت عالی و کافه‌ی دنج.”</p><div class="testimonial-author"><img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop" alt="کاربر" /><div><strong>سارا احمدی</strong><span>تصویرساز دیجیتال</span></div></div></div>
                <div class="testimonial-card"><div class="testimonial-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div><p>“همکاری با GRAFIUM باعث شد پروژه‌های سنگینم را بدون نگرانی انجام بدم.”</p><div class="testimonial-author"><img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop" alt="کاربر" /><div><strong>رضا نوری</strong><span>انیماتور</span></div></div></div>
            </div>
        </div>
    </section>

    <!-- ===== CONTACT ===== -->
    <section class="section contact" id="contact">
        <div class="container">
            <div class="section-header"><span class="badge gradient-badge">تماس با ما</span><h2 class="purple-text">در ارتباط باشید</h2><p>ما همیشه آماده پاسخگویی به شما هستیم</p></div>
            <div class="contact-grid">
                <div class="contact-info">
                    <div class="contact-item"><i class="fas fa-map-marker-alt"></i><div><h4>آدرس</h4><p>خیابان اصلی، نبش خیابان دوم، پلاک ۱۲۳</p></div></div>
                    <div class="contact-item"><i class="fas fa-phone"></i><div><h4>تلفن</h4><p>۰۲۱-۱۲۳۴-۵۶۷۸</p></div></div>
                    <div class="contact-item"><i class="fas fa-envelope"></i><div><h4>ایمیل</h4><p>info@grafium.ir</p></div></div>
                    <div class="contact-item"><i class="fas fa-clock"></i><div><h4>ساعت کاری</h4><p>شنبه تا پنجشنبه: ۹ صبح تا ۱۰ شب</p></div></div>
                </div>
                <form class="contact-form">
                    <div class="form-group"><label for="name">نام و نام خانوادگی</label><input type="text" id="name" placeholder="نام خود را وارد کنید" /></div>
                    <div class="form-group"><label for="email">ایمیل</label><input type="email" id="email" placeholder="ایمیل خود را وارد کنید" /></div>
                    <div class="form-group"><label for="message">پیام</label><textarea id="message" rows="5" placeholder="پیام خود را بنویسید..."></textarea></div>
                    <button type="submit" class="btn btn-gold">ارسال پیام</button>
                </form>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta" id="cta">
        <div class="container">
            <span class="badge gradient-badge" style="background:rgba(212,163,115,0.12);color:var(--gold);">شروع کنید</span>
            <h2 class="section-title">فضای کاری <span style="color:var(--gold);">خود را امروز رزرو کنید</span></h2>
            <p class="section-subtitle" style="color:rgba(255,255,255,0.35);max-width:600px;margin:0 auto 36px;">به جامعه طراحان حرفه‌ای بپیوندید و از امکانات ممتاز گرافیوم لذت ببرید.</p>
            <div class="btn-group">
                <a href="services.html" class="btn btn-gold">رزرو میز <i class="fas fa-arrow-left"></i></a>
                <a href="#contact" class="btn btn-white">تماس با ما</a>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index.html" class="logo"><img src="Aug 2, 2026, 03_28_58 PM.png" alt="Grafium Logo" class="logo-img" /></a>
                    <p>اولین سالن کار اشتراکی گرافیکی در شهر</p>
                    <div class="footer-social">
                        <a href="#"><i class="fas fa-comment"></i></a>
                        <a href="#"><i class="fas fa-check-circle"></i></a>
                        <a href="#"><i class="fas fa-video"></i></a>
                        <a href="#"><i class="fas fa-share-alt"></i></a>
                    </div>
                </div>
                <div class="footer-links">
                    <h4>لینک‌های مفید</h4>
                    <ul><li><a href="index.html">خانه</a></li><li><a href="about.html">درباره ما</a></li><li><a href="services.html">خدمات</a></li><li><a href="#">بلاگ</a></li><li><a href="#">تماس</a></li></ul>
                </div>
                <div class="footer-contact">
                    <h4>اطلاعات تماس</h4>
                    <ul><li><i class="fas fa-map-pin"></i> خیابان اصلی، پلاک ۱۲۳</li><li><i class="fas fa-phone"></i> ۰۲۱-۱۲۳۴-۵۶۷۸</li><li><i class="fas fa-envelope"></i> info@grafium.ir</li></ul>
                </div>
                <div class="footer-trust">
                    <h4>نمادهای اعتماد</h4>
                    <div class="trust-icons"><span>نماد ۱</span><span>نماد ۲</span><span>نماد ۳</span></div>
                </div>
            </div>
            <div class="footer-bottom"><p>&copy; ۲۰۲۶ تمامی حقوق برای <span class="gold-text">GRAFIUM</span> محفوظ است.</p></div>
        </div>
    </footer>

    <!-- ============================================================ -->
    <!-- ===== تمام JavaScript در اینجا ===== -->
    <!-- ============================================================ -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // ============================================================
        // 1. SWIPER SLIDER – حرفه‌ای با Fade + Progress Bar
        // ============================================================
        if (document.querySelector('.heroSwiper')) {
            const heroSwiper = new Swiper('.heroSwiper', {
                loop: true,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                autoplay: { delay: 2910, disableOnInteraction: false },
                speed: 1200,
                parallax: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    renderBullet: function(index, className) {
                        return `<span class="${className}" style="background: #d4a373; opacity:0.5; width:10px; height:10px;"></span>`;
                    }
                },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                on: {
                    init: function() {
                        const activeSlide = document.querySelector('.swiper-slide-active');
                        if (activeSlide) {
                            const h1 = activeSlide.querySelector('h1');
                            const p = activeSlide.querySelector('p');
                            const btn = activeSlide.querySelector('.btn');
                            if (h1) setTimeout(() => h1.classList.add('animate-in'), 100);
                            if (p) setTimeout(() => p.classList.add('animate-in'), 300);
                            if (btn) setTimeout(() => btn.classList.add('animate-in'), 500);
                        }
                        this.update();
                    },
                    slideChangeTransitionStart: function() {
                        document.querySelectorAll('.hero-content h1, .hero-content p, .hero-content .btn').forEach(el => {
                            el.classList.remove('animate-in');
                        });
                    },
                    slideChangeTransitionEnd: function() {
                        const activeSlide = document.querySelector('.swiper-slide-active');
                        if (activeSlide) {
                            const h1 = activeSlide.querySelector('h1');
                            const p = activeSlide.querySelector('p');
                            const btn = activeSlide.querySelector('.btn');
                            if (h1) setTimeout(() => h1.classList.add('animate-in'), 100);
                            if (p) setTimeout(() => p.classList.add('animate-in'), 300);
                            if (btn) setTimeout(() => btn.classList.add('animate-in'), 500);
                        }
                    }
                }
            });

            // Progress Bar
            const progressBar = document.createElement('div');
            progressBar.className = 'swiper-progress-bar';
            progressBar.innerHTML = `<span class="swiper-progress-fill"></span>`;
            const heroSlider = document.querySelector('.hero-slider');
            if (heroSlider) heroSlider.appendChild(progressBar);

            heroSwiper.on('autoplayTimeLeft', function(s, time, progress) {
                const fill = progressBar.querySelector('.swiper-progress-fill');
                if (fill) fill.style.width = (1 - progress) * 100 + '%';
            });
            heroSwiper.on('click', function() {
                const fill = progressBar.querySelector('.swiper-progress-fill');
                if (fill) fill.style.width = '0%';
            });
        }

        // ============================================================
        // 2. THEME TOGGLE
        // ============================================================
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = themeToggle?.querySelector('i');
        let darkMode = localStorage.getItem('theme') ? localStorage.getItem('theme') === 'dark' : true;

        function applyTheme() {
            document.documentElement.setAttribute('data-theme', darkMode ? 'dark' : 'light');
            if (themeIcon) themeIcon.className = darkMode ? 'fas fa-moon' : 'fas fa-sun';
            localStorage.setItem('theme', darkMode ? 'dark' : 'light');
        }
        applyTheme();
        themeToggle?.addEventListener('click', () => {
            darkMode = !darkMode;
            applyTheme();
        });

        // ============================================================
        // 3. MOBILE MENU
        // ============================================================
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        menuToggle?.addEventListener('click', () => {
            mobileMenu?.classList.toggle('open');
            const icon = menuToggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            }
        });
        document.querySelectorAll('.mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu?.classList.remove('open');
                const icon = menuToggle?.querySelector('i');
                if (icon) {
                    icon.classList.add('fa-bars');
                    icon.classList.remove('fa-times');
                }
            });
        });

        // ============================================================
        // 4. SCROLL ANIMATIONS (Reveal)
        // ============================================================
        const revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
        revealEls.forEach(el => revealObserver.observe(el));

        // ============================================================
        // 5. STATS COUNTER
        // ============================================================
        const statNumbers = document.querySelectorAll('.stat-number');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.dataset.target);
                    const el = entry.target;
                    let current = 0;
                    const increment = Math.ceil(target / 70);
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            el.textContent = target;
                            clearInterval(timer);
                        } else {
                            el.textContent = current;
                        }
                    }, 25);
                    counterObserver.unobserve(el);
                }
            });
        }, { threshold: 0.5 });
        statNumbers.forEach(el => counterObserver.observe(el));

        // ============================================================
        // 6. SMOOTH SCROLL
        // ============================================================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // ============================================================
        // 7. STICKY HEADER SHADOW
        // ============================================================
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (!header) return;
            if (window.scrollY > 50) header.style.boxShadow = '0 4px 30px rgba(0,0,0,0.4)';
            else header.style.boxShadow = 'none';
        });

        // ============================================================
        // 8. MODAL
        // ============================================================
        const modalOverlay = document.getElementById('modalOverlay');
        const modalClose = document.getElementById('modalClose');
        const openModalBtns = document.querySelectorAll('#openModalBtn, #openModalBtnMobile');
        const modalTabs = document.querySelectorAll('.modal-tab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        function openModal(tab = 'login') {
            modalOverlay?.classList.add('active');
            document.body.style.overflow = 'hidden';
            switchTab(tab);
        }

        function closeModal() {
            modalOverlay?.classList.remove('active');
            document.body.style.overflow = '';
        }

        function switchTab(tab) {
            modalTabs.forEach(t => t.classList.remove('active'));
            document.querySelector(`.modal-tab[data-tab="${tab}"]`)?.classList.add('active');
            loginForm?.classList.toggle('hidden', tab !== 'login');
            registerForm?.classList.toggle('hidden', tab !== 'register');
        }

        openModalBtns.forEach(btn => btn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal('login');
        }));
        modalClose?.addEventListener('click', closeModal);
        modalOverlay?.addEventListener('click', (e) => { if (e.target === modalOverlay) closeModal(); });
        modalTabs.forEach(tab => tab.addEventListener('click', () => switchTab(tab.dataset.tab)));
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

        // ============================================================
        // 9. FAQ ACCORDION
        // ============================================================
        document.querySelectorAll('.faq-question').forEach(q => {
            q.addEventListener('click', function() {
                const item = this.closest('.faq-item');
                const isActive = item.classList.contains('active');
                document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
                if (!isActive) item.classList.add('active');
            });
        });

        // ============================================================
        // 10. 3D PARTICLE SPHERE
        // ============================================================
        (function() {
            const canvas = document.getElementById('particleSphere');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            let W, H;
            let particles = [];
            const NUM_PARTICLES = 650;
            let mouseX = 0,
                mouseY = 0;
            let targetRotX = 0,
                targetRotY = 0;
            let rotX = 0,
                rotY = 0;
            let time = 0;

            function resize() {
                const rect = canvas.parentElement.getBoundingClientRect();
                const container = canvas.parentElement;
                const parentRect = container.getBoundingClientRect();
                if (window.innerWidth <= 768) {
                    canvas.width = Math.min(parentRect.width, 400);
                    canvas.height = Math.min(parentRect.width, 400) * 0.8;
                } else if (window.innerWidth <= 1024) {
                    canvas.width = Math.min(parentRect.width, 500);
                    canvas.height = Math.min(parentRect.width, 500) * 0.85;
                } else {
                    canvas.width = 580;
                    canvas.height = 580;
                }
                W = canvas.width;
                H = canvas.height;
                initParticles();
            }

            function initParticles() {
                particles = [];
                const radius = Math.min(W, H) * 0.38;
                for (let i = 0; i < NUM_PARTICLES; i++) {
                    const theta = Math.random() * Math.PI * 2;
                    const phi = Math.acos(2 * Math.random() - 1);
                    const r = radius * (0.85 + Math.random() * 0.15);
                    const x = r * Math.sin(phi) * Math.cos(theta);
                    const y = r * Math.sin(phi) * Math.sin(theta);
                    const z = r * Math.cos(phi);
                    const size = 1.5 + Math.random() * 3.5;
                    const brightness = 0.4 + Math.random() * 0.6;
                    particles.push({ x, y, z, ox: x, oy: y, oz: z, size, brightness, speed: 0.002 + Math.random() * 0.004,
                        phase: Math.random() * Math.PI * 2 });
                }
            }

            document.addEventListener('mousemove', (e) => {
                const rect = canvas.getBoundingClientRect();
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const dx = (e.clientX - cx) / (rect.width / 2);
                const dy = (e.clientY - cy) / (rect.height / 2);
                mouseX = Math.max(-1, Math.min(1, dx));
                mouseY = Math.max(-1, Math.min(1, dy));
            });

            document.addEventListener('touchmove', (e) => {
                if (e.touches.length > 0) {
                    const rect = canvas.getBoundingClientRect();
                    const cx = rect.left + rect.width / 2;
                    const cy = rect.top + rect.height / 2;
                    const dx = (e.touches[0].clientX - cx) / (rect.width / 2);
                    const dy = (e.touches[0].clientY - cy) / (rect.height / 2);
                    mouseX = Math.max(-1, Math.min(1, dx));
                    mouseY = Math.max(-1, Math.min(1, dy));
                }
            });

            function draw() {
                ctx.clearRect(0, 0, W, H);
                targetRotX = mouseY * 0.4;
                targetRotY = mouseX * 0.4;
                rotX += (targetRotX - rotX) * 0.06;
                rotY += (targetRotY - rotY) * 0.06;
                time += 0.008;
                const autoRot = time * 0.15;

                const transformed = particles.map((p) => {
                    const waveX = Math.sin(time * p.speed * 3 + p.phase) * 4;
                    const waveY = Math.cos(time * p.speed * 2.5 + p.phase * 1.3) * 4;
                    const waveZ = Math.sin(time * p.speed * 2 + p.phase * 0.7) * 4;
                    let x = p.ox + waveX,
                        y = p.oy + waveY,
                        z = p.oz + waveZ;
                    const angleY = autoRot + rotY;
                    const cosY = Math.cos(angleY),
                        sinY = Math.sin(angleY);
                    let rx = x * cosY - z * sinY;
                    let rz = x * sinY + z * cosY;
                    let ry = y;
                    const angleX = rotX;
                    const cosX = Math.cos(angleX),
                        sinX = Math.sin(angleX);
                    let ry2 = ry * cosX - rz * sinX;
                    let rz2 = ry * sinX + rz * cosX;
                    return { x: rx, y: ry2, z: rz2, size: p.size, brightness: p.brightness };
                });

                transformed.sort((a, b) => a.z - b.z);
                const cx = W / 2,
                    cy = H / 2;
                const scale = Math.min(W, H) * 0.85;
                const connectionDist = 45 * (Math.min(W, H) / 500);

                for (let i = 0; i < transformed.length; i++) {
                    const p = transformed[i];
                    const px = cx + p.x * scale * 0.4;
                    const py = cy + p.y * scale * 0.4;
                    const perspective = 1 + p.z * 0.06;
                    let size = p.size * perspective;
                    if (size < 0.1) size = 0.1;
                    const alpha = (0.6 + 0.4 * (1 - Math.abs(p.z) / 0.6)) * p.brightness;

                    const gradient = ctx.createRadialGradient(px, py, 0, px, py, size * 4);
                    const goldColor = `rgba(212, 163, 115, ${alpha * 0.4})`;
                    const goldColor2 = `rgba(212, 163, 115, ${alpha * 0.05})`;
                    gradient.addColorStop(0, goldColor);
                    gradient.addColorStop(1, goldColor2);
                    ctx.fillStyle = gradient;
                    ctx.beginPath();
                    ctx.arc(px, py, size * 4, 0, Math.PI * 2);
                    ctx.fill();

                    ctx.fillStyle = `rgba(255, 220, 180, ${alpha * 0.9})`;
                    ctx.shadowColor = `rgba(212, 163, 115, ${alpha * 0.5})`;
                    ctx.shadowBlur = size * 3;
                    ctx.beginPath();
                    ctx.arc(px, py, size, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.shadowBlur = 0;

                    if (size > 2) {
                        ctx.fillStyle = `rgba(255, 255, 255, ${alpha * 0.2})`;
                        ctx.beginPath();
                        ctx.arc(px - size * 0.2, py - size * 0.2, size * 0.4, 0, Math.PI * 2);
                        ctx.fill();
                    }

                    if (i < transformed.length - 1) {
                        for (let j = i + 1; j < Math.min(i + 8, transformed.length); j++) {
                            const p2 = transformed[j];
                            const dx2 = px - (cx + p2.x * scale * 0.4);
                            const dy2 = py - (cy + p2.y * scale * 0.4);
                            const dist = Math.sqrt(dx2 * dx2 + dy2 * dy2);
                            if (dist < connectionDist) {
                                const connAlpha = (1 - dist / connectionDist) * 0.15 * p.brightness * p2.brightness;
                                ctx.strokeStyle = `rgba(212, 163, 115, ${connAlpha})`;
                                ctx.lineWidth = 0.5;
                                ctx.beginPath();
                                ctx.moveTo(px, py);
                                ctx.lineTo(cx + p2.x * scale * 0.4, cy + p2.y * scale * 0.4);
                                ctx.stroke();
                            }
                        }
                    }
                }

                const ringRadius = Math.min(W, H) * 0.38;
                const gradient2 = ctx.createRadialGradient(cx, cy, ringRadius * 0.7, cx, cy, ringRadius * 1.2);
                gradient2.addColorStop(0, 'rgba(212, 163, 115, 0)');
                gradient2.addColorStop(0.5, 'rgba(212, 163, 115, 0.02)');
                gradient2.addColorStop(1, 'rgba(212, 163, 115, 0)');
                ctx.fillStyle = gradient2;
                ctx.beginPath();
                ctx.arc(cx, cy, ringRadius * 1.2, 0, Math.PI * 2);
                ctx.fill();

                requestAnimationFrame(draw);
            }

            window.addEventListener('resize', resize);
            resize();
            draw();
            setTimeout(resize, 500);
            window.particleSphere = { resize };
        })();
    </script>

</body>
</html>