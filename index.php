<?php
session_start();
include("navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AgriRent - Agriculture Equipment Rental</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <style>
    * { font-family: 'Poppins', sans-serif; }
    body { background: #f8fffe; margin: 0; }

    /* Hero */
    .hero {
      min-height: 92vh;
      background: linear-gradient(135deg, rgba(10,60,10,0.85) 0%, rgba(30,100,30,0.75) 100%),
                  url('images/bg1.webp') center/cover no-repeat;
      display: flex; align-items: center; justify-content: center; text-align: center;
      position: relative; overflow: hidden;
    }
    .hero-content { color: #fff; z-index: 2; }
    .hero-content h1 { font-size: 3.5rem; font-weight: 800; line-height: 1.2; margin-bottom: 20px; }
    .hero-content h1 span { color: #a8f0a8; }
    .hero-content p { font-size: 1.2rem; opacity: 0.9; margin-bottom: 35px; max-width: 600px; margin-left: auto; margin-right: auto; }
    .btn-hero-primary { background: #4caf50; color: #fff; border: none; padding: 14px 40px; border-radius: 50px; font-size: 1.1rem; font-weight: 600; text-decoration: none; transition: all 0.3s; box-shadow: 0 5px 20px rgba(76,175,80,0.4); }
    .btn-hero-primary:hover { background: #388e3c; transform: translateY(-3px); box-shadow: 0 10px 30px rgba(76,175,80,0.5); color: #fff; }
    .btn-hero-outline { background: transparent; color: #fff; border: 2px solid #fff; padding: 14px 40px; border-radius: 50px; font-size: 1.1rem; font-weight: 600; text-decoration: none; transition: all 0.3s; margin-left: 15px; }
    .btn-hero-outline:hover { background: rgba(255,255,255,0.15); color: #fff; }

    /* Stats bar */
    .stats-bar { background: #1a6b1a; color: #fff; padding: 25px 0; }
    .stat-item { text-align: center; }
    .stat-item h3 { font-size: 2.2rem; font-weight: 800; color: #a8f0a8; margin: 0; }
    .stat-item p { margin: 0; opacity: 0.85; font-size: 0.95rem; }

    /* Section titles */
    .section-title { font-size: 2rem; font-weight: 700; color: #1a6b1a; position: relative; display: inline-block; margin-bottom: 10px; }
    .section-title::after { content: ''; display: block; width: 60px; height: 4px; background: #4caf50; border-radius: 2px; margin: 8px auto 0; }
    .section-subtitle { color: #666; margin-bottom: 50px; }

    /* Feature cards */
    .feature-card { background: #fff; border-radius: 16px; padding: 35px 25px; text-align: center; box-shadow: 0 5px 25px rgba(0,0,0,0.07); transition: all 0.3s; border: 1px solid #e8f5e9; }
    .feature-card:hover { transform: translateY(-8px); box-shadow: 0 15px 40px rgba(76,175,80,0.15); }
    .feature-icon { width: 75px; height: 75px; background: linear-gradient(135deg, #4caf50, #1a6b1a); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
    .feature-icon i { font-size: 2rem; color: #fff; }
    .feature-card h5 { font-weight: 700; color: #1a6b1a; }

    /* Equipment cards */
    .eq-card { border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: all 0.3s; }
    .eq-card:hover { transform: translateY(-6px); box-shadow: 0 15px 40px rgba(0,0,0,0.15); }
    .eq-card img { height: 220px; object-fit: cover; width: 100%; }
    .eq-card .card-body { padding: 20px; }
    .eq-card .badge-green { background: #e8f5e9; color: #1a6b1a; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
    .btn-book { background: linear-gradient(135deg, #4caf50, #1a6b1a); color: #fff; border: none; padding: 10px 25px; border-radius: 25px; font-weight: 600; width: 100%; transition: all 0.3s; }
    .btn-book:hover { opacity: 0.9; transform: scale(1.02); color: #fff; }

    /* Testimonials */
    .testimonial-card { background: #fff; border-radius: 16px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.07); border-left: 4px solid #4caf50; }
    .testimonial-card p { color: #555; font-style: italic; }
    .testimonial-card .author { font-weight: 700; color: #1a6b1a; }
    .stars { color: #f9c74f; }

    /* Steps */
    .step-number { width: 50px; height: 50px; background: linear-gradient(135deg, #4caf50, #1a6b1a); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; font-weight: 800; margin: 0 auto 15px; }

    /* Footer */
    footer { background: #0d3d0d; color: #ccc; padding: 50px 0 20px; }
    footer h5 { color: #a8f0a8; font-weight: 700; margin-bottom: 20px; }
    footer a { color: #aaa; text-decoration: none; display: block; margin-bottom: 8px; transition: color 0.2s; }
    footer a:hover { color: #4caf50; }
    .footer-bottom { border-top: 1px solid #1a5c1a; margin-top: 30px; padding-top: 20px; text-align: center; color: #888; }
    .social-link { display: inline-flex; width: 38px; height: 38px; background: #1a5c1a; border-radius: 50%; align-items: center; justify-content: center; color: #fff; margin-right: 8px; transition: all 0.3s; text-decoration: none; }
    .social-link:hover { background: #4caf50; color: #fff; transform: translateY(-3px); }
  </style>
</head>
<body>

<!-- Hero -->
<section class="hero">
  <div class="hero-content px-3">
    <div class="mb-3"><span style="background:rgba(76,175,80,0.3); color:#a8f0a8; padding:6px 18px; border-radius:20px; font-size:0.9rem;">🌱 India's Trusted Farm Equipment Rental</span></div>
    <h1>Your Farm, Our <span>Machines</span><br>Together We Grow More!</h1>
    <p>Rent premium agriculture equipment at affordable prices. Tractors, harrows, cultivators and more — available near you.</p>
    <a href="user_view_eq.php" class="btn-hero-primary"><i class="fas fa-tractor me-2"></i>Browse Equipment</a>
    <a href="how-to-register.php" class="btn-hero-outline"><i class="fas fa-user-plus me-2"></i>Register Free</a>
  </div>
</section>

<!-- Stats -->
<section class="stats-bar">
  <div class="container">
    <div class="row g-3">
      <div class="col-6 col-md-3"><div class="stat-item"><h3>500+</h3><p>Equipment Listed</p></div></div>
      <div class="col-6 col-md-3"><div class="stat-item"><h3>1200+</h3><p>Happy Farmers</p></div></div>
      <div class="col-6 col-md-3"><div class="stat-item"><h3>50+</h3><p>Equipment Types</p></div></div>
      <div class="col-6 col-md-3"><div class="stat-item"><h3>24/7</h3><p>Support Available</p></div></div>
    </div>
  </div>
</section>

<!-- Why Us -->
<section class="py-5 mt-3">
  <div class="container text-center">
    <h2 class="section-title">Why Choose AgriRent?</h2>
    <p class="section-subtitle">We make equipment rental simple, affordable and reliable</p>
    <div class="row g-4">
      <div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="fas fa-rupee-sign"></i></div><h5>Affordable Rates</h5><p class="text-muted">Rent premium equipment at the lowest prices with flexible booking periods.</p></div></div>
      <div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="fas fa-shield-alt"></i></div><h5>Verified Equipment</h5><p class="text-muted">All listed equipment is verified and maintained to ensure best performance.</p></div></div>
      <div class="col-md-4"><div class="feature-card"><div class="feature-icon"><i class="fas fa-headset"></i></div><h5>24/7 Support</h5><p class="text-muted">Our support team is always available to help you with any queries.</p></div></div>
    </div>
  </div>
</section>

<!-- Featured Equipment -->
<section class="py-5" style="background:#f0faf0;">
  <div class="container text-center">
    <h2 class="section-title">Featured Equipment</h2>
    <p class="section-subtitle">Popular machines available for rent</p>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="eq-card card">
          <img src="images/inst1.webp" alt="Cultivator">
          <div class="card-body">
            <span class="badge-green">Cultivation</span>
            <h5 class="mt-2 fw-700">5 Tine Duck Foot Cultivator</h5>
            <p class="text-muted small">Tractor-operated implement for primary tillage operations and ploughing fields.</p>
            <a href="user_view_eq.php" class="btn btn-book mt-2">Book Now</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="eq-card card">
          <img src="images/inst3.png" alt="Disc Harrow">
          <div class="card-body">
            <span class="badge-green">Soil Prep</span>
            <h5 class="mt-2">Mounted Offset Disc Harrow</h5>
            <p class="text-muted small">Agriculture tool used to prepare soil, break clods and control weeds effectively.</p>
            <a href="user_view_eq.php" class="btn btn-book mt-2">Book Now</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="eq-card card">
          <img src="images/inst2.jfif" alt="Rake">
          <div class="card-body">
            <span class="badge-green">Hand Tools</span>
            <h5 class="mt-2">Agriculture Rake</h5>
            <p class="text-muted small">Garden and farm tool used to gather loose material like leaves, hay and debris.</p>
            <a href="user_view_eq.php" class="btn btn-book mt-2">Book Now</a>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-4"><a href="user_view_eq.php" class="btn-hero-primary" style="display:inline-block; margin-top:10px;"><i class="fas fa-list me-2"></i>View All Equipment</a></div>
  </div>
</section>

<!-- How it works -->
<section class="py-5">
  <div class="container text-center">
    <h2 class="section-title">How It Works</h2>
    <p class="section-subtitle">Rent equipment in 3 simple steps</p>
    <div class="row g-4">
      <div class="col-md-4"><div class="step-number">1</div><h5 class="fw-bold text-success">Register & Login</h5><p class="text-muted">Create your free account in minutes and get instant access.</p></div>
      <div class="col-md-4"><div class="step-number">2</div><h5 class="fw-bold text-success">Choose Equipment</h5><p class="text-muted">Browse our wide range of verified farm equipment and pick what you need.</p></div>
      <div class="col-md-4"><div class="step-number">3</div><h5 class="fw-bold text-success">Book & Use</h5><p class="text-muted">Confirm your booking, pick dates and start farming more efficiently.</p></div>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section class="py-5" style="background:#f0faf0;">
  <div class="container text-center">
    <h2 class="section-title">What Farmers Say</h2>
    <p class="section-subtitle">Real stories from our happy customers</p>
    <div class="row g-4">
      <div class="col-md-4"><div class="testimonial-card"><div class="stars mb-2">★★★★★</div><p>"AgriRent helped me rent a tractor at very affordable rates. Saved a lot of money during harvest season!"</p><div class="author">— Ramesh Kumar, Maharashtra</div></div></div>
      <div class="col-md-4"><div class="testimonial-card"><div class="stars mb-2">★★★★★</div><p>"Excellent service and well-maintained equipment. The booking process was very simple and fast."</p><div class="author">— Sunita Devi, Punjab</div></div></div>
      <div class="col-md-4"><div class="testimonial-card"><div class="stars mb-2">★★★★☆</div><p>"I found exactly the disc harrow I needed. Great platform for small farmers like me."</p><div class="author">— Mahesh Patel, Gujarat</div></div></div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer>
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <h5><i class="fas fa-tractor me-2"></i>AgriRent</h5>
        <p style="color:#aaa;">India's trusted platform for agriculture equipment rental. Empowering farmers with modern machinery.</p>
        <div class="mt-3">
          <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
          <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-link"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
      <div class="col-md-2">
        <h5>Quick Links</h5>
        <a href="index.php">Home</a>
        <a href="user_view_eq.php">Equipment</a>
        <a href="about us.php">About Us</a>
        <a href="contact.php">Contact</a>
      </div>
      <div class="col-md-3">
        <h5>Account</h5>
        <a href="user_login.php">User Login</a>
        <a href="how-to-register.php">Register</a>
        <a href="admin_login.php">Admin Login</a>
        <a href="forget_passoword.php">Forgot Password</a>
      </div>
      <div class="col-md-3">
        <h5>Contact Us</h5>
        <p style="color:#aaa;"><i class="fas fa-map-marker-alt me-2" style="color:#4caf50;"></i>India</p>
        <p style="color:#aaa;"><i class="fas fa-phone me-2" style="color:#4caf50;"></i>+91 98765 43210</p>
        <p style="color:#aaa;"><i class="fas fa-envelope me-2" style="color:#4caf50;"></i>support@agrirent.in</p>
      </div>
    </div>
    <div class="footer-bottom">&copy; 2024 AgriRent. All rights reserved.</div>
  </div>
</footer>

</body>
</html>
