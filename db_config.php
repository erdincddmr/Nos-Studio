    <?php
    $servername = "localhost"; // Veritabanı sunucunuzun adı. Genellikle "localhost"
    $username = "root";       // MySQL kullanıcı adınız. AppServ'de genelde "root"tur.
    $password = "12345678";           // MySQL şifreniz. AppServ'de genelde boş (password yok) veya sizin belirlediğiniz şifredir.
    $dbname = "nos_studio";    // Bir önceki adımda oluşturduğunuz veritabanının adı.

    // Veritabanı bağlantısı oluştur
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Bağlantıyı kontrol et (Bir sorun olursa hatayı gösterir)
    if ($conn->connect_error) {
        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
    }
    ?>