<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eid = $_POST['eid']  ?? ''; 

    if(isset($_POST['edit'])){
        

        $result = getEventById($eid);

        randerView('edit_get', ['event_id' => $result]);
        
    } elseif(isset($_POST['delete'])){
        $resultdl = deleteEvent($eid);
        if ($resultdl) {
            echo "<script>alert('ลบกิจกรรมเรียบร้อย!'); window.location.href='/event';</script>";
            header('Location: /profile');
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการลบกิจกรรม!'); window.location.href='/event';</script>";
        }
    } elseif(isset($_POST['view'])){

        $result = getEventById($eid);

        randerView('approval_at_get', ['event_id' => $result]);
    }
}