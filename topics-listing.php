<!doctype html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Hizmetlerimiz - Nos Studio</title>

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
                        
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/templatemo-topic-listing.css" rel="stylesheet">
<!--

TemplateMo 590 topic listing

https://templatemo.com/tm-590-topic-listing

-->
    </head>
    
    <body class="topics-listing-page" id="top">
        <?php
        session_start();
        ?>
        <main>

            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="index.php">
                        <i class="bi-back"></i>
                        <span>nos studio</span>
                    </a>

                    <div class="d-lg-none ms-auto me-4">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="profile.php" class="navbar-icon bi-person smoothscroll"></a>
                        <?php else: ?>
                            <a href="login.php" class="navbar-icon bi-person smoothscroll"></a>
                        <?php endif; ?>
                    </div>
    
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-lg-5 me-lg-auto">
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.php#section_1">Ana Sayfa</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.php#section_2">Hizmetlerimiz</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.php#section_3">Nasıl Çalışır</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.php#section_4">SSS</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="index.php#section_5">İletişim</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Sayfalar</a>

                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                                    <li><a class="dropdown-item" href="topics-listing.php">Hizmetlerimiz</a></li>
                                    <li><a class="dropdown-item" href="contact.php">İletişim Formu</a></li>
                                </ul>
                            </li>
                            
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <li class="nav-item">
                                        <a class="nav-link click-scroll" href="admin_panel.php">Admin Paneli</a>
                                    </li>
                                <?php endif; ?>
                                <li class="nav-item">
                                    <a class="nav-link click-scroll" href="profile.php">Profilim</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link click-scroll" href="logout.php">Çıkış Yap</a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link click-scroll" href="login.php">Giriş Yap</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link click-scroll" href="register.php">Kayıt Ol</a>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <div class="d-none d-lg-block">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="profile.php" class="navbar-icon bi-person smoothscroll"></a>
                            <?php else: ?>
                                <a href="login.php" class="navbar-icon bi-person smoothscroll"></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </nav>


            <header class="site-header d-flex flex-column justify-content-center align-items-center">
                <div class="container">
                    <div class="row align-items-center">

                        <div class="col-lg-5 col-12">
                            <h1 class="text-white">Hizmetlerimiz</h1>

                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>

                                    <li class="breadcrumb-item active" aria-current="page">Hizmetlerimiz</li>
                                </ol>
                            </nav>
                        </div>

                    </div>
                </div>
            </header>


            <section class="section-padding">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 text-center">
                            <h2 class="mb-4">Popüler Hizmetler</h2>
                        </div>

                        <div class="col-lg-8 col-12 mt-3 mx-auto">
                            <div class="custom-block custom-block-topics-listing bg-white shadow-lg mb-5">
                                <div class="d-flex">
                                    <img src="images/topics/studio-recording.jpg" class="custom-block-image img-fluid" alt="Stüdyo Kayıt">

                                    <div class="custom-block-topics-listing-info d-flex">
                                        <div>
                                            <h5 class="mb-2">Stüdyo Kayıt</h5>

                                            <p class="mb-0">Profesyonel stüdyo ortamında kayıt hizmetleri</p>

                                            <a href="topics-detail.php" class="btn custom-btn mt-3 mt-lg-4">Daha Fazla</a>
                                        </div>

                                        <span class="badge bg-design rounded-pill ms-auto">14</span>
                                    </div>
                                </div>
                            </div>

                            <div class="custom-block custom-block-topics-listing bg-white shadow-lg mb-5">
                                <div class="d-flex">
                                    <img src="images/topics/mixing.jpg" class="custom-block-image img-fluid" alt="Mix">

                                    <div class="custom-block-topics-listing-info d-flex">
                                        <div>
                                            <h5 class="mb-2">Mix</h5>

                                            <p class="mb-0">Profesyonel mix hizmetleri</p>

                                            <a href="topics-detail.php" class="btn custom-btn mt-3 mt-lg-4">Daha Fazla</a>
                                        </div>

                                        <span class="badge bg-advertising rounded-pill ms-auto">30</span>
                                    </div>
                                </div>
                            </div>

                            <div class="custom-block custom-block-topics-listing bg-white shadow-lg mb-5">
                                <div class="d-flex">
                                    <img src="images/topics/mastering.jpg" class="custom-block-image img-fluid" alt="Mastering">

                                    <div class="custom-block-topics-listing-info d-flex">
                                        <div>
                                            <h5 class="mb-2">Mastering</h5>

                                            <p class="mb-0">Profesyonel mastering hizmetleri</p>

                                            <a href="topics-detail.php" class="btn custom-btn mt-3 mt-lg-4">Daha Fazla</a>
                                        </div>

                                        <span class="badge bg-music rounded-pill ms-auto">20</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center mb-0">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">Önceki</span>
                                        </a>
                                    </li>

                                    <li class="page-item active" aria-current="page">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    
                                    <li class="page-item">
                                        <a class="page-link" href="#">3</a>
                                    </li>

                                    <li class="page-item">
                                        <a class="page-link" href="#">4</a>
                                    </li>

                                    <li class="page-item">
                                        <a class="page-link" href="#">5</a>
                                    </li>
                                    
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">Sonraki</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </section>


            <section class="section-padding section-bg">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12">
                            <h2 class="mb-4">Trend Hizmetler</h2>
                        </div>

                        <div class="col-lg-6 col-md-6 col-12 mt-3 mb-4 mb-lg-0">
                            <div class="custom-block bg-white shadow-lg">
                                <a href="topics-detail.php">
                                    <div class="d-flex">
                                        <div>
                                            <h5 class="mb-2">Prodüksiyon</h5>

                                            <p class="mb-0">Müzik prodüksiyon hizmetleri</p>
                                        </div>

                                        <span class="badge bg-finance rounded-pill ms-auto">30</span>
                                    </div>

                                    <img src="images/topics/production.jpg" class="custom-block-image img-fluid" alt="Prodüksiyon">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-12 mt-lg-3">
                            <div class="custom-block custom-block-overlay">
                                <div class="d-flex flex-column h-100">
                                    <img src="images/topics/education.jpg" class="custom-block-image img-fluid" alt="Eğitim">

                                    <div class="custom-block-overlay-text d-flex">
                                        <div>
                                            <h5 class="text-white mb-2">Eğitim</h5>

                                            <p class="text-white">Müzik prodüksiyon eğitimleri</p>

                                            <a href="topics-detail.php" class="btn custom-btn mt-2 mt-lg-3">Daha Fazla</a>
                                        </div>

                                        <span class="badge bg-finance rounded-pill ms-auto">25</span>
                                    </div>

                                    <div class="social-share d-flex">
                                        <p class="text-white me-4">Paylaş:</p>

                                        <ul class="social-icon">
                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-twitter"></a>
                                            </li>

                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-facebook"></a>
                                            </li>

                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-pinterest"></a>
                                            </li>
                                        </ul>

                                        <a href="#" class="custom-icon bi-bookmark ms-auto"></a>
                                    </div>

                                    <div class="section-overlay"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </main>

		<footer class="site-footer section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-12 mb-4 pb-2">
                        <a class="navbar-brand mb-2" href="index.php">
                            <i class="bi-back"></i>
                            <span>nos studio</span>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <h6 class="site-footer-title mb-3">Kaynaklar</h6>

                        <ul class="site-footer-links">
                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Ana Sayfa</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Nasıl Çalışır</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">SSS</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">İletişim</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6 mb-4 mb-lg-0">
                        <h6 class="site-footer-title mb-3">Bilgi</h6>

                        <p class="text-white d-flex mb-1">
                            <a href="tel: 05448375920" class="site-footer-link">
                                05448375920
                            </a>
                        </p>

                        <p class="text-white d-flex">
                            <a href="mailto:errdincdemirr577@gmail.com" class="site-footer-link">
                                errdincdemirr577@gmail.com
                            </a>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12 mt-4 mt-lg-0 ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            İngilizce</button>

                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item" type="button">Türkçe</button></li>

                                <li><button class="dropdown-item" type="button">Mısır</button></li>

                                <li><button class="dropdown-item" type="button">Arapça</button></li>
                            </ul>
                        </div>

                        <div class="col-lg-8 col-12 mt-lg-5">
                            Copyright © 2024 nos studio. Tüm hakları saklıdır.
                        </div>
                        
                    </div>

                </div>
            </div>
        </footer>

        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/custom.js"></script>

    </body>
</html>