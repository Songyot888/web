<?php
include 'db_connect.php';
require_once 'student.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // ตรวจสอบว่ามีข้อมูลที่ส่งมาหรือไม่
    if (!empty($_POST['Username']) && !empty($_POST['Gmail']) && !empty($_POST['Password'])) {
        // เข้ารหัสรหัสผ่านก่อนบันทึก
        $password_hash = password_hash($_POST['Password'], PASSWORD_DEFAULT);

        // สร้างอ็อบเจ็กต์ Account
        $account = new Account($_POST['Username'], $_POST['Gmail'], $password_hash);

        // ตรวจสอบว่าชื่อผู้ใช้ซ้ำหรือไม่
        $sql = 'INSERT INTO register (Username, Password) VALUES (?, ?)';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $username, $password_hash);
        $stmt->execute();

        if ($check_stmt->num_rows > 0) {
            echo "<script>
                    alert('ชื่อผู้ใช้นี้มีอยู่ในระบบแล้ว!');
                    window.location.href='register.html';
                  </script>";
        } else {
            // เพิ่มข้อมูลลงในฐานข้อมูล
            $sql = 'INSERT INTO register (Username, Email, Password) VALUES (?, ?, ?)';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sss', 
                $account->Username, 
                $account->Email, 
                $account->Password
            );
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
