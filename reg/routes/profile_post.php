<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['student_id']) && isset($_POST['course_id'])) {
        $student_id = $_POST['student_id'];
        $course_id = $_POST['course_id'];

        // เรียกใช้ฟังก์ชัน dropCourse() เพื่อลบการลงทะเบียน
        if (dropCourse($student_id, $course_id)) {
            $_SESSION['message'] = 'ถอนวิชาสำเร็จ';
        } else {
            $_SESSION['message'] = 'เกิดข้อผิดพลาดในการถอนวิชา';
        }
        header('Location: /profile');
        exit();
    } else {
        $_SESSION['message'] = 'ข้อมูลไม่ครบถ้วน';
    }
    
}

