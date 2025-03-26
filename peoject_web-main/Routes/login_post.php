<?php

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $result = login($username, $password);

        if ($result) {
          $student = getUserById($result['User_id']);
          $unix_timestamp = time();
          $_SESSION['timestamp'] = $unix_timestamp;
          $_SESSION['User_id'] = $result['User_id'];
        //   echo "User ID: " . $_SESSION['User_id'];

          header('Location: /main');
        } else {
            $_SESSION['alert'] = 'เข้าสู่ระบบไม่สำเร็จ';
            header('Location: /login');
        }
    }

?>