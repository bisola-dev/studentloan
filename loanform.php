<?php
session_start(); 
require_once("cann.php");
require_once("canny.php");

// Retrieve session variables with default values
$fullName = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : null;
$matricNumber = isset($_SESSION['matricnum']) ? $_SESSION['matricnum'] : null;
$Current_session = isset($_SESSION['Current_session']) ? $_SESSION['Current_session'] : null;
$Current_semester = isset($_SESSION['Current_semester']) ? $_SESSION['Current_semester'] : null;

// Check if any session variable is empty
if (empty($fullName) || empty($matricNumber) || empty($Current_session) || empty($Current_semester)) {
    header("Location:index.php"); 
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f1; /* Light grey background */
            display: flex;
            flex-direction: column;
            height: 100vh; /* Full height of the viewport */
        }

        header {
            background-color: #004d00; /* Dark green */
            color: white;
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header .logo img {
            max-width: 180px; /* Adjust width based on your logo size */
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .warning {
            background-color: #f44336; /* Red */
            color: #ffd700; /* Golden font color */
            padding: 10px; /* Reduced padding */
            text-align: center;
            font-weight: bold;
            font-size: 14px; /* Reduced font size */
            margin-bottom: 20px; /* Space below the warning */
        }
        main {
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: flex-start; /* Align items to the start (top) */
            flex: 1; /* Take up remaining space between header and footer */
            padding: 20px; /* Padding around the form */
            box-sizing: border-box; /* Include padding in the element's total width and height */
        }

        .form-container {
            background-color: #ffcc00; /* Yellow */
            border-radius: 12px;
            padding: 12px 24px;
            color: #004d00; /* Dark green text */
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        h1 {
            color: #004d00; /* Dark green */
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            box-sizing: border-box; /* Includes padding and border in the element's total width and height */
        }

        button {
            background-color: #28a745; /* Green */
            border: none;
            padding: 12px 24px;
            color: #004d00; /* Dark green text */
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #e6b800; /* Darker yellow */
            transform: scale(1.05); /* Slightly scale up button on hover */
        }

        footer {
            background-color: #004d00; /* Dark green */
            color: white;
            text-align: center;
            padding: 15px;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="imgg/yabanewlogo.png" alt="Yaba College of Technology">
        </div>
    </header>

    <div class="warning">
        <p>Please ensure that all details are filled in correctly. Incorrect details will lead to disqualification of the student loan application.</p>
    </div>

    <main>
        <section class="form-container">
            <h1>Welcome, <?php echo htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8'); ?>!</h1>
            <form action="look.php" method="post">
                <label for="nin">Please enter your NIN (11 digits):</label>
                <input type="hidden" name="fullname" value="<?php echo htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="matricnum" value="<?php echo htmlspecialchars($matricNumber, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="Current_session" value="<?php echo htmlspecialchars($Current_session, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="Current_semester" value="<?php echo htmlspecialchars($Current_semester, ENT_QUOTES, 'UTF-8'); ?>">

                <input type="text" id="nin" name="nin" pattern="\d{11}" title="NIN must be exactly 11 digits" required>

                <label for="jamb">Please enter your JAMB number (10, 11, 12, or up to 16 alphanumeric characters):</label>
                 <input type="text" id="jamb" name="jamb" pattern="^[A-Za-z0-9]{10,16}$" title="JAMB number must be between 10 and 16 alphanumeric characters" required>

                <label for="email">Personal Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>

                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" pattern="\d{10,15}" title="Phone number must be between 10 to 15 digits" required>

                <button type="submit">Submit</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Yaba College of Technology</p>
    </footer>
</body>
</html>