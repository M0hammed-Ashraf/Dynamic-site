<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'blog_db');
define('DB_USER', 'root');
define('DB_PASS', '');

try {

    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8",
        DB_USER,
        DB_PASS
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {

    die("Database connection failed");

}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");

$stmt->execute([$id]);

$post = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$post){
    die("Post not found");
}

$date = date('M j, Y', strtotime($post['created_at']));

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($post['title']) ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet"/>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        :root{
            --bg:#f7f4ef;
            --card:#ffffff;
            --dark:#111111;
            --accent:#e84e2a;
            --border:#e0dcd4;
            --muted:#777;
        }

        body{
            background:var(--bg);
            font-family:'Inter',sans-serif;
            color:#222;
        }

        nav{
            background:var(--dark);
            padding:1rem 3rem;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .logo{
            text-decoration:none;
            color:#fff;
            font-family:'Syne',sans-serif;
            font-size:1.4rem;
            font-weight:800;
        }

        .logo span{
            color:var(--accent);
        }

        .back-btn{
            color:#aaa;
            text-decoration:none;
            transition:0.2s;
        }

        .back-btn:hover{
            color:#fff;
        }

        .container{
            max-width:900px;
            margin:3rem auto;
            padding:0 1.5rem;
        }

        .post-card{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:14px;
            overflow:hidden;
            box-shadow:0 10px 30px rgba(0,0,0,0.05);
        }

        .hero{
            height:260px;
            background:linear-gradient(135deg,#111,#333);
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:5rem;
        }

        .content{
            padding:2rem;
        }

        .category{
            display:inline-block;
            background:rgba(232,78,42,0.1);
            color:var(--accent);
            padding:0.35rem 0.8rem;
            border-radius:5px;
            font-size:0.8rem;
            margin-bottom:1rem;
            font-weight:600;
        }

        h1{
            font-family:'Syne',sans-serif;
            font-size:2.4rem;
            line-height:1.2;
            margin-bottom:1rem;
        }

        .meta{
            color:var(--muted);
            margin-bottom:2rem;
            font-size:0.9rem;
        }

        .post-text{
            line-height:1.9;
            font-size:1.05rem;
            color:#444;
        }

        .back-home{
            display:inline-block;
            margin-top:2rem;
            background:var(--accent);
            color:#fff;
            text-decoration:none;
            padding:0.8rem 1.4rem;
            border-radius:8px;
            transition:0.2s;
        }

        .back-home:hover{
            background:#d8431f;
        }

        @media(max-width:700px){

            nav{
                padding:1rem 1.2rem;
            }

            h1{
                font-size:1.8rem;
            }

            .hero{
                height:180px;
                font-size:3rem;
            }

            .content{
                padding:1.3rem;
            }

        }

    </style>

</head>

<body>

    <nav>

        <a href="index.php" class="logo">
            Dev<span>Blog</span>
        </a>

        <a href="index.php" class="back-btn">
            ← Back
        </a>

    </nav>

    <div class="container">

        <div class="post-card">

            <div class="hero">
                <?= htmlspecialchars($post['title'][0]) ?>
            </div>

            <div class="content">

                <span class="category">
                    <?= htmlspecialchars($post['category']) ?>
                </span>

                <h1>
                    <?= htmlspecialchars($post['title']) ?>
                </h1>

                <div class="meta">
                    By <?= htmlspecialchars($post['author']) ?>
                    •
                    <?= $date ?>
                </div>

                <div class="post-text">

                    <?= nl2br(htmlspecialchars($post['excerpt'])) ?>

                    <br><br>

                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Repellendus dolores quaerat vitae voluptatem numquam
                    exercitationem accusamus fugit quia error aliquid.

                </div>

                <a href="index.php" class="back-home">
                    ← Back To Home
                </a>

            </div>

        </div>

    </div>

</body>

</html>