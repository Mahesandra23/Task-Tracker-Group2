<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_tracker";

$conn = new mysqli($servername, $username, $password, $dbname, 3306);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$gender = $_POST['gender'];

$check_email_query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($check_email_query);
$stmt->bind_param("s", $email);
$stmt->execute();
$check_email_result = $stmt->get_result();

if ($check_email_result->num_rows > 0) {
    echo "<script>alert('Email sudah digunakan.')</script>";
    echo '<script type="text/javascript">window.location.href = "signup.php";</script>';
} else {
    // Email belum terdaftar, lakukan penyisipan data
    $insert_query = "INSERT INTO users (first_name, last_name, email, password, gender) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insert_query);
$stmt->bind_param("sssss", $first_name, $last_name, $email, $password, $gender);


    if ($stmt->execute()) {
        echo "<script>alert('Pendaftaran Berhasil. Anda akan diarahkan ke halaman utama.')</script>";
        header("Location: login.php");
    } else {
        echo "Terjadi kesalahan saat mendaftar. Silakan coba lagi.";
    }
}

$stmt->close();
$conn->close();
?>
