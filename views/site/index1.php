<?php

$pageTitle = "WorkEddy";
include __DIR__ . '/../partials/site/header.php';
?>
  <!-- Hero Section -->
  <section class="landing-hero">
    <div class="container">
      <div class="row align-items-center hero-content">
        <div class="col-lg-6">
          <div class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2 mb-3 fw-bold border border-primary border-opacity-25">
            ✨ AI Ergonomics for MSD Prevention
          </div>
          <h1 class="hero-title">Prevent musculoskeletal injuries <span>before they happen</span></h1>
          <p class="hero-subtitle">WorkEddy transforms everyday task videos into ergonomic risk scores, prioritized interventions, and reports your team can act on within minutes. Identify harmful movement sooner and guide safer work design.</p>

          <div class="d-flex gap-3 hero-buttons flex-wrap">
            <a href="/register" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow">Start for Free</a>
            <a href="#how-it-works" class="btn btn-outline-secondary btn-lg rounded-pill px-4 fw-bold bg-white border-2">View Sample Report</a>
          </div>

          <div class="micro-value-tags mt-4">
            <div class="micro-value-tag"><i class="bi bi-camera-video-fill text-primary opacity-75"></i> Video based analysis</div>
            <div class="micro-value-tag"><i class="bi bi-shield-lock-fill text-primary opacity-75"></i> Privacy first posture detection</div>
            <div class="micro-value-tag"><i class="bi bi-arrow-left-right text-primary opacity-75"></i> Before and after risk comparison</div>
          </div>

          <p class="small text-muted mt-3 mb-4"><i class="bi bi-shield-check text-success"></i> Built with secure access and privacy conscious task analysis.</p>

          <!-- <div class="mt-4 pt-4 border-top">
            <div class="d-flex align-items-center gap-4 flex-wrap opacity-50 mb-3 grayscale" style="filter: grayscale(100%);">
              <span class="fs-5 fw-bold font-monospace">AMAZON</span>
              <span class="fs-5 fw-bold font-monospace">DHL</span>
              <span class="fs-5 fw-bold font-monospace">FEDEX</span>
              <span class="fs-5 fw-bold font-monospace">TESCO</span>
            </div>
            <p class="small text-dark fw-medium mb-0"><strong>1,248 task scans completed.</strong> Used across warehousing, logistics, and manufacturing teams.</p>
          </div> -->
        </div>
        <div class="col-lg-6 hero-image-col">
          <div class="d-flex justify-content-center mb-3">
              <div class="industry-selector">
                <div class="industry-tab active" onclick="changeIndustry('Warehouse', this)">Warehouse</div>
                <div class="industry-tab" onclick="changeIndustry('Logistics', this)">Logistics</div>
                <div class="industry-tab" onclick="changeIndustry('Manufacturing', this)">Manufacturing</div>
                <div class="industry-tab" onclick="changeIndustry('Healthcare', this)">Healthcare</div>
                <div class="industry-tab" onclick="changeIndustry('Construction', this)">Construction</div>
              </div>
          </div>

          <!-- Stylized Dashboard Mockup -->
          <div class="mock-ui-frame">
            <div class="mock-ui-header">
              <div class="mock-ui-dot bg-danger"></div>
              <div class="mock-ui-dot bg-warning"></div>
              <div class="mock-ui-dot bg-success"></div>
            </div>
            <div class="mock-ui-body py-4 px-4">
              <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2 fw-bold">
                  Potential reduction in high risk exposure: 32%
                </span>
                <div class="form-check form-switch m-0 border bg-white rounded-pill px-3 py-1 shadow-sm d-flex align-items-center gap-2 ps-5">
                  <input class="form-check-input ms-n4" type="checkbox" role="switch" id="beforeAfterToggle">
                  <label class="form-check-label small fw-bold mt-1" style="cursor:pointer;" for="beforeAfterToggle">Compare Before & After</label>
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-sm-6">
                  <div class="p-3 bg-white rounded-4 shadow-sm h-100 border">
                    <p class="small text-muted mb-2 fw-bold text-uppercase">Body Area Risk</p>
                    <div class="d-flex flex-column gap-2 mt-2">
                        <div class="d-flex justify-content-between align-items-center small"><span class="fw-medium">Lower Back</span> <span class="badge bg-danger rounded-pill px-2">High</span></div>
                        <div class="d-flex justify-content-between align-items-center small"><span class="fw-medium">Shoulder</span> <span class="badge bg-warning text-dark rounded-pill px-2">Med</span></div>
                        <div class="d-flex justify-content-between align-items-center small"><span class="fw-medium">Knee</span> <span class="badge bg-success rounded-pill px-2">Low</span></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="p-3 bg-white rounded-4 shadow-sm border border-primary border-opacity-50 h-100 position-relative overflow-hidden">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-primary bg-opacity-10"></div>
                    <div class="position-relative z-1">
                      <p class="small text-primary mb-1 fw-bold text-uppercase"><i class="bi bi-lightning-charge-fill text-warning"></i> Priority Action</p>
                      <h6 class="fw-bold mb-2 lh-sm text-dark" id="mockup-action-title">Reduce trunk flexion by raising pallet height</h6>
                      <div class="d-inline-block bg-white rounded-pill px-2 py-1 small text-success fw-bold border border-success border-opacity-25 shadow-sm" id="mockup-action-desc"><i class="bi bi-arrow-down"></i> -3.2 Score Impact</div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="p-3 bg-white rounded-4 shadow-sm mb-0 position-relative border">
                <h6 class="fw-bold mb-3" id="mockup-task-title">Recent Analysis: Warehouse Lifting</h6>
                <div class="d-flex align-items-center gap-3">
                  <div class="bg-light rounded-3 p-2 position-relative overflow-hidden" style="width: 120px; height: 90px; background: url('https://images.unsplash.com/photo-1587293852726-00624066f76c?w=200&q=80') center/cover;" id="mockup-image">
                     <!-- Pose Overlay: Straight standing posture -->
                     <svg class="pose-overlay-svg" viewBox="0 0 120 90" fill="none" xmlns="http://www.w3.org/2000/svg">
                       <!-- Skeleton lines -->
                       <line x1="60" y1="18" x2="60" y2="48" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/><!-- spine -->
                       <line x1="60" y1="22" x2="45" y2="35" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/><!-- L-upper arm -->
                       <line x1="45" y1="35" x2="40" y2="50" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/><!-- L-lower arm -->
                       <line x1="60" y1="22" x2="75" y2="35" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/><!-- R-upper arm -->
                       <line x1="75" y1="35" x2="80" y2="50" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/><!-- R-lower arm -->
                       <line x1="60" y1="48" x2="50" y2="65" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/><!-- L-upper leg -->
                       <line x1="50" y1="65" x2="45" y2="82" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/><!-- L-lower leg -->
                       <line x1="60" y1="48" x2="70" y2="65" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/><!-- R-upper leg -->
                       <line x1="70" y1="65" x2="75" y2="82" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/><!-- R-lower leg -->
                       <!-- Joint dots -->
                       <circle cx="60" cy="12" r="5" fill="#10b981" opacity="0.9"/><!-- head -->
                       <circle cx="60" cy="22" r="3.5" fill="#f59e0b"/><!-- shoulder (amber) -->
                       <circle cx="60" cy="48" r="3.5" fill="#ef4444"/><!-- hip -->
                       <circle cx="50" cy="65" r="3.5" fill="#10b981"/><!-- L-knee (green) -->
                       <circle cx="70" cy="65" r="3.5" fill="#10b981"/><!-- R-knee (green) -->
                     </svg>
                     <div class="w-100 h-100 d-flex align-items-center justify-content-center position-relative z-1">
                        <i class="bi bi-play-circle-fill text-white fs-4 opacity-75 shadow-sm rounded-circle"></i>
                     </div>
                  </div>
                  <div>
                    <h2 class="mb-0 text-danger fw-black" style="font-weight: 800; letter-spacing: -1px;"><span id="mockup-score">7.8</span> <span class="badge bg-danger fs-6 align-middle ms-1 rounded-pill fw-bold">High Risk</span></h2>
                    <p class="small text-muted mb-0 fw-medium" id="mockup-insight">Trunk flexion > 60° detected.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- How it Works -->
  <section id="how-it-works" class="py-5">
    <div class="container py-5">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0 pe-lg-5">
          <h2 class="fw-bold mb-4" style="font-family:'Outfit',sans-serif;font-size:3rem; line-height: 1.1; letter-spacing: -1px;">See risk early and act faster in 3 steps</h2>
          <p class="text-muted fs-5 mb-3">Capture real work, detect ergonomic risk early, and get clear actions your team can use to prevent strain.</p>
          <p class="fw-bold text-primary mb-5"><i class="bi bi-clock-history"></i> From upload to risk report in minutes</p>

          <div class="d-flex mb-4">
            <div class="me-4"><div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-4 shadow" style="width:50px;height:50px;">1</div></div>
            <div>
              <h5 class="fw-bold">Capture the task</h5>
              <p class="text-muted">Record a real job task on any smartphone and upload it securely to WorkEddy.</p>
            </div>
          </div>

          <div class="d-flex mb-4">
            <div class="me-4"><div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-4 shadow" style="width:50px;height:50px;">2</div></div>
            <div>
              <h5 class="fw-bold">Detect posture risk</h5>
              <p class="text-muted">WorkEddy analyzes movement, body position, and strain exposure using trusted ergonomic methods such as REBA, RULA, and NIOSH.</p>
            </div>
          </div>

          <div class="d-flex mb-4">
            <div class="me-4"><div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-4 shadow" style="width:50px;height:50px;">3</div></div>
            <div>
              <h5 class="fw-bold">Fix what needs attention first</h5>
              <p class="text-muted">Get prioritized interventions, export reports, and compare tasks over time to see whether redesign efforts are reducing risk.</p>
            </div>
          </div>

          <div class="mt-4 pt-4 border-top">
             <p class="small text-muted mb-0 fw-medium d-flex align-items-center"><i class="bi bi-shield-check text-success me-2 fs-5"></i> Secure upload. Trusted ergonomic methods. Action ready outputs.</p>
          </div>
        </div>

        <div class="col-lg-6">
          <!-- Mock Product Proof Visual -->
          <div class="bg-white rounded-4 shadow-lg border p-4 position-relative mx-auto ms-lg-auto me-lg-0" style="max-width: 480px;">
             <!-- Top header -->
             <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0">Analysis Complete</h6>
                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1 fw-bold"><i class="bi bi-exclamation-triangle-fill"></i> 8.5 High Risk</span>
             </div>

             <!-- Video Frame with Pose -->
             <div class="rounded-4 position-relative overflow-hidden mb-4 border" style="height: 240px; background: url('https://images.unsplash.com/photo-1587293852726-00624066f76c?w=600&q=80') center/cover;">
                 <svg viewBox="0 0 120 90" fill="none" xmlns="http://www.w3.org/2000/svg" style="position: absolute; width:100%; height:100%; top:0; left:0;">
                   <!-- Straight standing posture -->
                   <line x1="60" y1="18" x2="60" y2="48" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/>
                   <line x1="60" y1="22" x2="45" y2="35" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/>
                   <line x1="45" y1="35" x2="40" y2="50" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/>
                   <line x1="60" y1="22" x2="75" y2="35" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/>
                   <line x1="75" y1="35" x2="80" y2="50" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/>
                   <line x1="60" y1="48" x2="50" y2="65" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/>
                   <line x1="50" y1="65" x2="45" y2="82" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/>
                   <line x1="60" y1="48" x2="70" y2="65" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/>
                   <line x1="70" y1="65" x2="75" y2="82" stroke="#10b981" stroke-width="2.5" stroke-linecap="round"/>
                   <circle cx="60" cy="12" r="5" fill="#10b981" opacity="0.9"/>
                   <circle cx="60" cy="22" r="3.5" fill="#f59e0b"/>
                   <circle cx="60" cy="48" r="3.5" fill="#ef4444"/>
                   <circle cx="50" cy="65" r="3.5" fill="#10b981"/>
                   <circle cx="70" cy="65" r="3.5" fill="#10b981"/>
                 </svg>
             </div>

             <!-- Body Region Map/Heatmap -->
             <div class="row g-3 mb-4">
                <div class="col-6">
                   <div class="p-3 bg-light rounded-3 border">
                     <div class="d-flex justify-content-between small mb-2 fw-bold"><span class="text-dark">Lower Back</span> <span class="text-danger">High Risk</span></div>
                     <div class="progress shadow-sm" style="height: 6px;"><div class="progress-bar bg-danger rounded-pill" style="width: 85%"></div></div>
                   </div>
                </div>
                <div class="col-6">
                   <div class="p-3 bg-light rounded-3 border">
                     <div class="d-flex justify-content-between small mb-2 fw-bold"><span class="text-dark">Shoulder</span> <span class="text-warning text-dark">Medium</span></div>
                     <div class="progress shadow-sm" style="height: 6px;"><div class="progress-bar bg-warning rounded-pill" style="width: 55%"></div></div>
                   </div>
                </div>
             </div>

             <!-- Recommended Action -->
             <div class="p-3 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-3 d-flex align-items-center gap-3">
                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:40px;height:40px; font-size: 1.25rem;">
                  <i class="bi bi-lightning-charge-fill text-warning"></i>
                </div>
                <div>
                   <p class="small text-primary mb-1 fw-bold text-uppercase">Priority Action</p>
                   <p class="mb-0 fw-bold lh-sm text-dark small">Reduce trunk flexion by raising pallet height</p>
                </div>
             </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-5 bg-light border-top border-bottom">
    <div class="container py-5">
      <div class="text-center mb-5 max-w-2xl mx-auto">
        <h2 class="fw-bold" style="font-family:'Outfit'">Everything you need to detect risk early and prevent strain</h2>
        <p class="text-muted fs-5">Replace manual guesswork with video based ergonomic analysis, trusted scoring, and action ready insights that help teams reduce musculoskeletal risk.</p>
      </div>

      <div class="row g-4">
        <!-- Card 1: Capture -->
        <div class="col-md-6 col-lg-3">
          <div class="surface-card feature-card p-4 rounded-4 h-100 d-flex flex-column">
            <!-- Visual Proof: mini pose overlay -->
            <div class="bg-white rounded-3 p-3 mb-4 d-flex align-items-center justify-content-center position-relative overflow-hidden" style="height: 140px; border: 1px solid rgba(0,0,0,0.05); background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);">
              <svg viewBox="0 0 100 100" class="w-100 h-100 opacity-75">
                <line x1="50" y1="20" x2="50" y2="50" stroke="#7c3aed" stroke-width="4" stroke-linecap="round"/>
                <line x1="50" y1="25" x2="35" y2="40" stroke="#7c3aed" stroke-width="4" stroke-linecap="round"/>
                <line x1="50" y1="25" x2="65" y2="40" stroke="#7c3aed" stroke-width="4" stroke-linecap="round"/>
                <line x1="50" y1="50" x2="40" y2="75" stroke="#7c3aed" stroke-width="4" stroke-linecap="round"/>
                <line x1="50" y1="50" x2="60" y2="75" stroke="#7c3aed" stroke-width="4" stroke-linecap="round"/>
                <circle cx="50" cy="12" r="7" fill="#7c3aed"/>
                <circle cx="50" cy="45" r="5" fill="#ef4444"/> <!-- hotspot -->
                <circle cx="40" cy="75" r="4" fill="#f59e0b"/> <!-- knee hotspot -->

                <!-- scan line effect -->
                <line x1="20" y1="35" x2="80" y2="35" stroke="#10b981" stroke-width="1.5" stroke-dasharray="2,2"/>
              </svg>
            </div>
            <h5 class="fw-bold mb-3">See risk from real task video</h5>
            <p class="text-muted small mb-0 mt-auto">Upload a task video and let WorkEddy detect posture risk, joint movement, and strain exposure in minutes.</p>
          </div>
        </div>

        <!-- Card 2: Score -->
        <div class="col-md-6 col-lg-3">
          <div class="surface-card feature-card p-4 rounded-4 h-100 d-flex flex-column">
            <!-- Visual Proof: tiny REBA/RULA score -->
            <div class="bg-white rounded-3 p-3 mb-4 d-flex flex-column align-items-center justify-content-center gap-3" style="height: 140px; border: 1px solid rgba(0,0,0,0.05); background: linear-gradient(180deg, #fff7ed 0%, #fff 100%);">
              <div class="d-flex w-100 justify-content-between align-items-center px-1 border-bottom pb-2">
                <span class="fw-bold text-muted small"><i class="bi bi-file-earmark-bar-graph me-1"></i>REBA</span>
                <span class="badge bg-danger rounded-pill shadow-sm">8.5 High</span>
              </div>
              <div class="d-flex w-100 justify-content-between align-items-center px-1">
                <span class="fw-bold text-muted small"><i class="bi bi-file-earmark-bar-graph me-1"></i>RULA</span>
                <span class="badge bg-warning text-dark rounded-pill shadow-sm">6.0 Med</span>
              </div>
            </div>
      