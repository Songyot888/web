<?php require_once 'header.php' ?>
<?php
$events = getAllEvents();
$joined_events = getUserJoinedEvents($_SESSION['User_id']);
$joined_event_ids = array_map(function ($event) {
    return $event['Event_id'];
}, $joined_events);
?>
<style>
    body {
        padding-top: 60px;
        background-color: #f4f4f4;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        text-align: center;
        padding: 50px 0;
    }

    .title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #222;
        margin-bottom: 30px;
        text-transform: uppercase;
    }

    .activity-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        padding: 20px;
    }

    .activity-card {
        background: rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(15px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        cursor: pointer;
        overflow: hidden;
        position: relative;
    }

    .activity-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
    }

    .activity-card img {
        width: 100%;
        height: 200px;
        border-radius: 15px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .activity-card:hover img {
        transform: scale(1.1);
    }

    .content {
        text-align: center;
        padding: 15px 10px;
    }

    .content h3 {
        margin: 15px 0 10px;
        font-size: 1.8rem;
        color: #111;
        font-weight: 600;
    }

    .content p {
        color: #444;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .navbar {
            font-size: 0.9rem;
        }

        .activity-container {
            padding: 10px;
        }

        .activity-card {
            padding: 20px;
        }

        .content h3 {
            font-size: 1.6rem;
        }
    }
</style>

<div class="container">
    <div class="container d-flex justify-content-start">
        <div class="large-activity-card">
            <h3>Main Activity</h3>
        </div>
    </div>

    <div class="activity-container">
        <?php if (!empty($events)): ?>
            <?php foreach ($events as $event): ?>
                <div class="activity-card">
                    <?php if (!empty($event['image_url'])): ?>
                        <!-- เพิ่มลิงก์ที่กรอบรูปภาพ -->
                        <a href="/register_at?eid=<?php echo $event['Event_id']; ?>">
                            <img src="<?php echo $event['image_url']; ?>" alt="Event Image" class="event-image">
                        </a>
                    <?php endif; ?>

                    <div class="content">
                        <h3><?php echo htmlspecialchars($event['Eventname']); ?></h3>
                        <span class="like-count"></span>

                        <div class="content">
                            <form action="/main" method="post" onsubmit="event.preventDefault(); window.location.href='/register_at?eid=<?php echo $event['Event_id']; ?>'">
                                <div class="view">
                                    <input type="hidden" name="eid" value="<?php echo $event['Event_id']; ?>">
                                    <button class="btn btn-info" type="submit">View</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>ไม่มีข้อมูลกิจกรรม</p>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'footer.php' ?>