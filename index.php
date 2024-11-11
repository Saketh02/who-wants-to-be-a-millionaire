<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Who Wants to Be a Millionaire</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Existing styles */
        .button-container {
            flex-wrap: wrap;
            gap: 0px;
        }
        .button {
            margin: 18px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s ease;
        }
        .modal:target {
            display: flex;
        }
        .modal-content {
            color: black;
            background-color: #fff;
            padding: 40px;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }

        .modal-content h2 {
            text-align: center;
        }
        
        .close {
            display:flex;
            justify-content:center;
        }
        .close-btn {
            display: inline-block;
            margin-top: 20px;
            color: #fff;
            background-color: #333;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .instructions-modal {
            padding:
        }
    </style>
</head>
<body>
    <img src="images/logo.png" class="logo" alt="Logo">
    <div class="container">
        <h1 class="title">Who Wants to Be a Millionaire?</h1>
        <?php
        if (isset($_GET['message'])) {
            echo "<p class='success'>" . htmlspecialchars($_GET['message']) . "</p>";
        }
        ?>
        <div class="button-container">
            <a href="register.php" class="button animate">Register</a>
            <a href="login.php" class="button animate">Login</a>
            <a href="#instructions-modal" class="button animate">View Instructions</a>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="instructions-modal" class="modal">
    <div class="modal-content">
            <h2>Instructions</h2>
            <p>
                Who Wants to be a Millionaire is a popular game show where contestants answer a series of multiple-choice questions to win increasing amounts of money, with the final goal being a million or more dollars.
            </p><br>
            <h3>How to play the game ??</h2>
            <ul>
                <li>Create an Account</li>
                <li>Login from the Login page and Click Start</li>
                <li>That's all, Questions will be displayed, and you must pick the right answer</li>
                <li>You can see your leaderboard as well and improve your earnings if you wish to</li>
            </ul><br>
            <h3>Rules</h2>
            <ul>
                <li>Note that you can select the option only once</li>
                <li>You cannot go to the previous question</li>
            </ul>
            <div class="close">
                <a href="#" class="close-btn">Close</a>
            </div>

        </div>
    </div>
</body>
</html>
