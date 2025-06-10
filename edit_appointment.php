<?php
session_start();
include 'db_config.php';

// Kullanıcı giriş yapmamışsa veya admin değilse giriş sayfasına yönlendir
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$appointment_id = $_GET['id'] ?? null;
$appointment = null;
$message = '';

// Randevu ID'si belirtilmemişse veya geçersizse geri yönlendir
if (!$appointment_id || !is_numeric($appointment_id)) {
    $_SESSION['message'] = "<div class=\"alert alert-danger\">Geçersiz randevu ID'si.</div>";
    header("Location: admin_panel.php");
    exit();
}

// Mevcut randevu bilgilerini çek
try {
    $stmt = $conn->prepare("SELECT id, user_id, appointment_date, appointment_time, service_name, price FROM appointments WHERE id = ?");
    if ($stmt === false) {
        throw new Exception("SQL sorgusu hazırlama hatası: " . $conn->error);
    }
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();
    $stmt->close();

    if (!$appointment) {
        $_SESSION['message'] = "<div class=\"alert alert-danger\">Randevu bulunamadı.</div>";
        header("Location: admin_panel.php");
        exit();
    }
} catch (Exception $e) {
    $_SESSION['message'] = "<div class=\"alert alert-danger\">" . $e->getMessage() . "</div>";
    header("Location: admin_panel.php");
    exit();
}

// Form gönderildiğinde güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_appointment_date = $_POST['appointment_date'] ?? '';
    $new_appointment_time = $_POST['appointment_time'] ?? '';
    $new_service_name = $_POST['service_name'] ?? '';
    $new_price = $_POST['price'] ?? '';

    if (empty($new_appointment_date) || empty($new_appointment_time) || empty($new_service_name) || empty($new_price)) {
        $message = '<div class="alert alert-danger">Tüm alanları doldurun!</div>';
    } elseif (!is_numeric($new_price) || $new_price <= 0) {
        $message = '<div class="alert alert-danger">Fiyat geçerli bir sayı olmalıdır.</div>';
    } else {
        try {
            $stmt = $conn->prepare("UPDATE appointments SET appointment_date = ?, appointment_time = ?, service_name = ?, price = ? WHERE id = ?");
            if ($stmt === false) {
                throw new Exception("SQL güncelleme sorgusu hazırlama hatası: " . $conn->error);
            }
            $stmt->bind_param("sssid", $new_appointment_date, $new_appointment_time, $new_service_name, $new_price, $appointment_id);

            if ($stmt->execute()) {
                $message = '<div class="alert alert-success">Randevu başarıyla güncellendi.</div>';
                // Güncel bilgileri sayfaya yansıtmak için randevuyu tekrar çek
                $stmt_fetch = $conn->prepare("SELECT id, user_id, appointment_date, appointment_time, service_name, price FROM appointments WHERE id = ?");
                $stmt_fetch->bind_param("i", $appointment_id);
                $stmt_fetch->execute();
                $result_fetch = $stmt_fetch->get_result();
                $appointment = $result_fetch->fetch_assoc();
                $stmt_fetch->close();
            } else {
                $message = '<div class="alert alert-danger">Randevu güncellenirken bir hata oluştu: ' . $stmt->error . '</div>';
            }
            $stmt->close();
        } catch (Exception $e) {
            $message = '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
        }
    }
}

$conn->close();

// Mesajları görüntüle ve temizle (varsa)
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Randevu Düzenle - Admin Paneli</title>
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
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="admin_panel.php">Admin Paneli</a>
                        </li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <?php if ($_SESSION['role'] === 'admin'): ?>
                                <li class="nav-item">
                                    <a class="nav-link click-scroll" href="profile.php">Profilim</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link click-scroll" href="logout.php">Çıkış Yap</a>
                                </li>
                            <?php endif; ?>
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
                        <h2>Randevu Düzenle</h2>
                        <?php echo $message; ?>
                        <?php if ($appointment): ?>
                        <form action="edit_appointment.php?id=<?php echo htmlspecialchars($appointment['id']); ?>" method="post" class="custom-form contact-form" role="form">
                            <div class="form-floating mb-3">
                                <input type="date" name="appointment_date" id="appointment_date" class="form-control" value="<?php echo htmlspecialchars($appointment['appointment_date']); ?>" required>
                                <label for="appointment_date">Tarih</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="time" name="appointment_time" id="appointment_time" class="form-control" value="<?php echo htmlspecialchars($appointment['appointment_time']); ?>" required>
                                <label for="appointment_time">Saat</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="service_name" id="service_name" class="form-control" required>
                                    <option value="Stüdyo Kayıt" <?php echo ($appointment['service_name'] === 'Stüdyo Kayıt') ? 'selected' : ''; ?>>Stüdyo Kayıt</option>
                                    <option value="Mix ve Mastering" <?php echo ($appointment['service_name'] === 'Mix ve Mastering') ? 'selected' : ''; ?>>Mix ve Mastering</option>
                                    <option value="Müzik Prodüksiyon" <?php echo ($appointment['service_name'] === 'Müzik Prodüksiyon') ? 'selected' : ''; ?>>Müzik Prodüksiyon</option>
                                    <option value="Müzik Eğitimi" <?php echo ($appointment['service_name'] === 'Müzik Eğitimi') ? 'selected' : ''; ?>>Müzik Eğitimi</option>
                                </select>
                                <label for="service_name">Hizmet</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" step="0.01" name="price" id="price" class="form-control" value="<?php echo htmlspecialchars($appointment['price']); ?>" required>
                                <label for="price">Fiyat (TL)</label>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Randevuyu Güncelle</button>
                        </form>
                        <?php else: ?>
                            <p class="text-center">Randevu bilgileri yüklenemedi.</p>
                        <?php endif; ?>
                        <p class="text-center mt-3"><a href="view_user_appointments.php?user_id=<?php echo htmlspecialchars($appointment['user_id']); ?>">Randevu Listesine Geri Dön</a></p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/click-scroll.js"></script>
    <script src="js/custom.js"></script>
</body>
</html> 