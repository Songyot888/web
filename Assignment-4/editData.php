<?php
    require_once 'StudentManager.php';

    $studentManager = new StudentManager();

    if (!isset($_SESSION['edit_student']) || !isset($_SESSION['edit_index'])) {
        header('Location: showData.php');
        exit();
    }

    $student = $_SESSION['edit_student'];
    $index = $_SESSION['edit_index'];

    if (isset($_POST['update'])) {
        $data = [
            'id' => $_POST['id'],
            'prefix' => $_POST['prefix'],
            'fname' => $_POST['fname'],
            'lname' => $_POST['lname'],
            'year' => $_POST['year'],
            'gpa' => $_POST['gpa'],
            'birthday' => $_POST['birthday']
        ];
        $studentManager->editStudent($index, $data);
        unset($_SESSION['edit_student']);
        unset($_SESSION['edit_index']);
        header('Location: showData.php');
        exit();
    }

    function getValue($field) {
        global $student;
        return htmlspecialchars($student[$field]);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/ad.css">
</head>
<body>
    <div class="area d-flex justify-content-center align-items-center">
        <div class="login-container p-4 rounded-4 w-100 fw-bold">
            <h1 class="mb-1 fw-bold text-center">แก้ไขข้อมูลนิสิต</h1>
            <form action="editData.php" method="post">
                <!-- ข้อมูลที่จะส่งออกไปแบบ post -->
                <div class="mb-1">
                    <label for="inputId" class="form-label">รหัสนิสิต</label>
                    <input class="form-control rounded-5" type="text" name="id" value="<?php echo getValue('id'); ?>">
                </div>

                <div class="mb-1">
                    <label for="inputPrefix" class="form-label">คำนำหน้า</label>
                    <select class="form-control rounded-5" name="prefix">
                        <option value="นาย" <?php if ($student['prefix'] == 'นาย') echo 'selected'; ?>>นาย</option>
                        <option value="นางสาว" <?php if ($student['prefix'] == 'นางสาว') echo 'selected'; ?>>นางสาว</option>
                    </select>
                </div>

                <div class="mb-1">
                    <label for="inputFname" class="form-label">ชื่อ</label>
                    <input type="text" class="form-control rounded-5" name="fname" value="<?php echo getValue('fname'); ?>">
                </div>

                <div class="mb-1">
                    <label for="inputLname" class="form-label">นามสกุล</label>
                    <input type="text" class="form-control rounded-5" name="lname" value="<?php echo getValue('lname'); ?>">
                </div>

                <div class="mb-1">
                    <label for="inputYear" class="form-label">ปีการศึกษา</label>
                    <select class="form-control rounded-5" name="year">
                        <option value="1" <?php if ($student['year'] == '1') echo 'selected'; ?>>ปี 1</option>
                        <option value="2" <?php if ($student['year'] == '2') echo 'selected'; ?>>ปี 2</option>
                        <option value="3" <?php if ($student['year'] == '3') echo 'selected'; ?>>ปี 3</option>
                        <option value="4" <?php if ($student['year'] == '4') echo 'selected'; ?>>ปี 4</option>
                    </select>
                </div>

                <div class="mb-1">
                    <label for="inputGpa" class="form-label">เกรดเฉลี่ย</label>
                    <input type="text" class="form-control rounded-5" name="gpa" value="<?php echo getValue('gpa'); ?>">
                </div>

                <div class="mb-1">
                    <label for="inputBirthday" class="form-label">วันเกิด</label>
                    <input type="date" class="form-control rounded-5" name="birthday" value="<?php echo getValue('birthday'); ?>">
                </div>

                <div class="mt-2 d-flex justify-content-lg-between">
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
