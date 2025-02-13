<?php
include 'db_connect.php'; // เชื่อมต่อกับฐานข้อมูล
require_once 'student.php';


if (isset($_POST['submit'])) {
    // รับค่าจากฟอร์มและสร้างอ็อบเจ็กต์ Student
    $students = new Student($_POST['id'],
        $_POST['prefix'],
        $_POST['fname'],
        $_POST['lname'],
        intval($_POST['year']),  // แปลงเป็น int
        $_POST['birthday'],
        floatval($_POST['gpa'])  // แปลงเป็น float
    );

    if (!empty($students->id)) {
        // อัปเดตข้อมูลในฐานข้อมูล
        $sql = "UPDATE student SET prefix = ?, fname = ?, lname = ?, year = ?, birthday = ?, gpa = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssissd', 
            $students->prefix, 
            $students->fname, 
            $students->lname, 
            $students->year, 
            $students->birthday, 
            $students->gpa,
            $students->id  // ย้ายไปตำแหน่งสุดท้าย
        );

        if ($stmt->execute()) {
            // เปลี่ยนเส้นทางไปยังหน้า showdata.php เมื่ออัปเดตสำเร็จ
            header("Location: showdata.php");
            exit();
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>
                alert('ไม่มีรหัสนิสิตที่ถูกส่งมา!');
                window.location.href='showdata.php';
              </script>";
    }
}

$conn->close();
?>
