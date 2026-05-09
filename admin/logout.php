<?php
session_start();

// مسح كل بيانات الجلسة
session_unset();
session_destroy();

// رجوع لصفحة اللوجين
header("Location: login.php");
exit;