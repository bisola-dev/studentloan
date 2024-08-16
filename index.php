<?php 
session_start(); 
require_once("cann.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize matric number from form submission
    $matricNumber = trim($_POST['matnubr']); // Remove extra spaces

    // Validate matric number format (example pattern)
    $pattern = '/^[a-zA-Z0-9\/]+$/';
    if (!preg_match($pattern, $matricNumber)) { 
        echo '<script type="text/javascript">
                alert("Invalid matric number format. Please enter a valid matric number");
              </script>';

        exit();
    }

    try {
        // Prepare and execute the SQL query
        $sql = "SELECT * FROM [student].[dbo].[vw_student_record_1] WHERE matricnum = ?";
        $params = array($matricNumber);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception("Database query failed: " . print_r(sqlsrv_errors(), true));
        }

        // Fetch the results
        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        if ($result ==  0) {
            echo '<script type="text/javascript">
            alert("No records found for this Matric Number");
            </script>';
            
            "<h1>No records found for Matric Number: " . htmlspecialchars($matricNumber) . "</h1>";
        } else {
            // Store the student details in session
            $_SESSION['surname'] = $result['surname'];
            $_SESSION['firstname'] = $result['firstname'];
            $_SESSION['othername'] = $result['othername'];
            $_SESSION['matricnum'] = $matricNumber;
            $_SESSION ['Current_session'] = $result['Current_session'];
            $_SESSION['Current_semester'] = $result['Current_semester'];
            
    

            $fullName = htmlspecialchars($result['surname']) . ' ' .
                        htmlspecialchars($result['firstname']) . ' ' .
                        htmlspecialchars($result['othername']);
 

            $_SESSION['fullname'] = $fullName;
            $_SESSION['matricnum'] = $matricNumber;

            // Use JavaScript for user feedback and redirection
            echo '<script type="text/javascript">
                alert("Log in successful");
                window.location.href = "loanform.php";
                </script>';
            exit(); // Ensure no further code is executed after redirect
        }
    } catch (Exception $e) {
        // Handle exceptions
        echo "<h1>Error: " . htmlspecialchars($e->getMessage()) . "</h1>";
        // Optionally log the error or send an email to admin
    }
} 
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Loan Application</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f1; /* Light grey background */
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensures the body takes full height of the viewport */
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

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1; /* Takes up available space */
            padding: 20px;
        }

        .form-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 600px;
            margin: 0 20px;
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

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            box-sizing: border-box; /* Includes padding and border in the element's total width and height */
        }

        button {
            background-color: #ffcc00; /* Yellow */
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

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
                width: auto;
                max-width: 90%;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="imgg/yabanewlogo.png" alt="Yaba College of Technology">
        </div>
    </header>
    
    <main>
        <section class="form-container">
            <h1>Student Loan Application</h1>
            <form action="" method="post">
                <label for="matricNumber">Please enter your matric number:</label>
                <input type="text" id="matnubr" name="matnubr" required>
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2024 Yaba College of Technology</p>
    </footer>
</body>
</html>
