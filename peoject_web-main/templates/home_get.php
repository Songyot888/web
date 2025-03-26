<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: linear-gradient(135deg, #2c3e50, #4ca1af);
        background-size: cover;
        color: white;
        text-align: center;
        padding: 0 20px;
        box-sizing: border-box;
        position: relative;
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

    .container-0 {
        background: rgba(255, 255, 255, 0.85); /* พื้นหลังโปร่งใส */
        backdrop-filter: blur(10px); /* เบลอพื้นหลัง */
        padding: 50px 30px;
        border-radius: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 450px;
        text-align: center;
        margin-bottom: 30px;
        position: relative;
        animation: fadeIn 0.8s ease-in-out;
        z-index: 1;
    }

    h1 {
        font-size: 2.8rem;
        margin-bottom: 20px;
        color: #333;
        text-transform: uppercase;
    }

    p {
        font-size: 1.3rem;
        margin-bottom: 30px;
        color: #444;
    }

    .button {
        width: 100%;
        background: #667eea;
        color: white;
        padding: 15px;
        font-size: 1.1rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        margin: 12px 0;
        transition: background-color 0.3s ease, transform 0.3s ease;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .button:hover {
        background-color: #5a67d8;
        transform: translateY(-3px);
    }

    .button:active {
        transform: translateY(0);
    }

</style>

<div class="container-0">
    <h1>Activity Club</h1>
    <p>กิจกรรมที่ทุกคนรอ...คอย</p>
    <button class="button" onclick="window.location.href='/login';">Login</button>
    <button class="button" onclick="window.location.href='/register';">Sign up</button>
</div>