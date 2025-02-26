<?php
$courses = $data['courses'];
$student_id = $data['student_id'];
?>
<h2>รายวิชาที่เปิดให้ลงทะเบียน</h2>
<table border="1">
    <thead>
        <tr>
            <th>รหัสวิชา</th>
            <th>ชื่อวิชา</th>
            <th>อาจารย์ผู้สอน</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($courses)): ?>
            <tr>
                <td colspan="4">ไม่พบข้อมูล</td>
            </tr>
        <?php else: ?>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= $course['course_code'] ?></td>
                    <td><?= $course['course_name'] ?></td>
                    <td><?= $course['instructor'] ?></td>
                    <td>
                        <form action="/courses" method="post">
                            <input type="hidden" name="student_id" value="<?= $student_id ?> ?>">
                            <input type="hidden" name="course_id" value="<?= $course['course_id'] ?>">
                            <input type="submit" name="enroll" value="ลงทะเบียน" onclick="return confirmRegis()">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
