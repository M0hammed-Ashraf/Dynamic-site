<?php
// ===== db_config.php (include inline for demo) =====
// In production: separate this into db_config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'blog_db');
define('DB_USER', 'root');       // change for your host
define('DB_PASS', '');           // change for your host

function getDB() {
    try {
        $pdo = new PDO(
            "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8",
            DB_USER, DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return $pdo;
    } catch (PDOException $e) {
        // For demo: return null if no DB
        return null;
    }
}

// Fetch posts from DB (or use demo data)
function getPosts($pdo, $limit = 6) {
    if (!$pdo) {
        return [
            ['id'=>1,'title'=>'Getting Started with Web Dev','excerpt'=>'A beginner\'s guide to HTML, CSS, and JavaScript.','category'=>'Tutorial','created_at'=>'2025-01-15','author'=>'Admin'],
            ['id'=>2,'title'=>'PHP & MySQL for Beginners','excerpt'=>'Learn how to build dynamic websites using PHP and MySQL.','category'=>'Backend','created_at'=>'2025-01-20','author'=>'Admin'],
            ['id'=>3,'title'=>'Deploying to InfinityFree','excerpt'=>'Step-by-step guide to host your PHP website for free.','category'=>'Deployment','created_at'=>'2025-01-25','author'=>'Admin'],
            ['id'=>4,'title'=>'Responsive Design Tips','excerpt'=>'Make your website look great on all screen sizes.','category'=>'Design','created_at'=>'2025-02-01','author'=>'Admin'],
            ['id'=>5,'title'=>'Firebase Hosting Guide','excerpt'=>'Deploy your static site to Firebase in minutes.','category'=>'Deployment','created_at'=>'2025-02-05','author'=>'Admin'],
            ['id'=>6,'title'=>'GitHub Pages Tutorial','excerpt'=>'Host your portfolio on GitHub Pages for free.','category'=>'Tutorial','created_at'=>'2025-02-10','author'=>'Admin'],
        ];
    }
    $stmt = $pdo->prepare("SELECT id, title, excerpt, category, created_at, author FROM posts ORDER BY created_at DESC LIMIT 6");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$pdo   = getDB();

$posts = getPosts($pdo);
$total = count($posts);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>DevBlog – Web Development Articles</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg: #f7f4ef;
      --card: #ffffff;
      --dark: #111111;
      --accent: #e84e2a;
      --accent2: #2a6ee8;
      --border: #e0dcd4;
      --muted: #888;
      --text: #222;
    }

    body { background: var(--bg); color: var(--text); font-family: 'Inter', sans-serif; }

    /* NAV */
    nav {
      background: var(--dark);
      padding: 1rem 3rem;
      display: flex; justify-content: space-between; align-items: center;
      position: sticky; top: 0; z-index: 100;
    }
    .logo {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.4rem;
      color: #fff;
      text-decoration: none;
    }
    .logo span { color: var(--accent); }
    nav ul { list-style: none; display: flex; gap: 1.5rem; align-items: center; }
    nav a { color: #aaa; text-decoration: none; font-size: 0.9rem; transition: color 0.2s; }
    nav a:hover { color: #fff; }
    .nav-btn {
      background: var(--accent);
      color: #fff !important;
      padding: 0.4rem 1rem;
      border-radius: 5px;
      font-weight: 500;
    }
    .nav-btn:hover { background: #d43f1b !important; }

    /* HERO */
    .hero {
      background: var(--dark);
      color: #fff;
      padding: 5rem 3rem;
      text-align: center;
      position: relative; overflow: hidden;
    }
    .hero::before {
      content: '';
      position: absolute; inset: 0;
      background: repeating-linear-gradient(
        45deg, transparent, transparent 40px,
        rgba(232,78,42,0.03) 40px, rgba(232,78,42,0.03) 41px
      );
    }
    .hero-inner { position: relative; z-index: 1; max-width: 700px; margin: 0 auto; }
    .hero-tag {
      display: inline-block;
      background: var(--accent);
      color: #fff;
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      padding: 0.3rem 0.9rem;
      border-radius: 3px;
      margin-bottom: 1.5rem;
    }
    .hero h1 {
      font-family: 'Syne', sans-serif;
      font-size: clamp(2.2rem, 5vw, 4rem);
      font-weight: 800;
      line-height: 1.1;
      margin-bottom: 1rem;
    }
    .hero p { color: #888; font-size: 1.05rem; margin-bottom: 2rem; }
    .hero-stats {
      display: flex; gap: 3rem; justify-content: center;
      margin-top: 2rem;
    }
    .stat { text-align: center; }
    .stat-num {
      font-family: 'Syne', sans-serif;
      font-size: 2rem;
      font-weight: 800;
      color: var(--accent);
    }
    .stat-label { font-size: 0.8rem; color: #666; }

    /* SEARCH BAR */
    .search-bar {
      background: var(--card);
      border-bottom: 1px solid var(--border);
      padding: 1rem 3rem;
      display: flex; gap: 1rem; align-items: center;
    }
    .search-bar input {
      flex: 1;
      padding: 0.6rem 1rem;
      border: 1px solid var(--border);
      border-radius: 6px;
      font-family: 'Inter', sans-serif;
      font-size: 0.9rem;
      background: var(--bg);
      outline: none;
      transition: border-color 0.2s;
    }
    .search-bar input:focus { border-color: var(--accent); }
    .filter-btns { display: flex; gap: 0.5rem; flex-wrap: wrap; }
    .filter-btn {
      padding: 0.4rem 0.9rem;
      border: 1px solid var(--border);
      border-radius: 99px;
      background: transparent;
      font-size: 0.8rem;
      cursor: pointer;
      font-family: 'Inter', sans-serif;
      transition: all 0.2s;
    }
    .filter-btn:hover, .filter-btn.active {
      background: var(--accent);
      border-color: var(--accent);
      color: #fff;
    }

    /* POSTS */
    .posts-section { padding: 3rem; max-width: 1200px; margin: 0 auto; }
    .section-title {
      font-family: 'Syne', sans-serif;
      font-size: 1.6rem;
      font-weight: 700;
      margin-bottom: 2rem;
      display: flex; align-items: center; gap: 0.8rem;
    }
    .section-title::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border);
    }
    .posts-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
      gap: 1.5rem;
    }
    .post-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 10px;
      overflow: hidden;
      transition: all 0.25s;
    }
    .post-card:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,0.08); border-color: var(--accent); }
    .post-thumb {
      height: 160px;
      background: linear-gradient(135deg, #1a1a1a 0%, #333 100%);
      display: flex; align-items: center; justify-content: center;
      font-size: 3rem;
    }
    .post-body { padding: 1.4rem; }
    .post-meta {
      display: flex; align-items: center; gap: 0.8rem;
      margin-bottom: 0.8rem;
    }
    .post-cat {
      background: rgba(232,78,42,0.1);
      color: var(--accent);
      padding: 0.2rem 0.7rem;
      border-radius: 3px;
      font-size: 0.75rem;
      font-weight: 500;
    }
    .post-date { color: var(--muted); font-size: 0.8rem; }
    .post-body h3 {
      font-family: 'Syne', sans-serif;
      font-size: 1.1rem;
      font-weight: 700;
      margin-bottom: 0.6rem;
      line-height: 1.3;
    }
    .post-body p { font-size: 0.88rem; color: var(--muted); line-height: 1.6; margin-bottom: 1rem; }
    .post-footer {
      display: flex; justify-content: space-between; align-items: center;
      padding-top: 0.8rem;
      border-top: 1px solid var(--border);
    }
    .post-author { font-size: 0.8rem; color: var(--muted); }
    .read-more {
      font-size: 0.82rem;
      color: var(--accent);
      text-decoration: none;
      font-weight: 500;
    }
    .read-more:hover { text-decoration: underline; }

    /* NEWSLETTER */
    .newsletter {
      background: var(--dark);
      color: #fff;
      padding: 4rem 3rem;
      text-align: center;
      margin-top: 3rem;
    }
    .newsletter h2 {
      font-family: 'Syne', sans-serif;
      font-size: 2rem;
      font-weight: 800;
      margin-bottom: 0.8rem;
    }
    .newsletter p { color: #888; margin-bottom: 2rem; }
    .newsletter form {
      display: flex; gap: 0.8rem; justify-content: center; max-width: 480px; margin: 0 auto;
    }
    .newsletter input {
      flex: 1;
      padding: 0.8rem 1.2rem;
      border: none;
      border-radius: 6px;
      font-family: 'Inter', sans-serif;
      font-size: 0.95rem;
      outline: none;
    }
    .newsletter button {
      padding: 0.8rem 1.5rem;
      background: var(--accent);
      color: #fff;
      border: none;
      border-radius: 6px;
      font-family: 'Syne', sans-serif;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.2s;
    }
    .newsletter button:hover { background: #d43f1b; }

    /* FOOTER */
    footer {
      background: #0a0a0a;
      color: #555;
      text-align: center;
      padding: 1.5rem;
      font-size: 0.85rem;
    }

    @media (max-width: 640px) {
      nav { padding: 1rem 1.2rem; }
      nav ul { display: none; }
      .hero, .posts-section { padding: 3rem 1.2rem; }
      .search-bar { padding: 1rem 1.2rem; flex-direction: column; }
    }
  </style>
</head>
<body>

  <nav>
    <a href="index.php" class="logo">Dev<span>Blog</span></a>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="posts.php">Articles</a></li>
      <li><a href="admin/login.php" class="nav-btn">Admin →</a></li>
    </ul>
  </nav>

  <section class="hero">
    <div class="hero-inner">
      <span class="hero-tag">📚 Web Development Blog</span>
      <h1>Learn, Build &amp; Deploy<br/>Modern Websites</h1>
      <p>Tutorials, tips, and guides for web developers at every level.</p>
      <div class="hero-stats">
        <div class="stat">
          <div class="stat-num"><?= $total ?>+</div>
          <div class="stat-label">Articles</div>
        </div>
        <div class="stat">
          <div class="stat-num">3</div>
          <div class="stat-label">Categories</div>
        </div>
        <div class="stat">
          <div class="stat-num">Free</div>
          <div class="stat-label">Always</div>
        </div>
      </div>
    </div>
  </section>

  <div class="search-bar">
    <input type="text" placeholder="🔍  Search articles..." id="searchInput" oninput="filterPosts()"/>
    <div class="filter-btns">
      <button class="filter-btn active" onclick="filterCat(this,'all')">All</button>
      <button class="filter-btn" onclick="filterCat(this,'Tutorial')">Tutorial</button>
      <button class="filter-btn" onclick="filterCat(this,'Backend')">Backend</button>
      <button class="filter-btn" onclick="filterCat(this,'Deployment')">Deployment</button>
      <button class="filter-btn" onclick="filterCat(this,'Design')">Design</button>
    </div>
  </div>

  <div class="posts-section">
    <h2 class="section-title">Latest Articles</h2>
    <div class="posts-grid" id="postsGrid">
      <?php
      $emojis = ['🌐','🔧','🚀','🎨','☁️','📦'];
      foreach ($posts as $i => $post):
        $emoji = $emojis[$i % count($emojis)];
        $date  = date('M j, Y', strtotime($post['created_at']));
      ?>
      <div class="post-card" data-cat="<?= htmlspecialchars($post['category']) ?>">
        <div class="post-thumb"><?= $emoji ?></div>
        <div class="post-body">
          <div class="post-meta">
            <span class="post-cat"><?= htmlspecialchars($post['category']) ?></span>
            <span class="post-date"><?= $date ?></span>
          </div>
          <h3><?= htmlspecialchars($post['title']) ?></h3>
          <p><?= htmlspecialchars($post['excerpt']) ?></p>
          <div class="post-footer">
            <span class="post-author">By <?= htmlspecialchars($post['author']) ?></span>
            <a href="post.php?id=<?= $post['id'] ?>" class="read-more">Read More →</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="newsletter">
    <h2>Stay Updated</h2>
    <p>Get the latest articles delivered straight to your inbox.</p>
    <form onsubmit="subscribeNewsletter(event)">
      <input type="email" placeholder="your@email.com" required/>
      <button type="submit">Subscribe</button>
    </form>
  </div>

  <footer>
    <p>© <?= date('Y') ?> DevBlog &nbsp;·&nbsp; Built with PHP &amp; MySQL &nbsp;·&nbsp; All rights reserved</p>
  </footer>

  <script>
    let currentCat = 'all';

    function filterCat(btn, cat) {
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentCat = cat;
      filterPosts();
    }

    function filterPosts() {
      const q = document.getElementById('searchInput').value.toLowerCase();
      document.querySelectorAll('.post-card').forEach(card => {
        const title = card.querySelector('h3').textContent.toLowerCase();
        const cat   = card.dataset.cat;
        const matchQ = title.includes(q);
        const matchC = currentCat === 'all' || cat === currentCat;
        card.style.display = (matchQ && matchC) ? '' : 'none';
      });
    }

    function subscribeNewsletter(e) {
      e.preventDefault();
      alert('✅ Subscribed! Thank you.');
      e.target.reset();
    }
  </script>

</body>
</html>
