    <?php
    session_start(); // Oturumu başlat

    // Tüm oturum değişkenlerini sil
    $_SESSION = array();

    // Oturum çerezini sil. Bu, oturumun kalıcı olarak silinmesini sağlar.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Oturumu tamamen yok et
    session_destroy();

    // Kullanıcıyı giriş sayfasına veya ana sayfaya yönlendir
    header("Location: login.php"); // Veya "index.php" yönlendirebilirsiniz
    exit();
    ?>