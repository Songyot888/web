<?php
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
