<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kayıt Ol - Nos Studio</title>
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
        session_start();
        include 'db_config.php';

        $message = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                $message = '<div class="alert alert-danger">Tüm alanları doldurun!</div>';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = '<div class="alert alert-danger">Geçerli bir e-posta adresi girin!</div>';
            } elseif ($password !== $confirm_password) {
                $message = '<div class="alert alert-danger">Şifreler eşleşmiyor!</div>';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
                $stmt->bind_param("sss", $username, $email, $hashed_password);

                if ($stmt->execute()) {
                    $message = '<div class="alert alert-success">Kaydınız başarıyla oluşturuldu! Giriş yapabilirsiniz.</div>';
                } else {
                    if ($conn->errno == 1062) {
                        $message = '<div class="alert alert-danger">Bu kullanıcı adı zaten alınmış. Lütfen başka bir tane deneyin.</div>';
                    } else {
                        $message = '<div class="alert alert-danger">Kayıt olurken bir hata oluştu: ' . $stmt->error . '</div>';
                    }
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
                        <h2>Kayıt Ol</h2>
                        <?php echo $message; ?>
                        <form action="register.php" method="post" class="custom-form contact-form" role="form">
                            <div class="form-floating mb-3">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Kullanıcı Adı" required>
                                <label for="username">Kullanıcı Adı</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" id="email" class="form-control" placeholder="E-posta Adresi" required>
                                <label for="email">E-posta Adresi</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Şifre" required>
                                <label for="password">Şifre</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Şifre Tekrar" required>
                                <label for="confirm_password">Şifre Tekrar</label>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Kayıt Ol</button>
                        </form>
                        <p class="text-center mt-3">Hesabın var mı? <a href="login.php">Giriş Yap</a></p>
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