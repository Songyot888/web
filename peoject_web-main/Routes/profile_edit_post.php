<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $uid = $_POST['uid'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $birthday = $_POST['birthday'] ?? ''; 

    $image = $_FILES['image'] ?? null;
    // var_dump($_FILES['image']);
    // exit();

    if (empty($birthday)) {
        $birthday = null; 
    }

    // เรียกฟังก์ชัน updateUser
    $result = updateUser($username, $email, $phone, $address, $birthday, $image, $uid);

    if ($result) {
        header('Location: /profile');
    } else {
        header('Location: /profile');
    }
}
?>
