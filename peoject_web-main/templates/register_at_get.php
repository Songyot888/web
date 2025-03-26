<?php require_once 'header.php' ?>
<?php
if (isset($_GET['eid'])) {
    $eid = $_GET['eid'];
    $event = getEventById($eid);
    $eventImages = getEventImage($eid);
    $count = countParticipants($eid);

    $joined_event_ids = []; // กำหนดเป็นอาร์เรย์ว่างก่อน

    if (isset($_SESSION['User_id'])) {
        $joined_events = getUserJoinedEvents($_SESSION['User_id']);
        if (!empty($joined_events)) {
            $joined_event_ids = array_map(function ($event) {
                return $event['Event_id'];
            }, $joined_events);
        }
    }
} else {
    echo "ไม่ได้รับ eid";
}
?>

<style>
body {
    background: linear-gradient(135deg, #a6c8ff, #e1f0ff);
    color: #333;
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

section {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 80px 20px;
    height: 100vh;
}

.regis-at-container {
    background: rgba(255, 255, 255, 0.95);
    padding: 40px;
    border-radius: 15px;
    width: 100%;
    max-width: 1000px;
    box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease;
    animation: fadeIn 1s ease-out;
}

.regis-at-container:hover {
    transform: translateY(-5px);
}

h1 {
    font-size: 3.5rem;
    margin-bottom: 30px;
    color: #4a90e2;
    font-weight: bold;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.activity-container {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
    transition: all 0.3s ease-in-out;
}

.activity-image-container {
    display: flex;
    overflow-x: auto;
    scroll-behavior: smooth;
    max-width: 100%;
    padding: 10px;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.activity-image {
    flex: 0 0 auto;
    margin-right: 10px;
    border-radius: 15px;
}

.activity-image img {
    width: 300px;
    height: auto;
    object-fit: cover;
    transition: transform 0.3s ease;
    border-radius: 15px;
}

.activity-image img:hover {
    transform: scale(1.1);
}

.activity-details {
    color: #333;
    text-align: left;
    flex: 1;
    max-width: 500px;
}

.activity-description {
    font-size: 1.4rem;
    margin-bottom: 20px;
    line-height: 1.6;
    color: #555;
}

.status-container {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.status-text {
    font-size: 1.2rem;
    margin: 0;
    color: #777;
}

.status-dot {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: inline-block;
}

.status-dot.green {
    background-color: #28a745;
}

.register-button, .back-button {
    padding: 15px 30px;
    font-size: 1.2rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s ease;
    text-transform: uppercase;
    font-weight: 600;
    width: 100%;
    margin-top: 20px;
}

.register-button {
    background-color: #4a90e2;
    color: white;
    box-shadow: 0px 6px 12px rgba(74, 144, 226, 0.5);
}

.register-button:hover {
    background-color: #007bb5;
    transform: translateY(-5px);
    box-shadow: 0px 12px 24px rgba(74, 144, 226, 0.6);
}

.back-button {
    background-color: #95a5a6;
    color: white;
    box-shadow: 0px 6px 12px rgba(149, 165, 166, 0.5);
}

.back-button:hover {
    background-color: #7f8c8d;
    transform: translateY(-5px);
    box-shadow: 0px 12px 24px rgba(149, 165, 166, 0.6);
}

@media (max-width: 768px) {
    .activity-container {
        flex-direction: column;
        padding: 20px;
    }

    .activity-image img {
        width: 100%;
        height: 100%;
    }

    .register-button, .back-button {
        width: 100%;
        padding: 12px 25px;
        font-size: 1rem;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<section>
    <div class="regis-at-container">
        <h1><?php echo $event['Eventname']; ?></h1>

        <div class="activity-container">
            <div class="activity-image-container" id="carousel">
                <?php
                if (!empty($eventImages['images'])) {
                    foreach ($eventImages['images'] as $image) {
                        echo '<div class="activity-image"><img src="' . $image . '" alt="Activity Image"></div>';
                    }
                } else {
                    echo '<p>No images available for this event.</p>';
                }
                ?>
            </div>

            <div class="activity-details">
                <p class="activity-description">
                    <?php echo $event['description']; ?>
                </p>
                <p class="activity-description">
                    วันเริ่มกิจกรรม :  <?php echo date("d-m-y", strtotime($event['start_date'])); ?>
                </p>
                <p class="activity-description">
                    สิ้นสุดกิจกรรม :  <?php echo date("d-m-y", strtotime($event['end_date'])); ?>
                </p>
                <div class="status-container">
                    <p class="status-text">จำนวนผู้เข้าร่วม: <?php echo $count; ?> / <?php echo $event['Max_participants']; ?></p>
                </div>

                <!-- ตรวจสอบการเข้าร่วมกิจกรรม -->
                <?php if (in_array($event['Event_id'], $joined_event_ids)): ?>
                    <!-- ถ้าเคยเข้าร่วมแล้ว -->
                    <p class="status-text" style="color: red;">คุณได้เข้าร่วมกิจกรรมนี้แล้ว</p>
                <?php else: ?>
                    <!-- ถ้ายังไม่เข้าร่วมให้แสดงปุ่ม "เข้าร่วม" -->
                    <form action="/register_at" method="post">
                        <input type="hidden" name="eid" value="<?= $event['Event_id'] ?>">
                        <button class="register-button">เข้าร่วม</button>
                        <button type="button" class="back-button" onclick="window.location.href='/main'">กลับไปหน้าแรก</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
    // เมื่อเลื่อนแล้วให้การเลื่อนเป็นไปอย่างราบรื่น
    const carousel = document.getElementById('carousel');
    let scrollAmount = 0;

    // ฟังก์ชั่นในการเลื่อนภาพ
    function scrollCarousel(direction) {
        const imageWidth = document.querySelector('.activity-image').offsetWidth;
        if (direction === 'left') {
            scrollAmount -= imageWidth + 10; // เพิ่มค่า 10px สำหรับระยะห่าง
        } else {
            scrollAmount += imageWidth + 10;
        }
        carousel.scrollLeft = scrollAmount;
    }

    // ถ้าเลื่อนซ้าย
    document.getElementById('prevButton').addEventListener('click', function() {
        scrollCarousel('left');
    });

    // ถ้าเลื่อนขวา
    document.getElementById('nextButton').addEventListener('click', function() {
        scrollCarousel('right');
    });
</script>
