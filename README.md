# 📰 DevBlog – Dynamic Blog Website

A dynamic blog built with PHP and MySQL, featuring an admin panel for managing posts.

## 📋 Purpose

A full-featured blog with server-side rendering, database integration, and admin functionality. Deployed on InfinityFree and another free hosting service.

## 🛠 Technologies Used

- PHP 7.4+
- MySQL / MariaDB
- HTML5 / CSS3 / JavaScript
- PDO (PHP Data Objects)
- Sessions for admin auth
- Google Fonts (Syne, Inter)

## 🚀 Live URLs

- **InfinityFree:** `https://YOUR_SUBDOMAIN.infinityfreeapp.com`
- **Second Host:** `https://YOUR_SITE.000webhostapp.com` (or similar)

## 💻 Run Locally

### Prerequisites

- XAMPP / WAMP / MAMP (includes Apache + PHP + MySQL)

### Steps

```bash
1. Copy project folder to: htdocs/ (XAMPP) or www/ (WAMP)
2. Open phpMyAdmin → Import database.sql
3. Edit index.php: set DB_USER and DB_PASS
4. Visit: http://localhost/dynamic-site/
```

## 📁 File Structure

```
dynamic-site/
├── index.php           ← Homepage with blog posts
├── Posts.php           ← Displays all posts
├── post.php            ← Single post view
├── database.sql        ← DB schema + sample data
├── admin/
│   ├── login.php       ← Admin login page
│   ├── dashboard.php   ← Admin dashboard
│   └── logout.php      ← Logout handler
└── README.md
```

## 🔑 Admin Login (default)

- Username: `admin`
- Password: `abc123`
- ⚠️ Change before deploying to production!

## 🔧 Deploy to InfinityFree

1. Register at infinityfree.net
2. Create a hosting account & note the MySQL credentials
3. Update DB_HOST, DB_NAME, DB_USER, DB_PASS in index.php
4. Upload files via File Manager or FTP (FileZilla)
5. Import database.sql via phpMyAdmin in InfinityFree panel
