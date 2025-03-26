<?php require_once 'header.php'; ?>
<?php

if (!isset($_SESSION['User_id'])) {
    header('Location: /login');
    exit;
}

$user_id = $_SESSION['User_id'];
$user = getUserById($user_id);
$joined_events = getUserJoinedEvents($user_id);
?>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fa;
        color: #333;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 50px;
        width: 100%;
        max-width: 900px;
        background-color: #ffffff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .checkin-section {
        width: 100%;
        text-align: center;
        margin-top: 30px;
    }

    .checkin-title {
        font-size: 2em;
        color: #007bff;
        margin-bottom: 20px;
    }

    .checkin-card {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        max-width: 600px;
        margin: 0 auto;
    }

    .checkin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.2);
    }

    .checkin-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: center;
    }

    .checkin-form input[type="file"] {
        border: none;
        padding: 10px;
        border-radius: 10px;
        background-color: #f7f7f7;
        cursor: pointer;
        font-size: 1.1em;
    }

    .checkin-form button {
        padding: 12px 25px;
        background-color: #28a745;
        color: white;
        font-size: 1.1em;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        box-shadow: 0px 4px 10px rgba(40, 167, 69, 0.3);
    }

    .checkin-form button:hover {
        background-color: #218838;
        transform: scale(1.05);
        box-shadow: 0px 10px 20px rgba(40, 167, 69, 0.5);
    }

    .image-preview {
        margin-top: 20px;
        max-width: 100%;
        max-height: 300px;
        border-radius: 10px;
        border: 2px solid #ddd;
        object-fit: cover;
    }

    .back-button {
        padding: 12px 25px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 1.1em;
        margin-top: 30px;
    }

    .back-button:hover {
        background-color: #0056b3;
    }
</style>

<section>
    <div class="container">
        <div class="checkin-section">
            <h2 class="checkin-title">เช็คอินกิจกรรมของคุณ</h2>

            <?php if (!empty($joined_events)): ?>
                <?php foreach ($joined_events as $event): ?>
                    <?php if ($event['status'] === 'approved' && $event['check_in'] == 0): ?>
                        <div class="checkin-card">
                            <h3><?php echo htmlspecialchars($event['Eventname']); ?></h3>
                            <form class="checkin-form" action="/checkin_action" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="event_id" value="<?= $event['Event_id']; ?>">
                                <label for="checkin_image">อัพโหลดภาพเช็คอิน:</label>
                                <input type="file" id="checkin_image" name="checkin_image" accept="image/*" required onchange="previewImage(event)">
                                <button type="submit">เช็คอิน</button>
                            </form>

                            <!-- แสดงภาพที่อัพโหลด -->
                            <div id="image-preview-container">
                                <img id="image-preview" class="image-preview" src="" alt="ภาพที่อัพโหลด">
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>คุณยังไม่ได้เข้าร่วมกิจกรรมใด ๆ</p>
            <?php endif; ?>
        </div>

        <!-- ปุ่มกลับไปหน้า Main -->
        <button onclick="window.location.href='/main'" class="back-button">กลับไปหน้าแรก</button>
    </div>
</section>

<script>
    // ฟังก์ชันสำหรับแสดงตัวอย่างภาพที่อัพโหลด
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.getElementById('image-preview');
            preview.src = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['checkin_image'])) {
    $event_id = $_POST['event_id'];
    $image = $_FILES['checkin_image'];

    // การตรวจสอบภาพ
    $image_name = basename($image['name']);
    $image_tmp = $image['tmp_name'];
    $image_size = $image['size'];
    $image_error = $image['error'];

    if ($image_error === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . $image_name;
        if (move_uploaded_file($image_tmp, $target_file)) {
            echo "อัพโหลดภาพสำเร็จ!";
            // บันทึกข้อมูลเช็คอินในฐานข้อมูล
            // updateCheckinStatus($event_id, $user_id, $target_file);
        } else {
            echo "เกิดข้อผิดพลาดในการอัพโหลดภาพ";
        }
    }
}
?>

</section>
