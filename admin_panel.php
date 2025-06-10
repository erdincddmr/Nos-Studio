    <!doctype html>
    <html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Paneli - nos studio Müzik Stüdyosu</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-icons.css" rel="stylesheet">
        <link href="css/templatemo-topic-listing.css" rel="stylesheet">
        <style>
            .admin-container {
                max-width: 800px;
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
            .btn-danger {
                background-color: #dc3545;
                border-color: #dc3545;
            }
            .btn-danger:hover {
                background-color: #c82333;
                border-color: #bd2130;
            }
        </style>
    </head>
    <body id="top">
        <main>
            <?php
            session_start(); // Oturumu başlat
            include 'db_config.php'; // Veritabanı bağlantımızı dahil et

            // Kullanıcı giriş yapmamışsa veya admin değilse giriş sayfasına yönlendir
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
                header("Location: login.php");
                exit();
            }

            $users = [];
            // Tüm kullanıcıları veritabanından çek
            $stmt = $conn->prepare("SELECT id, username, email, role FROM users");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            $stmt->close();
            $conn->close();
            ?>

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
                            <h2>Admin Paneline Hoş Geldiniz, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
                            <div class="card mt-4">
                                <div class="card-body">
                                    <h5 class="card-title">Kullanıcı Adı: <?php echo htmlspecialchars($_SESSION['username']); ?></h5>
                                    <p class="card-text">E-posta: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                                    <p class="card-text">Rol: <?php echo htmlspecialchars($_SESSION['role']); ?></p>
                                    <a href="index.php" class="btn btn-primary">Ana Sayfaya Dön</a>
                                </div>
                            </div>

                            <h3 class="mt-5 mb-3 text-center">Kullanıcı Yönetimi</h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Kullanıcı Adı</th>
                                            <th>E-posta</th>
                                            <th>Rol</th>
                                            <th>Başvurular</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($users)): ?>
                                            <?php foreach ($users as $user): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                                                    <td><a href="view_user_appointments.php?user_id=<?php echo htmlspecialchars($user['id']); ?>" class="btn btn-sm btn-primary">Görüntüle</a></td>
                                                    <td>
                                                        <a href="edit_user.php?id=<?php echo htmlspecialchars($user['id']); ?>" class="btn btn-sm btn-info">Düzenle</a>
                                                        <a href="delete_user.php?id=<?php echo htmlspecialchars($user['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?');">Sil</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Kayıtlı kullanıcı bulunamadı.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mt-4">
                                <a href="logout.php" class="btn btn-danger">Çıkış Yap</a>
                            </div>
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