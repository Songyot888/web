<?php
   if (isset($_POST['new_password']) && isset($_POST['student_id'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_password = $_POST['new_password'];
        $student_id = $_POST['student_id'];
        updatePassword($new_password, $student_id);
        
    }
    // ดำเนินการต่อ
} else {
    echo "ข้อมูลที่จำเป็นไม่ครบถ้วน";
}