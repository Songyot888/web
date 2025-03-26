<?php
// ตรวจสอบค่า 'keyword', 'start_date', และ 'end_date' จาก URL
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';  // ถ้ามีคำค้นหาก็ใช้ค่า, ถ้าไม่มีก็เป็นค่าว่าง
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : ''; // วันที่เริ่มต้น
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';     // วันที่สิ้นสุด

// ถ้าไม่มีการกรอกคำค้นหา ให้ดึงข้อมูลทั้งหมดตามช่วงวันที่
if ($keyword == '') {
    // ถ้าไม่มีคำค้น ก็แสดงกิจกรรมทั้งหมดที่ตรงกับช่วงวันที่ที่กำหนด
    $events = getAllEvents($startDate, $endDate); // สมมติว่า getAllEvents คัดกรองกิจกรรมตามวันที่
} else {
    // ถ้ามีคำค้นให้ค้นหาตามคำค้นหา
    $events = getSearchByKeyword($keyword, $startDate, $endDate); // ฟังก์ชันนี้กรองตามคำค้น, วันที่เริ่มต้น, และวันที่สิ้นสุด
}
?>



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7fa;
        margin-top: 80px;
    }

    .container {
        margin-top: 50px;
    }

    /* ปรับปุ่มย้อนกลับให้ตำแหน่งอยู่บนซ้าย */
    .back-button {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 1000;
        /* ให้อยู่บนสุด */
    }

    .event-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .event-card-header {
        background-color: #007bff;
        color: white;
        padding: 15px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .event-card-body {
        padding: 20px;
    }

    .event-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }

    .event-description {
        font-size: 1.1rem;
        color: #555;
    }

    .event-date {
        font-size: 1rem;
        color: #777;
        margin-top: 10px;
    }

    .no-results {
        font-size: 1.2rem;
        color: #dc3545;
        text-align: center;
        margin-top: 50px;
    }
</style>

<div class="container">
    <!-- ปุ่มย้อนกลับจัดตำแหน่งซ้ายบน -->
    <button onclick="window.history.back()" class="btn btn-secondary back-button">Go Back</button>

    <h2 class="mb-4">Search Results</h2>

    <?php if (!empty($events)): ?>
        <!-- แสดงผลกิจกรรมที่ค้นหามา -->
        <?php foreach ($events as $event): ?>
            <div class="event-card">
                <div class="event-card-header">
                    <span><?php echo $event['Eventname']; ?></span>
                </div>
                <div class="event-card-body">
                    <p class="event-description"><?php echo $event['description']; ?></p>
                    <p class="event-date">
                        Start Date: <?php echo $event['start_date']; ?> <br>
                        End Date: <?php echo $event['end_date']; ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-results">
            <p>No events found based on your search criteria.</p>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-rbsA2VBKQGpUFnj46y1c9iUqD+OMwE8lV3qQWth/1lD6D9tGtJ+KjU5Wq5qF3hG5" crossorigin="anonymous"></script>