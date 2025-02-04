<?php
    session_start();

    if(isset($_POST['summit'])){
        $id = $_POST['id'];
        $prefix = $_POST['prefix'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $year = $_POST['year'];
        $birthday = $_POST['birthday'];
        $gpa = $_POST['gpa'];

        if (!isset($_SESSION['students'])) {
            $_SESSION['students'] = [];
        }

        $_SESSION['students'][] = [
            'id' => $id,
            'prefix' => $prefix,
            'fname' => $fname,
            'lname' => $lname,
            'year' => $year,
            'gpa' => $gpa,
            'birthday' => $birthday
        ];

        header('Location: showData.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/ad.css">
</head>

<body>


    <div class="area d-flex justify-content-center align-items-center">
        <div class="login-container p-4 rounded-4 w-100 fw-bold">
            <h1 class="mb-1 fw-bold text-center ">เพิ่มข้อมูลนิสิตใหม่</h1>

            <form action="addData.php" method="post">
                <!-- ข้อมูลที่จะส่งออกไปแบบ post -->
                <div class="mb-1">
                    <label for="inputUsername" class="form-label">รหัสนิสิต</label>
                    <input class="form-control rounded-5" type="text" name="id" placeholder="รหัสนิสิต">
                </div>

                <div class="mb-1">
                    <label for="inputUsername" class="form-label">คำนำหน้า</label>
                    <label for="inputGmail5" class="fname form-label" >ชื่อ</label>
                    <label for="inputGmail5" class="lname form-label">นามสกุล</label>
                    <div class="d-flex align-items-center">
                        <select class="tp form-control rounded-5" name="prefix">
                            <option value="นาย">นาย</option>
                            <option value="นางสาว">นางสาว</option>
                        </select>
                        <div class="input-fname">
                            <input type="text" class="a1 form-control rounded-5" name="fname" placeholder="ชื่อ">
                        </div>
                        <div class="input-gmail1">
                            <input type="text" class="a2 form-control rounded-5" name="lname" placeholder="นามสกุล">
                        </div>
                    </div>

                </div>

                <div class="mb-1">
                    <label for="inputPassword5" class="form-label">ชั้นปี</label>
                    <label for="inputPassword5" class="texth1 form-label">month/day/year</label>
                    <label for="inputPassword5" class="texth2 form-label">เกรดเฉลี่ย</label>
                    <div class="d-flex align-items-center">
                        <select class="a3  form-control rounded-5" name="year" >
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                        </select>
                        
                        <div class="d-flex align-items-center">
                            <input type="date" class="a4 form-control rounded-5" name="birthday" >
                        </div>
                        <div class="d-flex align-items-center">
                            <input type="text" name="gpa" class="a5 form-control rounded-5"  placeholder="เกรดเฉลี่ย">
                        </div>
                        
                    </div>
                </div>
             <div class="mt-2 d-flex justify-content-lg-between">
                <button type="submit" name="summit" class="btn btn-primary">เพิ่มข้อมูล</button>
                <button type="submit" name="summit1" class="btn btn-primary">กลับไปหน้าแรก</button>
             </div>
             
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!-- <div class="area d-flex justify-content-center align-items-center">
        <div class="login-container p-4 rounded-4 w-100 fw-bold">
            <h1 class="mb-1 fw-bold text-center">เพิ่มข้อมูลนิสิตใหม่</h1>
            <form action="addData.php" method="post">
                <div class="mb-1">
                    <label for="inputId" class="form-label">รหัสนิสิต</label>
                    <input class="form-control rounded-5" type="text" name="id" placeholder="รหัสนิสิต">
                </div>
                <div class="mb-1">
                    <label for="inputPrefix" class="form-label">คำนำหน้า</label>
                    <select class="form-control rounded-5" name="prefix">
                        <option value="นาย">นาย</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                </div>
                <div class="mb-1">
                    <label for="inputFname" class="form-label">ชื่อ</label>
                    <input type="text" class="form-control rounded-5" name="fname" placeholder="ชื่อ">
                </div>
                <div class="mb-1">
                    <label for="inputLname" class="form-label">นามสกุล</label>
                    <input type="text" class="form-control rounded-5" name="lname" placeholder="นามสกุล">
                </div>
                <div class="mb-1">
                    <label for="inputYear" class="form-label">ปีการศึกษา</label>
                    <input type="text" class="form-control rounded-5" name="year" placeholder="ปีการศึกษา">
                </div>
                <div class="mb-1">
                    <label for="inputGpa" class="form-label">เกรดเฉลี่ย</label>
                    <input type="text" class="form-control rounded-5" name="gpa" placeholder="เกรดเฉลี่ย">
                </div>
                <div class="mb-1">
                    <label for="inputBirthday" class="form-label">วันเกิด</label>
                    <input type="date" class="form-control rounded-5" name="birthday">
                </div>
                <button type="submit" name="summit" class="btn btn-primary">เพิ่มข้อมูล</button>
            </form>
        </div>
    </div> -->