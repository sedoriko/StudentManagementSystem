<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to PUTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@700&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Noto Serif', serif;
            color: white;
            background: url('background/login_register.jpg');
            background-size: cover;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(145deg, rgba(0, 0, 0, 0.7), rgba(255, 255, 255, 0.2));
            text-align: center;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 100px;
            height: auto;
        }

        .headline {
            font-size: 50px;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .subtext {
            font-size: 25px;
            margin-bottom: 40px;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        }

        .start-button {
            font-size: 18px;
            padding: 12px 30px;
            background: linear-gradient(45deg, white, grey);
            color: black;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .start-button:hover {
            background: linear-gradient(45deg, grey, white);
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="container">
        <img src="background/logo.jpg" class="logo" alt="Logo">
        <div class="headline">Philippine University of Technology</div>
        <a href="login.php">
            <button class="start-button">Let's Get Started</button>
        </a>
    </div>

</body>
</html>
