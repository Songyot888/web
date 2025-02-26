<section>
    <?php if (isset($data['student']) && !empty($data['student'])): ?>
        <h1 class="hello">สวัสดี <?= $data['student']['first_name'] ?></h1>
    <?php else: ?>
        <h1 class="hello">สวัสดี, ข้อมูลนักเรียนไม่พบ</h1>
    <?php endif; ?>
</section>
