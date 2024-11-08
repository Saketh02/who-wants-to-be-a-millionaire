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
            <p>Welcome to "Who Wants to Be a Millionaire". Follow these instructions carefully:</p>
            <ul>
                <li>Answer questions to the best of your knowledge.</li>
                <li>Each question has multiple choices; choose the correct one.</li>
                <li>You can use lifelines to help with difficult questions.</li>
            </ul>
            <div class="close">
                <a href="#" class="close-btn">Close</a>
            </div>
            
        </div>
    </div>
</body>
</html>
