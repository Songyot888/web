<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่า email และ password ถูกส่งมาหรือไม่
    if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูลตามอีเมล
        $user_data = getUserDataByEmail($email);
        $result = getStudentById($_SESSION['student_id']);


        if ($user_data) {
            $hashed_password = $user_data['password']; 

            if (password_verify($password, $hashed_password)) {
                // รหัสผ่านถูกต้อง
                $_SESSION['timestamp'] = time();
                $_SESSION['student_id'] = $user_data['student_id']; 
                renderView('main_get', ['student' => $result]);
            } else {
                // รหัสผ่านไม่ถูกต้อง
                $_SESSION['message'] = 'Email or Password invalid';
                renderView('login_get');
                unset($_SESSION['message']);
            }
        } else {
            // ไม่พบผู้ใช้ในฐานข้อมูล
            $_SESSION['message'] = 'Email not found';
            renderView('login_get');
            unset($_SESSION['message']);
        }
    } else {
        $_SESSION['message'] = 'Please enter your email and password';
        renderView('login_get');
        unset($_SESSION['message']);
    }
} else {
    // ถ้าไม่ใช่การส่งฟอร์ม POST
    $_SESSION['message'] = 'Invalid request method';
    renderView('login_get');
    unset($_SESSION['message']);
}