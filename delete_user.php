<?php
session_start();
include 'db_config.php';

// Kullanıcı giriş yapmamışsa veya admin değilse giriş sayfasına yönlendir
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Kullanıcı ID'si gelip gelmediğini kontrol et
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Kendisini silmeye çalışmasını engelle
    if ($user_id == $_SESSION['user_id']) {
        $_SESSION['message'] = "<div class=\"alert alert-danger\">Kendi hesabınızı silemezsiniz!</div>";
        header("Location: admin_panel.php");
        exit();
    }

    // Kullanıcıyı veritabanından sil
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "<div class=\"alert alert-success\">Kullanıcı başarıyla silindi.</div>";
    } else {
        $_SESSION['message'] = "<div class=\"alert alert-danger\">Kullanıcı silinirken bir hata oluştu: " . $stmt->error . "</div>";
    }
    $stmt->close();
} else {
    $_SESSION['message'] = "<div class=\"alert alert-warning\">Silinecek kullanıcı ID'si belirtilmedi.</div>";
}

$conn->close();

header("Location: admin_panel.php");
exit();
?> 