<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> <?= $title ?? 'WorkEddy - Ergonomics Risk Assessment' ?></title>
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
  
  <!-- Bootstrap 5 CSS -->
  <link href="/assets/css/core.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <!-- Global Styles (inherited base variables) -->
  <link href="/assets/css/app.css" rel="stylesheet">
  
  <style>
    /* Marketing specific styles overriding/extending app.css */
    :root {
      --hero-bg-accent: #f5f3ff; /* light purple */
    }
    body {
      background-color: #ffffff;
    }
    .marketing-nav {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .landing-hero {
      padding: 120px 0 80px 0;
      background: linear-gradient(135deg, var(--hero-bg-accent) 0%, rgba(255,255,255,0) 100%);
      position: relative;
      overflow: hidden;
    }
    .landing-hero::before {
      content: '';
      position: absolute;
      top: -10%;
      right: -5%;
      width: 50vw;
      height: 50vw;
      background: radial-gradient(circle, rgba(124,58,237,0.1) 0%, rgba(255,255,255,0) 70%);
      border-radius: 50%;
      z-index: 0;
    }
    .hero-content {
      position: relative;
      z-index: 1;
    }
    .hero-title {
      font-family: 'Outfit', sans-serif;
      font-size: 3.0rem;
      font-weight: 800;
      line-height: 1.1;
      letter-spacing: -1px;
      color: #111827;
      margin-bottom: 1.5rem;
    }
    .hero-title span {
      background: var(--we-hero-gradient, linear-gradient(135deg, #7c3aed 0%, #4c1d95 100%));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .hero-subtitle {
      font-size: 1.1rem;
      color: #6b7280;
      margin-bottom: 2rem;
      max-width: 600px;
    }
    .feature-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      background: #ffffff;
      border: 1px solid rgba(0,0,0,0.05);
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
    }
    .feature-icon-box {
      width: 64px;
      height: 64px;
      border-radius: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      margin-bottom: 1.5rem;
      background: var(--hero-bg-accent);
      color: var(--we-primary);
    }
    
    @media (max-width: 991px) {
      .hero-title { font-size: 2.5rem; }
      .landing-hero { padding: 100px 0 60px 0; text-align: center; }
      .hero-subtitle { margin: 0 auto 2rem; }
      .hero-buttons { justify-content: center; }
      .hero-image-col { margin-top: 3rem; }
      .micro-value-tags { justify-content: center; }
    }
    
    /* Mock UI frame for the hero */
    .mock-ui-frame {
      background: #fff;
      border-radius: 1.5rem;
      box-shadow: 0 25px 50px -12px rgba(124, 58, 237, 0.25);
      border: 1px solid rgba(124, 58, 237, 0.1);
      overflow: hidden;
      transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
      transition: transform 0.5s ease;
    }
    .mock-ui-frame:hover {
      transform: perspective(1000px) rotateY(0deg) rotateX(0deg);
    }
    .mock-ui-header {
      background: #f8fafc;
      padding: 1rem;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      gap: 0.5rem;
    }
    .mock-ui-dot { width: 12px; height: 12px; border-radius: 50%; }
    .mock-ui-body { background: #fafafa; }
    
    /* New Hero Additions */
    .industry-selector {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 2rem;
        padding: 0.25rem;
        display: inline-flex;
        gap: 0.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .industry-tab {
        padding: 0.5rem 1rem;
        border-radius: 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        color: #64748b;
        transition: all 0.2s;
    }
    .industry-tab.active {
        background: var(--hero-bg-accent);
        color: var(--we-primary, #7c3aed);
    }
    
    .pose-overlay-svg {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: 10;
        pointer-events: none;
    }
    
    .micro-value-tags {
        display: flex;
        gap: 1rem;
        font-size: 0.85rem;
        font-weight: 500;
        color: #4b5563;
        flex-wrap: wrap;
    }
    .micro-value-tag {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top marketing-nav py-3">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="/">
        <img src="/assets/img/workeddy.png" alt="WorkEddy logo" class="auth-brand-logo flex-shrink-0" />
      </a>
      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#marketingNavbar">
        <i class="bi bi-list fs-2 text-dark"></i>
      </button>
      <div class="collapse navbar-collapse" id="marketingNavbar">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-medium">
          <li class="nav-item"><a class="nav-link px-3" href="#features">Features</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="#how-it-works">How it Works</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="#pricing">Pricing</a></li>
        </ul>
        <div class="d-flex gap-2 flex-column flex-lg-row mt-3 mt-lg-0">
          <a href="/login" class="btn btn-light rounded-pill px-4 fw-bold">Login</a>
          <a href="/register" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Get Started</a>
        </div>
      </div>
    </div>
  </nav>
