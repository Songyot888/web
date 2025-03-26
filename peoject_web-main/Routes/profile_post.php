<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'] ?? '';
    // var_dump($event_id);
    $result = getEventById($event_id);

    randerView('detail_get', ['event_id' => $result]);

}