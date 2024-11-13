<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Menggunakan MD5 untuk mencocokkan dengan database

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
    
        switch ($user['role']) {
            case 'admin':
                header("Location: admin/index.php");
                break;
            case 'guru':
                header("Location: guru/index.php");
                break;
            case 'wali_kelas':
                header("Location: wali_kelas/index.php");
                break;
        }
    } else {
        $error = "Username atau password salah!";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        /* Menambahkan beberapa aturan CSS tambahan */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .card {
            width: 100%;
            max-width: 700px; /* Perbesar lebar maksimal dari card */
            padding: 5px;    /* Tambahkan padding di dalam card */
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px; /* Tambahkan margin bawah untuk memberi jarak */
        }
        .login-header img {
            max-width: 150px; /* Perbesar ukuran logo */
            margin-bottom: 10px;
        }
        .login-header h1 {
            font-size: 28px; /* Perbesar ukuran font untuk judul */
            font-weight: bold;
        }
        .form-group input {
            font-size: 18px; /* Perbesar ukuran font pada input */
            padding: 15px;   /* Tambahkan padding pada input agar lebih besar */
        }
        .btn {
            font-size: 18px; /* Perbesar ukuran font pada tombol login */
            padding: 15px;   /* Tambahkan padding pada tombol login */
        }
    </style>
</head>
<body class="bg-gradient-primary">
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <!-- Header dengan Judul dan Logo -->
                            <div class="login-header">
                                <h1>LATANSA CENDEKIA</h1>
                                <img src="assets/img/logolatansa.jpg" alt="Logo Latansa Cendekia">
                            </div>
                            <!-- Form Login -->
                            <form method="POST" action="index.php" class="user">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-control-user" placeholder="Enter Username">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                            </form>
                            <?php if (isset($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
