<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="icon" type="image/png" href="logostruk.png">
  <style>
    body {
      background: #f5f5f5;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      height: 100vh;
      justify-content: center;
      align-items: center;
    }
    .login-box {
      background: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }
    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 30px;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    input[type="submit"] {
      background: #007BFF;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }
    input[type="submit"]:hover {
      background: #0056b3;
    }
    .link {
      text-align: center;
      margin-top: 15px;
    }
    .link a {
      color: #007BFF;
      text-decoration: none;
    }
    .error {
      color: red;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2>Silahkan login terlebih dahulu supaya bisa melihat detail barang</h2>
  <form method="POST" action="login.php">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" name="login" value="Login">
  </form>
  <div class="link">
    Belum punya akun? <a href="register.php">Daftar di sini</a>
  </div>
  <?php
  session_start();
  if (isset($_POST['login'])) {
      include 'koneksi.php';
      $username = $_POST['username'];
      $password = $_POST['password'];
      $result = mysqli_query($koneksi, "SELECT * FROM login WHERE username='$username'");
      $data = mysqli_fetch_assoc($result);
      if ($data && password_verify($password, $data['password'])) {
          $_SESSION['username'] = $data['username'];
          header("Location: databarang.php");
          exit;
      } else {
          echo '<div class="error">Login gagal. Username atau password salah.</div>';
      }
  }
  ?>
</div>

</body>
</html>
