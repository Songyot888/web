<?php
if (isset($_POST['image_url']) && isset($_POST['eid'])) {
    $imageUrl = $_POST['image_url'];
    $eventId = $_POST['eid'];

    $event = getEventById($eventId);

    deleteEventImage($imageUrl, $eventId);

    randerView('edit_get', ['event_id' =>$event]);
}
?>
