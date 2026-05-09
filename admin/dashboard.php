<?php
session_start();

// حماية الصفحة (مينفعش تدخل بدون login)
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// DB connection
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=blog_db;charset=utf8",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // جلب عدد المقالات
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM posts");
    $totalPosts = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

} catch (PDOException $e) {
    die("DB Error");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet"/>

<style>
body {
    margin:0;
    font-family:'Inter',sans-serif;
    background:#111;
    color:#fff;
}

header {
    background:#1a1a1a;
    padding:1rem 2rem;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #333;
}

.logo {
    font-family:'Syne',sans-serif;
    font-size:1.3rem;
    font-weight:800;
}

.logo span { color:#e84e2a; }

.container {
    padding:2rem;
}

.cards {
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:1rem;
}

.card {
    background:#1a1a1a;
    padding:1.5rem;
    border-radius:10px;
    border:1px solid #333;
}

.card h2 {
    margin-bottom:0.5rem;
    color:#e84e2a;
}

a.button {
    display:inline-block;
    margin-top:2rem;
    background:#e84e2a;
    color:#fff;
    padding:0.7rem 1.2rem;
    text-decoration:none;
    border-radius:6px;
}

a.button:hover {
    background:#d43f1b;
}
</style>

</head>

<body>

<header>
    <div class="logo">Dev<span>Blog</span> Admin</div>

    <div>
        <a href="logout.php" style="color:#aaa;text-decoration:none;">Logout</a>
    </div>
</header>

<div class="container">

    <h1>Welcome Admin 👋</h1>
    <p>Here is your dashboard overview</p>

    <div class="cards">

        <div class="card">
            <h2><?= $totalPosts ?></h2>
            <p>Total Posts</p>
        </div>

        <div class="card">
            <h2>1</h2>
            <p>Admins</p>
        </div>

        <div class="card">
            <h2>OK</h2>
            <p>Status</p>
        </div>

    </div>

    <a class="button" href="../index.php">View Blog</a>

</div>

</body>
</html>