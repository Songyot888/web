<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html, body {
    height: 100%;
    width: 100%;
    font-family: 'Arial', sans-serif;
    color: #333;
    background: linear-gradient(135deg, #ff758c, #e84364);
}

section {
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f1f1f1;
    padding: 50px 20px;
    min-height: 100vh;
}

.approval-container {
    background: rgba(255, 255, 255, 0.9);
    padding: 40px;
    border-radius: 15px;
    width: 100%;
    max-width: 1200px;
    box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    position: relative;
    overflow: hidden;
    animation: slideIn 0.5s ease-out;
}

@keyframes slideIn {
    0% {
        transform: translateY(50px);
        opacity: 0;
    }
    100% {
        transform: translateY(0);
        opacity: 1;
    }
}

h1 {
    font-size: 3rem;
    color: #222;
    margin-bottom: 30px;
    font-weight: 600;
}

h2 {
    font-size: 1.8rem;
    margin-bottom: 15px;
    color: #555;
    font-weight: 600;
}

.user-list {
    max-height: 500px;
    overflow-y: auto;
    padding-right: 10px;
    margin-bottom: 30px;
}

.user-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8);
    margin-bottom: 15px;
    border-radius: 12px;
    box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.user-item:hover {
    transform: translateY(-5px);
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.15);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-icon {
    width: 60px;
    height: 60px;
    background-color: #ff758c;
    color: white;
    font-size: 1.8rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.user-name {
    font-size: 1.5rem;
    color: #333;
}

.user-status {
    display: flex;
    align-items: center;
    gap: 15px;
}

.status-button {
    padding: 10px 20px;
    background-color: #ff758c;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.status-button:hover {
    background-color: #e84364;
}

.approved-button {
    background-color: #42a5f5;
}

.approved-button:hover {
    background-color: #1e88e5;
}

.denied-button {
    background-color: #ff5252;
}

.denied-button:hover {
    background-color: #e84343;
}

.button-container {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-top: 25px;
}

.deny-button,
.apply-button {
    padding: 15px 30px;
    font-size: 1.2rem;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.deny-button {
    background-color: #ff5252;
}

.deny-button:hover {
    background-color: #e84343;
}

.apply-button {
    background-color: #42a5f5;
}

.apply-button:hover {
    background-color: #1e88e5;
}

.back-button {
    position: absolute;
    top: 20px;
    left: 20px;
    padding: 10px 20px;
    font-size: 1.2rem;
    background-color: #333;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    z-index: 10;
}

.back-button:hover {
    background-color: #444;
}

@media (max-width: 768px) {
    .approval-container {
        padding: 20px;
        width: 95%;
        max-width: 100%;
    }

    h1 {
        font-size: 2rem;
    }

    h2 {
        font-size: 1.5rem;
    }

    .user-item {
        padding: 15px;
    }

    .user-name {
        font-size: 1.3rem;
    }

    .user-status {
        flex-direction: column;
    }

    .button-container {
        flex-direction: column;
        gap: 15px;
    }
}
</style>


<section>
    <div class="approval-container">
        <button class="back-button" onclick="window.location.href='/profile'">← Back</button>
        <h1>Activity Approval</h1>
        <form method="POST" action="/approval_at" id="approval-form">
            <div class="user-list">
                <?php

                $users = join_event($data['event_id']['Event_id']);
                $grouped_users = [];

                foreach ($users as $user) {
                    $grouped_users[$user['event_id']][] = $user;
                }

                foreach ($grouped_users as $event_id => $event_users):
                    if ($event_id == $data['event_id']['Event_id']):
                ?>
                        <h2>Event ID: <?= $event_id ?></h2>
                        <?php
                        if (empty($event_users)) {
                            echo "<p>No users found for this event.</p>";
                        }
                        ?>
                        <?php foreach ($event_users as $user): ?>
                            <div class="user-item" data-user-id="<?= $user['User_id'] ?>">
                                <div class="user-info">
                                    <div class="user-icon">U</div>
                                    <div class="user-name"><?= $user['Name'] ?></div>
                                </div>
                                <div class="user-status">
                                    <!-- เปลี่ยนปุ่มเป็นสีต่างกัน -->
                                    <button type="button" class="status-button approved-button" onclick="updateStatus(<?= $user['User_id'] ?>, 'approved')">Approve</button>
                                    <button type="button" class="status-button denied-button" onclick="updateStatus(<?= $user['User_id'] ?>, 'denied')">Deny</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                <?php endif;
                endforeach; ?>
            </div>

            <div class="button-container">
                <input type="hidden" name="eid" value="<?= $data['event_id']['Event_id']; ?>">
                <button type="submit" class="apply-button" name="action" value="apply">Apply</button>
            </div>
        </form>
    </div>
</section>

<script>
    function updateStatus(userId, status) {
        const statusButtons = document.querySelectorAll(`.user-item[data-user-id="${userId}"] .status-button`);

        // ทำให้ปุ่มทั้งหมดหายไปเมื่อเลือกสถานะ
        statusButtons.forEach(button => {
            button.disabled = true;
            button.style.display = 'none'; // ซ่อนปุ่ม
        });

        // สร้าง input ซ่อนเพื่อส่งข้อมูลไปที่ server
        const form = document.getElementById('approval-form');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `status[${userId}]`;
        input.value = status;
        form.appendChild(input);

        // เมื่ออัปเดตสถานะเสร็จแล้วส่งแบบฟอร์ม
        form.submit();
    }
</script>
