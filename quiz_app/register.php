<?php
// Include the necessary functions and start session
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p class='error'>Invalid email format</p>";
    } elseif (strlen($password) < 6) {
        echo "<p class='error'>Password must be at least 6 characters long</p>";
    } else {
        // Check if username already exists
        $username_sql = "SELECT id FROM Users WHERE username = ?";
        $username_stmt = $conn->prepare($username_sql);
        $username_stmt->bind_param("s", $name);
        $username_stmt->execute();
        $username_stmt->store_result();

        if ($username_stmt->num_rows > 0) {
            echo "<p class='error'>Username already exists. Please try another.</p>";
        } else {
            // Check if email already exists
            $email_sql = "SELECT id FROM Users WHERE email = ?";
            $email_stmt = $conn->prepare($email_sql);
            $email_stmt->bind_param("s", $email);
            $email_stmt->execute();
            $email_stmt->store_result();

            if ($email_stmt->num_rows > 0) {
                echo "<p class='error'>Email already exists. Please try another.</p>";
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert user into database
                $insert_sql = "INSERT INTO Users (username, email, password) VALUES (?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("sss", $name, $email, $hashed_password);

                if ($insert_stmt->execute()) {
                    echo "<p class='success'>Registration successful!</p>";
                } else {
                    echo "<p class='error'>Error: " . $insert_stmt->error . "</p>";
                }

                $insert_stmt->close();
            }
            $email_stmt->close();
        }
        $username_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
      /* General page styling */
      body {
          font-family: Arial, sans-serif;
          background: #e0f7fa;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          background-image: url(https://www.ppt-backgrounds.net/thumbs/fantastic-blue-sky-clipart-downloads.jpeg);
          margin: 0;
      }

      /* Form container styling */
      .form-container {
          background: transparent; /* Light blue similar to the image */
          padding: 30px;
          border-radius: 20px;
          box-shadow: 0px 0px 10px blue;
          text-align: center;
          max-width: 350px;
          width: 100%;
      }

      /* Form header styling */
      .form-container h2 {
          margin-bottom: 20px;
          font-size: 24px;
          color: black;
          font-weight: bolder;
      }

      /* Input field styling */
      .form-container input {
          width: calc(100% - 20px);
          padding: 15px;
          margin: 10px 0;
          border: none;
          border-radius: 10px;
          box-shadow: inset 0px 0px 5px blue;
          font-size: 16px;
      }

      /* Button styling */
      .form-container button {
          width: calc(100% - 20px);
          padding: 15px;
          margin: 20px 0 0;
          background-color: darkblue;
          border: none;
          border-radius: 10px;
          color: white;
          font-size: 16px;
          cursor: pointer;
          transition: background-color 0.3s ease;
      }

      /* Button hover effect */
      .form-container button:hover {
          background-color: #004d40;
      }

      /* Error message styling */
      .error {
          color: red;
          font-size: 14px;
          margin-top: 10px;
      }

      /* Success message styling */
      .success {
          color: green;
          font-size: 14px;
          margin-top: 10px;
      }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Register</button>
            <br><br>
            <a href="login.php" style="text-decoration: none; font-weight: bold;">Login Now</a>
        </form>
    </div>
</body>
</html>
