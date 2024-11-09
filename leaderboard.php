<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Load the leaderboard data
$leaderboardFile = 'leaderboard.txt';
$leaderboardData = [];

if (file_exists($leaderboardFile) && filesize($leaderboardFile) > 0) {
    $leaderboardData = file($leaderboardFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - Who Wants to Be a Millionaire</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ccc;
        }

        th {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e0e0e0;
        }

        .button-container {
            display: flex;
            justify-content: space-evenly;
            gap: 20px;
            margin-top: 25px;
        }

        .button {
            text-decoration: none;
            margin: 25px;
            padding: 15px 30px;
            font-weight: bold;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .button.animate {
            background: linear-gradient(135deg, #203a43, #2c5364);
            color: #fff;
            border: 2px solid #00d1b2;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .button.animate:hover {
            background: #00d1b2;
            color: #333;
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        td {
            color: black;
        }

        /* Confetti Animation */
        .confetti {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 999;
        }

        .confetti .confetti-piece {
            position: absolute;
            top: -10px;
            width: 10px;
            height: 10px;
            background-color: #ff0000;
            animation: fall 3s infinite linear;
            opacity: 0;
        }

        .confetti .confetti-piece:nth-child(1) { background-color: #ff0000; }
        .confetti .confetti-piece:nth-child(2) { background-color: #00ff00; }
        .confetti .confetti-piece:nth-child(3) { background-color: #0000ff; }
        .confetti .confetti-piece:nth-child(4) { background-color: #ff6347; }
        .confetti .confetti-piece:nth-child(5) { background-color: #ffff00; }

        /* Confetti falling animation */
        @keyframes fall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* Randomize confetti positions and delays */
        .confetti .confetti-piece:nth-child(1) { left: 10%; animation-delay: 0s; }
        .confetti .confetti-piece:nth-child(2) { left: 20%; animation-delay: 0.1s; }
        .confetti .confetti-piece:nth-child(3) { left: 30%; animation-delay: 0.2s; }
        .confetti .confetti-piece:nth-child(4) { left: 40%; animation-delay: 0.3s; }
        .confetti .confetti-piece:nth-child(5) { left: 50%; animation-delay: 0.4s; }
        .confetti .confetti-piece:nth-child(6) { left: 60%; animation-delay: 0.5s; }
        .confetti .confetti-piece:nth-child(7) { left: 70%; animation-delay: 0.6s; }
        .confetti .confetti-piece:nth-child(8) { left: 80%; animation-delay: 0.7s; }
        .confetti .confetti-piece:nth-child(9) { left: 90%; animation-delay: 0.8s; }

    </style>
</head>
<body>

<a href="logout.php" class="button animate logout">Logout</a>
<img src="images/logo.png" class="logo" alt="Logo">
<div class="container">
    <h1>Leaderboard</h1>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Username</th>
                <th>Earnings</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $scores = [];

            foreach ($leaderboardData as $entry) {
                list($username, $score) = explode(',', $entry);
                $scores[$username] = (int)$score; 
            }

            arsort($scores);
            $rank = 1;

            foreach ($scores as $username => $score) {
                echo "<tr>
                        <td>{$rank}</td>
                        <td>" . htmlspecialchars($username) . "</td>
                        <td>" . number_format($score) . "$</td>
                      </tr>";
                $rank++;
            }
            ?>
        </tbody>
    </table>
    <div class="button-container">
        <a href="menu.php" class="button animate">Back to Menu</a>
    </div>
</div>

<div class="confetti">
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
    <div class="confetti-piece"></div>
</div>
</body>
</html>