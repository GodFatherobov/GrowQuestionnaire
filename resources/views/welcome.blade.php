<!doctype html>
<html lang="zh-TW">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>情境領導力問卷系統</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        :root {
            --lp-primary: #2C3E50;
            --lp-accent:  #1ABC9C;
            --lp-dark:    #1a252f;
            --lp-mid:     #34495E;
        }

        /* ── Reset ── */
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }

        /* ── Navbar ── */
        .lp-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            background: var(--lp-primary);
            padding: 0 0;
            box-shadow: 0 2px 12px rgba(0,0,0,0.18);
        }
        .lp-nav .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.01em;
        }
        .lp-nav .nav-btn {
            border-radius: 6px;
            font-size: 0.875rem;
            padding: 0.4rem 1rem;
            font-weight: 500;
        }
        .lp-nav .btn-outline-light { border-color: rgba(255,255,255,0.5); }
        .lp-nav .btn-outline-light:hover { background: rgba(255,255,255,0.1); }
        .navbar-toggler { border-color: rgba(255,255,255,0.4); }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255,255,255,0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* ── Hero ── */
        .lp-hero {
            background: linear-gradient(135deg, var(--lp-primary) 0%, var(--lp-mid) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 7rem 1.5rem 5rem;
            text-align: center;
        }
        .lp-hero h1 {
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.02em;
            margin-bottom: 1.25rem;
        }
        .lp-hero p {
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            color: rgba(255,255,255,0.78);
            max-width: 600px;
            margin: 0 auto 2.5rem;
            line-height: 1.8;
        }
        .btn-accent-hero {
            background: var(--lp-accent);
            color: #fff;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.18s, transform 0.18s;
            display: inline-block;
        }
        .btn-accent-hero:hover { background: #17a589; color: #fff; transform: translateY(-2px); text-decoration: none; }
        .btn-outline-hero {
            border: 2px solid rgba(255,255,255,0.55);
            color: #fff;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.18s, border-color 0.18s, transform 0.18s;
            display: inline-block;
        }
        .btn-outline-hero:hover { background: rgba(255,255,255,0.12); border-color: #fff; color: #fff; transform: translateY(-2px); text-decoration: none; }
        .hero-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }

        /* ── Sections ── */
        .lp-section { padding: 5rem 1.5rem; }
        .lp-section-title {
            text-align: center;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--lp-primary);
            margin-bottom: 0.5rem;
        }
        .lp-section-sub {
            text-align: center;
            color: #718096;
            font-size: 1rem;
            margin-bottom: 3rem;
        }

        /* ── Feature cards ── */
        .feature-card {
            background: #fff;
            border-radius: 12px;
            padding: 2rem 1.75rem;
            box-shadow: 0 2px 16px rgba(44,62,80,0.09);
            height: 100%;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 8px 32px rgba(44,62,80,0.14); }
        .feature-icon {
            font-size: 2.25rem;
            margin-bottom: 1rem;
            display: block;
        }
        .feature-card h3 { font-size: 1.1rem; font-weight: 700; color: var(--lp-primary); margin-bottom: 0.6rem; }
        .feature-card p  { font-size: 0.9rem; color: #718096; line-height: 1.7; margin: 0; }

        /* ── Steps ── */
        .lp-steps { background: #f8fafc; }
        .step-item { text-align: center; padding: 0 1rem; }
        .step-num {
            width: 56px; height: 56px;
            border-radius: 50%;
            background: var(--lp-accent);
            color: #fff;
            font-size: 1.4rem;
            font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1rem;
        }
        .step-item h4 { font-size: 1rem; font-weight: 700; color: var(--lp-primary); margin-bottom: 0.4rem; }
        .step-item p  { font-size: 0.875rem; color: #718096; margin: 0; line-height: 1.6; }
        .step-arrow {
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: var(--lp-accent); font-weight: 700;
            padding-top: 0.5rem;
        }

        /* ── CTA ── */
        .lp-cta {
            background: linear-gradient(135deg, var(--lp-accent) 0%, #17a589 100%);
            padding: 5rem 1.5rem;
            text-align: center;
        }
        .lp-cta h2 { font-size: clamp(1.4rem, 3vw, 2rem); font-weight: 700; color: #fff; margin-bottom: 1.5rem; }
        .btn-cta {
            background: #fff;
            color: var(--lp-accent);
            padding: 0.8rem 2.25rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            transition: transform 0.18s, box-shadow 0.18s;
            display: inline-block;
        }
        .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 4px 20px rgba(0,0,0,0.18); color: var(--lp-accent); text-decoration: none; }

        /* ── Footer ── */
        .lp-footer {
            background: var(--lp-dark);
            padding: 1.5rem;
            text-align: center;
            color: rgba(255,255,255,0.45);
            font-size: 0.85rem;
        }

        @media (max-width: 767px) {
            .step-arrow { display: none; }
            .lp-hero { padding-top: 6rem; }
        }
    </style>
</head>
<body>

{{-- ─── Navbar ─────────────────────────────────────────── --}}
<nav class="navbar navbar-expand-md lp-nav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">情境領導力問卷</a>

        <button class="navbar-toggler" type="button"
                data-toggle="collapse" data-target="#lpNav"
                aria-controls="lpNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="lpNav">
            <div class="ml-auto d-flex align-items-center" style="gap: 0.6rem; flex-wrap: wrap; padding: 0.5rem 0;">
                @auth
                    <a href="{{ route('backend.ClassIndex') }}"
                       class="btn btn-accent-hero nav-btn" style="padding: 0.4rem 1.2rem; border-radius: 6px;">
                        進入後台
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="btn btn-outline-light nav-btn text-white">登入</a>
                    <a href="{{ route('register') }}"
                       class="btn nav-btn"
                       style="background: var(--lp-accent); color: #fff; border: none;">立即註冊</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- ─── Hero ───────────────────────────────────────────── --}}
<section class="lp-hero">
    <div class="container">
        <h1>了解你的領導風格</h1>
        <p>
            透過情境領導力問卷，深入了解自己的領導行為，
            結合他人評量，獲得全方位的領導力發展建議。
        </p>
        <div class="hero-btns">
            <a href="{{ route('register') }}" class="btn-accent-hero">立即開始 &rarr;</a>
            <a href="{{ route('demo.show') }}" class="btn-outline-hero">查看範例</a>
        </div>
    </div>
</section>

{{-- ─── Features ───────────────────────────────────────── --}}
<section class="lp-section">
    <div class="container">
        <h2 class="lp-section-title">為什麼選擇我們？</h2>
        <p class="lp-section-sub">科學化的領導力評估工具，幫助您建立更有效的領導策略</p>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <span class="feature-icon">📋</span>
                    <h3>自我評估</h3>
                    <p>透過 12 個真實情境題目，評估自己在不同場合的領導行為模式，快速掌握個人領導風格偏好。</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <span class="feature-icon">👥</span>
                    <h3>360° 他人評量</h3>
                    <p>邀請上級主管、同事、部屬填寫，從多角度了解你的領導風格，發現自評與他評之間的落差。</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <span class="feature-icon">📊</span>
                    <h3>深度分析報告</h3>
                    <p>完成問卷後自動產生 PDF 分析報告，清楚呈現 S1～S4 四種領導風格分佈，提供具體發展建議。</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─── Steps ──────────────────────────────────────────── --}}
<section class="lp-section lp-steps">
    <div class="container">
        <h2 class="lp-section-title">三步驟完成評估</h2>
        <p class="lp-section-sub">簡單易用，最快 15 分鐘完成整個評估流程</p>
        <div class="row align-items-start justify-content-center">
            <div class="col-6 col-md-3 mb-4">
                <div class="step-item">
                    <div class="step-num">1</div>
                    <h4>建立課程</h4>
                    <p>管理員建立課程，將問卷連結分發給學員</p>
                </div>
            </div>
            <div class="col-md-1 d-none d-md-flex step-arrow">→</div>
            <div class="col-6 col-md-3 mb-4">
                <div class="step-item">
                    <div class="step-num">2</div>
                    <h4>填寫問卷</h4>
                    <p>完成 12 題自評，並邀請他人填寫 360° 評量</p>
                </div>
            </div>
            <div class="col-md-1 d-none d-md-flex step-arrow">→</div>
            <div class="col-6 col-md-3 mb-4">
                <div class="step-item">
                    <div class="step-num">3</div>
                    <h4>取得報告</h4>
                    <p>系統自動產生個人領導風格分析 PDF 報告</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─── CTA ────────────────────────────────────────────── --}}
<section class="lp-cta">
    <div class="container">
        <h2>準備好了解你的領導風格了嗎？</h2>
        <a href="{{ route('register') }}" class="btn-cta">免費開始使用</a>
    </div>
</section>

{{-- ─── Footer ─────────────────────────────────────────── --}}
<footer class="lp-footer">
    &copy; 2025 情境領導力問卷系統
</footer>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
