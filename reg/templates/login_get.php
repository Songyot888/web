<section>
    <div class="big-box">
        <div class="box">
            <div class="login">
                <form action="/login" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail2" class="form-label">อีเมล</label>
                        <input type="email" name="email" class="form-control rounded" id="exampleInputEmail2" placeholder="กรุณากรอกอีเมล">
                    </div><br>
                    <label class="e-1" for="password">รหัสผ่าน:</label>
                    <input type="password" id="password" name="password"><br><br>
    
                    <div class="sub">
                        <input type="submit" value="เข้าสู่ระบบ" class="btn btn-primary">
                    </div>
                    
                </form>

            </div>
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                header('Location: /login');
            }
            ?>
        </div>
    </div>




</section>