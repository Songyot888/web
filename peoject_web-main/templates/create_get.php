<?php
    
    $User_id = $_SESSION['User_id'];
?>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #ffffff;
    color: #2c3e50;
    animation: fadeIn 1.5s ease-in-out;
}

.create-container {
    background: rgba(255, 255, 255, 0.95);
    padding: 25px;
    border-radius: 12px;
    width: 90%;
    max-width: 480px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    border: 2px solid #3498db;
    transform: scale(0.95);
    opacity: 0;
    animation: containerFadeIn 1s forwards ease-in-out;
}

@keyframes containerFadeIn {
    0% {
        transform: scale(0.95);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.activity-image {
    width: 150px;
    height: 150px;
    border-radius: 10px;
    border: 3px solid #3498db;
    overflow: hidden;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: rgba(52, 152, 219, 0.1);
    margin-bottom: 20px;
    transition: all 0.3s ease;
    transform: scale(1);
    opacity: 0;
    animation: imageFadeIn 0.6s forwards ease-in-out;
}

@keyframes imageFadeIn {
    0% {
        transform: scale(0.8);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.activity-image:hover {
    transform: scale(1.05);
    background-color: rgba(52, 152, 219, 0.2);
}

.activity-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: none;
}

.activity-image input {
    display: none;
}

.create-form {
    display: flex;
    flex-direction: column;
    gap: 12px;
    width: 100%;
}

.create-form input,
.create-form textarea {
    padding: 10px;
    border: 2px solid rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    background-color: rgba(0, 0, 0, 0.05);
    color: #2c3e50;
    font-size: 0.95rem;
    transition: border-color 0.3s ease-in-out;
    width: 100%;
}

.create-form input:focus,
.create-form textarea:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 8px rgba(52, 152, 219, 0.6);
}

.create-form textarea {
    resize: vertical;
    height: 120px;
}

.button-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-top: 20px;
    animation: fadeInButtons 1.2s ease-in-out;
}

@keyframes fadeInButtons {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

button {
    padding: 10px;
    font-size: 0.9rem;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    width: 48%;
    font-weight: bold;
    text-transform: uppercase;
}

.cancel-button {
    background-color: #e74c3c;
    color: white;
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
    transform: scale(0.95);
    transition: transform 0.3s ease-in-out;
}

.cancel-button:hover {
    background-color: #c0392b;
    transform: scale(1.05);
}

.create-button {
    background-color: #3498db;
    color: white;
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
    transform: scale(0.95);
    transition: transform 0.3s ease-in-out;
}

.create-button:hover {
    background-color: #2980b9;
    transform: scale(1.05);
}

button:focus {
    outline: none;
    box-shadow: 0px 0px 20px rgba(52, 152, 219, 0.6);
}

button:active {
    transform: scale(0.98);
}
  
</style>

<div class="create-container">
    <form class="create-form" action="/create" method="POST" enctype="multipart/form-data">
        <h1>สร้างกิจกรรม</h1>

        <!-- Image Upload Section -->
        <div class="activity-image" onclick="document.getElementById('file-upload').click();">
            <img id="preview-image" src="" alt="Click to upload">
            <span id="upload-text">คลิกเพื่ออัพโหลดรูปภาพ</span>
            <input type="file" id="file-upload" name="images[]" accept="image/*" multiple onchange="previewFile()">
        </div>

        <div id="preview-container"></div>

        <input type="text" name="activity-name" placeholder="ใส่ชื่อกิจกรรม" required>
        <input type="number" name="participants" placeholder="จำนวนผู้เข้าร่วมสูงสุด" required>
        <input type="date" name="start-date" required>
        <input type="date" name="end-date" required>
        <textarea name="description" placeholder="รายละเอียดกิจกรรม" required></textarea>
        <input type="hidden" name="status" value="Open" required>
        <input type="hidden" name="User_id" value="<?=$User_id?>">

        <div class="button-container">
            <button type="submit" class="create-button">สร้างกิจกรรม</button>
            <button type="button" class="cancel-button" onclick="window.location.href='/profile'">ยกเลิก</button>
        </div>
    </form>
</div>

<script>
    function previewFile() {
        const files = document.getElementById("file-upload").files;
        const previewContainer = document.getElementById("preview-container");
        previewContainer.innerHTML = ''; // Clear previous previews

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.maxWidth = "100px"; // Optional: limit image size
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
