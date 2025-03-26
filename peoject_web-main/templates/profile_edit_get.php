<?php require_once 'header.php' ?>
<?php

    if (!isset($_SESSION['User_id'])) {
        header('Location: /login');
        exit;
    }

    $User_id = $_SESSION['User_id'];
    $user = getUserById($User_id);
   


?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
body {
    background: linear-gradient(to right, #a6c1ee, #f5f7fa);
    background-attachment: fixed;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    color: #2c3e50;
}

section {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 50px 20px;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(12px);
    border-radius: 20px;
}

.profile-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px; /* ลดระยะห่าง */
    width: 100%;
    max-width: 600px; /* ปรับขนาดให้เล็กลง */
    background: rgba(255, 255, 255, 0.9);
    padding: 30px; /* ลด padding */
    border-radius: 25px;
    box-shadow: 0px 10px 40px rgba(0, 0, 0, 0.1);
    text-align: center;
    backdrop-filter: blur(12px);
    animation: fadeIn 1.2s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.profile-image {
    width: 120px; /* ลดขนาดกรอบรูป */
    height: 120px; /* ลดขนาดกรอบรูป */
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid #64b5f6;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 15px; /* ลดช่องว่าง */
}

.profile-image:hover {
    transform: scale(1.1);
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
}

.profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    cursor: pointer;
}

.profile-image input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

label {
    display: block;
    font-size: 1rem;
    margin-bottom: 8px;
    text-align: left;
}

.profile-info input {
    width: 100%;
    max-width: 450px; /* ลดขนาดช่องกรอก */
    padding: 12px; /* ลด padding */
    margin: 10px 0; /* ลดช่องว่าง */
    border-radius: 12px;
    border: 1px solid #ddd;
    font-size: 1rem;
    background: rgba(255, 255, 255, 0.5);
    color: #333;
    outline: none;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.profile-info input::placeholder {
    color: #bbb;
}

.profile-info input:focus {
    background-color: rgba(255, 255, 255, 0.7);
    transform: scale(1.02);
    border: 1px solid #ff8c00;
    box-shadow: 0px 0px 20px rgba(255, 140, 0, 0.5);
}

.edit-profile-button, .cancel-button {
    padding: 14px 28px;
    font-size: 1.1rem;
    width: 48%;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: bold;
    border: none;
    outline: none;
    box-sizing: border-box;
    display: inline-block;
    text-align: center;
    text-decoration: none;
}

.edit-profile-button {
    background-color: #64B5F6; /* ฟ้าสด */
    color: white;
}

.edit-profile-button:hover {
    background-color: #42A5F5; /* ฟ้าสว่าง */
    transform: translateY(-5px);
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
}

.cancel-button {
    background-color: #ff5c8d; /* สีชมพูอ่อน */
    color: white;
    margin-left: 10px;
}

.cancel-button:hover {
    background-color: #ff4081; /* สีชมพูเข้ม */
    transform: translateY(-5px);
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
}

.cancel-button:focus, .edit-profile-button:focus {
    outline: none;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.15);
}

.profile-info button {
    margin: 10px 0;
}

@media (max-width: 768px) {
    .profile-container {
        width: 90%;
    }

    .profile-image {
        width: 120px;
        height: 120px;
    }

    .edit-profile-button {
        font-size: 1rem;
        padding: 12px 22px;
    }
}

</style>

<section>
    <div class="profile-container">
        <form class="profile-info" action="/profile_edit" method="POST" enctype="multipart/form-data">
            <div class="profile-image">
                <img id="profile-img" src="profile-placeholder.jpg" alt="">
                <input type="file" name="image" id="profile-pic" accept="image/*" onchange="previewImage(event)">
            </div>

            <input type="hidden" name="uid" value="<?php echo $user['User_id']; ?>" >
            <label for="username">Full Name</label>
            <input type="text" name="username" value="<?php echo $user['Name']; ?>" placeholder="Full Name">

            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo $user['Email']; ?>" placeholder="Email">

            <label for="phone">Phone</label>
            <input type="text" name="phone" value="<?php echo $user['phone'] ?? ''; ?>" placeholder="Phone">

            <label for="address">Address</label>
            <input type="text" name="address" value="<?php echo $user['Addss'] ?? ''; ?>" placeholder="Address">

            <label for="birthday">Birthday</label>
            <input type="date" name="birthday" value="<?php echo $user['birthday']; ?>" placeholder="Birthday">

            <button type="submit" class="edit-profile-button">ยืนยัน</button>
            <button type="button" class="cancel-button" onclick="window.location.href='/profile'">ยกเลิก</button>
        </form>
    </div>
</section>


<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('profile-img');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
