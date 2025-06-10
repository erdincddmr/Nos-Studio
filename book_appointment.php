<?php
session_start();
include 'db_config.php';

// Kullanıcı giriş yapmamışsa login sayfasına yönlendir
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';
$price_per_hour = 900.00; // 1 saatlik hizmet için fiyat

// Form gönderildiğinde randevu kaydetme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_date = $_POST['appointment_date'] ?? '';
    $appointment_time = $_POST['appointment_time'] ?? '';
    $service_name = $_POST['service_name'] ?? 'Stüdyo Kayıt'; // Varsayılan hizmet adı
    $user_id = $_SESSION['user_id'];

    if (empty($appointment_date) || empty($appointment_time)) {
        $message = '<div class="alert alert-danger">Lütfen tarih ve saat seçin.</div>';
    } else {
        try {
            // Randevu bilgilerini veritabanına kaydet
            $stmt = $conn->prepare("INSERT INTO appointments (user_id, appointment_date, appointment_time, service_name, price) VALUES (?, ?, ?, ?, ?)");
            if ($stmt === false) {
                throw new Exception("SQL sorgusu hazırlama hatası: " . $conn->error);
            }
            $stmt->bind_param("isssd", $user_id, $appointment_date, $appointment_time, $service_name, $price_per_hour);

            if ($stmt->execute()) {
                $message = '<div class="alert alert-success">Randevunuz başarıyla oluşturuldu!</div>';
            } else {
                $message = '<div class="alert alert-danger">Randevu oluşturulurken bir hata oluştu: ' . $stmt->error . '</div>';
            }
            $stmt->close();
        } catch (Exception $e) {
            $message = '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
        }
    }
}

$conn->close();
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Randevu Al - nos studio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-topic-listing.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .form-floating label {
            padding-left: 20px;
        }
        .form-control {
            border-radius: var(--border-radius-large);
            margin-bottom: 24px;
            padding-top: 13px;
            padding-bottom: 13px;
            padding-left: 20px;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 20px;
            border-radius: var(--border-radius-large);
            width: 100%;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #555;
            border-color: #555;
        }
        .text-center a {
            color: var(--primary-color);
        }
        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
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
                            <a class="nav-link click-scroll" href="index.php">Ana Sayfa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="topics-listing.php">Hizmetlerimiz</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="contact.php">İletişim</a>
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

        <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-12 mx-auto form-container">
                        <h2>Randevu Al</h2>
                        <?php echo $message; ?>
                        <form action="book_appointment.php" method="post" class="custom-form contact-form" role="form">
                            <div class="form-floating mb-3">
                                <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
                                <label for="appointment_date">Tarih</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="time" name="appointment_time" id="appointment_time" class="form-control" required>
                                <label for="appointment_time">Saat</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="service_name" id="service_name" class="form-control" required>
                                    <option value="Stüdyo Kayıt">Stüdyo Kayıt</option>
                                    <option value="Mix ve Mastering">Mix ve Mastering</option>
                                    <option value="Müzik Prodüksiyon">Müzik Prodüksiyon</option>
                                    <option value="Müzik Eğitimi">Müzik Eğitimi</option>
                                </select>
                                <label for="service_name">Hizmet</label>
                            </div>
                            <p class="text-center">1 saatlik hizmet ücreti: **<?php echo number_format($price_per_hour, 2); ?> TL**</p>
                            <button type="submit" class="btn btn-primary mt-3">Randevuyu Onayla</button>
                        </form>
                        <p class="text-center mt-3"><a href="topics-detail.php">Geri Dön</a></p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <div class="col-lg-8 col-12 mt-lg-5">
        Copyright © 2024 nos studio. Tüm hakları saklıdır.
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/click-scroll.js"></script>
    <script src="js/custom.js"></script>
</body>
</html> 