<?php

$student_id = (int)$_POST['student_id'];
$course_id = (int)$_POST['course_id'];

if (isset($_POST['enroll'])) {
    if (enrollCourse($student_id, $course_id)) {
        $data = ['alert' => 'ลงทะเบียนสำเร็จ'];
        echo "ลงทะเบียนสำเร็จ";
    } else {
        $data = ['alert' => 'มีวิชานี้อยู่ในรายการลงทะเบียนแล้ว'];
    }
}

    header('Location: /profile');
    exit;
?>