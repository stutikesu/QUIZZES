<?php
// dashboard.php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
/* Existing CSS */

/* General page styling */
body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(black, whitesmoke, black);
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    color: white;
}

/* Container for content */
.container {
    text-align: center;
    padding: 50px;
    border-radius: 10px;
    max-width: 600px; /* Add max-width to ensure the container doesn't get too wide */
    width: 100%;
 /* Semi-transparent background */
}

/* Main heading styling */
.container h1 {
    font-size: 3em;
    margin-bottom: 20px;
    text-shadow: 2px 2px 4px black;
}

/* Button group container */
.button-group {
    margin-bottom: 20px;
    display: flex;
    flex-direction: row; /* Keep buttons in a row for larger screens */
    justify-content: center;
}

/* Button styling */
.btn {
    text-decoration: none;
    color: white;
    background: rgba(0, 0, 0, 0.7);
    padding: 10px 20px;
    margin: 0 10px;
    border: 2px solid #f1c40f;
    border-radius: 5px;
    transition: background 0.3s, transform 0.3s;
    font-size: 1em;
    text-align: center;
}

/* Button hover effect */
.btn:hover {
    background: #f1c40f;
    color: black;
    transform: scale(1.05);
}

/* Message styling */
.message {
    font-size: 1.5em;
    margin-top: 30px;
    color: #f1c40f;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
}

/* Additional CSS for responsiveness */

/* Media query for tablets and smaller screens */
@media (max-width: 768px) {
    /* Reduce the size of the heading */
    .container h1 {
        font-size: 2.5em;
    }

    /* Adjust button paddings and margins */
    .btn {
        padding: 10px 15px;
        font-size: 0.9em;
        margin: 5px;
    }

    /* Stack buttons vertically instead of in a row */
    .button-group {
        flex-direction: column;
        align-items: center;
    }
}

/* Media query for phones and smaller screens */
@media (max-width: 480px) {
    /* Further reduce the size of the heading */
    .container h1 {
        font-size: 2em;
    }

    /* Adjust button paddings and margins for smaller screens */
    .btn {
        padding: 10px;
        font-size: 0.8em;
        margin: 5px;
    }

    /* Reduce the size of the message text */
    .message {
        font-size: 1.2em;
    }
}


    </style>
</head>
<body>
<div class="container">
        <h1>ONLINE QUIZ SYSTEM</h1>
        <div class="button-group">
            <a href="create_quiz.php" class="btn">CREATE QUIZ</a>
            <a href="join_quiz.php" class="btn">JOIN QUIZ</a>
        </div>
        <p class="message">GOOD LUCK.</p>
    </div>
    


   
</body>
</html>
