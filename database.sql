-- =============================================
--  DevBlog Database Setup
--  Run this in phpMyAdmin or MySQL CLI
-- =============================================


-- Posts table
CREATE TABLE IF NOT EXISTS posts (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(255)  NOT NULL,
    excerpt     TEXT          NOT NULL,
    content     LONGTEXT      NOT NULL,
    category    VARCHAR(100)  DEFAULT 'General',
    author      VARCHAR(100)  DEFAULT 'Admin',
    created_at  DATETIME      DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Subscribers table
CREATE TABLE IF NOT EXISTS subscribers (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    email      VARCHAR(255) UNIQUE NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Admin users table
CREATE TABLE IF NOT EXISTS admins (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(100) UNIQUE NOT NULL,
    password   VARCHAR(255) NOT NULL,  -- hashed with password_hash()
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- Sample Data
-- =============================================

INSERT INTO posts (title, excerpt, content, category, author) VALUES
(
  'Getting Started with Web Development',
  'A beginner guide to HTML, CSS, and JavaScript.',
  '<p>Welcome to the world of web development! In this article we cover the fundamentals of HTML, CSS, and JavaScript to help you build your first website.</p><p>Start with HTML to structure your content, then CSS to style it, and finally JavaScript to make it interactive.</p>',
  'Tutorial', 'Admin'
),
(
  'PHP & MySQL for Beginners',
  'Learn how to build dynamic websites using PHP and MySQL.',
  '<p>PHP is a powerful server-side scripting language. Combined with MySQL, you can create dynamic, data-driven websites. We will walk you through creating your first database and connecting it to your PHP application.</p>',
  'Backend', 'Admin'
),
(
  'Deploying to InfinityFree',
  'Step-by-step guide to host your PHP website for free.',
  '<p>InfinityFree offers free hosting with PHP and MySQL support. In this guide, you will learn how to upload your files using the file manager or FTP, set up your database, and go live in minutes.</p>',
  'Deployment', 'Admin'
),
(
  'Responsive Design Tips',
  'Make your website look great on all screen sizes.',
  '<p>Responsive design ensures your website looks great on mobile, tablet, and desktop. Use CSS media queries, flexible grids, and relative units to achieve a fully responsive layout.</p>',
  'Design', 'Admin'
),
(
  'Firebase Hosting Guide',
  'Deploy your static site to Firebase in minutes.',
  '<p>Firebase Hosting provides fast and secure hosting for your web apps. With a simple CLI command, you can deploy your site to a global CDN. We will walk through the setup process step by step.</p>',
  'Deployment', 'Admin'
),
(
  'GitHub Pages Tutorial',
  'Host your portfolio on GitHub Pages for free.',
  '<p>GitHub Pages lets you host static websites directly from a GitHub repository. It is perfect for portfolios, documentation, and project pages. This guide shows you how to set it up in under 10 minutes.</p>',
  'Tutorial', 'Admin'
);

-- Default admin (username: admin, password: admin123)
-- IMPORTANT: Change this password before deploying!
INSERT INTO admins (username, password) VALUES
('admin', 'abc123');

-- =============================================
-- Done! Open phpMyAdmin to verify the data.
-- =============================================
