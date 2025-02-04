<?php
    session_start();

    if (isset($_POST['delete'])) {
        $index = $_POST['index'];
        if (isset($_SESSION['students'][$index])) {
            unset($_SESSION['students'][$index]);
            $_SESSION['students'] = array_values($_SESSION['students']); // รีเซ็ตคีย์ของอาร์เรย์
        }
    }

    if (isset($_POST['edit'])) {
        $index = $_POST['index'];
        if (isset($_SESSION['students'][$index])) {
            $_SESSION['edit_student'] = $_SESSION['students'][$index];
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <div class="area d-flex justify-content-center align-items-center">
        <div class="login-container p-4 rounded-4 w-100 fw-bold">
            <h1 class="mb-3 fw-bold text-center">Data Student</h1>
            <a href="addData.php" class="btn btn-info">เพิ่มข้อมูลนิสิต</a>
            <form method="post">
                <div class="mb-2">
                <?php
                    if (isset($_SESSION['students']) && count($_SESSION['students']) > 0) {
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
                        foreach ($_SESSION['students'] as $index => $student) {
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
                                            <button type='submit' name='delete' class='btn btn-danger'>ลบ</button>
                                        </form>
                                        <form method='post' style='display:inline;'>
                                            <input type='hidden' name='index' value='$index'>
                                            <button type='submit' name='edit' class='btn btn-warning'>แก้ไข</button>
                                        </form>
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