<?php
// ตรวจสอบเมื่อฟอร์มถูกส่ง
// ตรวจสอบเมื่อฟอร์มถูกส่ง
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    // รับค่าจากฟอร์ม
    $statusData = $_POST['status'];
    $event_id = $_POST['eid'];
        foreach ($statusData as $userId => $status) {
            updateUserStatus($userId, $status, $event_id); 
        }
    if(isset($_POST['action'])){
        $result = getEventById($event_id);
        randerView('approval_at_get', ['event_id' => $result]);
    }
}
?>