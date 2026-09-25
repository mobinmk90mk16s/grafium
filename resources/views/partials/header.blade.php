{{-- ============================================================
SHARED SITE HEADER + AUTH MODAL + CART
============================================================ --}}

<style>
    /* ============================================================
    SITE HEADER
    ============================================================ */
    .site-header {
        position: sticky; top: 0; z-index: 1000;
        background: rgba(10, 22, 40, 0.85);
        backdrop-filter: blur(24px) saturate(180%);
        -webkit-backdrop-filter: blur(24px) saturate(180%);
        border-bottom: 1px solid rgba(212, 163, 115, 0.12);
        padding: 12px 0;
        transition: all 0.4s;
        font-family: "Vazirmatn", "Inter", sans-serif;
    }
    [data-theme="light"] .site-header {
        background: rgba(255, 255, 255, 0.85);
        border-bottom: 1px solid #e4e7ec;
    }
    .site-header-inner {
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }
    .site-logo { display: flex; align-items: center; flex-shrink: 0; }
    .site-logo img { height: 48px; width: auto; transition: transform 0.4s; }
    .site-logo:hover img { transform: scale(1.05); }

    .site-nav ul { display: flex; gap: 6px; list-style: none; margin: 0; padding: 0; }
    .site-nav a {
        font-weight: 500; font-size: 14px;
        color: rgba(255, 255, 255, 0.65);
        padding: 8px 16px;
        border-radius: 10px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }
    [data-theme="light"] .site-nav a { color: #6b7a8a; }
    .site-nav a:hover { color: #d4a373; background: rgba(212, 163, 115, 0.08); }
    .site-nav a.active {
        color: #fff;
        background: linear-gradient(135deg, #d4a373, #b8874a);
        box-shadow: 0 6px 20px rgba(212, 163, 115, 0.3);
    }

    .site-header-actions { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }

    /* ============================================================
    UNIFIED ACTION BUTTONS (Theme / Cart / Avatar)
    ============================================================ */
    .site-action-btn {
        width: 44px; height: 44px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: 2px solid rgba(255, 255, 255, 0.15);
        padding: 0;
        position: relative;
        font-family: inherit;
        overflow: visible;
    }

    /* Theme toggle - dark/neutral */
    .site-theme-toggle {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(255, 255, 255, 0.1);
        color: #fff;
    }
    [data-theme="light"] .site-theme-toggle {
        background: rgba(10, 22, 40, 0.04);
        border-color: #e4e7ec;
        color: #0a1628;
    }
    .site-theme-toggle:hover {
        border-color: #d4a373;
        color: #d4a373;
        transform: rotate(20deg) scale(1.05);
    }

    /* Cart button - gold (same as avatar) */
    .site-cart-btn {
        background: linear-gradient(135deg, #d4a373, #b8874a);
        color: #fff;
        box-shadow: 0 6px 20px rgba(212, 163, 115, 0.3);
    }
    .site-cart-btn:hover {
        transform: scale(1.08);
        box-shadow: 0 10px 30px rgba(212, 163, 115, 0.5);
    }

    /* Cart badge - count */
    .site-cart-badge {
        position: absolute;
        top: -6px;
        left: -6px;
        min-width: 22px;
        height: 22px;
        padding: 0 6px;
        border-radius: 11px;
        background: linear-gradient(135deg, #f43f5e, #e11d48);
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        display: none;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(244, 63, 94, 0.4);
        border: 2px solid var(--bg-card, #fff);
        font-family: "Vazirmatn", sans-serif;
        animation: cartBadgeIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        z-index: 10;
    }
    [data-theme="dark"] .site-cart-badge {
        border-color: #0f1f33;
    }
    .site-cart-badge.show { display: flex; }
    @keyframes cartBadgeIn {
        from { transform: scale(0) rotate(-180deg); }
        to { transform: scale(1) rotate(0deg); }
    }

    /* Avatar button - gold */
    .site-user-avatar {
        background: linear-gradient(135deg, #d4a373, #b8874a);
        color: #fff;
        box-shadow: 0 6px 20px rgba(212, 163, 115, 0.3);
        overflow: hidden;
    }
    .site-user-avatar img {
        width: 100%; height: 100%;
        object-fit: cover;
        border-radius: 12px;
    }
    .site-user-avatar:hover {
        transform: scale(1.08);
        box-shadow: 0 10px 30px rgba(212, 163, 115, 0.5);
    }

    /* ===== User Dropdown ===== */
    .site-user-dropdown { position: relative; }
    .site-dropdown-menu {
        position: absolute;
        top: calc(100% + 14px);
        left: 0;
        background: var(--bg-card, #fff);
        border: 1px solid var(--border, #e4e7ec);
        border-radius: 18px;
        padding: 8px;
        min-width: 250px;
        box-shadow: 0 20px 60px rgba(10, 22, 40, 0.15);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px) scale(0.95);
        transform-origin: top left;
        transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        z-index: 1000;
    }
    .site-dropdown-menu.open {
        opacity: 1; visibility: visible;
        transform: translateY(0) scale(1);
    }
    [data-theme="dark"] .site-dropdown-menu {
        background: #0f1f33;
        border-color: #1a2f4a;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }

    .site-dropdown-header {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border, #e4e7ec);
        margin-bottom: 6px;
    }
    [data-theme="dark"] .site-dropdown-header { border-color: #1a2f4a; }
    .site-dropdown-header .user-name {
        font-weight: 700; font-size: 15px;
        display: block; margin-bottom: 3px;
        color: var(--text, #0a1628);
    }
    [data-theme="dark"] .site-dropdown-header .user-name { color: #f0f0f0; }
    .site-dropdown-header .user-phone {
        font-size: 12px;
        color: var(--text-muted, #6b7a8a);
        direction: ltr; display: block;
        font-family: monospace;
    }

    .site-dropdown-item {
        display: flex; align-items: center; gap: 12px;
        padding: 11px 14px;
        border-radius: 12px;
        font-size: 14px; font-weight: 600;
        color: var(--text, #0a1628);
        transition: all 0.25s;
        width: 100%; text-align: right;
        text-decoration: none; cursor: pointer;
        border: none; background: none;
        font-family: inherit;
    }
    [data-theme="dark"] .site-dropdown-item { color: #f0f0f0; }
    .site-dropdown-item:hover {
        background: rgba(212, 163, 115, 0.1);
        color: #b8874a;
        padding-right: 18px;
    }
    [data-theme="dark"] .site-dropdown-item:hover { color: #d4a373; }
    .site-dropdown-item i { width: 20px; text-align: center; color: #d4a373; }
    .site-dropdown-divider {
        height: 1px;
        background: var(--border, #e4e7ec);
        margin: 6px 10px;
    }
    [data-theme="dark"] .site-dropdown-divider { background: #1a2f4a; }
    .site-logout-item:hover { background: rgba(244, 63, 94, 0.1); color: #fb7185; }
    .site-logout-item:hover i { color: #fb7185; }

    /* ===== Login Button ===== */
    .site-login-btn {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 22px;
        border-radius: 12px;
        background: linear-gradient(135deg, #d4a373, #b8874a);
        color: #fff;
        font-weight: 700; font-size: 14px;
        text-decoration: none;
        transition: all 0.35s;
        box-shadow: 0 6px 20px rgba(212, 163, 115, 0.3);
        border: none; cursor: pointer;
        font-family: inherit;
    }
    .site-login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(212, 163, 115, 0.5);
    }
    .site-login-btn i { font-size: 13px; }

    /* ===== Mobile Menu ===== */
    .site-menu-toggle {
        display: none;
        width: 44px; height: 44px;
        border-radius: 14px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.04);
        color: #fff; font-size: 18px;
        align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.3s;
    }
    [data-theme="light"] .site-menu-toggle {
        border-color: #e4e7ec;
        background: rgba(10, 22, 40, 0.03);
        color: #0a1628;
    }

    .site-mobile-menu {
        display: none;
        flex-direction: column;
        background: var(--bg-card, #fff);
        border-top: 1px solid var(--border, #e4e7ec);
        padding: 16px 24px 24px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease, padding 0.4s ease;
    }
    [data-theme="dark"] .site-mobile-menu {
        background: #0f1f33;
        border-top-color: #1a2f4a;
    }
    .site-mobile-menu.open { max-height: 700px; display: flex; }
    .site-mobile-menu ul {
        list-style: none; padding: 0; margin: 0;
        display: flex; flex-direction: column; gap: 4px;
    }
    .site-mobile-menu a {
        display: block;
        padding: 12px 16px;
        border-radius: 12px;
        font-weight: 600; font-size: 15px;
        color: var(--text, #0a1628);
        text-decoration: none;
        transition: all 0.3s;
    }
    [data-theme="dark"] .site-mobile-menu a { color: #f0f0f0; }
    .site-mobile-menu a:hover,
    .site-mobile-menu a.active {
        background: rgba(212, 163, 115, 0.1);
        color: #d4a373;
    }
    .site-mobile-menu .mobile-divider {
        height: 1px;
        background: var(--border, #e4e7ec);
        margin: 10px 0;
    }
    [data-theme="dark"] .site-mobile-menu .mobile-divider { background: #1a2f4a; }
    .site-mobile-menu .mobile-login {
        background: linear-gradient(135deg, #d4a373, #b8874a);
        color: #fff !important;
        text-align: center; margin-top: 8px;
        box-shadow: 0 6px 20px rgba(212, 163, 115, 0.3);
    }

    /* ============================================================
    CART PANEL (Slide-in from right)
    ============================================================ */
    .cart-backdrop {
        position: fixed; inset: 0;
        background: rgba(4, 10, 20, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        z-index: 9998;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s, visibility 0.4s;
    }
    .cart-backdrop.open {
        opacity: 1;
        visibility: visible;
    }

    .cart-panel {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        width: 68%;
        max-width: 900px;
        background: var(--bg-card, #fff);
        z-index: 9999;
        transform: translateX(100%);
        transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex;
        flex-direction: column;
        box-shadow: -30px 0 80px rgba(0, 0, 0, 0.3);
        font-family: "Vazirmatn", "Inter", sans-serif;
        overflow: hidden;
    }
    [data-theme="dark"] .cart-panel {
        background: #0f1f33;
    }
    .cart-panel.open {
        transform: translateX(0);
    }

    /* Cart header */
    .cart-panel-header {
        padding: 24px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--border, #e4e7ec);
        background: linear-gradient(135deg, #0a1628, #1a2f4a);
        color: #fff;
        flex-shrink: 0;
        position: relative;
    }
    .cart-panel-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 80% 50%, rgba(212, 163, 115, 0.15), transparent 60%);
        pointer-events: none;
    }
    .cart-panel-header-content {
        display: flex;
        align-items: center;
        gap: 14px;
        position: relative;
        z-index: 1;
    }
    .cart-panel-header-icon {
        width: 48px; height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #d4a373, #b8874a);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
        box-shadow: 0 8px 22px rgba(212, 163, 115, 0.4);
    }
    .cart-panel-header h3 {
        font-size: 19px;
        font-weight: 800;
        margin-bottom: 2px;
    }
    .cart-panel-header p {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.6);
    }
    .cart-panel-close {
        width: 40px; height: 40px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        transition: all 0.3s;
        position: relative;
        z-index: 1;
    }
    .cart-panel-close:hover {
        background: rgba(244, 63, 94, 0.2);
        border-color: #fb7185;
        color: #fb7185;
        transform: rotate(90deg);
    }

    /* Timer bar */
    .cart-timer-bar {
        padding: 14px 28px;
        background: rgba(251, 191, 36, 0.1);
        border-bottom: 1px solid rgba(251, 191, 36, 0.2);
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        color: #fbbf24;
        font-weight: 700;
        flex-shrink: 0;
    }
    .cart-timer-bar i {
        font-size: 16px;
        animation: timerPulse 1.5s ease-in-out infinite;
    }
    @keyframes timerPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .cart-timer {
        font-family: monospace;
        font-weight: 800;
        font-size: 15px;
        direction: ltr;
        min-width: 60px;
        color: #fbbf24;
    }
    .cart-timer-bar.hidden { display: none; }

    /* Cart body - scrollable */
    .cart-panel-body {
        flex: 1;
        overflow-y: auto;
        padding: 24px 28px;
        scrollbar-width: thin;
        scrollbar-color: rgba(212, 163, 115, 0.4) transparent;
    }
    .cart-panel-body::-webkit-scrollbar { width: 6px; }
    .cart-panel-body::-webkit-scrollbar-track { background: transparent; }
    .cart-panel-body::-webkit-scrollbar-thumb {
        background: rgba(212, 163, 115, 0.4);
        border-radius: 10px;
    }

    /* Cart item */
    .cart-item {
        display: grid;
        grid-template-columns: 60px 1fr auto;
        gap: 16px;
        align-items: center;
        padding: 18px 20px;
        background: var(--bg-body, #f5f7fa);
        border: 1px solid var(--border, #e4e7ec);
        border-radius: 16px;
        margin-bottom: 12px;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        animation: cartItemIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
    }
    [data-theme="dark"] .cart-item {
        background: #0a1628;
        border-color: #1a2f4a;
    }
    .cart-item::before {
        content: '';
        position: absolute;
        right: 0; top: 0; bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, #d4a373, #b8874a);
    }
    .cart-item:hover {
        transform: translateX(-6px);
        border-color: #d4a373;
        box-shadow: 0 12px 36px rgba(212, 163, 115, 0.15);
    }
    .cart-item.removing {
        animation: cartItemOut 0.4s ease forwards;
    }
    @keyframes cartItemIn {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes cartItemOut {
        to { opacity: 0; transform: translateX(60px); height: 0; padding: 0; margin: 0; }
    }

    .cart-item-icon {
        width: 60px; height: 60px;
        border-radius: 16px;
        background: linear-gradient(135deg, #d4a373, #b8874a);
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: 24px;
        box-shadow: 0 8px 20px rgba(212, 163, 115, 0.25);
        flex-shrink: 0;
    }

    .cart-item-info { min-width: 0; }
    .cart-item-service {
        font-size: 12px;
        color: #d4a373;
        font-weight: 700;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .cart-item-title {
        font-size: 15px;
        font-weight: 800;
        color: var(--text, #0a1628);
        margin-bottom: 8px;
    }
    [data-theme="dark"] .cart-item-title { color: #f0f0f0; }
    .cart-item-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 12px;
        color: var(--text-muted, #6b7a8a);
    }
    .cart-item-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .cart-item-meta i {
        color: #d4a373;
        font-size: 11px;
    }

    .cart-item-price {
        text-align: left;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
    }
    .cart-item-price-value {
        font-size: 16px;
        font-weight: 800;
        color: #b8874a;
        direction: rtl;
        white-space: nowrap;
    }
    [data-theme="dark"] .cart-item-price-value { color: #d4a373; }
    .cart-item-remove {
        width: 34px; height: 34px;
        border-radius: 10px;
        background: rgba(244, 63, 94, 0.1);
        border: 1px solid rgba(244, 63, 94, 0.2);
        color: #fb7185;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px;
        transition: all 0.3s;
    }
    .cart-item-remove:hover {
        background: rgba(244, 63, 94, 0.2);
        transform: scale(1.1);
    }

    /* Empty state */
    .cart-empty {
        text-align: center;
        padding: 80px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }
    .cart-empty-icon {
        width: 100px; height: 100px;
        border-radius: 30px;
        background: linear-gradient(135deg, rgba(212, 163, 115, 0.1), rgba(212, 163, 115, 0.03));
        border: 2px dashed rgba(212, 163, 115, 0.3);
        color: #d4a373;
        display: flex; align-items: center; justify-content: center;
        font-size: 40px;
    }
    .cart-empty h4 {
        font-size: 18px;
        font-weight: 800;
        color: var(--text, #0a1628);
    }
    [data-theme="dark"] .cart-empty h4 { color: #f0f0f0; }
    .cart-empty p {
        font-size: 14px;
        color: var(--text-muted, #6b7a8a);
    }

    /* Cart footer */
    .cart-panel-footer {
        padding: 20px 28px 24px;
        border-top: 1px solid var(--border, #e4e7ec);
        background: var(--bg-body, #f5f7fa);
        flex-shrink: 0;
    }
    [data-theme="dark"] .cart-panel-footer {
        background: #0a1628;
        border-top-color: #1a2f4a;
    }
    .cart-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        font-size: 14px;
    }
    .cart-summary-row .label { color: var(--text-muted, #6b7a8a); }
    .cart-summary-row .value { font-weight: 700; color: var(--text, #0a1628); }
    [data-theme="dark"] .cart-summary-row .value { color: #f0f0f0; }
    .cart-summary-row.total {
        border-top: 1px dashed var(--border, #e4e7ec);
        padding-top: 16px;
        margin-top: 8px;
    }
    [data-theme="dark"] .cart-summary-row.total { border-top-color: #1a2f4a; }
    .cart-summary-row.total .label {
        font-size: 15px;
        font-weight: 700;
        color: var(--text, #0a1628);
    }
    [data-theme="dark"] .cart-summary-row.total .label { color: #f0f0f0; }
    .cart-summary-row.total .value {
        font-size: 22px;
        color: #b8874a;
    }
    [data-theme="dark"] .cart-summary-row.total .value { color: #d4a373; }

    .cart-checkout-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 16px;
        margin-top: 16px;
        border-radius: 16px;
        background: linear-gradient(135deg, #d4a373, #b8874a);
        color: #fff;
        font-weight: 800;
        font-size: 15px;
        border: none;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 12px 32px rgba(212, 163, 115, 0.35);
        font-family: inherit;
        position: relative;
        overflow: hidden;
    }
    .cart-checkout-btn::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.7s;
    }
    .cart-checkout-btn:hover::before { left: 100%; }
    .cart-checkout-btn:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 20px 50px rgba(212, 163, 115, 0.55);
    }
    .cart-checkout-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Loading state */
    .cart-loading {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
        padding: 80px 20px;
        color: var(--text-muted, #6b7a8a);
    }
    .cart-loading-spinner {
        width: 48px; height: 48px;
        border-radius: 50%;
        border: 3px solid rgba(212, 163, 115, 0.15);
        border-top-color: #d4a373;
        animation: cartSpin 0.8s linear infinite;
    }
    @keyframes cartSpin {
        to { transform: rotate(360deg); }
    }

    /* ============================================================
    AUTH MODAL (keep existing)
    ============================================================ */
    .auth-modal-overlay {
        position: fixed; inset: 0;
        background: rgba(4, 10, 20, 0.92);
        backdrop-filter: blur(30px) saturate(140%);
        -webkit-backdrop-filter: blur(30px) saturate(140%);
        z-index: 9999;
        display: none;
        align-items: center; justify-content: center;
        opacity: 0;
        transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 24px;
        font-family: "Vazirmatn", "Inter", sans-serif;
        overflow: hidden;
    }
    .auth-modal-overlay.active { display: flex; opacity: 1; }

    .auth-modal-overlay::before,
    .auth-modal-overlay::after {
        content: '';
        position: absolute;
        width: 400px; height: 400px;
        border-radius: 50%;
        filter: blur(120px);
        opacity: 0.3;
        pointer-events: none;
    }
    .auth-modal-overlay::before {
        background: radial-gradient(circle, #d4a373, transparent 70%);
        top: -100px; right: -100px;
        animation: authOrb1 14s ease-in-out infinite;
    }
    .auth-modal-overlay::after {
        background: radial-gradient(circle, #2AABEE, transparent 70%);
        bottom: -100px; left: -100px;
        animation: authOrb2 16s ease-in-out infinite;
    }
    @keyframes authOrb1 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(-40px, 40px) scale(1.1); }
    }
    @keyframes authOrb2 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(40px, -40px) scale(1.1); }
    }

    .auth-modal-wrap {
        position: relative;
        max-width: 440px;
        width: 100%;
        max-height: calc(100vh - 48px);
        border-radius: 34px;
        padding: 1.5px;
        background: linear-gradient(135deg, #d4a373, #b8874a, #8a6a3f, #d4a373, #2AABEE, #d4a373);
        background-size: 400% 400%;
        animation: authBorderFlow 8s ease infinite;
        box-shadow: 0 40px 100px rgba(0, 0, 0, 0.6), 0 0 100px rgba(212, 163, 115, 0.2);
        transform: scale(0.88) translateY(60px);
        opacity: 0;
        transition: transform 0.7s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.5s ease;
        z-index: 2;
        display: flex;
    }
    .auth-modal-overlay.active .auth-modal-wrap {
        transform: scale(1) translateY(0);
        opacity: 1;
    }
    @keyframes authBorderFlow {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .auth-modal {
        background: #0b1728;
        border-radius: 32px;
        padding: 48px 40px 38px;
        width: 100%;
        position: relative;
        overflow-y: auto;
        overflow-x: hidden;
        color: #f0f0f0;
        scrollbar-width: thin;
        scrollbar-color: rgba(212, 163, 115, 0.4) transparent;
    }
    .auth-modal::-webkit-scrollbar { width: 6px; }
    .auth-modal::-webkit-scrollbar-thumb {
        background: rgba(212, 163, 115, 0.4);
        border-radius: 10px;
    }
    [data-theme="light"] .auth-modal { background: #ffffff; color: #0a1628; }

    .auth-modal::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(212, 163, 115, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(212, 163, 115, 0.03) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
        mask-image: radial-gradient(ellipse at center, black 20%, transparent 75%);
        border-radius: 32px;
    }
    .auth-modal::after {
        content: '';
        position: absolute;
        top: 0; left: 10%; right: 10%;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(212, 163, 115, 0.8), transparent);
        pointer-events: none;
    }

    .auth-modal-close {
        position: absolute; top: 16px; left: 18px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        font-size: 15px;
        color: #8fa0b5;
        cursor: pointer;
        width: 42px; height: 42px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        z-index: 10;
    }
    [data-theme="light"] .auth-modal-close {
        background: rgba(10, 22, 40, 0.03);
        border-color: #e4e7ec;
        color: #6b7a8a;
    }
    .auth-modal-close:hover {
        color: #fff;
        background: linear-gradient(135deg, #d4a373, #b8874a);
        border-color: transparent;
        transform: rotate(90deg) scale(1.1);
        box-shadow: 0 10px 28px rgba(212, 163, 115, 0.5);
    }

    .auth-modal-title {
        text-align: center;
        margin-bottom: 8px;
        font-size: 26px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.6px;
        position: relative; z-index: 2;
        background: linear-gradient(135deg, #ffffff 30%, #d4a373 130%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    [data-theme="light"] .auth-modal-title {
        background: linear-gradient(135deg, #0a1628 30%, #b8874a 130%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .auth-modal-subtitle {
        text-align: center;
        color: #8fa0b5;
        font-size: 14px;
        margin-bottom: 28px;
        line-height: 1.85;
        position: relative; z-index: 2;
        padding: 0 8px;
    }
    [data-theme="light"] .auth-modal-subtitle { color: #6b7a8a; }

    .auth-step-badge {
        width: 72px; height: 72px;
        border-radius: 22px;
        background: linear-gradient(135deg, rgba(212, 163, 115, 0.2), rgba(184, 135, 74, 0.08)), rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(212, 163, 115, 0.3);
        color: #d4a373;
        font-size: 28px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 22px;
        position: relative; z-index: 2;
        box-shadow: 0 14px 40px rgba(212, 163, 115, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.08);
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        animation: authBadgeIn 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    @keyframes authBadgeIn {
        from { opacity: 0; transform: scale(0.6) rotate(-15deg); }
        to { opacity: 1; transform: scale(1) rotate(0deg); }
    }

    .auth-form-group { margin-bottom: 22px; position: relative; z-index: 2; }
    .auth-form-group label {
        display: block;
        font-weight: 600;
        font-size: 13px;
        color: #8fa0b5;
        margin-bottom: 10px;
        padding-right: 4px;
    }
    [data-theme="light"] .auth-form-group label { color: #6b7a8a; }

    .auth-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }
    .auth-input-icon {
        position: absolute;
        right: 18px;
        color: #d4a373;
        font-size: 15px;
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        z-index: 2;
    }
    .auth-input-wrap:focus-within .auth-input-icon {
        transform: scale(1.15);
        filter: drop-shadow(0 0 8px rgba(212, 163, 115, 0.6));
    }
    .auth-form-input {
        width: 100%;
        padding: 16px 48px 16px 20px;
        border: 1.5px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.04);
        color: #fff;
        font-family: inherit;
        font-size: 15px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        outline: none;
        position: relative; z-index: 1;
    }
    [data-theme="light"] .auth-form-input {
        background: #f5f7fa;
        border-color: #e4e7ec;
        color: #0a1628;
    }
    .auth-form-input:focus {
        border-color: #d4a373;
        background: rgba(212, 163, 115, 0.06);
        box-shadow: 0 0 0 5px rgba(212, 163, 115, 0.12);
    }
    .auth-form-input[dir="ltr"] {
        text-align: left;
        letter-spacing: 3px;
        font-weight: 700;
        font-size: 17px;
    }

    .auth-btn-primary {
        width: 100%;
        display: inline-flex;
        align-items: center; justify-content: center;
        gap: 10px;
        padding: 16px 24px;
        border-radius: 16px;
        background: linear-gradient(135deg, #d4a373, #b8874a);
        color: #fff;
        font-weight: 700;
        font-size: 15px;
        border: none;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 12px 32px rgba(212, 163, 115, 0.35);
        margin-top: 8px;
        position: relative; z-index: 2;
        overflow: hidden;
    }
    .auth-btn-primary:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 20px 50px rgba(212, 163, 115, 0.55);
    }
    .auth-btn-primary:disabled {
        opacity: 0.55;
        cursor: not-allowed;
    }

    .auth-btn-link {
        display: block;
        width: 100%;
        margin-top: 14px;
        background: none;
        border: none;
        color: #8fa0b5;
        font-family: inherit;
        font-size: 13px;
        cursor: pointer;
        transition: color 0.3s;
        text-align: center;
        padding: 6px;
        position: relative; z-index: 2;
    }
    [data-theme="light"] .auth-btn-link { color: #6b7a8a; }
    .auth-btn-link:hover { color: #d4a373; }

    .auth-alert {
        padding: 13px 16px;
        border-radius: 14px;
        font-size: 13px;
        display: none;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 18px;
        line-height: 1.7;
        position: relative; z-index: 2;
    }
    .auth-alert.show { display: flex; }
    .auth-alert.alert-info {
        background: rgba(96, 165, 250, 0.1);
        border: 1px solid rgba(96, 165, 250, 0.25);
        color: #60a5fa;
    }
    .auth-alert.alert-error {
        background: rgba(244, 63, 94, 0.1);
        border: 1px solid rgba(244, 63, 94, 0.25);
        color: #fb7185;
    }
    .auth-alert.alert-success {
        background: rgba(52, 211, 153, 0.1);
        border: 1px solid rgba(52, 211, 153, 0.25);
        color: #34d399;
    }
    .auth-alert i { margin-top: 3px; flex-shrink: 0; }

    .auth-bot-block { text-align: center; position: relative; z-index: 2; }
    .auth-bot-icon {
        width: 84px; height: 84px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4CD964, #2FA84F);
        color: #fff; font-size: 38px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 22px;
        box-shadow: 0 18px 48px rgba(76, 217, 100, 0.45);
        animation: botPulse 2.4s ease-in-out infinite;
        position: relative;
    }
    .auth-bot-icon::after {
        content: '';
        position: absolute;
        inset: -10px;
        border-radius: 50%;
        border: 2px solid rgba(76, 217, 100, 0.4);
        animation: botRing 2.4s ease-in-out infinite;
    }
    @keyframes botPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.07); }
    }
    @keyframes botRing {
        0% { transform: scale(1); opacity: 0.7; }
        100% { transform: scale(1.4); opacity: 0; }
    }
    .auth-bot-btn {
        display: inline-flex;
        align-items: center; justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 16px 24px;
        background: linear-gradient(135deg, #4CD964, #2FA84F);
        color: #fff;
        border-radius: 16px;
        font-weight: 700;
        font-size: 15px;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        margin-bottom: 14px;
        box-shadow: 0 12px 32px rgba(76, 217, 100, 0.4);
        border: none; cursor: pointer;
        text-decoration: none;
        font-family: inherit;
    }
    .auth-bot-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 50px rgba(76, 217, 100, 0.6);
    }

    .auth-otp-inputs {
        display: flex;
        justify-content: center;
        gap: 10px;
        direction: ltr;
        margin: 20px 0 16px;
        position: relative;
    }
    .auth-otp-inputs input {
        width: 52px; height: 62px;
        text-align: center;
        font-size: 26px; font-weight: 800;
        border: 1.5px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.04);
        color: #fff;
        outline: none;
        font-family: inherit;
        padding: 0;
        caret-color: #d4a373;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    [data-theme="light"] .auth-otp-inputs input {
        background: #f5f7fa;
        border-color: #e4e7ec;
        color: #0a1628;
    }
    .auth-otp-inputs input:focus {
        border-color: #d4a373;
        background: rgba(212, 163, 115, 0.1);
        box-shadow: 0 0 0 5px rgba(212, 163, 115, 0.15);
        transform: translateY(-3px) scale(1.05);
    }
    .auth-otp-inputs input.filled {
        border-color: #d4a373;
        background: rgba(212, 163, 115, 0.12);
        color: #d4a373;
        box-shadow: 0 10px 28px rgba(212, 163, 115, 0.22);
    }

    .auth-otp-timer {
        text-align: center;
        color: #8fa0b5;
        font-size: 13px;
        margin-top: 14px;
        position: relative; z-index: 2;
    }
    [data-theme="light"] .auth-otp-timer { color: #6b7a8a; }
    .auth-otp-timer span {
        color: #d4a373;
        font-weight: 700;
        font-family: monospace;
        direction: ltr;
        display: inline-block;
        min-width: 48px;
    }
    .auth-otp-resend {
        display: block;
        width: 100%;
        margin-top: 10px;
        background: none;
        border: none;
        color: #8fa0b5;
        font-family: inherit;
        font-size: 13px;
        cursor: pointer;
        transition: color 0.3s;
        text-align: center;
        padding: 6px;
        position: relative; z-index: 2;
    }
    .auth-otp-resend:hover:not(:disabled) { color: #d4a373; }
    .auth-otp-resend:disabled { opacity: 0.4; cursor: not-allowed; }

    /* ===== Toast ===== */
    .auth-toast-container {
        position: fixed;
        bottom: 30px; left: 30px;
        z-index: 999999;
        display: flex; flex-direction: column; gap: 12px;
        font-family: "Vazirmatn", "Inter", sans-serif;
        pointer-events: none;
    }
    .auth-toast {
        display: flex; align-items: center; gap: 14px;
        padding: 16px 22px;
        background: #0f1f33;
        border: 1px solid #1a2f4a;
        border-radius: 16px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        min-width: 300px; max-width: 420px;
        font-size: 14px; font-weight: 600;
        color: #f0f0f0;
        animation: authToastIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
        pointer-events: auto;
    }
    [data-theme="light"] .auth-toast {
        background: #fff;
        border-color: #e4e7ec;
        color: #0a1628;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    }
    .auth-toast::before {
        content: '';
        position: absolute;
        right: 0; top: 0; bottom: 0;
        width: 4px;
        background: var(--toast-color);
    }
    .auth-toast i { font-size: 20px; color: var(--toast-color); flex-shrink: 0; }
    .auth-toast.success { --toast-color: #34d399; }
    .auth-toast.error { --toast-color: #fb7185; }
    .auth-toast.info { --toast-color: #60a5fa; }
    .auth-toast.warning { --toast-color: #fbbf24; }

    @keyframes authToastIn {
        from { opacity: 0; transform: translateX(-100px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .auth-step {
        animation: authStepIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    @keyframes authStepIn {
        from { opacity: 0; transform: translateY(24px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ============================================================
    RESPONSIVE
    ============================================================ */
    @media (max-width: 992px) {
        .site-nav { display: none; }
        .site-menu-toggle { display: flex; }
        .cart-panel { width: 90%; }
    }
    @media (max-width: 768px) {
        .cart-panel { width: 100%; }
        .cart-item {
            grid-template-columns: 50px 1fr;
            gap: 12px;
        }
        .cart-item-price {
            grid-column: 1 / -1;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding-top: 12px;
            border-top: 1px solid var(--border, #e4e7ec);
            width: 100%;
        }
        [data-theme="dark"] .cart-item-price { border-top-color: #1a2f4a; }
    }
    @media (max-width: 576px) {
        .site-header-inner { padding: 0 16px; gap: 8px; }
        .site-logo img { height: 40px; }
        .site-login-btn { padding: 9px 18px; font-size: 13px; }
        .site-action-btn,
        .site-menu-toggle { width: 40px; height: 40px; font-size: 15px; }
        .site-dropdown-menu { left: auto; right: 0; min-width: 220px; }
        .auth-modal { padding: 42px 22px 30px; border-radius: 26px; }
        .auth-modal-wrap { border-radius: 28px; max-height: calc(100vh - 32px); }
        .auth-modal-title { font-size: 21px; }
        .auth-modal-subtitle { font-size: 13px; margin-bottom: 22px; }
        .auth-step-badge { width: 60px; height: 60px; font-size: 24px; border-radius: 18px; margin-bottom: 18px; }
        .auth-otp-inputs { gap: 6px; }
        .auth-otp-inputs input { width: 44px; height: 54px; font-size: 22px; border-radius: 13px; }
        .auth-toast-container { left: 16px; right: 16px; bottom: 16px; }
        .auth-toast { min-width: auto; max-width: 100%; }
        .cart-panel-header { padding: 18px 18px; }
        .cart-panel-header h3 { font-size: 16px; }
        .cart-panel-header-icon { width: 40px; height: 40px; font-size: 16px; }
        .cart-panel-body { padding: 18px 18px; }
        .cart-panel-footer { padding: 16px 18px 20px; }
        .cart-item { padding: 14px 16px; }
        .cart-item-icon { width: 50px; height: 50px; font-size: 20px; }
        .cart-item-title { font-size: 14px; }
        .cart-summary-row.total .value { font-size: 18px; }
    }
</style>

{{-- ============================================================
HEADER HTML
============================================================ --}}
<header class="site-header">
    <div class="site-header-inner">
        <a href="{{ route('home') }}" class="site-logo">
            <img src="{{ asset('images/Aug 2, 2026, 03_28_58 PM.png') }}" alt="Grafium" />
        </a>

        <nav class="site-nav">
            <ul>
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">خانه</a></li>
                <li><a href="{{ route('services') }}" class="{{ request()->routeIs('services*') ? 'active' : '' }}">خدمات</a></li>
                <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog*') ? 'active' : '' }}">بلاگ</a></li>
                <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">درباره ما</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">تماس</a></li>
            </ul>
        </nav>

        <div class="site-header-actions">
            {{-- 1. Theme Toggle --}}
            <button class="site-action-btn site-theme-toggle" id="siteThemeToggle" type="button" aria-label="تغییر تم">
                <i class="fas fa-moon"></i>
            </button>

            {{-- 2. Cart Button (only for logged users) --}}
            @auth
            <button class="site-action-btn site-cart-btn" id="siteCartBtn" type="button" aria-label="سبد خرید">
                <i class="fas fa-shopping-cart"></i>
                <span class="site-cart-badge" id="siteCartBadge">0</span>
            </button>
            @endauth

            {{-- 3. User / Login --}}
            @auth
                <div class="site-user-dropdown" id="siteUserDropdown">
                    <button class="site-action-btn site-user-avatar" id="siteAvatarBtn" type="button" aria-label="حساب کاربری">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->display_name }}" />
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </button>
                    <div class="site-dropdown-menu" id="siteDropdownMenu">
                        <div class="site-dropdown-header">
                            <span class="user-name">{{ auth()->user()->display_name }}</span>
                            <span class="user-phone">{{ auth()->user()->phone }}</span>
                        </div>
                        <a href="{{ route('dashboard') }}" class="site-dropdown-item">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>پنل من</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="site-dropdown-item">
                            <i class="fas fa-user-edit"></i>
                            <span>ویرایش اطلاعات</span>
                        </a>
                        <div class="site-dropdown-divider"></div>
                        <button type="button" class="site-dropdown-item site-logout-item" id="siteLogoutBtn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>خروج از حساب</span>
                        </button>
                    </div>
                </div>
            @else
                <button type="button" class="site-login-btn" id="siteOpenAuthModal">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>ورود</span>
                </button>
            @endauth

            {{-- Mobile Menu Toggle --}}
            <button class="site-menu-toggle" id="siteMenuToggle" type="button" aria-label="منو">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div class="site-mobile-menu" id="siteMobileMenu">
        <ul>
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">خانه</a></li>
            <li><a href="{{ route('services') }}" class="{{ request()->routeIs('services*') ? 'active' : '' }}">خدمات</a></li>
            <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog*') ? 'active' : '' }}">بلاگ</a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">درباره ما</a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">تماس</a></li>

            @auth
                <div class="mobile-divider"></div>
                <li><a href="{{ route('dashboard') }}">پنل من</a></li>
                <li><a href="{{ route('profile.edit') }}">ویرایش اطلاعات</a></li>
                <li>
                    <button type="button" id="siteMobileLogoutBtn" style="width:100%;text-align:right;padding:12px 16px;border-radius:12px;font-weight:600;font-size:15px;color:#fb7185;border:none;background:transparent;cursor:pointer;font-family:inherit;display:flex;align-items:center;gap:12px;">
                        <i class="fas fa-sign-out-alt" style="width:20px;"></i>
                        <span>خروج از حساب</span>
                    </button>
                </li>
            @else
                <div class="mobile-divider"></div>
                <li>
                    <button type="button" id="siteMobileOpenAuthModal" class="mobile-login" style="width:100%;cursor:pointer;border:none;font-family:inherit;">
                        <i class="fas fa-sign-in-alt"></i>
                        ورود / ثبت‌نام
                    </button>
                </li>
            @endauth
        </ul>
    </div>
</header>

{{-- ============================================================
CART PANEL
============================================================ --}}
@auth
<div class="cart-backdrop" id="cartBackdrop"></div>
<aside class="cart-panel" id="cartPanel">
    <div class="cart-panel-header">
        <div class="cart-panel-header-content">
            <div class="cart-panel-header-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div>
                <h3>سبد خرید</h3>
                <p id="cartHeaderSubtitle">آماده‌ی پرداخت</p>
            </div>
        </div>
        <button class="cart-panel-close" id="cartPanelClose" type="button" aria-label="بستن">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="cart-timer-bar" id="cartTimerBar" style="display:none;">
        <i class="fas fa-clock"></i>
        <span>زمان باقی‌مانده برای تکمیل رزرو:</span>
        <span class="cart-timer" id="cartTimer">۰۴:۰۰</span>
    </div>

    <div class="cart-panel-body" id="cartPanelBody">
        <div class="cart-loading">
            <div class="cart-loading-spinner"></div>
            <span>در حال بارگذاری...</span>
        </div>
    </div>

    <div class="cart-panel-footer" id="cartPanelFooter" style="display:none;">
        <div class="cart-summary-row">
            <span class="label">تعداد آیتم:</span>
            <span class="value" id="cartItemCount">۰</span>
        </div>
        <div class="cart-summary-row total">
            <span class="label">مجموع کل:</span>
            <span class="value" id="cartTotal">۰ تومان</span>
        </div>
        <button type="button" class="cart-checkout-btn" id="cartCheckoutBtn">
            <i class="fas fa-credit-card"></i>
            <span>پرداخت و نهایی‌سازی</span>
        </button>
    </div>
</aside>
@endauth

{{-- ============================================================
AUTH MODAL (only for guests)
============================================================ --}}
@guest
<div class="auth-modal-overlay" id="authModalOverlay">
    <div class="auth-modal-wrap">
        <div class="auth-modal">
            <button class="auth-modal-close" id="authModalClose" type="button" aria-label="بستن">
                <i class="fas fa-times"></i>
            </button>

            <div id="authStepPhone" class="auth-step">
                <div class="auth-step-badge">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="auth-modal-title">ورود / ثبت‌نام</h3>
                <p class="auth-modal-subtitle">شماره موبایل خود را وارد کنید تا کد ورود برایتان ارسال شود</p>

                <div class="auth-alert alert-error" id="authPhoneError">
                    <i class="fas fa-exclamation-circle"></i>
                    <span id="authPhoneErrorText"></span>
                </div>

                <div class="auth-form-group">
                    <label for="authPhoneInput">شماره موبایل</label>
                    <div class="auth-input-wrap">
                        <i class="fas fa-phone auth-input-icon"></i>
                        <input type="tel" id="authPhoneInput" class="auth-form-input" placeholder="09123456789" dir="ltr" maxlength="11" inputmode="numeric" autocomplete="tel" />
                    </div>
                </div>

                <button type="button" class="auth-btn-primary" id="authSendOtpBtn">
                    <span>ارسال کد</span>
                    <i class="fas fa-arrow-left"></i>
                </button>
            </div>

            <div id="authStepBot" class="auth-step" style="display:none;">
                <div class="auth-bot-block">
                    <div class="auth-bot-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3 class="auth-modal-title">استارت بازوی بله</h3>
                    <p class="auth-modal-subtitle">برای دریافت کد ورود، لطفاً ابتدا بازوی ما را در پیام‌رسان بله استارت کنید.</p>

                    <a href="https://ble.ir/GRAFIUM_bot" target="_blank" rel="noopener" class="auth-bot-btn">
                        <i class="fas fa-paper-plane"></i>
                        <span>رفتن به بازوی GRAFIUM</span>
                    </a>

                    <div class="auth-alert alert-info show" style="text-align:right;margin-bottom:14px;">
                        <i class="fas fa-info-circle"></i>
                        <span>پس از استارت بازو، به اینجا برگردید و روی دکمه زیر کلیک کنید.</span>
                    </div>

                    <button type="button" class="auth-btn-primary" id="authRetrySend">
                        <span>استارت کردم، دوباره تلاش کن</span>
                        <i class="fas fa-redo"></i>
                    </button>

                    <button type="button" class="auth-btn-link" id="authBackToPhoneFromBot">ویرایش شماره</button>
                </div>
            </div>

            <div id="authStepCode" class="auth-step" style="display:none;">
                <div class="auth-step-badge">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="auth-modal-title">کد تایید</h3>
                <p class="auth-modal-subtitle">کد ۶ رقمی ارسال شده به بله را وارد کنید</p>

                <div class="auth-alert alert-error" id="authCodeError">
                    <i class="fas fa-exclamation-circle"></i>
                    <span id="authCodeErrorText"></span>
                </div>

                <div class="auth-alert alert-success" id="authCodeSuccess">
                    <i class="fas fa-check-circle"></i>
                    <span id="authCodeSuccessText"></span>
                </div>

                <div class="auth-otp-inputs" id="authOtpInputs">
                    <input type="text" inputmode="numeric" maxlength="1" data-index="0" autocomplete="one-time-code" />
                    <input type="text" inputmode="numeric" maxlength="1" data-index="1" />
                    <input type="text" inputmode="numeric" maxlength="1" data-index="2" />
                    <input type="text" inputmode="numeric" maxlength="1" data-index="3" />
                    <input type="text" inputmode="numeric" maxlength="1" data-index="4" />
                    <input type="text" inputmode="numeric" maxlength="1" data-index="5" />
                </div>

                <button type="button" class="auth-btn-primary" id="authVerifyOtpBtn">
                    <span>تایید و ورود</span>
                    <i class="fas fa-check"></i>
                </button>

                <p class="auth-otp-timer">
                    ارسال مجدد تا <span id="authTimer">۰۲:۰۰</span>
                </p>
                <button type="button" class="auth-otp-resend" id="authResendOtp" disabled>
                    <i class="fas fa-redo"></i> ارسال مجدد کد
                </button>
                <button type="button" class="auth-btn-link" id="authBackToPhoneFromCode">ویرایش شماره</button>
            </div>
        </div>
    </div>
</div>
@endguest

<div class="auth-toast-container" id="authToastContainer"></div>

{{-- ============================================================
HEADER + AUTH + CART SCRIPT
============================================================ --}}
<script>
(function() {
    'use strict';

    // ===== THEME TOGGLE =====
    const themeToggle = document.getElementById('siteThemeToggle');
    const themeIcon = themeToggle?.querySelector('i');
    let darkMode = localStorage.getItem('theme') ? localStorage.getItem('theme') === 'dark' : true;

    function applyTheme() {
        document.documentElement.setAttribute('data-theme', darkMode ? 'dark' : 'light');
        if (themeIcon) themeIcon.className = darkMode ? 'fas fa-moon' : 'fas fa-sun';
        localStorage.setItem('theme', darkMode ? 'dark' : 'light');
    }
    applyTheme();
    themeToggle?.addEventListener('click', () => { darkMode = !darkMode; applyTheme(); });

    // ===== TOAST =====
    window.showAuthToast = function(message, type = 'info', duration = 4000) {
        const container = document.getElementById('authToastContainer');
        if (!container) return;
        const icons = { success: 'fa-check-circle', error: 'fa-exclamation-circle', info: 'fa-info-circle', warning: 'fa-exclamation-triangle' };
        const toast = document.createElement('div');
        toast.className = `auth-toast ${type}`;
        toast.innerHTML = `<i class="fas ${icons[type] || 'fa-info-circle'}"></i><span>${message}</span>`;
        container.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(-100px)';
            setTimeout(() => toast.remove(), 400);
        }, duration);
    };

    // ===== USER DROPDOWN =====
    const avatarBtn = document.getElementById('siteAvatarBtn');
    const dropdownMenu = document.getElementById('siteDropdownMenu');
    const userDropdown = document.getElementById('siteUserDropdown');

    avatarBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdownMenu?.classList.toggle('open');
    });

    document.addEventListener('click', (e) => {
        if (userDropdown && !userDropdown.contains(e.target)) {
            dropdownMenu?.classList.remove('open');
        }
    });

    // ===== LOGOUT =====
    async function performLogout() {
        if (!confirm('آیا از خروج اطمینان دارید؟')) return;
        try {
            await fetch('{{ route("logout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
            });
        } catch (e) {}
        window.location.href = '{{ route("home") }}';
    }
    document.getElementById('siteLogoutBtn')?.addEventListener('click', performLogout);
    document.getElementById('siteMobileLogoutBtn')?.addEventListener('click', performLogout);

    // ===== MOBILE MENU =====
    const menuToggle = document.getElementById('siteMenuToggle');
    const mobileMenu = document.getElementById('siteMobileMenu');
    const menuIcon = menuToggle?.querySelector('i');

    menuToggle?.addEventListener('click', () => {
        const isOpen = mobileMenu?.classList.toggle('open');
        if (menuIcon) menuIcon.className = isOpen ? 'fas fa-times' : 'fas fa-bars';
    });

    document.querySelectorAll('.site-mobile-menu a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu?.classList.remove('open');
            if (menuIcon) menuIcon.className = 'fas fa-bars';
        });
    });

    // ============================================================
    // CART SYSTEM
    // ============================================================
    const cartBtn = document.getElementById('siteCartBtn');
    const cartBackdrop = document.getElementById('cartBackdrop');
    const cartPanel = document.getElementById('cartPanel');
    const cartPanelClose = document.getElementById('cartPanelClose');
    const cartPanelBody = document.getElementById('cartPanelBody');
    const cartPanelFooter = document.getElementById('cartPanelFooter');
    const cartTimerBar = document.getElementById('cartTimerBar');
    const cartTimer = document.getElementById('cartTimer');
    const cartBadge = document.getElementById('siteCartBadge');
    const cartHeaderSubtitle = document.getElementById('cartHeaderSubtitle');
    const cartItemCount = document.getElementById('cartItemCount');
    const cartTotal = document.getElementById('cartTotal');
    const cartCheckoutBtn = document.getElementById('cartCheckoutBtn');

    let cartTimerInterval = null;
    let cartRefreshInterval = null;
    let cartRemainingSeconds = 0;

    // ===== Open/Close Panel =====
    function openCartPanel() {
        cartBackdrop?.classList.add('open');
        cartPanel?.classList.add('open');
        document.body.style.overflow = 'hidden';
        loadCartItems();

        // Refresh هر ۱۰ ثانیه
        clearInterval(cartRefreshInterval);
        cartRefreshInterval = setInterval(loadCartItems, 10000);
    }

    function closeCartPanel() {
        cartBackdrop?.classList.remove('open');
        cartPanel?.classList.remove('open');
        document.body.style.overflow = '';
        clearInterval(cartRefreshInterval);
    }

    cartBtn?.addEventListener('click', openCartPanel);
    cartPanelClose?.addEventListener('click', closeCartPanel);
    cartBackdrop?.addEventListener('click', closeCartPanel);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && cartPanel?.classList.contains('open')) {
            closeCartPanel();
        }
    });

    // ===== Load Cart Items =====
    async function loadCartItems() {
        if (!cartPanelBody) return;

        try {
            const res = await fetch('{{ route("cart.items") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
            });

            const data = await res.json();

            if (data.success) {
                renderCartItems(data);
                updateCartBadge(data.cart_count);
            }
        } catch (err) {
            console.error('Cart load error:', err);
        }
    }

    // ===== Render Cart =====
    function renderCartItems(data) {
        const items = data.items || [];

        // بروزرسانی بج
        updateCartBadge(data.cart_count);

        // بروزرسانی زیرتیتر
        if (cartHeaderSubtitle) {
            if (items.length === 0) {
                cartHeaderSubtitle.textContent = 'سبد خرید خالی است';
            } else {
                cartHeaderSubtitle.textContent = `${items.length} آیتم در سبد`;
            }
        }

        // اگه خالی بود
        if (items.length === 0) {
            cartPanelBody.innerHTML = `
                <div class="cart-empty">
                    <div class="cart-empty-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h4>سبد خرید شما خالی است</h4>
                    <p>برای رزرو، از صفحه خدمات یک میز یا استودیو انتخاب کنید.</p>
                </div>
            `;
            cartPanelFooter.style.display = 'none';
            cartTimerBar.style.display = 'none';
            clearInterval(cartTimerInterval);
            return;
        }

        // ساخت آیتم‌ها
        cartPanelBody.innerHTML = items.map(item => `
            <div class="cart-item" data-scheduling-id="${item.scheduling_id}">
                <div class="cart-item-icon">
                    <i class="fas fa-desktop"></i>
                </div>
                <div class="cart-item-info">
                    <div class="cart-item-service">
                        <i class="fas fa-tag"></i>
                        ${item.service_title}
                    </div>
                    <div class="cart-item-title">${item.item_title}</div>
                    <div class="cart-item-meta">
                        <span><i class="fas fa-calendar"></i> ${item.jalali_date || ''}</span>
                        <span><i class="fas fa-clock"></i> ${item.time_start} - ${item.time_end}</span>
                        ${item.item_place ? `<span><i class="fas fa-map-marker-alt"></i> ${item.item_place}</span>` : ''}
                    </div>
                </div>
                <div class="cart-item-price">
                    <div class="cart-item-price-value">${item.price_formatted} تومان</div>
                    <button type="button" class="cart-item-remove" onclick="removeCartItem(${item.scheduling_id})" title="حذف">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        `).join('');

        // فوتر
        cartPanelFooter.style.display = 'block';
        cartItemCount.textContent = items.length.toLocaleString('fa-IR');
        cartTotal.textContent = `${data.total_formatted} تومان`;

        // تایمر
        if (data.remaining_seconds > 0) {
            cartRemainingSeconds = data.remaining_seconds;
            cartTimerBar.style.display = 'flex';
            startCartTimer(cartRemainingSeconds);
        } else {
            cartTimerBar.style.display = 'none';
            clearInterval(cartTimerInterval);
        }
    }

    // ===== Cart Timer =====
    function startCartTimer(seconds) {
        clearInterval(cartTimerInterval);
        cartRemainingSeconds = seconds;
        updateCartTimerDisplay();

        cartTimerInterval = setInterval(() => {
            cartRemainingSeconds--;
            if (cartRemainingSeconds <= 0) {
                clearInterval(cartTimerInterval);
                cartRemainingSeconds = 0;
                updateCartTimerDisplay();
                // reload to show empty
                setTimeout(() => loadCartItems(), 500);
                return;
            }
            updateCartTimerDisplay();
        }, 1000);
    }

    function updateCartTimerDisplay() {
        if (!cartTimer) return;
        const m = String(Math.floor(cartRemainingSeconds / 60)).padStart(2, '0');
        const s = String(cartRemainingSeconds % 60).padStart(2, '0');
        const toFa = (str) => str.replace(/[0-9]/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);
        cartTimer.textContent = toFa(`${m}:${s}`);
    }

    // ===== Update Badge =====
    function updateCartBadge(count) {
        if (!cartBadge) return;
        if (count > 0) {
            cartBadge.textContent = count.toLocaleString('fa-IR');
            cartBadge.classList.add('show');
        } else {
            cartBadge.classList.remove('show');
        }
    }

    // ===== Remove Item =====
    window.removeCartItem = async function(schedulingId) {
        if (!confirm('آیا از حذف این آیتم اطمینان دارید؟')) return;

        const itemEl = document.querySelector(`.cart-item[data-scheduling-id="${schedulingId}"]`);
        if (itemEl) itemEl.classList.add('removing');

        try {
            const res = await fetch('{{ route("cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({ scheduling_id: schedulingId }),
            });

            const data = await res.json();

            if (data.success) {
                window.showAuthToast('آیتم حذف شد', 'success');
                setTimeout(() => loadCartItems(), 400);

                // اطلاع به صفحه (اگه توی صفحه reserve هستیم)
                if (window.onCartItemRemoved) {
                    window.onCartItemRemoved(schedulingId);
                }
            } else {
                window.showAuthToast(data.message || 'خطا در حذف', 'error');
                if (itemEl) itemEl.classList.remove('removing');
            }
        } catch (err) {
            window.showAuthToast('خطا در ارتباط با سرور', 'error');
            if (itemEl) itemEl.classList.remove('removing');
        }
    };

    // ===== Checkout =====
    cartCheckoutBtn?.addEventListener('click', () => {
        window.location.href = '{{ route("cart.checkout") ?? "#" }}';
    });

    // ===== Load Badge on Page Load =====
    @auth
    if (cartBadge) {
        fetch('{{ route("cart.items") }}', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) updateCartBadge(data.cart_count);
        })
        .catch(() => {});
    }
    @endauth

    // ===== Global: Expose cart API =====
    window.CartAPI = {
        loadCartItems,
        openCartPanel,
        closeCartPanel,
        updateCartBadge,
    };

    // ============================================================
    // AUTH MODAL
    // ============================================================
    const authModalOverlay = document.getElementById('authModalOverlay');
    if (!authModalOverlay) {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('open_login') === '1' && window.history.replaceState) {
            const cleanUrl = window.location.pathname + window.location.hash;
            window.history.replaceState({}, document.title, cleanUrl);
        }
        return;
    }

    const authModalClose = document.getElementById('authModalClose');
    const siteOpenAuthModal = document.getElementById('siteOpenAuthModal');
    const siteMobileOpenAuthModal = document.getElementById('siteMobileOpenAuthModal');

    const authStepPhone = document.getElementById('authStepPhone');
    const authStepBot = document.getElementById('authStepBot');
    const authStepCode = document.getElementById('authStepCode');

    const authPhoneInput = document.getElementById('authPhoneInput');
    const authPhoneError = document.getElementById('authPhoneError');
    const authPhoneErrorText = document.getElementById('authPhoneErrorText');
    const authSendOtpBtn = document.getElementById('authSendOtpBtn');

    const authRetrySend = document.getElementById('authRetrySend');
    const authBackToPhoneFromBot = document.getElementById('authBackToPhoneFromBot');

    const authOtpInputs = document.querySelectorAll('#authOtpInputs input');
    const authVerifyOtpBtn = document.getElementById('authVerifyOtpBtn');
    const authCodeError = document.getElementById('authCodeError');
    const authCodeErrorText = document.getElementById('authCodeErrorText');
    const authCodeSuccess = document.getElementById('authCodeSuccess');
    const authCodeSuccessText = document.getElementById('authCodeSuccessText');
    const authBackToPhoneFromCode = document.getElementById('authBackToPhoneFromCode');
    const authTimerEl = document.getElementById('authTimer');
    const authResendOtp = document.getElementById('authResendOtp');

    let authTimerInterval = null;
    let authCurrentPhone = '';
    let authIsSending = false;
    let chatIdPollingInterval = null;

    function openAuthModal() {
        authModalOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        resetAuthModal();
        setTimeout(() => authPhoneInput?.focus(), 500);
    }

    function closeAuthModal() {
        authModalOverlay.classList.remove('active');
        document.body.style.overflow = '';
        clearInterval(authTimerInterval);
        clearInterval(chatIdPollingInterval);
    }

    function resetAuthModal() {
        authStepPhone.style.display = 'block';
        authStepBot.style.display = 'none';
        authStepCode.style.display = 'none';
        authPhoneError.classList.remove('show');
        authCodeError.classList.remove('show');
        authCodeSuccess.classList.remove('show');
        authOtpInputs.forEach(i => { i.value = ''; i.classList.remove('filled'); });
        clearInterval(authTimerInterval);
        if (authResendOtp) authResendOtp.disabled = true;
    }

    function showAuthStep(step) {
        const steps = { phone: authStepPhone, bot: authStepBot, code: authStepCode };
        Object.values(steps).forEach(s => { s.style.display = 'none'; s.style.animation = 'none'; });
        const active = steps[step];
        if (active) {
            active.style.display = 'block';
            void active.offsetWidth;
            active.style.animation = '';
        }
    }

    siteOpenAuthModal?.addEventListener('click', openAuthModal);
    siteMobileOpenAuthModal?.addEventListener('click', () => {
        mobileMenu?.classList.remove('open');
        if (menuIcon) menuIcon.className = 'fas fa-bars';
        openAuthModal();
    });

    (function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('open_login') === '1') {
            setTimeout(openAuthModal, 300);
            if (window.history.replaceState) {
                const cleanUrl = window.location.pathname + window.location.hash;
                window.history.replaceState({}, document.title, cleanUrl);
            }
        }
    })();

    authModalClose?.addEventListener('click', closeAuthModal);
    authModalOverlay?.addEventListener('click', (e) => {
        if (e.target === authModalOverlay) closeAuthModal();
    });

    async function authSendOtp(phone) {
        if (authIsSending) return;
        authIsSending = true;
        authCurrentPhone = phone;

        authSendOtpBtn.disabled = true;
        authSendOtpBtn.innerHTML = '<span>در حال ارسال...</span><i class="fas fa-spinner fa-spin"></i>';
        authPhoneError.classList.remove('show');

        try {
            const res = await fetch('{{ route("otp.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ phone }),
            });

            const data = await res.json();

            if (data.success) {
                showAuthStep('code');
                startAuthTimer(120);
                window.showAuthToast('کد ورود به بله شما ارسال شد', 'success');
                setTimeout(() => authOtpInputs[0]?.focus(), 500);
            } else if (data.needs_bot_start) {
                showAuthStep('bot');
            } else {
                authPhoneErrorText.textContent = data.message || 'خطا در ارسال کد';
                authPhoneError.classList.add('show');
            }
        } catch (err) {
            authPhoneErrorText.textContent = 'خطا در ارتباط با سرور.';
            authPhoneError.classList.add('show');
        } finally {
            authSendOtpBtn.disabled = false;
            authSendOtpBtn.innerHTML = '<span>ارسال کد</span><i class="fas fa-arrow-left"></i>';
            authIsSending = false;
        }
    }

    authSendOtpBtn?.addEventListener('click', () => {
        const phone = authPhoneInput.value.trim();
        if (!phone || phone.length < 10) {
            authPhoneErrorText.textContent = 'لطفاً شماره موبایل معتبر وارد کنید.';
            authPhoneError.classList.add('show');
            return;
        }
        authSendOtp(phone);
    });

    authPhoneInput?.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
        authPhoneError.classList.remove('show');
    });
    authPhoneInput?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') authSendOtpBtn?.click();
    });

    authRetrySend?.addEventListener('click', () => {
        if (!authCurrentPhone) { showAuthStep('phone'); return; }
        authRetrySend.disabled = true;
        authRetrySend.innerHTML = '<span>در حال بررسی...</span><i class="fas fa-spinner fa-spin"></i>';

        let attempts = 0;
        const maxAttempts = 15;

        clearInterval(chatIdPollingInterval);
        chatIdPollingInterval = setInterval(async () => {
            attempts++;
            try {
                const res = await fetch('{{ route("otp.check-chat-id") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ phone: authCurrentPhone }),
                });
                const data = await res.json();
                if (data.success && data.has_chat_id) {
                    clearInterval(chatIdPollingInterval);
                    authRetrySend.disabled = false;
                    authRetrySend.innerHTML = '<span>استارت کردم، دوباره تلاش کن</span><i class="fas fa-redo"></i>';
                    window.showAuthToast('بازو متصل شد!', 'success');
                    authSendOtp(authCurrentPhone);
                    return;
                }
                if (attempts >= maxAttempts) {
                    clearInterval(chatIdPollingInterval);
                    authRetrySend.disabled = false;
                    authRetrySend.innerHTML = '<span>استارت کردم، دوباره تلاش کن</span><i class="fas fa-redo"></i>';
                    window.showAuthToast('زمان انتظار تمام شد.', 'warning');
                }
            } catch (err) { console.error(err); }
        }, 2000);
    });

    authBackToPhoneFromBot?.addEventListener('click', () => {
        showAuthStep('phone');
        authPhoneError.classList.remove('show');
        clearInterval(chatIdPollingInterval);
    });

    authBackToPhoneFromCode?.addEventListener('click', () => {
        showAuthStep('phone');
        clearInterval(authTimerInterval);
        authOtpInputs.forEach(i => { i.value = ''; i.classList.remove('filled'); });
    });

    authOtpInputs.forEach((input, idx) => {
        input.addEventListener('input', (e) => {
            const val = e.target.value.replace(/[^0-9]/g, '');
            e.target.value = val;
            if (val) {
                e.target.classList.add('filled');
                if (idx < authOtpInputs.length - 1) authOtpInputs[idx + 1].focus();
            } else {
                e.target.classList.remove('filled');
            }
        });
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && idx > 0) authOtpInputs[idx - 1].focus();
            if (e.key === 'Enter') authVerifyOtpBtn?.click();
        });
        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
            if (paste.length === 6) {
                paste.split('').forEach((char, i) => {
                    if (authOtpInputs[i]) { authOtpInputs[i].value = char; authOtpInputs[i].classList.add('filled'); }
                });
                authOtpInputs[5]?.focus();
            }
        });
    });

    authOtpInputs[5]?.addEventListener('input', () => {
        const code = Array.from(authOtpInputs).map(i => i.value).join('');
        if (code.length === 6) setTimeout(() => authVerifyOtpBtn?.click(), 300);
    });

    authVerifyOtpBtn?.addEventListener('click', async () => {
        const code = Array.from(authOtpInputs).map(i => i.value).join('');
        if (code.length !== 6) {
            authCodeErrorText.textContent = 'لطفاً کد ۶ رقمی را کامل وارد کنید.';
            authCodeError.classList.add('show');
            return;
        }
        authVerifyOtpBtn.disabled = true;
        authVerifyOtpBtn.innerHTML = '<span>در حال بررسی...</span><i class="fas fa-spinner fa-spin"></i>';
        authCodeError.classList.remove('show');

        try {
            const res = await fetch('{{ route("otp.verify") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ phone: authCurrentPhone, code }),
            });
            const data = await res.json();
            if (data.success) {
                authCodeSuccessText.textContent = 'ورود موفق! در حال انتقال...';
                authCodeSuccess.classList.add('show');
                window.showAuthToast('خوش آمدید!', 'success');
                setTimeout(() => { window.location.href = '/profile'; }, 900);
            } else {
                authCodeErrorText.textContent = data.message || 'کد صحیح نیست.';
                authCodeError.classList.add('show');
                authOtpInputs.forEach(i => { i.value = ''; i.classList.remove('filled'); });
                authOtpInputs[0]?.focus();
            }
        } catch (err) {
            authCodeErrorText.textContent = 'خطا در ارتباط با سرور.';
            authCodeError.classList.add('show');
        } finally {
            authVerifyOtpBtn.disabled = false;
            authVerifyOtpBtn.innerHTML = '<span>تایید و ورود</span><i class="fas fa-check"></i>';
        }
    });

    function startAuthTimer(seconds) {
        clearInterval(authTimerInterval);
        let remaining = seconds;
        updateAuthTimer(remaining);
        if (authResendOtp) authResendOtp.disabled = true;
        authTimerInterval = setInterval(() => {
            remaining--;
            if (remaining <= 0) {
                clearInterval(authTimerInterval);
                if (authTimerEl) authTimerEl.textContent = '۰۰:۰۰';
                if (authResendOtp) authResendOtp.disabled = false;
                return;
            }
            updateAuthTimer(remaining);
        }, 1000);
    }

    function updateAuthTimer(sec) {
        const m = String(Math.floor(sec / 60)).padStart(2, '0');
        const s = String(sec % 60).padStart(2, '0');
        const toFa = (str) => str.replace(/[0-9]/g, d => '۰۱۲۳۴۵۶۷۸۹'[d]);
        if (authTimerEl) authTimerEl.textContent = toFa(`${m}:${s}`);
    }

    authResendOtp?.addEventListener('click', () => {
        if (authCurrentPhone) authSendOtp(authCurrentPhone);
    });

})();
</script>