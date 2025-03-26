<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ;
    $username = $_POST['username'] ;
    $password = $_POST['password'] ;
    $confirm_password = $_POST['confirm_password'] ;
    $gender = $_POST['gender'];

    if ($password !== $confirm_password) {
        echo "❌ รหัสผ่านไม่ตรงกัน";
        exit; 
    }
    // แฮชรหัสผ่านก่อนบันทึก
    // เรียกใช้ฟังก์ชัน register()
    if (register($email, $username, $password,$gender)) {
        $_SESSION['alert'] = 'ลงทะเบียนสำเร็จ';
        randerView('login_get');
    } else {
        echo "❌ เกิดข้อผิดพลาดในการลงทะเบียน";
    }
}
?>