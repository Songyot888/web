<?php
    $result = getStudentById($_SESSION['student_id']);
    renderView('main_get',[ 'student' => $result ]);
?>