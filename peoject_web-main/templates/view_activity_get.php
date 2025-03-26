<?php
   
?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #87CEFA, #4682B4);
            color: white;
            text-align: center;
            padding: 50px;
        }
        .activity-container {
            background: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 15px;
            width: 80%;
            max-width: 800px;
            margin: auto;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5);
        }
        img {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid white;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            font-size: 1.1rem;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #5a6268;
        }
    </style>

    <div class="container">
        <h1><?php echo htmlspecialchars($event['Eventname']); ?></h1>
        <p><strong>Participants:</strong> <?php echo htmlspecialchars($event['Max_participants']); ?></p>
        <p><strong>Start Date:</strong> <?php echo htmlspecialchars($event['start_date']); ?></p>
        <p><strong>End Date:</strong> <?php echo htmlspecialchars($event['end_date']); ?></p>
        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
        <img src="../public/uploads/<?php echo htmlspecialchars($event['image_url']); ?>" alt="Event Image" style="max-width: 500px;">
        <p><strong>Status:</strong> <?php echo htmlspecialchars($event['status_event']); ?></p>
    </div>

