<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url(https://wallpaperboat.com/wp-content/uploads/2020/03/pink-sky-08.jpg);
        }

        .results-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px darkviolet;
            width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn-back {
            padding: 10px;
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            box-sizing: border-box;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            box-shadow: 0 0 10px darkblue;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        p.error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="results-container">
    <?php
    include 'config.php';
    session_start();
    
include 'functions.php';

    // Check if quiz_id parameter is provided in the URL
    if (isset($_GET['quiz_id'])) {
        $quizId = intval($_GET['quiz_id']);

        // Retrieve user's results
        $sql = "SELECT COUNT(*) AS total_questions, SUM(IF(user_option != correct_option, 1, 0)) AS incorrect_questions FROM quiz_results WHERE quiz_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $quizId);
        $stmt->execute();
        $stmt->bind_result($totalQuestions, $incorrectQuestions);
        $stmt->fetch();
        $stmt->close();

        if ($totalQuestions > 0) {
            $score = $totalQuestions - $incorrectQuestions;
            echo "<h2>Your Results</h2>";
            echo "<p>You scored $score out of $totalQuestions.</p>";
            echo "<p>You answered $incorrectQuestions question(s) incorrectly.</p>";

            // Update the results table with current quiz attempt
            $takenAt = date('Y-m-d H:i:s'); // Assuming you want to record the time of quiz completion
            $sql_insert = "INSERT INTO results (total_questions, score, quiz_id, taken_at, correct_option_id) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            if ($stmt_insert) {
                $stmt_insert->bind_param("iiisi", $totalQuestions, $score, $quizId, $takenAt, $correctOptionId);
                $stmt_insert->execute();
                $stmt_insert->close();
            } else {
                echo "<p class='error'>Error inserting quiz results: " . $conn->error . "</p>";
            }

            // Retrieve overall statistics
            $sql_avg = "SELECT AVG(score) AS avg_score, COUNT(*) AS total_attempts FROM results WHERE quiz_id = ?";
            $stmt_avg = $conn->prepare($sql_avg);
            $stmt_avg->bind_param("i", $quizId);
            $stmt_avg->execute();
            $stmt_avg->bind_result($avgScore, $totalAttempts);
            $stmt_avg->fetch();
            $stmt_avg->close();

            if ($totalAttempts) {
                echo "<h2>Overall Statistics</h2>";
                echo "<table>
                        <tr><th>Average Score</th><td>" . round($avgScore, 2) . "</td></tr>
                        <tr><th>Total Attempts</th><td>$totalAttempts</td></tr>
                      </table>";
            }
        } else {
            echo "<p class='error'>No results found for this quiz.</p>";
        }
    } else {
        echo "<p class='error'>Quiz ID is not provided.</p>";
    }
    ?>
    <a class="btn-back" href="index.php">Back to Home</a>
    </div>
</body>
</html>
