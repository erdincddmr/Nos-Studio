<?php
session_start();
include 'db_config.php';

// Kullanıcı giriş yapmamışsa veya admin değilse giriş sayfasına yönlendir
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$user_id = $_GET['id'] ?? null;
$user = null;
$message = '';

// Kullanıcı ID'si belirtilmemişse veya geçersizse geri yönlendir
if (!$user_id || !is_numeric($user_id)) {
    $_SESSION['message'] = "<div class=\"alert alert-danger\">Geçersiz kullanıcı ID'si.</div>";
    header("Location: admin_panel.php");
    exit();
}

// Mevcut kullanıcı bilgilerini çek
try {
    $stmt = $conn->prepare("SELECT id, username, email, role FROM users WHERE id = ?");
    if ($stmt === false) {
        throw new Exception("SQL sorgusu hazırlama hatası: " . $conn->error);
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        $_SESSION['message'] = "<div class=\"alert alert-danger\">Kullanıcı bulunamadı.</div>";
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
    $new_username = $_POST['username'] ?? '';
    $new_email = $_POST['email'] ?? '';
    $new_role = $_POST['role'] ?? '';
    $new_password = $_POST['password'] ?? ''; // Yeni şifre, boş bırakılabilir

    if (empty($new_username) || empty($new_email) || empty($new_role)) {
        $message = '<div class="alert alert-danger">Tüm alanları doldurun!</div>';
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $message = '<div class="alert alert-danger">Geçerli bir e-posta adresi girin!</div>';
    } else {
        $update_password_sql = '';
        $params = [];
        $types = '';

        // Şifre güncellenecekse
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_password_sql = ", password = ?";
            $params[] = $hashed_password;
            $types .= 's';
        }

        $sql = "UPDATE users SET username = ?, email = ?, role = ?" . $update_password_sql . " WHERE id = ?";
        
        $params[] = $new_username;
        $params[] = $new_email;
        $params[] = $new_role;
        $params[] = $user_id;
        
        $types .= 'sssi'; // s: username, s: email, s: role, i: id

        // Şifre güncellenecekse türleri ve parametreleri doğru sıraya koy
        if (!empty($new_password)) {
            // types: s (hashed_password) + sss (username, email, role) + i (user_id)
            // params: hashed_password, new_username, new_email, new_role, user_id
            // Yukarıdaki `sssi` sırası, password yokken geçerli. password varsa değişir.
            // Bunu basitleştirmek için params dizisini doğrudan bağlayabiliriz:
            $final_params = [];
            $final_types = '';
            if (!empty($new_password)) {
                $final_params[] = $hashed_password;
                $final_types .= 's';
            }
            $final_params[] = $new_username;
            $final_types .= 's';
            $final_params[] = $new_email;
            $final_types .= 's';
            $final_params[] = $new_role;
            $final_types .= 's';
            $final_params[] = $user_id;
            $final_types .= 'i';

        } else {
            $final_params = [$new_username, $new_email, $new_role, $user_id];
            $final_types = 'sssi';
        }

        // PDO yerine mysqli kullan
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $message = '<div class="alert alert-danger">SQL güncelleme sorgusu hazırlama hatası: ' . $conn->error . '</div>';
        } else {
            // bind_param değişken sayısına göre dinamik hale getirilmeli
            call_user_func_array([$stmt, 'bind_param'], array_merge([$final_types], refValues($final_params)));

            if ($stmt->execute()) {
                $message = '<div class="alert alert-success">Kullanıcı bilgileri başarıyla güncellendi.</div>';
                // Güncel bilgileri sayfaya yansıtmak için kullanıcıyı tekrar çek
                $stmt_fetch = $conn->prepare("SELECT id, username, email, role FROM users WHERE id = ?");
                $stmt_fetch->bind_param("i", $user_id);
                $stmt_fetch->execute();
                $result_fetch = $stmt_fetch->get_result();
                $user = $result_fetch->fetch_assoc();
                $stmt_fetch->close();

                // Oturumdaki admin kendi bilgilerini güncellediyse oturumu güncelle
                if ($user['id'] == $_SESSION['user_id']) {
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                }

            } else {
                if ($conn->errno == 1062) {
                    $message = '<div class="alert alert-danger">Bu kullanıcı adı veya e-posta zaten kullanımda.</div>';
                } else {
                    $message = '<div class="alert alert-danger">Kullanıcı güncellenirken bir hata oluştu: ' . $stmt->error . '</div>';
                }
            }
            $stmt->close();
        }
    }
}

$conn->close();

// bind_param için referans geçirme yardımcı fonksiyonu
function refValues($arr){
    if (strnatcmp(phpversion(),'5.3') >= 0) //PHP 5.3 or later
    {
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = & $arr[$key];
        return $refs;
    }
    return $arr;
}
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kullanıcı Düzenle - Admin Paneli</title>
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
<body id="top">
    <main>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <i class="bi-back"></i>
                    <span>Melodi</span>
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
                        <h2>Kullanıcı Düzenle</h2>
                        <?php echo $message; ?>
                        <?php if ($user): ?>
                        <form action="edit_user.php?id=<?php echo htmlspecialchars($user['id']); ?>" method="post" class="custom-form contact-form" role="form">
                            <div class="form-floating mb-3">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Kullanıcı Adı" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                                <label for="username">Kullanıcı Adı</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" id="email" class="form-control" placeholder="E-posta Adresi" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                <label for="email">E-posta Adresi</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="role" id="role" class="form-control" required>
                                    <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>Kullanıcı</option>
                                    <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                </select>
                                <label for="role">Rol</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Yeni Şifre (boş bırakınca değişmez)">
                                <label for="password">Yeni Şifre (değiştirmek istemiyorsanız boş bırakın)</label>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Bilgileri Güncelle</button>
                        </form>
                        <?php else: ?>
                            <p class="text-center">Kullanıcı bilgileri yüklenemedi.</p>
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