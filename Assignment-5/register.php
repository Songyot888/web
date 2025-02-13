<?php
include 'db_connect.php';
require_once 'student.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // ตรวจสอบว่ามีข้อมูลที่ส่งมาหรือไม่
    if (!empty($_POST['Username']) && !empty($_POST['Gmail']) && !empty($_POST['Password'])) {
        // รับค่าจากฟอร์ม
        $username = $_POST['Username'];
        $email = $_POST['Gmail'];
        $password_hash = password_hash($_POST['Password'], PASSWORD_DEFAULT);

        // ตรวจสอบว่าชื่อผู้ใช้ซ้ำหรือไม่
        $check_sql = 'SELECT * FROM register WHERE Username = ?';
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param('s', $username);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>
                    alert('ชื่อผู้ใช้นี้มีอยู่ในระบบแล้ว!');
                    window.location.href='register.html';
                  </script>";
        } else {
            // สร้างอ็อบเจ็กต์ Account และเพิ่มข้อมูลลงในฐานข้อมูล
            $sql = 'INSERT INTO register (Username, Email, Password) VALUES (?, ?, ?)';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sss', $username, $email, $password_hash);

            if ($stmt->execute()) {
                // ไปหน้า Login ถ้าสมัครสำเร็จ
                header('Location: login.html');
                exit();
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการสมัครสมาชิก');</script>";
            }
            $stmt->close();
        }
        $check_stmt->close();
    } else {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน');</script>";
    }

    $conn->close();
}
?>
