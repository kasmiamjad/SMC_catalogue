<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./assets/css/theme.min.css">
    <link rel="stylesheet" href="./assets/css/utility.min.css">
    <style>
        body {
            background-color: #032824;
            background-image: url(https://saudimotorsport.com/static/pattern-bg-138686d69440bf998f880b4ef82ec35f.svg);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Be Vietnam Pro', sans-serif;
        }
        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container h2 {
            color: #333;
            margin-bottom: 1.5rem;
        }
        .form-control {
            margin-bottom: 1rem;
        }
        .form-control input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            margin-top: 1rem;
        }

        .btn-login {
            background: linear-gradient(135deg, #006633, #00994d);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 102, 51, 0.25);
            letter-spacing: 0.5px;
            }

            .btn-login:hover {
            background: linear-gradient(135deg, #00994d, #00cc66);
            box-shadow: 0 6px 18px rgba(0, 102, 51, 0.35);
            transform: translateY(-1px);
            }

            .btn-login:active {
            background: linear-gradient(135deg, #005a2b, #008844);
            transform: translateY(1px);
            }

    </style>
</head>
<body>
    <div class="login-container">
        <img src="./assets/images/sms_logo.png" style="width:200px; margin-bottom: 1rem;" alt="Logo">
        <h2>User Login</h2>
        <form action="handle_login.php" method="post">
            <div class="form-control">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-control">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error-message">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>
    </div>
</body>
</html>
