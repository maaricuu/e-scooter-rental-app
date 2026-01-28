<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === "zaposleni@gmail.com" && $password === "zaposleni123") {               //Usmeravanje korisnika i zaposlenih
        header("Location: interni.php");
        exit();
    } else {
        $_SESSION['user_email'] = $email;
        header("Location: pocetna.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="CSS/indexStyle.css">
</head>
<body>
  <div class="login-wrapper">
    <div class="login-card">
      <h1>Login</h1>
      <form method="POST" action="">
        <div class="form-group">
          <label for="email">Email</label>
          <input id="email" type="email" name="email" placeholder="ime@gmail.com" required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input id="password" type="password" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit">Prijava</button>
      </form>
    </div>
  </div>
</body>

</html>
