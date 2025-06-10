<?php
session_start();
include 'db_config.php';

// Kullanıcı giriş yapmamışsa veya admin değilse giriş sayfasına yönlendir
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$viewing_user_id = $_GET['user_id'] ?? null;
$viewing_username = '';
$appointments = [];
$message = '';

// user_id gelip gelmediğini kontrol et
if (!$viewing_user_id || !is_numeric($viewing_user_id)) {
    $_SESSION['message'] = "<div class=\"alert alert-danger\">Görüntülenecek kullanıcı ID'si belirtilmedi veya geçersiz.</div>";
    header("Location: admin_panel.php");
    exit();
}

// Görüntülenen kullanıcının adını al
try {
    $stmt_user = $conn->prepare("SELECT username FROM users WHERE id = ?");
    if ($stmt_user === false) {
        throw new Exception("Kullanıcı adı sorgusu hazırlama hatası: " . $conn->error);
    }
    $stmt_user->bind_param("i", $viewing_user_id);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $user_data = $result_user->fetch_assoc();
    $stmt_user->close();

    if ($user_data) {
        $viewing_username = $user_data['username'];
    } else {
        $_SESSION['message'] = "<div class=\"alert alert-danger\">Kullanıcı bulunamadı.</div>";
        header("Location: admin_panel.php");
        exit();
    }
} catch (Exception $e) {
    $_SESSION['message'] = "<div class=\"alert alert-danger\">" . $e->getMessage() . "</div>";
    header("Location: admin_panel.php");
    exit();
}

// Kullanıcının randevularını veritabanından çek
try {
    $stmt_appointments = $conn->prepare("SELECT id, appointment_date, appointment_time, service_name, price FROM appointments WHERE user_id = ? ORDER BY appointment_date DESC, appointment_time DESC");
    if ($stmt_appointments === false) {
        throw new Exception("SQL randevu sorgusu hazırlama hatası: " . $conn->error);
    }
    $stmt_appointments->bind_param("i", $viewing_user_id);
    $stmt_appointments->execute();
    $result_appointments = $stmt_appointments->get_result();
    while ($row = $result_appointments->fetch_assoc()) {
        $appointments[] = $row;
    }
    $stmt_appointments->close();
} catch (Exception $e) {
    $message = "<div class=\"alert alert-danger\">Randevu bilgilerini yüklerken bir hata oluştu: " . $e->getMessage() . "</div>";
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
    <title><?php echo htmlspecialchars($viewing_username); ?> Randevuları - Admin Paneli</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/templatemo-topic-listing.css" rel="stylesheet">
    <style>
        .admin-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .admin-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .alert {
            margin-top: 20px;
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
                    <div class="col-lg-10 col-12 mx-auto admin-container">
                        <h2><?php echo htmlspecialchars($viewing_username); ?> Randevuları</h2>
                        <?php echo $message; ?>
                        <?php if (!empty($appointments)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tarih</th>
                                            <th>Saat</th>
                                            <th>Hizmet</th>
                                            <th>Fiyat</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($appointments as $appointment): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($appointment['id']); ?></td>
                                                <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                                <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                                                <td><?php echo htmlspecialchars($appointment['service_name']); ?></td>
                                                <td><?php echo number_format(htmlspecialchars($appointment['price']), 2); ?> TL</td>
                                                <td>
                                                    <a href="edit_appointment.php?id=<?php echo htmlspecialchars($appointment['id']); ?>" class="btn btn-sm btn-info">Düzenle</a>
                                                    <a href="delete_appointment.php?id=<?php echo htmlspecialchars($appointment['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu randevuyu silmek istediğinizden emin misiniz?');">Sil</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-center">Bu kullanıcının henüz randevusu bulunmamaktadır.</p>
                        <?php endif; ?>
                        <p class="text-center mt-3"><a href="admin_panel.php">Admin Paneline Geri Dön</a></p>
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