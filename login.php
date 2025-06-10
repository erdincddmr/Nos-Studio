    <!doctype html>
    <html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Giriş Yap - Nos Studio</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-icons.css" rel="stylesheet">
        <link href="css/templatemo-topic-listing.css" rel="stylesheet">
        <style>
            .form-container {
                max-width: 500px;
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
            <?php
            session_start(); // Oturumu başlat, kullanıcı bilgilerini saklamak için
            include 'db_config.php'; // Veritabanı bağlantımızı dahil et

            $message = '';

            // Kullanıcı zaten giriş yapmışsa ana sayfaya yönlendir
            if (isset($_SESSION['user_id'])) {
                header("Location: index.php");
                exit();
            }

            // Form gönderildiğinde
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $username = $_POST['username'] ?? '';
                $password = $_POST['password'] ?? '';

                if (empty($username) || empty($password)) {
                    $message = '<div class="alert alert-danger">Kullanıcı adı ve şifre boş bırakılamaz!</div>';
                } else {
                    // Kullanıcıyı veritabanında ara
                    $stmt = $conn->prepare("SELECT id, username, password, role, email FROM users WHERE username = ?");
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows === 1) {
                        $user = $result->fetch_assoc();
                        // Girilen şifreyi hashlenmiş şifre ile doğrula
                        if (password_verify($password, $user['password'])) {
                            // Giriş başarılı, oturum değişkenlerini ayarla
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['username'] = $user['username'];
                            $_SESSION['role'] = $user['role'];
                            $_SESSION['email'] = $user['email'];

                            // Kullanıcının rolüne göre yönlendir
                            if ($user['role'] === 'admin') {
                                header("Location: admin_panel.php"); // Henüz oluşturmadık, sonra yaparız
                            } else {
                                header("Location: index.php"); // Normal kullanıcı ana sayfaya
                            }
                            exit();
                        } else {
                            $message = '<div class="alert alert-danger">Yanlış şifre!</div>';
                        }
                    } else {
                        $message = '<div class="alert alert-danger">Kullanıcı bulunamadı!</div>';
                    }
                    $stmt->close();
                }
            }
            $conn->close();
            ?>

            <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-12 mx-auto form-container">
                            <h2>Giriş Yap</h2>
                            <?php echo $message; ?>
                            <form action="login.php" method="post" class="custom-form contact-form" role="form">
                                <div class="form-floating mb-3">
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Kullanıcı Adı" required>
                                    <label for="username">Kullanıcı Adı</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Şifre" required>
                                    <label for="password">Şifre</label>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Giriş Yap</button>
                            </form>
                            <p class="text-center mt-3">Hesabın yok mu? <a href="register.php">Kayıt Ol</a></p>
                        </div>
                    </div>
                    <div class="col-lg-8 col-12 mt-lg-5">
                        Copyright © 2024 nos studio. Tüm hakları saklıdır.
                    </div>
                </div>
            </section>
        </main>
        <!-- JavaScript dosyalarını dahil et -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/click-scroll.js"></script>
        <script src="js/custom.js"></script>
    </body>
    </html>