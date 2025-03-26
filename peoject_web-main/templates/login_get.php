<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: linear-gradient(135deg, #2c3e50, #4ca1af);
        background-size: cover;
    }

    .container {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(15px);
        padding: 40px 50px;
        width: 100%;
        max-width: 500px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        color: #fff;
        animation: fadeIn 0.8s ease-in-out;
        box-sizing: border-box;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    h1 {
        font-size: 30px;
        color: #fff;
        margin-bottom: 30px;
    }

    .input-wrapper {
        position: relative;
        margin-bottom: 20px;
    }

    .input-wrapper label {
        position: absolute;
        top: 50%;
        left: 20px;
        transform: translateY(-50%);
        font-size: 18px;
        color: rgba(255, 255, 255, 0.7);
        transition: all 0.3s ease-in-out;
    }

    input {
        width: 100%;
        padding: 15px 20px;
        border: none;
        border-radius: 25px;
        background: rgba(255, 255, 255, 0.3);
        color: #fff;
        font-size: 18px;
        transition: 0.3s;
    }

    input:focus {
        background: rgba(255, 255, 255, 0.5);
        outline: none;
        transform: scale(1.05);
    }

    input:focus + label, input:not(:placeholder-shown) + label {
        top: -10px;
        left: 15px;
        font-size: 14px;
        color:rgb(255, 255, 255);
    }

    button {
        background: linear-gradient(135deg, #007bff, #00c6ff);
        border: none;
        padding: 15px;
        border-radius: 25px;
        width: 100%;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.5);
        font-size: 18px;
    }

    button:hover {
        background: linear-gradient(135deg, #0056b3, #0094cc);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 123, 255, 0.7);
    }

    .password-wrapper {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 20px;
        color: rgba(255, 255, 255, 0.7);
        transition: 0.3s;
    }

    .toggle-password:hover {
        color: rgba(255, 255, 255, 1);
    }

    .remember-forgot-wrapper {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        gap: 100px;
        align-items: center;
        flex-wrap: nowrap; /* Add this to ensure no wrapping */
    }

    .remember-forgot-wrapper label {
        font-size: 14px;
        white-space: nowrap; /* Prevent breaking the label */
    }

    .form-check {
        font-size: 12px;
        display: flex;
        align-items: center;
    }

    .form-check-input {
        padding: 5px;
        margin-right: 8px;
        display: inline-block;
    }

    .form-check label {
        display: inline-block;
        font-size: 14px;
    }

    .form-check a {
        font-size: 12px;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s;
    }

    .form-check a:hover {
        text-decoration: underline;
        color: #0094cc;
    }

    .signup-link {
        margin-top: 20px;
        font-size: 16px;
    }

    .signup-link a {
        color: #00c6ff;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s;
    }

    .signup-link a:hover {
        text-decoration: underline;
        color: #0094cc;
    }

    footer {
        text-align: center;
        padding: 15px;
        background: rgba(0, 0, 0, 0.1);
        margin-top: auto;
        font-size: 12px;
        color: #fff;
    }

</style>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<section>
    <div class="container">
        <h1>Login</h1>

        <form action="/login" method="POST">
            <div class="input-wrapper" id="username-wrapper">
                <input type="text" name="username" placeholder=" " id="username" required>
                <label for="username">Username</label>
            </div>

            <div class="input-wrapper" id="password-wrapper">
                <input type="password" name="password" id="password" placeholder=" " required>
                <label for="password">Password</label>
                <i class="fa-solid fa-eye-slash toggle-password" id="toggleIcon" onclick="togglePassword()"></i>
            </div>

            <div class="remember-forgot-wrapper" style="color: white;">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <a href="#">Forgot password?</a>
            </div>

            <button type="submit">Login</button>
        </form>

        <p class="signup-link">Don't have an account? <a href="/register">Sign up</a></p>
    </div>
</section>

<script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        var toggleIcon = document.getElementById("toggleIcon");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        }
    }
</script>
