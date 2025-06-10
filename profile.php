<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('db_config.php');

// Kullanıcı giriş yapmamışsa login sayfasına yönlendir
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Kullanıcı bilgilerini veritabanından çek
// PDO yerine mysqli kullan
$stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");

if ($stmt === false) {
    die("SQL sorgusu hazırlama hatası: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    // Kullanıcı bulunamazsa çıkış yap
    header("Location: logout.php");
    exit();
}
$stmt->close();

// Kullanıcının randevularını veritabanından çek
$appointments = [];
try {
    $stmt_appointments = $conn->prepare("SELECT appointment_date, appointment_time, service_name, price FROM appointments WHERE user_id = ? ORDER BY appointment_date DESC, appointment_time DESC");
    if ($stmt_appointments === false) {
        throw new Exception("SQL randevu sorgusu hazırlama hatası: " . $conn->error);
    }
    $stmt_appointments->bind_param("i", $user_id);
    $stmt_appointments->execute();
    $result_appointments = $stmt_appointments->get_result();
    while ($row = $result_appointments->fetch_assoc()) {
        $appointments[] = $row;
    }
    $stmt_appointments->close();
} catch (Exception $e) {
    // Randevu çekilirken oluşan hataları mesaj olarak göster
    $appointment_message = "<div class=\"alert alert-danger\">Randevu bilgilerini yüklerken bir hata oluştu: " . $e->getMessage() . "</div>";
}

$conn->close();
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profilim - Nos Studio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-topic-listing.css" rel="stylesheet">
    <style>
        .profile-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body id="top">
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

        <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-12 mx-auto profile-container">
                        <h1 class="text-white text-center">Profil Bilgilerim</h1>
                        <div class="card mt-4">
                            <div class="card-body">
                                <h5 class="card-title">Kullanıcı Adı: <?php echo htmlspecialchars($user['username']); ?></h5>
                                <p class="card-text">E-posta: <?php echo htmlspecialchars($user['email']); ?></p>
                                <p class="card-text">Rol: <?php echo htmlspecialchars($user['role']); ?></p>
                                <a href="index.php" class="btn btn-primary">Ana Sayfaya Dön</a>
                            </div>
                        </div>

                        <h3 class="mt-5 mb-3 text-center">Randevularım</h3>
                        <?php if (isset($appointment_message)) { echo $appointment_message; } ?>
                        <?php if (!empty($appointments)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tarih</th>
                                            <th>Saat</th>
                                            <th>Hizmet</th>
                                            <th>Fiyat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($appointments as $appointment): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                                <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                                                <td><?php echo htmlspecialchars($appointment['service_name']); ?></td>
                                                <td><?php echo number_format(htmlspecialchars($appointment['price']), 2); ?> TL</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-center">Henüz randevunuz bulunmamaktadır.</p>
                        <?php endif; ?>
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
    <script src="js/custom.js"></script>
</body>
</html> 