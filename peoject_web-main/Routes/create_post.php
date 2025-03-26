<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $activity_name = $_POST['activity-name'] ?? '';
    $participants = $_POST['participants'] ?? 0;
    $start_date = $_POST['start-date'] ?? '';
    $end_date = $_POST['end-date'] ?? '';
    $description = $_POST['description'] ?? '';
    $status = $_POST['status'] ?? 'Open';
    $User_id = $_POST['User_id'] ?? '';

    $images = $_FILES['images'] ?? null;

    $event_id = insertEvent($activity_name, $participants, $start_date, $end_date, $description, $status, $User_id, $images);

    if ($event_id) {
        insertEventImages($event_id, $images);
        header('Location: /profile');
    } else {
        echo "Insert event failed. Check error log for details.";
    }
}


