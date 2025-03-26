<?php
function insertEvent($activity_name, $participants, $start_date, $end_date, $description, $status, $User_id, $images) {
    $conn = getConnection();
    $conn->query("ALTER TABLE Event AUTO_INCREMENT = 1");
    // อัปโหลดรูปภาพและบันทึกรูปแรกลงใน Event
    $uploadDir = 'uploads/event/';
    $backgroundImagePath = null;

    if (isset($images)) {
        $backgroundImage = $images['tmp_name'][0]; // รูปแรกจะเป็นภาพพื้นหลัง
        $backgroundImagePath = $uploadDir . basename($images['name'][0]);
        move_uploaded_file($backgroundImage, $backgroundImagePath);
    }

    // SQL คำสั่งบันทึกข้อมูลกิจกรรม
    $sql = 'INSERT INTO Event (Eventname, Max_participants, start_date, end_date, description, status_event, User_id, image_url) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sissssss', $activity_name, $participants, $start_date, $end_date, $description, $status, $User_id, $backgroundImagePath);

    if ($stmt->execute()) {
        $event_id = $stmt->insert_id;  // Get the inserted event's ID
        $stmt->close();
        return $event_id;
    } else {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return false;
    }
}


function getEventById($eid) {
    $conn = getConnection();
    $sql = "SELECT * FROM Event WHERE Event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eid);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


function getAllEvents(): mysqli_result|bool {
    $conn = getConnection();
    $sql = "SELECT * FROM Event";
    $result = $conn->query($sql);
    $conn->close();
    return $result;
}



function updateEvent($eid, $Eventname, $Max_participants, $start_date, $end_date, $description) {
    $conn = getConnection();
    $sql = "UPDATE Event SET Eventname=?, Max_participants=?, description=?, start_date=?, end_date=? WHERE Event_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssi", $Eventname, $Max_participants, $description, $start_date, $end_date, $eid);

    // Execute the query
    if ($stmt->execute()) {
        // ตรวจสอบว่ามีการอัพเดตแถวใดๆ หรือไม่
        if ($stmt->affected_rows > 0) {
            return true;  // ข้อมูลอัพเดตแล้ว
        } else {
            echo "ไม่มีการอัพเดตข้อมูล เนื่องจากไม่พบ Event_id ที่ตรงกับที่กำหนด";
            return false;
        }
    } else {
        echo "Error executing query: " . $stmt->error;
        return false;
    }
}

function getSearch(): mysqli_result|bool {
    $conn = getConnection();
    $sql = 'select * from Event';
    $result = $conn->query($sql);
    return $result;
}

function getUserEventsById($user_id) {
    $conn = getConnection();

    $sql = "SELECT * FROM Event WHERE User_id = ?";  // เปลี่ยนเป็นชื่อของตารางและฟิลด์ตามที่คุณใช้
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id); // ผูกตัวแปร $user_id กับ query
    $stmt->execute();

    $result = $stmt->get_result();
    $events = [];

    // ดึงข้อมูลกิจกรรมทั้งหมดที่ตรงกับ user_id
    while ($event = $result->fetch_assoc()) {
        $events[] = $event;
    }

    return $events;
}

function getJoinedEventsById($user_id) {
    $conn = getConnection();

    // เขียน SQL Query เพื่อดึงกิจกรรมที่ผู้ใช้เข้าร่วม
    $sql = "SELECT * FROM Event WHERE Event_id IN (SELECT Event_id FROM JoinEvent WHERE User_id = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id); // ผูกตัวแปร $user_id กับ query
    $stmt->execute();

    $result = $stmt->get_result();
    $events = [];

    // ดึงข้อมูลกิจกรรมทั้งหมดที่ตรงกับ user_id
    while ($event = $result->fetch_assoc()) {
        $events[] = $event;
    }

    return $events;
}


function searchEvent(string $search, $startDate = null, $endDate = null): array
{
    $conn = getConnection();
    $sql = "SELECT * FROM Event WHERE Eventname LIKE ?";
    $params = [];
    $types = "s";

    // เพิ่ม wildcard (%) เพื่อให้ค้นหาได้ถูกต้อง
    $search = "%" . $search . "%";
    $params[] = $search;

    if (!empty($startDate) && !empty($endDate)) {
        $sql .= " AND start_date BETWEEN ? AND ?";
        $params[] = $startDate;
        $params[] = $endDate;
        $types .= "ss";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}
function searchEvents(string $keyword): array
{
    $conn = getConnection();
    $sql = 'SELECT * FROM event WHERE eventname LIKE ?';
    $stmt = $conn->prepare($sql);
    $keyword = '%' . $keyword . '%';
    $stmt->bind_param('s', $keyword);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}





function deleteEvent($event_id) {
    $conn = getConnection();

    // ดึงรายการไฟล์ภาพที่เกี่ยวข้องกับกิจกรรม
    $sql = "SELECT url FROM Event_Img WHERE Event_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $imagePath = $row['url'];
        if (!empty($imagePath)) {
            if (file_exists($imagePath)) {
                if (unlink($imagePath)) {
                    echo "Deleted: $imagePath\n";
                } else {
                    echo "Failed to delete: $imagePath\n";
                }
            } else {
                echo "File does not exist: $imagePath\n";
            }
        }
    }

    $stmt->close();

    // ลบรายการภาพออกจากตาราง Event_Img
    $sql = "DELETE FROM Event_Img WHERE Event_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->close();

    $sql = "SELECT image_url FROM Event WHERE Event_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->bind_result($imagePathInEvent);
    $stmt->fetch();
    $stmt->close();

    // ลบไฟล์จากเซิร์ฟเวอร์ถ้ามีรูปภาพใน Event
    if ($imagePathInEvent && file_exists($imagePathInEvent)) {
        if (unlink($imagePathInEvent)) {
            echo "Deleted image from Event: $imagePathInEvent\n";
        } else {
            echo "Failed to delete image from Event: $imagePathInEvent\n";
        }
    }

    $deleteUserEventQuery = "DELETE FROM User_Event WHERE event_id = ?";
    $stmt = $conn->prepare($deleteUserEventQuery);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->close();

    $sql = "DELETE FROM Event WHERE Event_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $success = $stmt->execute();
    $stmt->close();
    $conn->close();

    return $success;
}


function countParticipants($eventId) {
    $conn = getConnection();
    $sql = "SELECT COUNT(*) as total FROM User_Event WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result['total'] ?? 0;
}

