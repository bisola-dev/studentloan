<?php
session_start();
require_once("cann.php");
require_once("canny.php");

// Fetch parameters from URL
$fullName = isset($_GET['fullname']) ? htmlspecialchars($_GET['fullname'], ENT_QUOTES, 'UTF-8') : '';
$matricNumber = isset($_GET['matricnum']) ? htmlspecialchars($_GET['matricnum'], ENT_QUOTES, 'UTF-8') : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
            padding: 50px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Application Successfully Submitted</h1>
        <p>Thank you, <strong><?php echo $fullName; ?></strong>! Your application has been submitted successfully.</p>
        <p><a href="index.php">Go back to home</a></p>
    </div>
</body>
</html>
