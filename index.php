<!doctype html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Nos Studio</title>

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
    
    <body id="top">
        <?php
        session_start();
        $search_results = '';
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['keyword'])) {
            $keyword = htmlspecialchars($_GET['keyword']);
            
            // Hizmetler dizisi
            $services = [
                'kayıt' => 'Stüdyo Kayıt Hizmetleri',
                'mix' => 'Mix ve Mastering Hizmetleri',
                'mastering' => 'Profesyonel Mastering',
                'prodüksiyon' => 'Müzik Prodüksiyon',
                'eğitim' => 'Müzik Eğitimi'
            ];
            
            $found_services = [];
            foreach ($services as $key => $service) {
                if (stripos($key, $keyword) !== false || stripos($service, $keyword) !== false) {
                    $found_services[] = $service;
                }
            }
            
            if (!empty($found_services)) {
                $search_results = '<div class="alert alert-info mt-3">';
                $search_results .= '<h5>Arama Sonuçları:</h5>';
                $search_results .= '<ul>';
                foreach ($found_services as $service) {
                    $search_results .= "<li>$service</li>";
                }
                $search_results .= '</ul></div>';
            } else {
                $search_results = '<div class="alert alert-warning mt-3">Aramanızla eşleşen sonuç bulunamadı.</div>';
            }
        }
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
                                <a class="nav-link click-scroll" href="#section_1">Ana Sayfa</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_2">Hizmetlerimiz</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_3">Nasıl Çalışır</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_4">SSS</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link click-scroll" href="#section_5">İletişim</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#section_5" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Sayfalar</a>

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
                    <div class="row justify-content-center align-items-center">

                        <div class="col-lg-5 col-12 mb-5">
                            <h2 class="text-white">Nos Studio</h2>
                            <p class="text-white">Müzik Stüdyosu</p>
                            <a href="https://github.com/erdincddmr/Nos-Studio.git" target="_blank" class="btn custom-btn custom-border-btn mt-3">
                                <i class="bi-github"></i> GitHub Projesi
                            </a>
                        </div>

                    </div>
                </div>
            </header>

            <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-8 col-12 mx-auto">
                            <h1 class="text-white text-center">Müziğinizi. Kaydedin. Yayınlayın.</h1>

                            <h6 class="text-center">profesyonel müzik stüdyosu</h6>

                            <form method="get" class="custom-form mt-4 pt-2 mb-lg-0 mb-5" role="search">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bi-search" id="basic-addon1"></span>

                                    <input name="keyword" type="search" class="form-control" id="keyword" placeholder="Kayıt, Mix, Mastering, Prodüksiyon ..." aria-label="Ara" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">

                                    <button type="submit" class="form-control">Ara</button>
                                </div>
                            </form>
                            <?php echo $search_results; ?>
                        </div>

                    </div>
                </div>
            </section>


            <section class="featured-section">
                <div class="container">
                    <div class="row justify-content-center">

                        <div class="col-lg-4 col-12 mb-4 mb-lg-0">
                            <div class="custom-block bg-white shadow-lg">
                                <a href="topics-detail.php">
                                    <div class="d-flex">
                                        <div>
                                            <h5 class="mb-2">Stüdyo Kayıt</h5>

                                            <p class="mb-0">Profesyonel stüdyo ortamında kayıt hizmetleri</p>
                                        </div>

                                        <span class="badge bg-design rounded-pill ms-auto">14</span>
                                    </div>

                                    <img src="images/topics/studio-recording.jpg" class="custom-block-image img-fluid" alt="Stüdyo Kayıt">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="custom-block custom-block-overlay">
                                <div class="d-flex flex-column h-100">
                                    <img src="images/topics/mastering.jpg" class="custom-block-image img-fluid" alt="Mastering Hizmetleri">

                                    <div class="custom-block-overlay-text d-flex">
                                        <div>
                                            <h5 class="text-white mb-2">Mastering</h5>

                                            <p class="text-white">Müziğinizi profesyonel ses mühendislerimizle mükemmel hale getirin. Mix ve mastering hizmetlerimizle müziğiniz radyo kalitesinde olacak.</p>

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


            <section class="explore-section section-padding" id="section_2">
                <div class="container">
                    <div class="row">

                        <div class="col-12 text-center">
                            <h2 class="mb-4">Hizmetlerimiz</h1>
                        </div>

                    </div>
                </div>

                <div class="container-fluid">
                    <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="design-tab" data-bs-toggle="tab" data-bs-target="#design-tab-pane" type="button" role="tab" aria-controls="design-tab-pane" aria-selected="true">Kayıt</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="marketing-tab" data-bs-toggle="tab" data-bs-target="#marketing-tab-pane" type="button" role="tab" aria-controls="marketing-tab-pane" aria-selected="false">Mix</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance-tab-pane" type="button" role="tab" aria-controls="finance-tab-pane" aria-selected="false">Mastering</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="music-tab" data-bs-toggle="tab" data-bs-target="#music-tab-pane" type="button" role="tab" aria-controls="music-tab-pane" aria-selected="false">Prodüksiyon</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="education-tab" data-bs-toggle="tab" data-bs-target="#education-tab-pane" type="button" role="tab" aria-controls="education-tab-pane" aria-selected="false">Eğitim</button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="container">
                    <div class="row">

                        <div class="col-12">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="design-tab-pane" role="tabpanel" aria-labelledby="design-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.php">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Stüdyo Kayıt</h5>

                                                            <p class="mb-0">Profesyonel stüdyo ortamında kayıt hizmetleri</p>
                                                        </div>

                                                        <span class="badge bg-design rounded-pill ms-auto">14</span>
                                                    </div>

                                                    <img src="images/topics/studio-recording.jpg" class="custom-block-image img-fluid" alt="Stüdyo Kayıt">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.php">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Prodüksiyon</h5>

                                                                <p class="mb-0">Müzik prodüksiyon hizmetleri</p>
                                                        </div>

                                                        <span class="badge bg-design rounded-pill ms-auto">75</span>
                                                    </div>

                                                    <img src="images/topics/production.jpg" class="custom-block-image img-fluid" alt="Prodüksiyon Hizmetleri">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.php">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Mix</h5>

                                                                <p class="mb-0">Profesyonel mix hizmetleri</p>
                                                        </div>

                                                        <span class="badge bg-design rounded-pill ms-auto">100</span>
                                                    </div>

                                                    <img src="images/topics/mixing.jpg" class="custom-block-image img-fluid" alt="Mix Hizmetleri">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="marketing-tab-pane" role="tabpanel" aria-labelledby="marketing-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                                <div class="custom-block bg-white shadow-lg">
                                                    <a href="topics-detail.php">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">Mix</h5>

                                                                <p class="mb-0">Profesyonel mix hizmetleri</p>
                                                            </div>

                                                            <span class="badge bg-advertising rounded-pill ms-auto">30</span>
                                                        </div>

                                                        <img src="images/topics/mixing.jpg" class="custom-block-image img-fluid" alt="Mix Hizmetleri">
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                                <div class="custom-block bg-white shadow-lg">
                                                    <a href="topics-detail.php">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">Prodüksiyon</h5>

                                                                <p class="mb-0">Müzik prodüksiyon hizmetleri</p>
                                                            </div>

                                                            <span class="badge bg-advertising rounded-pill ms-auto">65</span>
                                                        </div>

                                                        <img src="images/topics/production.jpg" class="custom-block-image img-fluid" alt="Prodüksiyon Hizmetleri">
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12">
                                                <div class="custom-block bg-white shadow-lg">
                                                    <a href="topics-detail.php">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">Mastering</h5>

                                                                <p class="mb-0">Profesyonel mastering hizmetleri</p>
                                                            </div>

                                                            <span class="badge bg-advertising rounded-pill ms-auto">50</span>
                                                        </div>

                                                        <img src="images/topics/mastering.jpg" class="custom-block-image img-fluid" alt="Mastering Hizmetleri">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                  </div>

                                <div class="tab-pane fade" id="finance-tab-pane" role="tabpanel" aria-labelledby="finance-tab" tabindex="0">   <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-0">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.php">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Mastering</h5>

                                                            <p class="mb-0">Profesyonel mastering hizmetleri</p>
                                                        </div>

                                                        <span class="badge bg-finance rounded-pill ms-auto">30</span>
                                                    </div>

                                                    <img src="images/topics/mastering.jpg" class="custom-block-image img-fluid" alt="Mastering Hizmetleri">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="custom-block custom-block-overlay">
                                                <div class="d-flex flex-column h-100">
                                                    <img src="images/topics/mastering.jpg" class="custom-block-image img-fluid" alt="Mastering Hizmetleri">

                                                    <div class="custom-block-overlay-text d-flex">
                                                        <div>
                                                            <h5 class="text-white mb-2">Mastering</h5>

                                                            <p class="text-white">Müziğinizi profesyonel ses mühendislerimizle mükemmel hale getirin. Mix ve mastering hizmetlerimizle müziğiniz radyo kalitesinde olacak.</p>

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

                                <div class="tab-pane fade" id="music-tab-pane" role="tabpanel" aria-labelledby="music-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.php">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Prodüksiyon</h5>

                                                            <p class="mb-0">Müzik prodüksiyon hizmetleri</p>
                                                        </div>

                                                        <span class="badge bg-music rounded-pill ms-auto">45</span>
                                                    </div>

                                                    <img src="images/topics/production.jpg" class="custom-block-image img-fluid" alt="Prodüksiyon Hizmetleri">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.php">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Mix</h5>

                                                            <p class="mb-0">Profesyonel mix hizmetleri</p>
                                                        </div>

                                                        <span class="badge bg-music rounded-pill ms-auto">45</span>
                                                    </div>

                                                    <img src="images/topics/mixing.jpg" class="custom-block-image img-fluid" alt="Mix Hizmetleri">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.php">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Mastering</h5>

                                                            <p class="mb-0">Profesyonel mastering hizmetleri</p>
                                                        </div>

                                                        <span class="badge bg-music rounded-pill ms-auto">20</span>
                                                    </div>

                                                    <img src="images/topics/mastering.jpg" class="custom-block-image img-fluid" alt="Mastering Hizmetleri">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="education-tab-pane" role="tabpanel" aria-labelledby="education-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-3">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.php">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Eğitim</h5>

                                                            <p class="mb-0">Müzik prodüksiyon eğitimleri</p>
                                                        </div>

                                                        <span class="badge bg-education rounded-pill ms-auto">80</span>
                                                    </div>

                                                    <img src="images/topics/education.jpg" class="custom-block-image img-fluid" alt="Eğitim Hizmetleri">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="custom-block bg-white shadow-lg">
                                                <a href="topics-detail.php">
                                                    <div class="d-flex">
                                                        <div>
                                                            <h5 class="mb-2">Eğitmen</h5>

                                                            <p class="mb-0">Birebir veya grup dersleri ile müzik prodüksiyonunda uzmanlaşın.</p>
                                                        </div>

                                                        <span class="badge bg-education rounded-pill ms-auto">75</span>
                                                    </div>

                                                    <img src="images/topics/education.jpg" class="custom-block-image img-fluid" alt="Eğitim Hizmetleri">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </section>


            <section class="timeline-section section-padding" id="section_3">
                <div class="section-overlay"></div>

                <div class="container">
                    <div class="row">

                        <div class="col-12 text-center">
                            <h2 class="text-white mb-4">Nasıl Çalışır?</h1>
                        </div>

                        <div class="col-lg-10 col-12 mx-auto">
                            <div class="timeline-container">
                                <ul class="vertical-scrollable-timeline" id="vertical-scrollable-timeline">
                                    <div class="list-progress">
                                        <div class="inner"></div>
                                    </div>

                                    <li>
                                        <h4 class="text-white mb-3">Randevu Alın</h4>

                                        <p class="text-white">Stüdyomuzda kayıt için randevu alın. Size en uygun zamanı seçin ve profesyonel ekibimizle çalışmaya başlayın.</p>

                                        <div class="icon-holder">
                                          <i class="bi-search"></i>
                                        </div>
                                    </li>
                                    
                                    <li>
                                        <h4 class="text-white mb-3">Kayıt Yapın</h4>

                                        <p class="text-white">En son teknoloji ekipmanlarımız ve deneyimli ses mühendislerimizle müziğinizi kaydedin.</p>

                                        <div class="icon-holder">
                                          <i class="bi-bookmark"></i>
                                        </div>
                                    </li>

                                    <li>
                                        <h4 class="text-white mb-3">Mix & Mastering</h4>

                                        <p class="text-white">Müziğinizi profesyonel ses mühendislerimizle mix ve mastering yapın.</p>

                                        <div class="icon-holder">
                                          <i class="bi-book"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-5">
                            <p class="text-white">
                                Daha Fazla Öğrenmek İster Misin?
                                <a href="#" class="btn custom-btn custom-border-btn ms-3">YouTube'da Keşfet</a>
                            </p>
                        </div>
                    </div>
                </div>
            </section>


            <section class="faq-section section-padding" id="section_4">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-12">
                            <h2 class="mb-4">Sıkça Sorulan Sorular</h2>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-lg-5 col-12">
                            <img src="images/topics/studio-recording.jpg" class="img-fluid" alt="Sıkça Sorulan Sorular">
                        </div>

                        <div class="col-lg-6 col-12 m-auto">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Stüdyo kayıt ücretleri nedir?
                                        </button>
                                    </h2>

                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Kayıt ücretlerimiz, proje bazında ve kullanılan ekipmanlara göre değişiklik göstermektedir. Detaylı bilgi için lütfen iletişime geçin.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Mix ve mastering ne kadar sürer?
                                    </button>
                                    </h2>

                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Mix ve mastering süresi, şarkının karmaşıklığına ve projenin yoğunluğuna bağlı olarak değişir. Genellikle bir şarkı için 3-7 gün arasında tamamlanır.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Stüdyo ekipmanları nelerdir?
                                    </button>
                                    </h2>

                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Stüdyomuzda Neumann U87 mikrofon, SSL 4000 konsol, Pro Tools HD sistem, Yamaha NS10 monitörler ve Beyerdynamic DT 770 Pro kulaklıklar gibi endüstri standardı ekipmanlar kullanılmaktadır.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <section class="contact-section section-padding section-bg" id="section_5">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 text-center">
                            <h2 class="mb-5">İletişime Geçin</h2>
                        </div>

                        <div class="col-lg-5 col-12 mb-4 mb-lg-0">
                            <iframe class="google-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3011.6504900120997!2d29.0631!3d40.9637!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cac7c7d0b9b9b9%3A0x9b9b9b9b9b9b9b9b9!2sBa%C4%9Fdat%20Caddesi%2C%20Kad%C4%B1k%C3%B6y%2F%C4%B0stanbul!5e0!3m2!1str!2str!4v1647887654321!5m2!1str!2str" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mb-3 mb-lg- mb-md-0 ms-auto">
                            <h4 class="mb-3">İstanbul Stüdyo</h4>

                            <p>Bağdat Caddesi No:123, Kadıköy, İstanbul, Türkiye</p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Telefon</span>

                                <a href="tel: 05448375920" class="site-footer-link">
                                    05448375920
                                </a>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <a href="mailto:errdincdemirr577@gmail.com" class="site-footer-link">
                                    errdincdemirr577@gmail.com
                                </a>
                            </p>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mx-auto">
                            <h4 class="mb-3">Melodi Müzik Stüdyosu</h4>

                            <p>Türkiye'nin her yerinden ulaşabilirsiniz.</p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Telefon</span>

                                <a href="tel: 05448375920" class="site-footer-link">
                                    05448375920
                                </a>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <a href="mailto:errdincdemirr577@gmail.com" class="site-footer-link">
                                    errdincdemirr577@gmail.com
                                </a>
                            </p>
                        </div>

                    </div>
                </div>
            </section>
        </main>

        <footer class="site-footer">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-12 mt-4 mb-3 mb-lg-0">
                        <a class="navbar-brand mb-2" href="index.php">
                            <i class="bi-back"></i>
                            <span>nos studio</span>
                        </a>
                    </div>

                    <div class="col-lg-3 col-12 mt-4 mb-3 mb-lg-0">
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

                    <div class="col-lg-3 col-12 mt-4 mb-3 mb-lg-0">
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

                    <div class="col-lg-3 col-12 mt-4 ms-auto">
                        <h6 class="site-footer-title mb-3">Sosyal</h6>

                        <ul class="social-icon">
                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-facebook"></a>
                            </li>

                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-twitter"></a>
                            </li>

                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-instagram"></a>
                            </li>

                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-youtube"></a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-8 col-12 mt-lg-5">
                        Copyright © 2024 nos studio. Tüm hakları saklıdır.
                    </div>
                </div>
            </div>
        </footer>

        <!-- JAVASCRIPT FILES -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/click-scroll.js"></script>
        <script src="js/custom.js"></script>

    </body>
</html>
