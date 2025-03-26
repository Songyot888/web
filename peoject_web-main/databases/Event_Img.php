<?php
function insertEventImages($event_id, $images) {
    $conn = getConnection();
    $uploadDir = 'uploads/event/';
    
    if (isset($images['tmp_name'])) {
        foreach ($images['tmp_name'] as $key => $tmp_name) {
            // เพิ่มรูปภาพถัดไปหลังจากรูปแรก
            if ($key > 0) {
                $imagePath = $uploadDir . basename($images['name'][$key]);
                if (move_uploaded_file($tmp_name, $imagePath)) {
                    // เพิ่มรูปภาพเข้าไปใน Event_Img โดยอ้างอิงกับ event_id
                    $sql = 'INSERT INTO Event_Img (Event_id, url) VALUES (?, ?)';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('is', $event_id, $imagePath);
                    $stmt->execute();
                } else {
                    error_log("Image upload failed for file: " . $images['name'][$key]);
                }
            }
        }
    }

    $conn->close();
}

function getEventImages($eventId) {
    $conn = getConnection();
    $imagesQuery = "SELECT url FROM Event_Img WHERE Event_id = ?";
    $stmt = $conn->prepare($imagesQuery);
    
    // ผูกพารามิเตอร์
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    
    // รับผลลัพธ์
    $result = $stmt->get_result();
    $images = [];
    
    // ดึงข้อมูลรูปภาพจากฐานข้อมูล
    while ($row = $result->fetch_assoc()) {
        $images[] = $row['url']; // เก็บเส้นทางของรูปภาพ
    }
    
    // คืนค่าผลลัพธ์
    return $images;
}

function getEventImage($eventId) {
    $conn = getConnection();
    
    // ดึงข้อมูลกิจกรรมจากตาราง Event รวมถึงรูปหลัก
    $eventQuery = "SELECT image_url FROM Event WHERE Event_id = ?";
    $stmt = $conn->prepare($eventQuery);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $eventResult = $stmt->get_result();
    $eventDetails = $eventResult->fetch_assoc();
    
    // ดึงรูปภาพจากตาราง Event_Img
    $imagesQuery = "SELECT url FROM Event_Img WHERE Event_id = ?";
    $stmt = $conn->prepare($imagesQuery);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    $images = [];
    
    while ($row = $result->fetch_assoc()) {
        $images[] = $row['url'];
    }
    
    if ($eventDetails['image_url']) {
        array_unshift($images, $eventDetails['image_url']);
    }

    $eventDetails['images'] = $images;
    
    return $eventDetails;
}


function deleteEventImage($imageUrl, $eventId) {
    $conn = getConnection();

    $deleteQuery = "DELETE FROM Event_Img WHERE url = ? AND Event_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    
    // Bind the parameters
    $stmt->bind_param("si", $imageUrl, $eventId);

    if ($stmt->execute()) {
        if (file_exists($imageUrl)) {
            unlink($imageUrl); 
        }
        return "Image deleted successfully";
    } else {
        return "Error deleting image";
    }
}


function updateEventImages($imageFiles, $event_id, $old_image_url) {
    $conn = getConnection();

    if (!isset($imageFiles['tmp_name']) || !is_array($imageFiles['tmp_name'])) {
        echo "ข้อมูลไฟล์ไม่ถูกต้อง!";
        return false;
    }

    foreach ($imageFiles['tmp_name'] as $index => $tmpName) {
        if ($imageFiles['error'][$index] == 0) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imageFiles['type'][$index], $allowedTypes)) {
                echo "ประเภทไฟล์ไม่ถูกต้อง!";
                return false;
            }

            $uploadDir = 'uploads/event/';
            $fileExtension = pathinfo($imageFiles['name'][$index], PATHINFO_EXTENSION);
            $fileName = uniqid('event_', true) . '.' . $fileExtension; 
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $filePath)) {
                // ลบรูปเดิมที่ต้องการเปลี่ยน
                if ($old_image_url && file_exists($old_image_url)) {
                    unlink($old_image_url);
                }

                $sql = "UPDATE Event_Img SET url = ? WHERE Event_id = ? AND url = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sis", $filePath, $event_id, $old_image_url);
                $stmt->execute();

                if ($stmt->affected_rows == 0) {
                    $sql = "UPDATE Event SET image_url = ? WHERE Event_id = ? AND image_url = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sis", $filePath, $event_id, $old_image_url);
                    $stmt->execute();
                }

                $stmt->close();
            } else {
                echo "เกิดข้อผิดพลาดในการอัปโหลดภาพ!";
                return false;
            }
        }
    }

    $conn->close();
    return true;
}






?>

