<?php
include 'db_connect.php';
require_once 'student.php';

// ดึงข้อมูลจากฐานข้อมูล
$sql_student = 'SELECT * FROM student';
$result = $conn->query($sql_student);

$students = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}
// ตรวจสอบการส่งฟอร์มเพิ่มข้อมูล
if (isset($_POST['submit'])) {
    $students = new Student($_POST['id'],
                            $_POST['prefix'],
                            $_POST['fname'],
                            $_POST['lname'],
                            $_POST['year'],
                            $_POST['birthday'],
                            $_POST['gpa']);

    $id = $students->id;

    // ตรวจสอบว่ารหัสนิสิตซ้ำหรือไม่
    $check_sql = 'SELECT id FROM student WHERE id = ?';
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param('s', $id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<script>
                alert('รหัสนิสิตนี้มีอยู่ในระบบแล้ว! กรุณากรอกรหัสอื่น');
                window.location.href='showdata.php';
              </script>";
        exit();
    }

    $check_stmt->close();

    // เพิ่มข้อมูลลงในฐานข้อมูล
    $sql = 'INSERT INTO student(id, prefix, fname, lname, year, birthday, gpa) VALUES (?, ?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssisd', 
        $students->id, 
        $students->prefix, 
        $students->fname, 
        $students->lname, 
        $students->year, 
        $students->birthday, 
        $students->gpa
    );
    
    if ($stmt->execute()) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>
                alert('เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $stmt->error . "');
              </script>";
    }

    $stmt->close();
    $check_stmt->close();
}
    

// ตรวจสอบการลบข้อมูล
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = 'DELETE FROM student WHERE id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();

    // รีเฟรชหน้าเว็บเพื่อแสดงข้อมูลใหม่
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/login1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <nav class="btn-group ">
                <a href="index.html" class="btn fs-5 fw-bold  ">Home</a>
                <a href="showAccount.html" class="btn fs-5 fw-semibold">Profile</a>
                <a href="EditProfile.html" class="btn fs-5 fw-semibold">Edit Profile</a>
    </nav>
    <div class="area d-flex justify-content-center align-items-center">
        <div class="login-container p-4 rounded-4 w-100 fw-bold">
            <h1 class="mb-3 fw-bold text-center">Data Student</h1>
            <a href="addData.html" class="btn btn-info">เพิ่มข้อมูลนิสิต</a>
            <form method="post">
                <div class="mb-2">
                <?php
                    if (count($students) > 0) {
                        echo "<table class='table table-hover'>";
                        echo "<tr>
                                <th>รหัสนิสิต</th>
                                <th>คำนำหน้า</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>ชั้นปี</th>
                                <th>เกรดเฉลี่ย</th>
                                <th>วันเกิด</th>
                                <th>จัดการข้อมูล</th>
                              </tr>";
                        foreach ($students as $student) {
                            echo "<tr>
                                    <td>{$student['id']}</td>
                                    <td>{$student['prefix']}</td>
                                    <td>{$student['fname']}</td>
                                    <td>{$student['lname']}</td>
                                    <td>{$student['year']}</td>
                                    <td>{$student['gpa']}</td>
                                    <td>{$student['birthday']}</td>
                                    <td>
                                        <form  method='post' style='display:inline;'>
                                            <input type='hidden' name='id' value='{$student['id']}'>
                                            <button type='submit' name='delete' class='btn btn-danger'>ลบ</button>
                                        </form>
                                        <a href='editData.php?id={$student['id']}' class='btn btn-warning'>แก้ไข</a>
                                    </td>
                                  </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<div class='hd mb-3 fw-bold text-center'>ยังไม่มีข้อมูลนิสิต</div>";
                    }
                ?>
                </div>
            </form>
        </div>
    </div>
</body>
</html>