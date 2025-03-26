<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the event_id and User_id
        $event_id = $_POST['eid'] ?? '';
        $user_id = $_SESSION['User_id'] ?? ''; 
    

        if ($event_id && $user_id) {

            registerUserForEvent($user_id, $event_id);
        } else {
            echo "Event ID or User ID is missing.";
        }
    }
}
?>