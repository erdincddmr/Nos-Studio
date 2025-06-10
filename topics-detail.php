<!doctype html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Stüdyo Kayıt Detayları - Nos Studio</title>

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
        $subscribe_message = '';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['subscribe-email'] ?? '';
            
            if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $to = "newsletter@nosstudio.com";
                $subject = "Yeni Bülten Aboneliği";
                $headers = "From: $email\r\n";
                $headers .= "Reply-To: $email\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                
                $email_content = "Yeni bülten aboneliği:<br>";
                $email_content .= "E-posta: $email<br>";
                
                if(mail($to, $subject, $email_content, $headers)) {
                    $subscribe_message = '<div class="alert alert-success">Bülten aboneliğiniz başarıyla gerçekleşti!</div>';
                } else {
                    $subscribe_message = '<div class="alert alert-danger">Abonelik işlemi sırasında bir hata oluştu.</div>';
                }
            } else {
                $subscribe_message = '<div class="alert alert-warning">Lütfen geçerli bir e-posta adresi girin.</div>';
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
                    <div class="row justify-content-center align-items-center">

                        <div class="col-lg-5 col-12 mb-5">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>

                                    <li class="breadcrumb-item active" aria-current="page">Stüdyo Kayıt</li>
                                </ol>
                            </nav>

                            <h1 class="text-white">Stüdyo Kayıt</h1>

                            <h2 class="text-white">Stüdyo Kayıt Hizmetlerimiz</h2>

                            <p>Profesyonel stüdyo ortamında en iyi ses kalitesiyle kayıt yapın. Deneyimli ses mühendislerimiz ve en son teknoloji ekipmanlarımızla hizmetinizdeyiz.</p>

                            <p>Stüdyomuzda şu hizmetleri sunuyoruz:</p>

                            <ul>
                                <li>Vokal kayıt</li>
                                <li>Enstrüman kayıt</li>
                                <li>Canlı performans kayıt</li>
                                <li>Podcast kayıt</li>
                                <li>Seslendirme kayıt</li>
                            </ul>

                            <p>Stüdyomuzda kullanılan ekipmanlar:</p>

                            <ul>
                                <li>Neumann U87 mikrofon</li>
                                <li>SSL 4000 konsol</li>
                                <li>Pro Tools HD sistem</li>
                                <li>Yamaha NS10 monitörler</li>
                                <li>Beyerdynamic DT 770 Pro kulaklıklar</li>
                            </ul>

                            <p>Kayıt sürecimiz:</p>

                            <ol>
                                <li>Randevu alın</li>
                                <li>Stüdyoya gelin</li>
                                <li>Kayıt yapın</li>
                                <li>Mix ve mastering</li>
                                <li>Final ürünü teslim alın</li>
                            </ol>

                            <div class="d-flex align-items-center mt-5">
                                <a href="#topics-detail" class="btn custom-btn custom-border-btn smoothscroll me-4">Devamını Oku</a>

                                <a href="#top" class="custom-icon bi-bookmark smoothscroll"></a>
                            </div>
                        </div>

                        <div class="col-lg-5 col-12">
                            <div class="topics-detail-block bg-white shadow-lg">
                                <img src="images/topics/studio-recording.jpg" class="topics-detail-block-image img-fluid" alt="Stüdyo Kayıt">
                            </div>
                        </div>

                    </div>
                </div>
            </header>


            <section class="topics-detail-section section-padding" id="topics-detail">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-8 col-12 m-auto">
                            <h3 class="mb-4">Web Tasarımına Giriş</h3>

                            <p>Peki nasıl öne çıkabilir, benzersiz ve ilginç bir şeyler yapabilir, çevrimiçi bir iş kurabilir ve hayatı değiştirecek kadar para kazanabilirsiniz? Lütfen ücretsiz web sitesi şablonlarını indirmek için TemplateMo web sitesini ziyaret edin.</p>

                            <p><strong>Çevrimiçi para kazanmanın birçok yolu var</strong>. Aşağıda başarıya ulaşmak için kullanabileceğiniz birkaç platform bulunmaktadır. Unutmayın ki herkesin izleyebileceği tek bir yol yoktur. Öyle olsaydı, herkesin bir milyon doları olurdu.</p>

                            <blockquote>
                                Becerilerinizi serbest çalışma olarak sunmak sizi bir gecede milyoner yapmayacak.
                            </blockquote>

                            <div class="row my-4">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <img src="images/topics/mixing.jpg" class="topics-detail-block-image img-fluid" alt="Mix">
                                </div>

                                <div class="col-lg-6 col-md-6 col-12 mt-4 mt-lg-0 mt-md-0">
                                    <img src="images/topics/mastering.jpg" class="topics-detail-block-image img-fluid" alt="Mastering">
                                </div>
                            </div>

                            <p>Çoğu insan, gelir elde etmek için yan iş olarak zaten sahip oldukları serbest çalışma becerileriyle başlar. Bu ekstra para tatil için, tasarrufları artırmak için, yatırım yapmak için, iş kurmak için kullanılabilir.</p>
                        </div>

                    </div>
                </div>
            </section>


            <section class="section-padding section-bg">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-12">
                            <h5 class="mb-3">Randevu Alın</h5>

                            <?php if (isset($_SESSION['user_id'])): // Kullanıcı giriş yapmışsa ?>
                                <p>Randevu almak için aşağıdaki butona tıklayın.</p>
                                <a href="book_appointment.php" class="btn custom-btn custom-border-btn mt-3">Randevu Al</a>
                            <?php else: // Kullanıcı giriş yapmamışsa ?>
                                <p>Randevu almak için lütfen giriş yapın veya kayıt olun.</p>
                                <a href="login.php" class="btn custom-btn custom-border-btn mt-3">Giriş Yap</a>
                                <a href="register.php" class="btn custom-btn custom-border-btn mt-3">Kayıt Ol</a>
                            <?php endif; ?>

                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mb-4 mb-md-0 mb-lg-0">
                            <h4 class="mb-3">nos studio</h4>
                        </div>
                    </div>
                </div>
            </section>
        </main>
		
        <footer class="site-footer section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 col-12 mb-4 mb-md-0 mb-lg-0">
                        <h4 class="mb-3">nos studio</h4>
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