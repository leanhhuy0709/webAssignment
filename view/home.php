<!DOCTYPE html>
<html lang = "en">

<head>
  <title>Olivia</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/webAssignment/public/css/home.css">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
  <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-brand-color justify-content-between">
    <div class="container-fluid">
      
      <a class="navbar-brand">
        <button class="btn btn-outline-dark m-1"><i class="fas fa-bars" style="font-size: 23px;"></i></button>
        <i class="fas fa-cat" style="margin-right: 10px"></i>OLIVIA
      </a>

      <form class="d-flex">
        <input class="form-control me-2 rounded" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success mx-2" type="submit">Search</button>
      </form>

      <div class="d-flex">
        <button class="btn btn-outline-dark m-1"><i class="fas fa-user" style="font-size: 23px;"></i></button>
        <button class="btn btn-outline-dark m-1"><i class="fas fa-shopping-cart" style="font-size: 23px;"></i></div></button>
      </div>
        
    </div>
  </nav>

  <div style="margin: 56px"></div>

  <div id="home-slideshow" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-100" src="/webAssignment/public/images/slideshow1.jpg" alt="First slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="/webAssignment/public/images/slideshow2.jpg" alt="Second slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="/webAssignment/public/images/slideshow3.jpg" alt="Third slide">
      </div>
    </div>
    <a class="carousel-control-prev" href="#home-slideshow" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#home-slideshow" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
    <p class="carousel-caption">
      <button class="btn btn-primary">Show now</button>
    </p>
  </div>


  <div>
    <h2 class="m-2">Best-seller products</h2>
    <div id="bsp" class="text-center bs-list">
    </div>
  </div>


  <div class="d-flex w-100" style="margin: auto;">
    <img class="p-5" src= "/webAssignment/public/images/adproduct1.png" style="width: 50%">
    <img class="p-5" src= "/webAssignment/public/images/adproduct2.png" style="width: 50%">
  </div>



  <div class="pt-3">
    <!-- Footer -->
<footer class="text-center text-white bg-footer-color">
  <!-- Grid container -->
  <div class="container p-4">
    <!-- Section: Social media -->
    <section class="mb-4">
      <!-- Facebook -->
      <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-facebook-f"></i
      ></a>

      <!-- Twitter -->
      <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-twitter"></i
      ></a>

      <!-- Google -->
      <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-google"></i
      ></a>

      <!-- Instagram -->
      <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-instagram"></i
      ></a>

      <!-- Linkedin -->
      <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-linkedin-in"></i
      ></a>

      <!-- Github -->
      <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"
        ><i class="fab fa-github"></i
      ></a>
    </section>
    <!-- Section: Social media -->

    <!-- Section: Form -->
    <section class="">
      <form action="">
        <!--Grid row-->
        <div class="row d-flex justify-content-center">
          <!--Grid column-->
          <div class="col-auto">
            <p class="pt-2">
              <strong>Subscribe for more product information and beauty tips!</strong>
            </p>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-md-5 col-12">
            <!-- Email input -->
            <div class="form-outline form-white mb-4">
              <input type="email" id="form5Example21" class="form-control" placeholder="Enter your email address" />
            </div>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-auto">
            <!-- Submit button -->
            <button type="submit" class="btn btn-outline-light mb-4">
              Subscribe
            </button>
          </div>
          <!--Grid column-->
        </div>
        <!--Grid row-->
      </form>
    </section>
    <!-- Section: Form -->

    <!-- Section: Links -->
    <section class="">
      <!--Grid row-->
      <div class="row">
        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">OLIVIA</h5>

          <ul class="list-unstyled mb-0">
            <li>
              <a href="#!" class="text-white no-decoration">Our story</a>
            </li>
            <li>
              <a href="#!" class="text-white no-decoration">Location</a>
            </li>
            <li>
              <a href="#!" class="text-white no-decoration">Careers</a>
            </li>
            <li>
              <a href="#!" class="text-white no-decoration">Blogs</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">Category</h5>

          <ul class="list-unstyled mb-0">
            <li>
              <a href="#!" class="text-white no-decoration">Make-up</a>
            </li>
            <li>
              <a href="#!" class="text-white no-decoration">Hair Care</a>
            </li>
            <li>
              <a href="#!" class="text-white no-decoration">Skin Care</a>
            </li>
            <li>
              <a href="#!" class="text-white no-decoration">Body Care</a>
            </li>
          </ul>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase">HELP</h5>

          <ul class="list-unstyled mb-0">
            <li>
              <a href="#!" class="text-white no-decoration">Track My Orders</a>
            </li>
            <li>
              <a href="#!" class="text-white no-decoration">Payment</a>
            </li>
            <li>
              <a href="#!" class="text-white no-decoration">Delivery</a>
            </li>
            <li>
              <a href="#!" class="text-white no-decoration">Returns Policy</a>
            </li>
          </ul>
        </div>
      </div>
      <!--Grid row-->
    </section>
    <!-- Section: Links -->
  </div>
  <!-- Grid container -->
</footer>
<!-- Footer -->
  </div>


  <script src="/webAssignment/public/js/home.js"></script>
</body>

</html>

