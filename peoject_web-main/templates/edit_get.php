<?php

$imagePath = getEventImage($data['event_id']['Event_id']);

?>
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
    background: #e0f7fa;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 50px;
}

.edit-container {
    background: rgba(255, 255, 255, 0.9); 
    padding: 40px;
    border-radius: 15px;
    width: 90%;
    max-width: 600px;
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2); 
    text-align: center;
}

h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    color: #007bff; 
    font-weight: bold;
}

.image-upload-container {
    margin-bottom: 20px;
    text-align: center;
}

.image-scroll-container {
    display: flex;
    overflow-x: auto;
    gap: 10px;
    justify-content: center;
}

.image-item {
    position: relative;
}

.event-image {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #007bff;
}

.delete-button {
    position: absolute;
    top: 5px;
    right: 5px;
    background-color: #ff5733;
    color: white;
    border: none;
    padding: 5px;
    cursor: pointer;
    border-radius: 50%;
}

.delete-button:hover {
    background-color: #c0392b; 
}

.upload-btn-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: center;
}

.upload-btn {
    position: relative;
    display: inline-block;
    overflow: hidden;
    cursor: pointer;
    width: 200px;
    height: 50px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    text-align: center;
    line-height: 50px;
    font-weight: bold;
    font-size: 1rem;
    transition: background-color 0.3s ease;
}

.upload-btn:hover {
    background-color: #0056b3;
}

.upload-btn input[type="file"] {
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.create-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.create-form label {
    text-align: left;
    font-weight: bold;
    color: #333;
}

.create-form input,
.create-form textarea {
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f1f8ff;
    color: black;
    font-size: 1rem;
    width: 100%;
}

.create-form textarea {
    resize: vertical;
    height: 100px;
}

.button-container {
    display: flex;
    justify-content: space-between;
    gap: 15px;
}

button {
    padding: 12px 20px;
    font-size: 1.1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 48%;
}

.cancel-button {
    background-color: #dc3545;
    color: white;
}

.cancel-button:hover {
    background-color: #c82333;
}

.update-button {
    background-color: #28a745; 
    color: white;
}

.update-button:hover {
    background-color: #218838;
}

@media (max-width: 768px) {
    .edit-container {
        width: 90%;
        padding: 20px;
    }

    .image-scroll-container {
        flex-direction: column;
        align-items: center;
    }

    .image-item {
        margin-bottom: 15px;
    }

    .create-form {
        gap: 10px;
    }

    .button-container {
        flex-direction: column;
        gap: 10px;
    }

    button {
        width: 100%;
    }
}

</style>

<div class="edit-container">
    <h1>Edit Activity</h1>

    <!-- Image Display Section -->
    <div class="image-upload-container">
        <div class="image-scroll-container">
            <?php foreach ($imagePath['images'] as $image) { ?>
                <div class="image-item">
                    <img src="<?php echo $image; ?>" alt="Event Image" class="event-image">

                    <!-- Form to Delete Image -->
                    <form action="/deleteimg" method="POST" style="display:inline;">
                        <input type="hidden" name="image_url" value="<?php echo $image; ?>">
                        <input type="hidden" name="eid" value="<?php echo $data['event_id']['Event_id']; ?>">
                        <button type="submit" class="delete-button">Delete</button>
                    </form>

                    <!-- Form to Update Image -->
                    <form action="/imgedit" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="old_image_url" value="<?php echo $image; ?>">
                        <input type="hidden" name="eid" value="<?php echo $data['event_id']['Event_id']; ?>">
                        <label class="upload-btn">
                            เลือกรูปภาพ
                            <input type="file" name="image-upload[]" accept="image/*" onchange="this.form.submit()">
                        </label>
                    </form>

                </div>
            <?php } ?>
        </div>
    </div>


    <!-- Form Section for Activity -->
    <form class="create-form" action="/edit" method="POST" enctype="multipart/form-data">
        <label for="activity-name">Activity Name:</label>
        <input type="text" id="activity-name" name="activity-name" value="<?php echo $data['event_id']['Eventname']; ?>" required>

        <label for="participants">Participants:</label>
        <input type="number" id="participants" name="participants" value="<?php echo $data['event_id']['Max_participants']; ?>" required>

        <label for="start-date">Start Date:</label>
        <input type="date" id="start-date" name="start-date" value="<?php echo date('Y-m-d', strtotime($data['event_id']['start_date'])); ?>" required>

        <label for="end-date">End Date:</label>
        <input type="date" id="end-date" name="end-date" value="<?php echo date('Y-m-d', strtotime($data['event_id']['end_date'])); ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($data['event_id']['description']); ?></textarea>

        <div class="button-container">
            <input type="hidden" name="eid" value="<?php echo $data['event_id']['Event_id']; ?>">
            <button type="submit" class="update-button">แก้ไข</button>
            <button type="button" class="cancel-button" onclick="goBack()">ยกเลิก</button>
        </div>
    </form>
</div>

<script>
    function goBack() {
        
        window.location.href = '/profile';
    }
</script>
