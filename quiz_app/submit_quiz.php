<?php
include 'config.php';
include 'functions.php';
session_start();

$userId = $_SESSION['user_id'];
$quizId = intval($_POST['quiz_id']);
$answers = $_POST['quiz_results']; // Assuming answers are sent as an associative array [question_id => selected_option_id]

try {
    // Debugging: Output the received answers for verification
    echo "Received Answers:<pre>";
    print_r($answers);
    echo "</pre>";

    processQuizSubmission($answers, $userId, $quizId);

    // Redirect to results page
    header("Location: view_results.php?quiz_id=$quizId");
    exit();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
