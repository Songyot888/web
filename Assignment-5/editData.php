<?php
include 'db_connect.php'; // เชื่อมต่อกับฐานข้อมูล
require_once 'check_login.php';

if(!isset($_SESSION['username'])){
    header("Location: login.html");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // ดึงข้อมูลจากฐานข้อมูล
    $sql = "SELECT * FROM student WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
} else {
    $data = []; // กำหนดให้เป็นอาร์เรย์เปล่าเพื่อป้องกันข้อผิดพลาด
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
    <div class="m-3">
        <nav>
            <a href="login.html" class="btn btn-danger">ออกจากระบบ</a>
        </nav>
    </div>
    <div class="area d-flex justify-content-center align-items-center">
        <div class="login-container p-4 rounded-4 w-100 fw-bold">
            <h1 class="mb-1 fw-bold text-center ">เพิ่มข้อมูลนิสิตใหม่</h1>

            <form action="update.php" method="post">
                <!-- ข้อมูลที่จะส่งออกไปแบบ post -->
                <div class="mb-1">
                    <label for="inputUsername" class="form-label">รหัสนิสิต</label>
                    <input class="form-control rounded-5" type="text" name="id_display" placeholder="รหัสนิสิต" 
                        value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>" readonly>
                    <input type="hidden" name="id" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>">
                 </div>

                <div class="mb-1">
                    <label for="inputUsername" class="form-label">คำนำหน้า</label>
                    <label for="inputGmail5" class="fname form-label" >ชื่อ</label>
                    <label for="inputGmail5" class="lname form-label">นามสกุล</label>
                    <div class="d-flex align-items-center">
                        <select class="tp form-control rounded-5" name="prefix">
                            <option value="นาย" <?php if ($data['prefix'] === "นาย") echo "selected"; ?>>นาย</option>
                            <option value="นางสาว" <?php if ($data['prefix'] === "นางสาว") echo "selected"; ?>>นางสาว</option>

                        </select>
                        <div class="input-fname">
                            <input type="text" class="a1 form-control rounded-5" name="fname" placeholder="ชื่อ" value="<?php echo $data['fname']; ?>">
                        </div>
                        <div class="input-gmail1">
                            <input type="text" class="a2 form-control rounded-5" name="lname" placeholder="นามสกุล" value="<?php echo $data['lname']; ?>">
                        </div>
                    </div>

                </div>

                <div class="mb-1">
                    <label for="inputPassword5" class="form-label">ชั้นปี</label>
                    <label for="inputPassword5" class="texth1 form-label">month/day/year</label>
                    <label for="inputPassword5" class="texth2 form-label">เกรดเฉลี่ย</label>
                    <div class="d-flex align-items-center">
                        <select class="a3  form-control rounded-5" name="year" ">
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
                            <input type="date" class="a4 form-control rounded-5" name="birthday"  value="<?php echo $data['birthday']; ?>">
                        </div>
                        <div class="d-flex align-items-center">
                            <input type="text" name="gpa" class="a5 form-control rounded-5"  placeholder="เกรดเฉลี่ย" value="<?php echo $data['gpa']; ?>">
                        </div>
                        
                    </div>
                </div>
             <div class="mt-2 d-flex justify-content-lg-between">
                <button type="submit" name="submit" class="btn btn-primary">update</button>
                <!-- <button type="submit" name="summit1" class="btn btn-primary">กลับไปหน้าแรก</button> -->
             </div>
             
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
