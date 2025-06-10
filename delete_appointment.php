<?php
session_start();
include 'db_config.php';

// Kullanıcı giriş yapmamışsa veya admin değilse giriş sayfasına yönlendir
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$appointment_id = $_GET['id'] ?? null;
$user_id = null;

// Randevu ID'si belirtilmemişse veya geçersizse geri yönlendir
if (!$appointment_id || !is_numeric($appointment_id)) {
    $_SESSION['message'] = "<div class=\"alert alert-danger\">Geçersiz randevu ID'si.</div>";
    header("Location: admin_panel.php");
    exit();
}

// Silinecek randevunun user_id'sini al, böylece geri dönüş için kullanabiliriz
try {
    $stmt_fetch_user_id = $conn->prepare("SELECT user_id FROM appointments WHERE id = ?");
    if ($stmt_fetch_user_id === false) {
        throw new Exception("Kullanıcı ID sorgusu hazırlama hatası: " . $conn->error);
    }
    $stmt_fetch_user_id->bind_param("i", $appointment_id);
    $stmt_fetch_user_id->execute();
    $result_fetch_user_id = $stmt_fetch_user_id->get_result();
    $appointment_data = $result_fetch_user_id->fetch_assoc();
    $stmt_fetch_user_id->close();

    if ($appointment_data) {
        $user_id = $appointment_data['user_id'];
    } else {
        $_SESSION['message'] = "<div class=\"alert alert-danger\">Randevu bulunamadı.</div>";
        header("Location: admin_panel.php");
        exit();
    }
} catch (Exception $e) {
    $_SESSION['message'] = "<div class=\"alert alert-danger\">" . $e->getMessage() . "</div>";
    header("Location: admin_panel.php");
    exit();
}

// Randevuyu sil
try {
    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
    if ($stmt === false) {
        throw new Exception("SQL silme sorgusu hazırlama hatası: " . $conn->error);
    }
    $stmt->bind_param("i", $appointment_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "<div class=\"alert alert-success\">Randevu başarıyla silindi.</div>";
    } else {
        $_SESSION['message'] = "<div class=\"alert alert-danger\">Randevu silinirken bir hata oluştu: " . $stmt->error . "</div>";
    }
    $stmt->close();
} catch (Exception $e) {
    $_SESSION['message'] = "<div class=\"alert alert-danger\">" . $e->getMessage() . "</div>";
}

$conn->close();

// Randevuların listelendiği sayfaya geri yönlendir
if ($user_id) {
    header("Location: view_user_appointments.php?user_id=" . htmlspecialchars($user_id));
} else {
    header("Location: admin_panel.php");
}
exit();
?> 