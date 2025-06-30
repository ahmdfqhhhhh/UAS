<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="icon" type="image/png" href="logostruk.png">
  <style>
    body {
      background: #f0f0f0;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .register-box {
      background: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
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
      background: #28a745;
      color: white;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }
    input[type="submit"]:hover {
      background: #218838;
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
    .success {
      color: green;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<div class="register-box">
  <h2>Register</h2>
  <form method="POST" action="register.php">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" name="register" value="Daftar">
  </form>
  <div class="link">
    Sudah punya akun? <a href="login.php">Login di sini</a>
  </div>

  <?php
  if (isset($_POST['register'])) {
      include 'koneksi.php';
      $username = $_POST['username'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

      $cek = mysqli_query($koneksi, "SELECT * FROM login WHERE username='$username'");
      if (mysqli_num_rows($cek) > 0) {
          echo '<div class="error">Username sudah terdaftar!</div>';
      } else {
          $query = mysqli_query($koneksi, "INSERT INTO login (username, password) VALUES ('$username', '$password')");
          if ($query) {
              echo '<div class="success">Pendaftaran berhasil! <a href="login.php">Login</a></div>';
          } else {
              echo '<div class="error">Gagal mendaftar: ' . mysqli_error($koneksi) . '</div>';
          }
      }
  }
  ?>
</div>

</body>
</html>
