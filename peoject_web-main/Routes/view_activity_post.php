<?php


if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    $sql = "SELECT * FROM Event WHERE Event_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result->fetch_assoc();
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
        exit();
    }
} else {
    echo "Event ID is missing.";
    exit();
}
?>