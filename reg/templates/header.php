<html>

<head>
<link rel="stylesheet" href="/css/styles.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<script>
    function confirmDelete() {
        return confirm("ถอนรายวิชาใช่หรือไม่");
    }
    function confirmlogin() {
        return confirm("เข้าสู่ระบบใช่หรือไม่");
    }
    function confirmRegis() {
        return confirm("ลงทะเบียนใช่หรือไม่");
    }
</script>


<body>
    <header class="h-1">
        <h1>ระบบลงทะเบียนเรียน</h1>
        <nav class="nav">
            <a href="/main">หน้าแรก</a>
            <?php
            if (isset($_SESSION['timestamp'])) {
            ?>
                <a href="/profile">ข้อมูลนักเรียน</a>
                <a href="/courses">รายวิชา</a>
                <a href="/logout">ออกจากระบบ</a>
            <?php
            } else {
            ?>
                <a href="/login">เข้าสู่ระบบ</a>
                <!-- <a href="/insert">รหัสใหม่</a> -->
            <?php
            }
            ?>
        </nav>
    </header>
    