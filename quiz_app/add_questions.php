
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Questions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('https://wallpaperset.com/w/full/2/1/f/77005.jpg');
            background-size: cover;
        }

        form {
            background-color: whitesmoke;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px green;
            width: 300px;
            
            text-align: center;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 12px 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
             box-shadow: 0 0 3px #65cdee ;
            font-size: 16px;
        }

        input[type="text"]:focus, input[type="number"]:focus {
            outline: none;
            
            border-color: #28a745;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"]::placeholder {
            color: #aaa;
        }

        input[type="text"]::placeholder {
            color: #bbb;
        }

        input[type="text"]:hover, input[type="number"]:hover {
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        button {
            padding: 12px 20px;
            background-color:#65cdee ;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        p.error {
            color: red;
            font-size: 0.9em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php
    include 'functions.php';
    session_start();

    if (!isset($_SESSION['quiz_id'])) {
        echo "<p class='error'>No quiz selected. Please create a quiz first.</p>";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $quizId = $_SESSION['quiz_id'];
        $question = htmlspecialchars(trim($_POST['question']));
        $options = array_map('htmlspecialchars', array_map('trim', $_POST['options']));
        $correctOption = intval($_POST['correct_option']);

        if ($correctOption < 0 || $correctOption >= count($options)) {
            echo "<p class='error'>Invalid correct option index.</p>";
        } else {
            // Insert question into the database
            $sql = "INSERT INTO Questions (quiz_id, question) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $quizId, $question);

            if ($stmt->execute()) {
                $questionId = $stmt->insert_id;

                // Insert options into the database
                $sql = "INSERT INTO Options (question_id, option_text, is_correct) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                foreach ($options as $index => $option) {
                    $isCorrect = ($index == $correctOption) ? $index : $index;
                    $stmt->bind_param("isi", $questionId, $option, $isCorrect);
                    $stmt->execute();
                }

                // Insert into quiz_results for demonstration (if really needed)
                $correctOptionText = $options[$correctOption];
                $sql = "INSERT INTO quiz_results (question, correct_option, quiz_id) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("iii", $question, $correctOption, $quizId);
                    $stmt->execute();
                }

                echo "<p style='color: green;'>Question added successfully!</p>";
            } else {
                echo "<p class='error'>Error adding question: " . $stmt->error . "</p>";
            }

            $stmt->close();
        }
    }
    ?>
    <h1 style="color:whitesmoke; margin-bottom:20px; font-style:italic">Maximum number of question should be 2</h1>
    &nbsp;&nbsp;
    <form method="POST" action="">
        <input type="text" name="question" placeholder="Enter Question" required><br>
        <input type="text" name="options[]" placeholder="Option 1" required><br>
        <input type="text" name="options[]" placeholder="Option 2" required><br>
        <input type="text" name="options[]" placeholder="Option 3" required><br>
        <input type="text" name="options[]" placeholder="Option 4" required><br>
        <input type="number" name="correct_option" placeholder="Correct Option (0-3)" min="0" max="3" required><br>
        <button type="submit">Add Question</button>

       <p> <a href="index.php" style="text-decoration:none; color:plum; font-weight:500;">Back to Home</a></p>
    </form>
</body>
</html>