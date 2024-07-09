<?php
include 'functions.php';
session_start();

$quizCode = ''; // Initialize the quiz code variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));

    // Create the quiz in the database
    $sql = "INSERT INTO Quizzes (title, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $description);

    if ($stmt->execute()) {
        // Get the quiz ID and generate the quiz code
        $quizId = $stmt->insert_id;
        $quizCode = generateQuizCode($quizId);

        // Update the quiz with the generated code
        $updateSql = "UPDATE Quizzes SET code = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $quizCode, $quizId);
        $updateStmt->execute();
        $updateStmt->close();

        // Store the quiz ID and quiz code in the session
        $_SESSION['quiz_id'] = $quizId;
        $_SESSION['quiz_code'] = $quizCode;

        // Display the quiz ID and code on the form
        echo "<p class='success'>Quiz created successfully! Your quiz ID is: <strong>$quizId</strong> and code is: <strong>$quizCode</strong></p>";

        // Share buttons URLs
        $quizURL = 'http://yourquizsite.com/join?code=' . $quizCode;
        $facebookShareURL = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($quizURL);
        $twitterShareURL = 'https://twitter.com/intent/tweet?url=' . urlencode($quizURL) . '&text=Join%20my%20quiz!';
        $whatsappShareURL = 'https://wa.me/?text=Join%20my%20quiz!%20Use%20code:%20' . $quizCode . '%20at%20' . urlencode('http://yourquizsite.com/join');

        // Redirect to the add_questions.php page after a delay
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'add_questions.php';
                }, 5000); // 5000 milliseconds delay (50 seconds)
              </script>";
    } else {
        echo "<p class='error'>Error creating quiz: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
            background-image: url('http://cdn.wallpapersafari.com/16/31/BEjUgV.jpeg');
            background-size: cover;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px darkslategrey;
            width: 400px;
            text-align: center;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            width: 100%;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            box-sizing: border-box;
        }

        button:hover {
            background-color: #218838;
        }

        .success {
            margin-top: 20px;
            color: green;
            font-weight: bold;
        }

        .error {
            margin-top: 20px;
            color: red;
            font-weight: bold;
        }

        .share-buttons {
            margin-top: 20px;
        }

        .share-buttons a {
            margin: 0 5px;
            text-decoration: none;
            color: white;
            padding: 10px;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .share-buttons .copy-link {
            background-color: #6c757d;
        }

        .share-buttons .copy-link:hover {
            background-color: #5a6268;
        }

        .share-buttons .facebook {
            background-color: #3b5998;
        }

        .share-buttons .facebook:hover {
            background-color: #2d4373;
        }

        .share-buttons .twitter {
            background-color: #1da1f2;
        }

        .share-buttons .twitter:hover {
            background-color: #0d95e8;
        }

        .share-buttons .whatsapp {
            background-color: #25d366;
        }

        .share-buttons .whatsapp:hover {
            background-color: #1ebd58;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <input type="text" name="title" placeholder="Quiz Title" required><br>
        <textarea name="description" placeholder="Quiz Description" required></textarea><br>
        <button type="submit">Create Quiz</button>
        <?php if ($quizCode): ?>
            <p class="success">Quiz created successfully! Your quiz ID is: <strong><?= htmlspecialchars($quizId) ?></strong> and code is: <strong><?= htmlspecialchars($quizCode) ?></strong></p>
            <div class="share-buttons">
                <a href="#" class="copy-link" onclick="copyToClipboard('<?= htmlspecialchars($quizCode) ?>')" title="Copy to clipboard"><i class="fa fa-clipboard"></i></a>
                <a href="<?= $facebookShareURL ?>" class="facebook" target="_blank" title="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="<?= $twitterShareURL ?>" class="twitter" target="_blank" title="Share on Twitter"><i class="fab fa-twitter"></i></a>
                <a href="<?= $whatsappShareURL ?>" class="whatsapp" target="_blank" title="Share on WhatsApp"><i class="fab fa-whatsapp"></i></a>
            </div>
        <?php endif; ?>
        <br>
        <br>
        <p style="font-weight: bold; text-shadow: 2px 2px 5px seagreen">Make your quiz with <i class="fa-solid fa-heart" style="color: red;"></i></p>
    </form>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Quiz code copied to clipboard');
            }, function() {
                alert('Failed to copy the quiz code');
            });
        }
    </script>
</body>
</html>
