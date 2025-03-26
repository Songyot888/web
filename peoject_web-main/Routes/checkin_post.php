<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['checkin_image'])) {
    $event_id = $_POST['event_id'];
    $image = $_FILES['checkin_image'];

    // การตรวจสอบภาพ
    $image_name = basename($image['name']);
    $image_tmp = $image['tmp_name'];
    $image_size = $image['size'];
    $image_error = $image['error'];

    if ($image_error === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . $image_name;
        if (move_uploaded_file($image_tmp, $target_file)) {
            echo "อัพโหลดภาพสำเร็จ!";
            // บันทึกข้อมูลเช็คอินในฐานข้อมูล
            // updateCheckinStatus($event_id, $user_id, $target_file);
        } else {
            echo "เกิดข้อผิดพลาดในการอัพโหลดภาพ";
        }
    }
}
?>