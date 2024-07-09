<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
       body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #d0e7f9;
            background-image: url(https://www.ppt-backgrounds.net/thumbs/fantastic-blue-sky-clipart-downloads.jpeg);
        }
        .login-container {
            background-color: transparent;
            border-radius: 15px;
            
            box-shadow: 0px 0px 10px blue;
            padding: 30px;
            width: 300px;
            
            text-align: center;
        }
        .login-container h2 {
            color: #2b3e50;
            margin-bottom: 20px;
        }
        .login-container input[type="email"], .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 20px;
            box-shadow: inset 0 2px 4px blue;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 20px;
            background-color:darkblue;
            color: white;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 4px 8px blue;
        }
        .login-container button:hover {
            background-color: #2b7aab;
        }
        .login-container a {
            display: block;
            margin-top: 10px;
            color: black;

            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div>
        <?php
        include 'functions.php';
        session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = htmlspecialchars(trim($_POST['email']));
            $password = $_POST['password'];

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<p class='error'>Invalid email format</p>";
            } else {
                // Check if user exists and password is correct
                $sql = "SELECT id, password FROM Users WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($userId, $hashed_password);
                $stmt->fetch();
                $stmt->close();

                if ($userId && password_verify($password, $hashed_password)) {
                    // Login successful, start session
                    $_SESSION['user_id'] = $userId;
                    echo "<p class='success'>Login successful! Redirecting...</p>";
                    header("refresh:2; url=dashboard.php"); // Redirect after 2 seconds
                } else {
                    echo "<p class='error'>Incorrect email or password</p>";
                }
            }
        }
        ?>
       <div class="login-container">
        <h2>Quizzes</h2>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <a href="Register.php">New user? Sign Up</a>
       
    </div>

    </div>
</body>
</html>
