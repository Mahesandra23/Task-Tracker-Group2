<?php
session_start();
include "koneksi.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5" data-aos="fade-up">
        <div class="card p-3 shadow" data-aos="fade">
            <h2 class="text-center">Login</h2>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <p class="text-center mt-3">
                Don't have an account? <a href="signup.php">Sign Up</a>
            </p>

            <?php
            if ($connection->connect_error) {
                die("Koneksi database gagal: " . $connection->connect_error);
            }

            $stmt = null; // Declare $stmt outside the conditional block
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST["email"];
                $password = $_POST["password"];

                $stmt = $connection->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $user = $result->fetch_assoc();
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['user_id'] = $user['user_id'];
                        $_SESSION['user_email'] = $user['email'];
                        header("Location: index.php");
                    } else {
                        echo "<script>alert('Password yang Anda masukan salah! Silahkan coba lagi.')</script>";
                        echo '<script type="text/javascript">window.location.href = "login.php";</script>';
                    }
                } else {
                    echo "<script>alert('Akun tidak ditemukan! Silahkan coba lagi.')</script>";
                    echo '<script type="text/javascript">window.location.href = "login.php";</script>';
                }
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            offset: 120,
        });
    </script>
</body>

</html>
