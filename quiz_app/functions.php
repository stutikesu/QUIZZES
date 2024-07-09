<?php
// functions.php - Functions for interacting with database and handling quiz operations
include 'config.php'; // Include your database connection

function generateQuizCode($quizId) {
    global $conn;
    $code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 10);
    $sql = "INSERT INTO QuizCodes (quiz_id, code) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $quizId, $code);
    $stmt->execute();
    return $code;
}

function joinQuizByCode($userId, $quizCode) {
    global $conn;
    $sql = "SELECT quiz_id FROM QuizCodes WHERE code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $quizCode);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $quizId = $row['quiz_id'];
        $sql = "INSERT INTO UserQuizParticipation (user_id, quiz_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $userId, $quizId);
        $stmt->execute();
        return $quizId;
    } else {
        return null;
    }
}

function getQuizQuestions($quizId) {
    global $conn; // Assuming $conn is your database connection

    $questions = array();

    // Select questions and their options
    $sql = "SELECT q.id AS question_id, q.question, o.id AS option_id, o.option_text
            FROM Questions q
            LEFT JOIN Options o ON q.id = o.question_id
            WHERE q.quiz_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $quizId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $questionId = $row['question_id'];
        if (!isset($questions[$questionId])) {
            $questions[$questionId]['question'] = $row['question'];
            $questions[$questionId]['options'] = array();
        }
        if ($row['option_id'] !== null) {
            $questions[$questionId]['options'][] = array(
                'id' => $row['option_id'],
                'text' => $row['option_text']
            );
        }
    }

    $stmt->close();

    return $questions;
}

function processQuizSubmission($correctOption, $userId, $quizId) {
    global $conn;

    foreach ($correctOption as $questionId => $userOptionId) {
        // Fetch the correct option ID and text for the question
        $sql = "SELECT correct_option_id FROM Options WHERE question_id = ? AND is_correct = 1 LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $questionId);
        $stmt->execute();
        $stmt->bind_result($correctOptionId);
        $stmt->fetch();
        $stmt->close();

        // Check if a row already exists for this question in quiz_results
        $sql_check = "SELECT id FROM quiz_results WHERE quiz_id = ? AND user_id = ? AND question = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("iii", $quizId, $userId, $questionId);
        $stmt_check->execute();
        $stmt_check->store_result();
        if ($stmt_check->num_rows > 0) {
            // Update the existing row
            $sql_update = "UPDATE quiz_results SET user_option = ? WHERE quiz_id = ? AND user_id = ? AND question = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("iiii", $userOptionId, $quizId, $userId, $questionId);
            $stmt_update->execute();
            $stmt_update->close();
        } 
        $stmt_check->close();
    }
}







// Retrieve the correct option ID for a given question and quiz
function getCorrectOptionId($questionId, $quizId) {
    global $conn;

    $sql = "SELECT correct_option_id FROM Questions WHERE id = ? AND quiz_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $questionId, $quizId);
        $stmt->execute();
        $stmt->bind_result($correctOptionId);
        $stmt->fetch();
        $stmt->close();
        return $correctOptionId;
    } else {
        throw new Exception("Failed to prepare statement for retrieving correct option ID.");
    }
}


// Fetch user's answers for a specific quiz
function getUserAnswers($userId, $quizId) {
    global $conn;

    $sql = "SELECT a.question_id, a.selected_option_id, q.question, o.option_text AS user_answer
            FROM Answers a
            JOIN Questions q ON a.question_id = q.id
            JOIN Options o ON a.selected_option_id = o.id
            WHERE a.user_id = ? AND a.quiz_id = ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $userId, $quizId);
        $stmt->execute();
        $result = $stmt->get_result();
        $userAnswers = array();
        while ($row = $result->fetch_assoc()) {
            $userAnswers[] = $row;
        }
        $stmt->close();
        return $userAnswers;
    } else {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }
}

// Fetch correct answers and score
function calculateScore($userAnswers, $quizId) {
    global $conn;

    $sql = "SELECT q.id AS question_id, q.question, o.id AS correct_option_id, o.option_text AS correct_answer
            FROM Questions q
            JOIN Options o ON q.correct_option_id = o.id
            WHERE q.quiz_id = ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $quizId);
        $stmt->execute();
        $result = $stmt->get_result();
        $correctAnswers = array();
        while ($row = $result->fetch_assoc()) {
            $correctAnswers[$row['question_id']] = $row;
        }
        $stmt->close();
        
        // Calculate score
        $scoreData = array();
        $totalScore = 0;
        $totalQuestions = count($correctAnswers);

        foreach ($userAnswers as $answer) {
            $questionId = $answer['question_id'];
            $userAnswer = $answer['user_answer'];
            $correctAnswer = $correctAnswers[$questionId]['correct_answer'];
            $isCorrect = ($answer['selected_option_id'] == $correctAnswers[$questionId]['correct_option_id']);
            if ($isCorrect) {
                $totalScore++;
            }

            $scoreData[] = array(
                'question' => $answer['question'],
                'your_answer' => $userAnswer,
                'correct_answer' => $correctAnswer
            );
        }

        $scoreData['total_score'] = $totalScore;
        $scoreData['total_questions'] = $totalQuestions;
        return $totalScore;
    } else {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }
}

?>