<?php
// join_quiz.php

// Include functions and start session
include 'functions.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quizCode = htmlspecialchars(trim($_POST['quiz_code']));
    $userId = $_SESSION['user_id'];

    // Call function to join quiz by code
    $quizId = joinQuizByCode($userId, $quizCode);

    if ($quizId) {
        // Successful join, redirect to take_quiz.php
        header("Location: take_quiz.php?quiz_id=$quizId");
        exit;
    } else {
        // Invalid quiz code
        echo "<p class='error'>Invalid quiz code.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Quiz</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('https://static.vecteezy.com/system/resources/previews/002/386/783/large_2x/sky-and-clouds-in-beautiful-pink-pastel-background-abstract-sweet-dreamy-colored-sky-background-and-romantic-free-photo.jpg');
            background-size: cover;
            background-position: center;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px purple;
            text-align: center;
            width: 100%;
            height: 300px;
            max-width: 400px;
            margin: 0 20px;
            transition: all 0.3s ease;
        }

        h2 {
            margin-bottom: 20px;
            color: darkmagenta;
            font-size: 2em;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        input[type="text"] {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            box-shadow: 0 0 20px purple;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 20px purple;
        }

        button {
            padding: 15px;
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 10px;
        }

        h1 {
            position: absolute;
            top: 10%;
            left: 5%;
            color: white;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                border-radius: 10px;
            }

            h2 {
                font-size: 1.5em;
            }

            input[type="text"], button {
                padding: 12px;
                font-size: 0.9em;
            }

            h1 {
                font-size: 2em;
                top: 5%;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 15px;
                border-radius: 8px;
            }

            h2 {
                font-size: 1.3em;
            }

            input[type="text"], button {
                padding: 10px;
                font-size: 0.8em;
            }

            h1 {
                font-size: 1.5em;
                top: 5%;
                left: 10%;
            }
        }
    </style>
</head>
<body>
    <h1>JOIN THE QUIZ!!</h1>
    <div class="container">
        <h2>Join Quiz</h2>
        <form method="POST" action="">
            <input type="text" name="quiz_code" placeholder="Quiz Code" required><br>
            <button type="submit">Join Quiz</button>
            
            <p style="font-weight: bold; text-shadow: 2px 2px 5px darkmagenta">Attempt the quiz with <i class="fa-solid fa-heart" style="color: red;"></i></p>
    
        </form>
    </div>
</body>
</html>
