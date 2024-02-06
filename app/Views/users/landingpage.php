<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive bootstrap landing template">
    <meta name="author" content="Themesdesign">

    <link rel="shortcut icon" href="images/favicon.ico">

    <title>Slima | Responsive Bootstrap Landing Template</title>


    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('landingpage/'); ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- tiny slider -->
    <link href="<?= base_url('landingpage/'); ?>css/tiny-slider.css" rel="stylesheet">
    <link rel="stylesheet" href="css/swiper.min.css" type="text/css" />


    <!-- Materialdesign icons css -->
    <link href="<?= base_url('landingpage/'); ?>css/materialdesignicons.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('landingpage/'); ?>css/style.css" rel="stylesheet">

</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-navlist" data-bs-offset="71">
    <?php 
        $identityModel = new \App\Models\IdentityModel();
    ?>

    <!--Navbar Start-->
    <nav class="navbar navbar-expand-lg fixed-top sticky" id="navbar">
        <div class="container-fluid custom-container">
            <!-- <a class="navbar-brand logo text-uppercase" href="index.html">
                <img src="<?= base_url('landingpage/'); ?>images/logo-dark.png" class="logo-light" alt="" height="32">
                <img src="<?= base_url('landingpage/'); ?>images/logo-light.png" class="logo-dark" alt="" height="28">
            </a> -->
            <h2 class="navbar-brand logo text-uppercase">
                PoundWithRangers
            </h2>


            <button class="navbar-toggler me-3 order-2 ms-4" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mx-auto navbar-center">
                    <li class="nav-item">
                        <a href="#home" class="nav-link ">Home</a>
                    </li>
                    <li class="nav-item dropdown dropdown-hover">
                        <a href="#service" class="nav-link ">Service</a>
                    </li>
                </ul>
                <!--end navbar-nav-->
            </div>

            <!--end header-menu-->
        </div>
        <!--end container-->
    </nav>
    <!-- Navbar End -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sign up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation">
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">First name <span
                                    class="text-primary">*</span></label>
                            <input type="text" class="form-control" id="validationCustom01" value="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom02" class="form-label">Email <span
                                    class="text-primary">*</span></label>
                            <input type="email" class="form-control" id="validationCustom02" value="" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom03" class="form-label">Subject <span
                                    class="text-primary">*</span></label>
                            <input type="text" class="form-control" id="validationCustom03" required>
                            <div class="invalid-feedback">
                                Please provide a valid city.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom05" class="form-label">Password <span
                                    class="text-primary">*</span></label>
                            <input type="password" class="form-control" id="validationCustom05" required>
                            <div class="invalid-feedback">
                                Please provide a valid zip.
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="validationTextarea" class="form-label">Textarea<span
                                    class="text-primary">*</span></label>
                            <textarea class="form-control" id="validationTextarea" required></textarea>
                            <div class="invalid-feedback">
                                You must agree before submitting.
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- end modal -->


    <!-- start home section -->
    <section class="home" id="home" style="padding-bottom: 50px !important;">
        <div class="container" id="ani-round">
            <div class="home-content">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 class="title mt-5 mt-lg-0">
                            <?= $identityModel->getEmailConfig('title_page')['value'] ?? "Gabung Kelas PoundFit Sekarang!" ?>
                        </h2>
                        <p class="f-16 my-4 text-muted">
                            <?= $identityModel->getEmailConfig('desc_page')['value'] ?? 
                        "Nikmati pengalaman kebugaran yang unik dan penuh semangat.
                        PoundFit membawa Anda melalui latihan ritmis yang menyenangkan dan efektif, didukung oleh
                        komunitas yang energetik.
                        Daftar hari ini dan rasakan perbedaannya!" ?>
                        </p>
                        <button class="btn btn-primary" id="joinNowButton">
                            <i class="mdi mdi-pencil f-20 align-middle me-2"></i> DAFTAR DISINI !
                        </button>

                    </div>

                    <div class="col-lg-6 mt-5">
                        <div class="animation-image" id="home-animation">
                            <div class="main-image mt-5 mt-lg-0 ms-lg-5 position-relative">
                                <?php $images = $identityModel->getEmailConfig('img_page')['value'] 
                                ? base_url('uploads/'). $identityModel->getEmailConfig('img_page')['value']
                                : base_url('landingpage/')."images/home/poundfit.png" ?>

                                <img src="<?= $images ?>" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- end section -->

    <!-- start service -->
    <section class="section bg-light" id="service" style="padding-top: 50px !important;">
        <div class="container">
            <div class="row justify-content-center mb-4 pb-2">
                <div class="col-lg-6">
                    <div class="heading text-center">
                        <h6 class="text-muted f-16 fw-normal">Jelajahi Energi PoundFit</h6>
                        <h2 class="mb-3">Mulai <span class="text-primary fw-normal"> perjalanan kebugaran </span> Anda
                            dengan
                            <br> kelas PoundFit yang menakjubkan.
                        </h2>
                        <p class="text-muted para-p mx-auto mb-0">Bergabunglah dengan kami untuk pengalaman latihan yang
                            unik dan penuh energi, dirancang untuk semua tingkat kebugaran.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 mt-4 pt-2">
                    <div class="service-box text-center text-lg-start">
                        <div class="service-image">
                            <?php $images1 = $identityModel->getEmailConfig('image1')['value'] 
                                ? base_url('uploads/'). $identityModel->getEmailConfig('image1')['value']
                                : base_url('landingpage/')."images/service/img-1.png" ?>
                            
                            <img src="<?= $images1; ?>" alt="img-fluid">
                        </div>
                        <h5 class="fw-bold mt-4 mb-3"><?= $identityModel->getEmailConfig('desc_img_1')['description'] ?></h5>
                        <p><?= $identityModel->getEmailConfig('desc_img_1')['value'] ?></p>
                        <div class="button-link mt-2">
                            <a href="" class="f-14 fw-bold">Gabung Sekarang <i
                                    class="mdi mdi-arrow-right align-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 pt-2">
                    <div class="service-box text-center text-lg-start">
                        <div class="service-image">
                        <?php $images2 = $identityModel->getEmailConfig('image2')['value'] 
                                ? base_url('uploads/'). $identityModel->getEmailConfig('image2')['value']
                                : base_url('landingpage/')."images/service/img-2.png" ?>
                            
                            <img src="<?= $images2; ?>" alt="img-fluid">
                        </div>
                        <h5 class="fw-bold mt-4 mb-3"><?= $identityModel->getEmailConfig('desc_img_2')['description'] ?></h5>
                        <p><?= $identityModel->getEmailConfig('desc_img_2')['value'] ?></p>
                        <div class="button-link mt-2">
                            <a href="" class="f-14 fw-bold">Pelajari Lebih Lanjut <i
                                    class="mdi mdi-arrow-right align-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 pt-2">
                    <div class="service-box text-center text-lg-start">
                        <div class="service-image">
                            <?php $images3 = $identityModel->getEmailConfig('image3')['value'] 
                                ? base_url('uploads/'). $identityModel->getEmailConfig('image3')['value']
                                : base_url('landingpage/')."images/service/img-3.png" ?>
                            
                            <img src="<?= $images3; ?>" alt="img-fluid">
                        </div>
                        <h5 class="fw-bold mt-4 mb-3"><?= $identityModel->getEmailConfig('desc_img_3')['description'] ?></h5>
                        <p><?= $identityModel->getEmailConfig('desc_img_3')['value'] ?></p>
                        <div class="button-link mt-2">
                            <a href="" class="f-14 fw-bold">Daftar Sekarang <i
                                    class="mdi mdi-arrow-right align-middle"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end service -->

    <!-- start footer -->
    <section class="footer py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="address-content fw-bold">
                        <h5 class="text-black">Address</h5>
                        <p class="mt-5  f-14 "><?= $identityModel->getEmailConfig('alamat')['value'] ?></p>
                        <p class="mt-3 f-14 "><?= $identityModel->getEmailConfig('phone_pribadi')['value'] ?></p>
                        <a href="" class=" f-14"><?= $identityModel->getEmailConfig('email')['value'] ?></a>
                    </div>
                    <div class="social-icon d-flex mt-4 mb-4 mb-lg-0">
                        <div class="facebook">
                            <a href=""><i class="mdi mdi-facebook-box f-30"></i></a>
                        </div>
                        <div class="twitter ms-4">
                            <a href=""><i class="mdi mdi-twitter f-30"></i></a>
                        </div>
                        <div class="twitter ms-4">
                            <a href=""><i class="mdi mdi-instagram f-30"></i></a>
                        </div>
                        <div class="twitter ms-4">
                            <a href=""><i class="mdi mdi-linkedin-box f-30"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-black">Explore</h5>
                    <ul class="menu list-unstyled mt-5">
                        <li class="menu-item"><a href="">Start here</a></li>
                        <li class="menu-item"><a href="">Services</a></li>
                        <li class="menu-item"><a href="">Features</a></li>
                        <li class="menu-item"><a href="">Client</a></li>
                        <li class="menu-item"><a href="">Pricing</a></li>
                        <li class="menu-item"><a href="">support center</a></li>
                        <li class="menu-item"><a href="">Blogs</a></li>
                        <li class="menu-item"><a href="">Newsletters</a></li>
                    </ul>

                </div>
                <div class="col-lg-2">
                    <h5 class="text-black">Explore</h5>
                    <ul class="menu mt-5 list-unstyled d-block">
                        <li class="info-item"><a href="">Membership</a></li>
                        <li class="info-item"><a href="">Purchase guide</a></li>
                        <li class="info-item"><a href="">Privacy policy</a></li>
                        <li class="info-item"><a href="">Terms of service</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- end footer -->

    <div class="bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="copy-right mb-5 text-center text-muted">
                        <script>
                        document.write(new Date().getFullYear())
                        </script> <span class="fw-bold">PoundWithRangers</span> .
                        PoundWithRangers with <i class="mdi mdi-heart text-danger"></i> by <a
                            href="https://themeforest.net/search/themesdesign" target="_blank" class="text-reset"><span
                                class="fw-bold">PoundWithRangers</span></a>.
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- bootstrap -->
    <script src="<?= base_url('landingpage/js/bootstrap.bundle.min.js'); ?>"></script>

    <script src="<?= base_url('landingpage/'); ?>js/tiny-slider.js"></script>
    <script src="<?= base_url('landingpage/'); ?>js/swiper.min.js"></script>

    <!-- counter -->
    <script src="<?= base_url('landingpage/'); ?>js/counter.init.js"></script>

    <!-- Custom -->
    <script src="<?= base_url('landingpage/'); ?>js/app.js"></script>

    <script>
    (function() {
        // Add event listener
        document.addEventListener("mousemove", parallax);
        const elem = document.querySelector("#home-animation");
        // Magic happens here
        function parallax(e) {
            let _w = window.innerWidth / 2;
            let _h = window.innerHeight / 2;
            let _mouseX = e.clientX;
            let _mouseY = e.clientY;
            let _depth1 = `${50 - (_mouseX - _w) * 0.01}% ${50 - (_mouseY - _h) * 0.01}%`;
            let _depth2 = `${50 - (_mouseX - _w) * 0.02}% ${50 - (_mouseY - _h) * 0.02}%`;
            let _depth3 = `${50 - (_mouseX - _w) * 0.06}% ${50 - (_mouseY - _h) * 0.06}%`;
            let x = `${_depth3}, ${_depth2}, ${_depth1}`;
            elem.style.backgroundPosition = x;
        }

    })();
    </script>
    <script>
    (function() {
        // Add event listener
        document.addEventListener("mousemove", parallax);
        const elem = document.querySelector("#ani-round");
        // Magic happens here
        function parallax(e) {
            let _w = window.innerWidth / 2;
            let _h = window.innerHeight / 2;
            let _mouseX = e.clientX;
            let _mouseY = e.clientY;
            let _depth1 = `${50 - (_mouseX - _w) * 0.01}% ${50 - (_mouseY - _h) * 0.01}%`;
            let _depth2 = `${50 - (_mouseX - _w) * 0.02}% ${50 - (_mouseY - _h) * 0.02}%`;
            let _depth3 = `${50 - (_mouseX - _w) * 0.06}% ${50 - (_mouseY - _h) * 0.06}%`;
            let x = `${_depth3}, ${_depth2}, ${_depth1}`;
            elem.style.backgroundPosition = x;
        }

    })();
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#joinNowButton').click(function() {
            window.location.href = '/form?id=<?= $code ?>';
        });
    });
    </script>


</body>

</html>