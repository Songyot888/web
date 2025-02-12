<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    // ตรวจสอบว่ามีผู้ใช้ในฐานข้อมูลหรือไม่
    $sql = 'SELECT Password FROM register WHERE Username = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    // ถ้าไม่มีข้อมูลในฐานข้อมูล
    if ($stmt->num_rows == 0) {
        echo "<script>
                alert('ไม่มีบัญชีผู้ใช้นี้ กรุณาสมัครสมาชิกก่อน!');
                window.location.href='register.html';
              </script>";
        exit();
    }

    $stmt->bind_result($stored_password);
    $stmt->fetch();

    // ตรวจสอบรหัสผ่าน
    if (password_verify($password, $stored_password)) {
        echo "<script>
                alert('เข้าสู่ระบบสำเร็จ!');
                window.location.href='addData.html';
              </script>";
    } else {
        echo "<script>
                alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!');
                window.location.href='login.html';
              </script>";
    }
    
    $stmt->close();
}
?>
