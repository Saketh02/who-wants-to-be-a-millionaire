<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 0;
}
if (!isset($_SESSION['question_index'])) {
    $_SESSION['question_index'] = 0;
}
$allQuestionsFinished = false; 

$questions = file('questions.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$totalQuestions = count($questions);

$progress = 0;
if ($_SESSION['question_index'] >= $totalQuestions-1) {
    $progress = 100;
} else {
    $progress = ($_SESSION['question_index'] / $totalQuestions) * 100;
}

if (isset($_POST['reset'])) {
    $_SESSION['score'] = 0;
    $_SESSION['question_index'] = 0;  
    $allQuestionsFinished = false;
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if ($_SESSION['question_index'] >= $totalQuestions) {
    $allQuestionsFinished = true; 
} else {
    $currentQuestion = $questions[$_SESSION['question_index']];
    list($questionText, $optionA, $optionB, $optionC, $optionD, $correctAnswer) = explode('|', $currentQuestion);

    $selectedAnswer = null; 
    $feedback = ""; 
    $feedbackClass = ""; 

    function getScoreForQuestion($questionIndex, $isCorrect) {
    
        $score = 0;

        if ($questionIndex >= 0 && $questionIndex <= 2) { 
            $score = $isCorrect ? 1000 : -500;
        } elseif ($questionIndex >= 3 && $questionIndex <= 5) { 
            $score = $isCorrect ? 5000 : -2500;
        } elseif ($questionIndex >= 6 && $questionIndex <= 9) { 
            $score = $isCorrect ? 10000 : -5000;
        } elseif ($questionIndex >= 10 && $questionIndex <= 12) { 
            $score = $isCorrect ? 25000 : -10000;
        } elseif ($questionIndex >= 13 && $questionIndex <= 15) { 
            $score = $isCorrect ? 100000 : -50000;
        } elseif ($questionIndex >= 16 && $questionIndex <= 18) { 
            $score = $isCorrect ? 500000 : -250000;
        } elseif ($questionIndex == 19) { 
            $score = $isCorrect ? 1000000 : -500000;
        }

        return $score;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
        $selectedAnswer = $_POST['answer'];


        if ($selectedAnswer === $correctAnswer) {
        
            $_SESSION['score'] += getScoreForQuestion($_SESSION['question_index'], true);
            $feedback = "Correct!";
            $feedbackClass = "correct";
        } else {
            $_SESSION['score'] += getScoreForQuestion($_SESSION['question_index'], false);
            $feedback = "Wrong! The correct answer was: $correctAnswer";
            $feedbackClass = "wrong";
        }

        $_SESSION['question_index']++;

        if ($_SESSION['question_index'] >= $totalQuestions) {
            $allQuestionsFinished = true;
            $leaderboardFile = 'leaderboard.txt';
            $username = $_SESSION['username'];
            $score = $_SESSION['score'];
            
            $contents = file($leaderboardFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $found = false;
        
            foreach ($contents as &$line) {
                list($existingUsername, $existingScore) = explode(',', $line);
                if (trim($existingUsername) === $username) {
                    $line = $username . ',' . max($score, (int)$existingScore);
                    $found = true;
                    break;
                }
            }
        
            if (!$found) {
                $contents[] = "$username,$score";
            }
        
            file_put_contents($leaderboardFile, implode(PHP_EOL, $contents));
        }
        
    } else {
        $feedback = ""; 
        $feedbackClass = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game - Who Wants to Be a Millionaire</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .title {
            font-size: 1.3rem;
            text-align: center;
            margin-bottom: 20px;
        }

        .question-container {
            padding: 15px;
            font-size: 0.95rem;
        }

        .question {
            font-size: 1.1rem;
            margin-bottom: 12px;
        }

        .options {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .option {
            background-color: #e0e0e0;
            border: none;
            border-radius: 6px;
            padding: 12px 20px;
            margin: 8px;
            font-size: 0.95rem;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            text-align: left;
        }

        .option:hover {
            background-color: #d1d1d1;
        }

        .option.selected {
            background-color: #00d1b2;
            color: white;
            transform: scale(1.05);
        }


        .progress-container {
            width: 100%;
            max-width: 600px;
            text-align: center;
            margin-bottom: 20px;
        }

        progress {
            width: 100%;
            height: 15px;
            border-radius: 10px;
            background-color: #f1f1f1;
            appearance: none;
        }

        progress::-webkit-progress-bar {
            background-color: #f1f1f1;
            border-radius: 10px;
        }

        progress::-webkit-progress-value {
            background-color: #00d1b2;
            border-radius: 10px;
        }

        progress::-moz-progress-bar {
            background-color: #00d1b2;
            border-radius: 10px;
        }

        #progress-text {
            font-size: 0.9rem;
            margin-top: 5px;
            color: #333;
        }

        
        .feedback {
            font-size: 1.1rem;
            text-align: center;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .correct {
            color: green;
            opacity: 1;
        }

        .wrong {
            color: red;
            opacity: 1;
        }

        
        .button-container {
            text-align: center;
            margin: 20px 0;
        }

        .button {
            padding: 12px 24px;
            font-size: 1rem; 
            background-color: #00d1b2;
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .button:hover {
            background-color: #008c7f;
        }

        .next-button-container {
            display: none;
        }

        .next-button-container.show {
            display: block; 
        }

        .score {
            font-size: 1rem; 
            margin-top: 20px;
            text-align: center;
        }
        
        .button {
            margin:0;
        }

        #progress-text {
            color: white;
        }
    </style>
</head>
<body>
<img src="images/logo.png" class="logo" alt="Logo">
    <div class="container">
        <h1 class="title">Who Wants to Be a Millionaire?</h1>

        <div class="progress-container">
            <label for="progress-bar">Progress</label>
            <progress id="progress-bar" value="<?php echo round($progress); ?>" max="100"></progress>
            <p id="progress-text"><?php echo round($progress); ?>% Complete</p>
        </div>

        <div class="button-container">
            <a href="logout.php" class="button animate">Logout</a>
            <a href="leaderboard.php" class="button animate">Leaderboard</a>
        </div>

        <div class="question-container">
            <?php if (!$allQuestionsFinished): ?>
                <p class="question"><?php echo isset($questionText) ? $questionText : ''; ?></p>
                <form method="POST">
                    <div class="options">
                        <button type="submit" name="answer" value="A" class="option <?php echo ($selectedAnswer === 'A') ? 'selected' : ''; ?>" 
                                <?php echo ($selectedAnswer) ? 'disabled' : ''; ?>><?php echo isset($optionA) ? $optionA : ''; ?></button>
                        <button type="submit" name="answer" value="B" class="option <?php echo ($selectedAnswer === 'B') ? 'selected' : ''; ?>" 
                                <?php echo ($selectedAnswer) ? 'disabled' : ''; ?>><?php echo isset($optionB) ? $optionB : ''; ?></button>
                        <button type="submit" name="answer" value="C" class="option <?php echo ($selectedAnswer === 'C') ? 'selected' : ''; ?>" 
                                <?php echo ($selectedAnswer) ? 'disabled' : ''; ?>><?php echo isset($optionC) ? $optionC : ''; ?></button>
                        <button type="submit" name="answer" value="D" class="option <?php echo ($selectedAnswer === 'D') ? 'selected' : ''; ?>" 
                                <?php echo ($selectedAnswer) ? 'disabled' : ''; ?>><?php echo isset($optionD) ? $optionD : ''; ?></button>
                    </div>
                </form>

                <?php if (isset($feedback) && $feedback): ?>
                    <p class="feedback <?php echo $feedbackClass; ?>"><?php echo $feedback; ?></p>
                <?php endif; ?>

        
                <div class="next-button-container <?php echo ($selectedAnswer) ? 'show' : ''; ?>">
                    <form method="POST" action="">
                        <button type="submit" class="button animate" style="margin-top: 20px;">Next</button>
                    </form>
                </div>

            <?php else: ?>
                <p class="question">You've answered all the questions!</p>
                <form method="POST" action="">
                    <button type="submit" name="reset" class="button animate">Improve Score</button>
                </form>
            <?php endif; ?>
        </div>

        <div class="score">
            <p>Your Earnings: <?php echo number_format($_SESSION['score']); ?>$</p>
        </div>
    </div>
</body>
</html>
