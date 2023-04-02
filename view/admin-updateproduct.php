<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Update Product</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/webAssignment/public/css/aboutus.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>

<body>
    <!-- Header -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-brand-color justify-content-between">
        <div class="container-fluid">

            <div class="d-flex">
                <button class="btn btn-outline-light text-dark m-1"><i class="fas fa-bars"
                        style="font-size: 23px;"></i></button>
                <span>
                    <image src="/webAssignment/public/images/Logo.png" style="width:30%; padding-top:1%">
                </span>
            </div>

            <div class="d-flex">
                <button class="btn btn-outline-light text-dark m-1"><i class="fas fa-user"
                        style="font-size: 23px;"></i></button>
            </div>
        </div>

        </div>
    </nav>
    <!-- Header -->
    <div style="margin: 5%"></div>

    <h2>PRODUCT UPDATE</h2>

    <form action="/action_page.php" style="padding: 0 20% 0 20%;">
        <div class="mb-3 mt-3">
            <label for="productTitle" style="font-weight: bold;">Product Title</label>
            <input type="text" class="form-control" id="productTitle" placeholder="Enter product name"
                name="productTitle" style="border-radius: 20px;">
        </div>

        <div class="idandprice row">
            <div class="mb-3 col-sm-4">
                <label for="productID" style="font-weight: bold;">Product ID</label>
                <input type="text" class="form-control" id="productID" placeholder="Enter product ID" name="productID"
                    style="border-radius: 20px; width: 100%;">
            </div>
            <div class="mb-3 col-sm-3"></div>
            <div class="mb-3 col-sm-4">
                <label for="price" style="font-weight: bold;">Price $ </label>
                <input type="text" class="form-control" id="price" placeholder="Enter price" name="price"
                    style="border-radius: 20px; width: 100%;">
            </div>
        </div>

        <div class="date row">
            <div class="mb-3 col-sm-4">
                <label for="manufacturingDate" style="font-weight: bold;">Manufacturing Date </label>
                <input type="date" id="manufacturingDate" name="manufacturingDate" class="form-control"
                    style="border-radius: 20px; width: 100%">
            </div>
            <div class="mb-3 col-sm-3"></div>
            <div class="mb-3 col-sm-4">
                <label for="exipiringDate" style="font-weight: bold;">Exipiring Date </label>
                <input type="date" id="exipiringDate" name="exipiringDate" class="form-control"
                    style="border-radius: 20px;width: 100%">
            </div>
        </div>

        <br>
        <label for="productImage" style="font-weight: bold; margin-right: 2%;">Product Image </label>
        <input type="file" id="productImage" name="productImage" multiple>
        <br>
        <br>
        <div class="mb-3">
            <label for="stock" style="font-weight: bold;">Stock</label>
            <input type="text" class="form-control" id="stock" placeholder="Enter stock" name="stock"
                style="border-radius: 20px; width: 30%;">
        </div>

        <label for="specification" style="font-weight: bold;">Specification</label>
        <div class=" mb-3" id="specification">
            <label for="color">Color:</label>
            <input type="text" class="form-control" id="color" placeholder="Enter color (separated by ',')" name="color"
                style="border-radius: 20px;">
            <label for="size">Size:</label>
            <input type="text" class="form-control" id="size" placeholder="Enter size (separated by ',')" name="size"
                style="border-radius: 20px;">
        </div>

        <div class="mb-3 mt-3">
            <label for="productDescription" style="font-weight: bold;">Product Description</label>
            <textarea rows="8" class="form-control" id="productDescription" name="productDescription"
                style="border-radius: 20px;">Enter description...</textarea>
        </div>

        <div class="mb-3 mt-3">
            <label for="ingredients" style="font-weight: bold;">Ingredients</label>
            <textarea rows="8" class="form-control" id="ingredients" name="ingredients"
                style="border-radius: 20px;">Enter ingredients...</textarea>
        </div>
        <br>
        <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-outline-dark rounded-pill mx-1">UPDATE</button>
        </div>
        <br>
    </form>

    <!-- Footer -->
    <footer class=" text-center text-white bg-footer-color">
        <!-- Grid container -->
        <div class="container p-4">
            <!-- Section: Social media -->
            <section class="mb-4">
                <!-- Facebook -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fab fa-facebook-f"></i></a>

                <!-- Twitter -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fab fa-twitter"></i></a>

                <!-- Google -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fab fa-google"></i></a>

                <!-- Instagram -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fab fa-instagram"></i></a>

                <!-- Linkedin -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fab fa-linkedin-in"></i></a>

                <!-- Github -->
                <a class="btn btn-outline-light btn-floating m-1" href="#!" role="button"><i
                        class="fab fa-github"></i></a>
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
                                <input type="email" id="form5Example21" class="form-control"
                                    placeholder="Enter your email address" />
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