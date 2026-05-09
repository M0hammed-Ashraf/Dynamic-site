<?php
$pdo = new PDO(
    "mysql:host=localhost;dbname=blog_db;charset=utf8",
    "root",
    "",
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

$posts = $pdo->query("SELECT id, title, excerpt FROM posts ORDER BY created_at DESC")
             ->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Articles</title>

<style>
body{
    font-family: Arial;
    background:#f5f5f5;
    margin:0;
}

.container{
    max-width:900px;
    margin:40px auto;
    padding:0 15px;
}

.card{
    background:#fff;
    padding:20px;
    margin-bottom:15px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.card h2{
    margin:0 0 10px;
}

.card a{
    display:inline-block;
    margin-top:10px;
    color:#e84e2a;
    text-decoration:none;
    font-weight:bold;
}
</style>
</head>

<body>

<div class="container">

<h1>📚 Articles</h1>

<?php foreach ($posts as $post): ?>

    <div class="card">
        <h2><?= htmlspecialchars($post['title']) ?></h2>

        <p><?= htmlspecialchars($post['excerpt']) ?></p>

        <a href="post.php?id=<?= $post['id'] ?>">
            Read More →
        </a>
    </div>

<?php endforeach; ?>
<a href="index.php" style="
    display:inline-block;
    margin-top:20px;
    padding:10px 15px;
    background:#e84e2a;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    font-weight:bold;
">
    ← Back to Home
</a>
</div>

</body>
</html>
