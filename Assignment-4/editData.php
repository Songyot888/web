<?php
    session_start();

    if (!isset($_SESSION['edit_student']) || !isset($_SESSION['edit_index'])) {
        header('Location: showData.php');
        exit();
    }

    $student = $_SESSION['edit_student'];
    $index = $_SESSION['edit_index'];

    if (isset($_POST['update'])) {
        $_SESSION['students'][$index] = [
            'id' => $_POST['id'],
            'prefix' => $_POST['prefix'],
            'fname' => $_POST['fname'],
            'lname' => $_POST['lname'],
            'year' => $_POST['year'],
            'gpa' => $_POST['gpa'],
            'birthday' => $_POST['birthday']
        ];
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
                    <label for="inputUsername" class="form-label">รหัสนิสิต</label>
                    <input class="form-control rounded-5" type="text" name="id" value="<?php echo getValue('id'); ?>">
                </div>

                <div class="mb-1">
                    <label for="inputUsername" class="form-label">คำนำหน้า</label>
                    <label name="fname" for="inputGmail5" class="form-label">ชื่อ</label>
                    <label name="lname" for="inputGmail5" class="form-label">นามสกุล</label>
                    <div class="d-flex align-items-center">
                        <select class="tp form-control rounded-5" name="prefix">
                            <option value="นาย" <?php if ($student['prefix'] == 'นาย') echo 'selected'; ?>>นาย</option>
                            <option value="นางสาว" <?php if ($student['prefix'] == 'นางสาว') echo 'selected'; ?>>นางสาว</option>
                        </select>
                        <div class="input-fname">
                            <input type="text" name="fname" class="a1 form-control rounded-5" placeholder="ชื่อ"  value="<?php echo getValue('fname'); ?>" >
                        </div>
                        <div class="input-gmail1">
                            <input type="text" name="lname" class="a2 form-control rounded-5" placeholder="นามสกุล"  value="<?php echo getValue('lname'); ?>">
                        </div>
                    </div>

                </div>

                <div class="mb-1">
                    <label for="inputPassword5" class="form-label">ชั้นปี</label>
                    <label for="inputPassword5" class="texth1 form-label">month/day/year</label>
                    <label for="inputPassword5" class="texth2 form-label">เกรดเฉลี่ย</label>
                    <div class="d-flex align-items-center">
                        <select class="a3  form-control rounded-5" name="year" >
                        <option value="1" <?php if ($student['year'] == '1') echo 'selected'; ?>>1</option>
                        <option value="2" <?php if ($student['year'] == '2') echo 'selected'; ?>>2</option>
                        <option value="3" <?php if ($student['year'] == '3') echo 'selected'; ?>>3</option>
                        <option value="4" <?php if ($student['year'] == '4') echo 'selected'; ?>>4</option>
                        <option value="5" <?php if ($student['year'] == '1') echo 'selected'; ?>>5</option>
                        <option value="6" <?php if ($student['year'] == '2') echo 'selected'; ?>>6</option>
                        <option value="7" <?php if ($student['year'] == '3') echo 'selected'; ?>>7</option>
                        <option value="8" <?php if ($student['year'] == '4') echo 'selected'; ?>>8</option>
                        </select>
                        
                        <div class="d-flex align-items-center">
                            <input type="date"  class="a4 form-control rounded-5" name="birthday" value="<?php echo htmlspecialchars($student['birthday']); ?>" >
                        </div>
                        <div class="d-flex align-items-center">
                            <input type="text" name="gpa" class="a5 form-control rounded-5" name="gpa" value="<?php echo htmlspecialchars($student['gpa']); ?>">
                        </div>
                        
                    </div>
                </div>
             <div class="mt-2 d-flex justify-content-lg-between">
             <button type="submit" name="update" class="btn btn-primary">Update</button>
             </div>
             
            </form>
        </div>
    </div>
</body>
</html>
