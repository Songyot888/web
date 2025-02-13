<?php
session_start();  // เริ่มต้น session

// ล้างข้อมูล session และทำลาย session
session_unset();
session_destroy();

header('Location: login.html');
exit();
?>