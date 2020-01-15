

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand ml-3" href="index.php?controller=Frontpage&method=index">Herc-Bus</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=Frontpage&method=index">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=Schedule&method=index">Schedule</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=BuyTicket&method?index">Buy a Ticket</a>
      </li>
      <?php if(isset($_SESSION["id"])){ ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <?php print($accountName); ?> </a>
        
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="#">Profile</a>
          <a class="dropdown-item" href="#">Settings</a>
          <a class="dropdown-item" href="index.php?controller=Frontpage&method=logout">Log out</a>
        </div>
      </li>
      <?php } else { ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?controller=Login&method=index">Log in</a>
      </li>
      <?php }; ?>
    </ul>
  </div>
</nav>

<header class="masthead text-white text-center shadow" style="background-image: url('asts/imgs/interior-2.jpg');" data-aos="fade-in">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h1 class="mb-5" style="color: white;" data-aos="fade-down" data-aos-delay="400">Herc-Bus transport</h1>
          
          <a href="index.php?controller=BuyTicket&method?index" data-aos="fade-in" data-aos-delay="700" class="btn btn-outline-light">Buy a ticket</a>
        </div>
      </div>
    </div>
  </header>

  <section class="features-icons text-center">
    <div class="container">
      <div class="row">
        <div class="col-md-4" data-aos="fade-left" data-aos-delay="300">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex mb-3">
              <img src="asts/imgs/sunbed.png" height="98px" width="98px" class="mx-auto d-block">
            </div>
            <h3>Comfort on board</h3>
            <p class="lead mb-0">Our buses are equipped with large and comfortable seats, a toilet, Wi-Fi and power outlets. </p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex mb-3">
              <img src="asts/imgs/fast.png" height="98px" width="98px" class="mx-auto d-block">
            </div>
            <h3>Arrive on time</h3>
            <p class="lead mb-0">We’ll get you there in comfort and on time: 9 out of 10 of our buses arrive punctually.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-right" data-aos-delay="300">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex mb-3">
              <img src="asts/imgs/palm.png" height="98px" width="98px" class="mx-auto d-block">
            </div>
            <h3>Nature-friendly</h3>
            <p class="lead mb-0">Our efficient coaches are proven to have an excellent carbon footprint per driven passenger-kilometer.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="showcase">
    <div class="container-fluid p-0">
      <div class="row no-gutters">

        <div class="col-lg-6 order-lg-2 text-white showcase-img mt-3 shadow" style="background-image: url('asts/imgs/5.jpg');" data-aos="fade-right"></div>
        <div class="col-lg-6 order-lg-1 my-auto showcase-text" data-aos="fade-in">
          <h2>Fully Responsive Design</h2>
          <p class="lead mb-0">When you use a theme created by Start Bootstrap, you know that the theme will look great on any device, whether it's a phone, tablet, or desktop the page will behave responsively!</p>
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-lg-6 text-white showcase-img shadow" style="background-image: url('asts/imgs/interior-1.jpg');" data-aos="fade-left"></div>
        <div class="col-lg-6 my-auto showcase-text" data-aos="fade-in">
          <h2>Arrive</h2>
          <p class="lead mb-0">Newly improved, and full of great utility classes, Bootstrap 4 is leading the way in mobile responsive web development! All of the themes on Start Bootstrap are now using Bootstrap 4!</p>
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-lg-6 order-lg-2 text-white showcase-img mb-3 shadow" style="background-image: url('asts/imgs/7.jpg');" data-aos="fade-right"></div>
        <div class="col-lg-6 order-lg-1 my-auto showcase-text" data-aos="fade-in">
          <h2>Easy to Use &amp; Customize</h2>
          <p class="lead mb-0">Landing Page is just HTML and CSS with a splash of SCSS for users who demand some deeper customization options. Out of the box, just add your content and images, and your new landing page will be ready to go!</p>
        </div>
      </div>
    </div>
  </section>

  <hr class="col-8 my-3">

  <iframe class="mt-3 shadow-sm" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d46428.66645766114!2d17.78622105001283!3d43.33954865797219!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x134b43a43b6340a9%3A0x14f32b2d4e37c5a!2sMostar%2088000!5e0!3m2!1sen!2sba!4v1578316364354!5m2!1sen!2sba" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" data-aos="fade-up"></iframe>

  <footer class="footer" data-aos="fade-in">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          <ul class="list-inline mb-2">
            <li class="list-inline-item">
              <a href="#">About</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Contact</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Terms of Use</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Privacy Policy</a>
            </li>
          </ul>
          <p class="text-muted small mb-4 mb-lg-0">&copy; Herc-Bus <?php print(date("Y")); ?>. All Rights Reserved.</p>
        </div>
        <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
          <ul class="list-inline mb-0">
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fab fa-facebook fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fab fa-twitter-square fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fab fa-instagram fa-2x fa-fw"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>


