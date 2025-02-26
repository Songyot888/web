<section>
    .
    <h2>ช้อมูลนักเรียน</h2>
    <table border="1">
        <tr>
            <th>ชื่อ</th>
            <td><?= $data['result']['first_name'] ?></td>
        </tr>
        <tr>
            <th>นามสกุล</th>
            <td><?= $data['result']['last_name'] ?></td>
        </tr>
        <tr>
            <th>วันเกิด</th>
            <td><?= $data['result']['date_of_birth'] ?></td>
        </tr>
        <tr>
            <th>เบอร์โทรศัพท์</th>
            <td><?= $data['result']['phone_number'] ?></td>
        </tr>
    </table>
    <h2>วิชาที่ลงทะเบียนเรียน</h2>
    <table border="1">
        <thead>
            <tr>
                <th>รหัสวิชา</th>
                <th>ชื่อวิชา</th>
                <th>อาจารย์ผู้สอน</th>
                <th>วันที่ลงทะเบียน</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['enrollments'] as $enrollment): ?>
                <tr>
                    <td><?= $enrollment['course_code'] ?></td>
                    <td><?= $enrollment['course_name'] ?></td>
                    <td><?= $enrollment['instructor'] ?></td>
                    <td><?= $enrollment['enrollment_date'] ?></td>
                    <td><form action="/profile" method="post">
                    <input type="hidden" name="student_id" value="<?= $data['result']['student_id'] ?>">
                    <input type="hidden" name="course_id" value="<?= $enrollment['course_id'] ?>" >
                            <input type="submit" value="ถอนรายวิชา" onclick="return confirmD">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

