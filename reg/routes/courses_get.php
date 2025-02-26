<?php


$result = getCourses();
$courses = getCourses();
$student_id = $_SESSION['student_id']; // ตรวจสอบให้แน่ใจว่า session มีค่า student_id

renderView('courses_get', [
    'courses' => $courses,
    'student_id' => $student_id
]);