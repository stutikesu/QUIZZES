<?php
// take_quiz.php

include 'functions.php';
session_start();

// Redirect user to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Redirect user to join quiz if quiz ID is not set
if (!isset($_SESSION['quiz_id'])) {
    header("Location: join_quiz.php");
    exit;
}

$quizId = $_SESSION['quiz_id'];
$userId = $_SESSION['user_id'];

// Fetch quiz questions from the database
$quizQuestions = getQuizQuestions($quizId);

// Check for form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $answers = array();
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'answer_') !== false) {
            $questionId = substr($key, strlen('answer_'));
            $answers[$questionId] = intval($value); // Store selected option ID
        }
    }

    // Process submitted answers
    try {
        processQuizSubmission($answers, $userId, $quizId);

        // Redirect to view results
        header("Location: view_results.php?quiz_id=" . urlencode($quizId));
        exit;
    } catch (Exception $e) {
        echo "Error processing quiz submission: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            background:linear-gradient(white,plum,purple);
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        h2 {
            margin-bottom: 20px;
        }

        .question-container {
            display: none;
        }

        .question-container.active {
            display: block;
        }

        p {
            margin-bottom: 10px;
        }

        button {
            padding: 10px;
            width: 100%;
            background-color: darkblue;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            box-sizing: border-box;
            margin-top: 10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Quiz Questions</h2>
        <?php if (!empty($quizQuestions)): ?>
            <form method="POST" action="" id="quizForm">
                <?php foreach ($quizQuestions as $index => $question): ?>
                    <div class="question-container <?= $index === 0 ? 'active' : '' ?>" data-question-index="<?= $index ?>">
                        <p><?= htmlspecialchars($question['question']) ?></p>
                        <?php foreach ($question['options'] as $optionIndex => $option): ?>
                            <div class="option">
                                <label>
                                    <input type="radio">
                                    <?= htmlspecialchars($option['text']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
                <div id="navigationButtons">
                    <button type="button" id="prevButton" onclick="showPreviousQuestion()" style="display: none;">Previous</button>
                    <button type="button" id="nextButton" onclick="showNextQuestion()">Next</button>
                    <button type="submit" id="submitButton" style="display: none;">Submit Quiz</button>
                </div>
            </form>
        <?php else: ?>
            <p class="error">No questions found for this quiz.</p>
        <?php endif; ?>
    </div>

    <script>
        let currentQuestionIndex = 0;
        const questions = document.querySelectorAll('.question-container');
        const prevButton = document.getElementById('prevButton');
        const nextButton = document.getElementById('nextButton');
        const submitButton = document.getElementById('submitButton');

        function updateNavigationButtons() {
            prevButton.style.display = currentQuestionIndex === 0 ? 'none' : 'block';
            nextButton.style.display = currentQuestionIndex === questions.length - 1 ? 'none' : 'block';
            submitButton.style.display = currentQuestionIndex === questions.length - 1 ? 'block' : 'none';
        }

        function showQuestion(index) {
            questions[currentQuestionIndex].classList.remove('active');
            currentQuestionIndex = index;
            questions[currentQuestionIndex].classList.add('active');
            updateNavigationButtons();
        }

        function showNextQuestion() {
            if (currentQuestionIndex < questions.length - 1) {
                showQuestion(currentQuestionIndex + 1);
            }
        }

        function showPreviousQuestion() {
            if (currentQuestionIndex > 0) {
                showQuestion(currentQuestionIndex - 1);
            }
        }

        // Initialize navigation buttons
        updateNavigationButtons();
    </script>
</body>
</html>
