<?php
session_start();
if (isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // DB connection
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=blog_db;charset=utf8", 'root', '',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if  ($admin && $password === $admin['password'])  {
            $_SESSION['admin'] = $admin['id'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    } catch (PDOException $e) {
        $error = 'Database connection failed. Check db_config.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Admin Login – DevBlog</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      min-height: 100vh;
      background: #111;
      display: flex; align-items: center; justify-content: center;
      font-family: 'Inter', sans-serif;
    }
    .box {
      background: #1a1a1a;
      border: 1px solid #2a2a2a;
      border-radius: 14px;
      padding: 2.5rem;
      width: 100%; max-width: 420px;
    }
    .logo {
      font-family: 'Syne', sans-serif;
      font-size: 1.6rem;
      font-weight: 800;
      color: #fff;
      text-align: center;
      margin-bottom: 0.3rem;
    }
    .logo span { color: #e84e2a; }
    .subtitle { text-align: center; color: #555; font-size: 0.88rem; margin-bottom: 2rem; }
    label { display: block; color: #aaa; font-size: 0.85rem; margin-bottom: 0.4rem; }
    input[type=text], input[type=password] {
      width: 100%;
      padding: 0.75rem 1rem;
      background: #111;
      border: 1px solid #333;
      border-radius: 7px;
      color: #fff;
      font-family: 'Inter', sans-serif;
      font-size: 0.95rem;
      margin-bottom: 1.2rem;
      outline: none;
      transition: border-color 0.2s;
    }
    input:focus { border-color: #e84e2a; }
    .error {
      background: rgba(232,78,42,0.1);
      border: 1px solid rgba(232,78,42,0.3);
      color: #e84e2a;
      padding: 0.7rem 1rem;
      border-radius: 7px;
      font-size: 0.85rem;
      margin-bottom: 1.2rem;
    }
    button {
      width: 100%;
      padding: 0.85rem;
      background: #e84e2a;
      color: #fff;
      border: none;
      border-radius: 7px;
      font-family: 'Syne', sans-serif;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
    }
    button:hover { background: #d43f1b; }
    .back { text-align: center; margin-top: 1.2rem; }
    .back a { color: #555; font-size: 0.85rem; text-decoration: none; }
    .back a:hover { color: #fff; }
  </style>
</head>
<body>
  <div class="box">
    <div class="logo">Dev<span>Blog</span></div>
    <p class="subtitle">Admin Panel Login</p>

    <?php if ($error): ?>
      <div class="error">⚠ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="admin" required/>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="••••••••" required/>

      <button type="submit">Login →</button>
    </form>

    <div class="back"><a href="../index.php">← Back to Blog</a></div>
  </div>
</body>
</html>