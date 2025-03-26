<?php
// ในไฟล์ update_event_post.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['User_id'])) {
        $uid = $_SESSION['User_id']; // รับ uid จาก session
    } else {
        $data['alert'] = "กรุณาเข้าสู่ระบบก่อนแก้ไขกิจกรรม";
        echo $data['alert'];
        exit;
    }
    var_dump($_POST['eid']);
    // ตรวจสอบว่ามี eid หรือไม่
    if (!isset($_POST['eid'])) {
        $data['alert'] = "ไม่พบ ID กิจกรรม";
        echo $data['alert'];
        exit;
    }

    $eid = $_POST['eid']; // รับ eid จาก form

    $eventname = $_POST['activity-name'];
    $activityDetails = $_POST['description'];
    $max_participants = $_POST['participants'];
    $sdate = $_POST['start-date'];
    $edate = $_POST['end-date'];

    $result = updateEvent($eid, $eventname, $max_participants,  $sdate, $edate, $activityDetails);

    if ($result) {
        $data['alert'] = "แก้ไขกิจกรรมสำเร็จ";
        header('Location: /profile');
    } else {
        header('Location: /profile');
        $data['alert'] = "แก้ไขกิจกรรมไม่สำเร็จ";
        echo $data['alert'];
    }
} else {
    $data['alert'] = "Invalid request";
    echo $data['alert'];
}


?>