<?php
require_once 'StudentManager.php';
$studentManager = new StudentManager();

if (isset($_POST['delete'])) {
    $index = $_POST['index'];
    $studentManager->deleteStudent($index);
}

if (isset($_POST['edit'])) {
    $index = $_POST['index'];
    $student = $studentManager->getStudent($index);
    if ($student !== null) {
        $_SESSION['edit_student'] = $student;
        $_SESSION['edit_index'] = $index;
        header('Location: editData.php');
        exit();
    }
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <div class="area d-flex justify-content-center align-items-center">
        <div class="login-container p-4 rounded-4 w-100 fw-bold">
            <h1 class="mb-3 fw-bold text-center">Data Student</h1>
            <a href="addData.php" class="btn btn-info mb-3"><i class="fa fa-plus"></i> เพิ่มข้อมูลนิสิต</a>
            
            <?php
                $students = $studentManager->getStudents();
                if (!empty($students)) {
                    echo "<table class='table table-hover text-center'>";
                    echo "<tr >
                            <th>รหัสนิสิต</th>
                            <th>คำนำหน้า</th>
                            <th>ชื่อ</th>
                            <th>นามสกุล</th>
                            <th>ชั้นปี</th>
                            <th>เกรดเฉลี่ย</th>
                            <th>วันเกิด</th>
                            <th>จัดการข้อมูล</th>
                          </tr>";
                    
                    foreach ($students as $index => $student) {
                        if (!is_array($student)) continue;

                        echo "<tr>
                                <td>{$student['id']}</td>
                                <td>{$student['prefix']}</td>
                                <td>{$student['fname']}</td>
                                <td>{$student['lname']}</td>
                                <td>{$student['year']}</td>
                                <td>{$student['gpa']}</td>
                                <td>{$student['birthday']}</td>
                                <td>
                                    <form method='post' style='display:inline;'>
                                        <input type='hidden' name='index' value='$index'>
                                        <button type='submit' name='delete' class='btn btn-danger btn-sm' onclick='return confirm(\"คุณแน่ใจหรือไม่ที่จะลบข้อมูลนี้?\");'>
                                            <i class='fa fa-trash'></i> ลบ
                                        </button>
                                    </form>
                                    <form method='post' style='display:inline;'>
                                        <input type='hidden' name='index' value='$index'>
                                        <button type='submit' name='edit' class='btn btn-warning btn-sm'>
                                            <i class='fa fa-edit'></i> แก้ไข
                                        </button>
                                    </form>
                                    
                                </td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<div class='alert alert-warning text-center'>ยังไม่มีข้อมูลนิสิต</div>";
                }
            ?>
        </div>
    </div>
</body>
</html>
