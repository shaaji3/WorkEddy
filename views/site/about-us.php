<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - WorkEddy</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">

  <link href="/assets/css/core.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="/assets/css/app.css" rel="stylesheet">

  <style>
    body { background-color: #fafafa; }
    .marketing-nav {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .page-header {
      padding: 160px 0 80px 0;
      background: #ffffff;
      border-bottom: 1px solid rgba(0,0,0,0.05);
    }
    .about-panel {
      border: 1px solid rgba(0,0,0,0.08);
      border-radius: 1rem;
      box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top marketing-nav py-3">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="/">
        <img src="/assets/img/logo.png" alt="WorkEddy logo" class="auth-brand-logo flex-shrink-0" />
        <span class="auth-brand-name">WorkEddy</span>
      </a>
      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#marketingNavbar">
        <i class="bi bi-list fs-2 text-dark"></i>
      </button>
      <div class="collapse navbar-collapse" id="marketingNavbar">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-medium">
          <li class="nav-item"><a class="nav-link px-3" href="/#features">Features</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="/#how-it-works">How it Works</a></li>
          <li class="nav-item"><a class="nav-link px-3" href="/#pricing">Pricing</a></li>
        </ul>
        <div class="d-flex gap-2 flex-column flex-lg-row mt-3 mt-lg-0">
          <a href="/login" class="btn btn-light rounded-pill px-4 fw-bold">Login</a>
          <a href="/register" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Get Started</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Page Header -->
  <header class="page-header text-center position-relative">
    <div class="container">
      <div class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-3 fw-bold border border-primary border-opacity-25 mx-auto d-table text-uppercase" style="letter-spacing: 1px;">
         Company
      </div>
      <h1 class="fw-bold mb-0" style="font-family:'Outfit',sans-serif;font-size:3.5rem; letter-spacing: -1px; color:#111827;">About Us</h1>
    </div>
  </header>

  <!-- Main Content -->
  <main class="py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-11">
          <div class="about-panel bg-white p-4 p-lg-5">
            <div class="row align-items-center g-4 g-lg-5">
              <div class="col-lg-7">
                <p class="fs-5 text-dark fw-medium mb-4">WorkEddy is an AI ergonomics platform built to help organizations prevent musculoskeletal disorders by providing earlier risk visibility, faster intervention, and stronger evidence of improvement over time.</p>
                <p class="text-muted mb-4">The platform transforms everyday task videos into ergonomic risk scores, prioritized intervention guidance, and reports that teams can act on within minutes. Rather than positioning ergonomic assessment as a slow, manual process, WorkEddy is designed to help safety, operations, and workplace health teams identify harmful movement early, understand exposure by task and body region, and focus attention where risk is highest.</p>
                <p class="text-muted mb-0">WorkEddy is built around the workflow buyers care about most: capture the task, detect posture risk using trusted ergonomic methods, fix what needs attention first, then compare results over time to verify that changes are reducing exposure. That structure supports assessment and prevention decision-making across teams and sites.</p>

                <div class="mt-4">
                  <a href="/founder-story" class="btn btn-outline-dark rounded-pill px-4 fw-bold">
                    Read: Why we built WorkEddy <i class="bi bi-chevron-right ms-1"></i>
                  </a>
                </div>
              </div>

              <div class="col-lg-5">
                <div class="border rounded-4 p-4 p-lg-5 h-100 d-flex flex-column">
                  <div class="flex-grow-1 d-flex justify-content-center align-items-center py-4">
                    <img src="/assets/img/WorkEddy Main Logo.png" alt="WorkEddy Logo" class="img-fluid" style="max-width: 260px;">
                  </div>

                  <div class="d-flex align-items-center gap-3 pt-4 border-top mt-auto">
                    <div class="bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 54px; height: 54px;">
                      <i class="bi bi-shield-check fs-3"></i>
                    </div>
                    <div>
                      <p class="mb-1 fw-bold text-dark lh-sm">Moving from delayed review</p>
                      <p class="mb-0 small text-muted">To earlier action and better prevention outcomes.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-dark text-white py-5 mt-5">
    <div class="container py-4">
      <div class="row g-4">
        <div class="col-lg-4">
          <h4 class="fw-bold mb-3"><img src="/assets/img/logo.png" alt="WorkEddy logo" class="auth-brand-logo" /> WorkEddy</h4>
          <p class="text-white-50 pe-lg-5">Automating ergonomic risk assessments to support MSD prevention, improve assessment consistency, and document prevention actions.</p>
        </div>
        <div class="col-6 col-lg-2 offset-lg-2">
          <h6 class="fw-bold text-uppercase mb-3">Product</h6>
          <ul class="list-unstyled text-white-50">
            <li class="mb-2"><a href="/#features" class="text-white-50 text-decoration-none">Features</a></li>
            <li class="mb-2"><a href="/#pricing" class="text-white-50 text-decoration-none">Pricing</a></li>
            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Enterprise</a></li>
          </ul>
        </div>
        <div class="col-6 col-lg-2">
          <h6 class="fw-bold text-uppercase mb-3">Company</h6>
          <ul class="list-unstyled text-white-50">
            <li class="mb-2"><a href="/about-us" class="text-white-50 text-decoration-none">About Us</a></li>
            <li class="mb-2"><a href="/founder-story" class="text-white-50 text-decoration-none">From the Founder</a></li>
            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Careers</a></li>
            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Contact</a></li>
          </ul>
        </div>
        <div class="col-6 col-lg-2">
          <h6 class="fw-bold text-uppercase mb-3">Legal</h6>
          <ul class="list-unstyled text-white-50">
            <li class="mb-2"><a href="/privacy-policy" class="text-white-50 text-decoration-none">Privacy Policy</a></li>
            <li class="mb-2"><a href="/terms-of-service" class="text-white-50 text-decoration-none">Terms of Service</a></li>
          </ul>
        </div>
      </div>
      <div class="border-top border-secondary mt-5 pt-4 text-center text-white-50 small">
        &copy; <?= date('Y') ?> WorkEddy, Inc. All rights reserved.
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
