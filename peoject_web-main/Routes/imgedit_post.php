<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image-upload'])) {
    $imageFile = $_FILES['image-upload'];
    $eventId = $_POST['eid'] ?? '';
    $oldImageUrl = $_POST['old_image_url'] ?? '';

    if (!$eventId || !$oldImageUrl) {
        echo "ข้อมูลไม่ครบถ้วน!";
        exit;
    }

    $event = getEventById($eventId);

    updateEventImages($imageFile, $eventId, $oldImageUrl); // ส่ง URL รูปเก่าไปด้วย

    randerView('edit_get', ['event_id' => $event]);
}
