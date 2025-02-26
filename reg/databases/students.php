<?php

function getStudents(): mysqli_result|bool
{
    $conn = getConnection();
    $sql = 'select * from students';
    $result = $conn->query($sql);
    return $result;
}

function getStudentById(int $id): array|bool
{
    $conn = getConnection();
    $sql = 'select * from students where student_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        return false;
    }
    return $result->fetch_assoc();
}

function updatePassword($new_password, $student_id): void {

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE students SET password = ? WHERE student_id = ?"; // ใช้ ? แทนพารามิเตอร์
    try {
        $conn = getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $hashed_password,$student_id); 

        $stmt->execute();

        echo "รหัสผ่านถูกอัปเดตสำเร็จ!";
    } catch(PDOException $e) {
        echo "เกิดข้อผิดพลาด: " . $e->getMessage();
    }
}

function getUserDataByEmail($email) {
    // สร้างการเชื่อมต่อฐานข้อมูล (กรุณาใช้ฟังก์ชันการเชื่อมต่อที่เหมาะสม)
    $conn = getConnection();

    $sql = "SELECT * FROM students WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->fetch_assoc(); // คืนค่าข้อมูลผู้ใช้เป็นอาร์เรย์
}

