<?php
session_start();
require_once("cann.php"); // Ensure this includes correct database connection setup
require_once("canny.php"); // Ensure this includes correct database connection setup

// Retrieve form inputs
$fullName = $_POST['fullname'] ?? '';
$matricNumber = $_POST['matricnum'] ?? '';
$Current_session = $_POST['Current_session'] ?? '';
$Current_semester = $_POST['Current_semester'] ?? '';

$responseMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch additional form data
    $nin = $_POST['nin'] ?? '';
    $jamb = $_POST['jamb'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';

    try {
        // Check if an entry exists in summary_table_2
        $sqlCheckSummary = "SELECT COUNT(*) AS count 
                            FROM [student].[dbo].[summary_table_2] 
                            WHERE MatricNo = ? 
                            AND A_SessionID = ? 
                            AND SemesterID = ?";
        $paramsCheckSummary = array($matricNumber, $Current_session, $Current_semester);
        $stmtCheckSummary = sqlsrv_query($conn, $sqlCheckSummary, $paramsCheckSummary);

        if ($stmtCheckSummary === false) {
            throw new Exception("Database query failed: " . print_r(sqlsrv_errors(), true));
        }

        $existsSummary = sqlsrv_fetch_array($stmtCheckSummary, SQLSRV_FETCH_ASSOC);

        if ($existsSummary['count'] > 0) {
            // Proceed to check if the form has already been submitted
            $sqlCheck = "SELECT COUNT(*) AS count 
                         FROM [studentloan].[dbo].[loanapplicant]
                         WHERE matricnum = ? 
                         AND current_session = ?
                         AND current_semester = ?";
            $paramsCheck = array($matricNumber, $Current_session, $Current_semester);
            $stmtCheck = sqlsrv_query($conn, $sqlCheck, $paramsCheck);

            if ($stmtCheck === false) {
                throw new Exception("Database query failed: " . print_r(sqlsrv_errors(), true));
            }

            $exists = sqlsrv_fetch_array($stmtCheck, SQLSRV_FETCH_ASSOC);

            if ($exists['count'] > 0) {
                echo '<script type="text/javascript">
                alert("You have already filled and submitted this form.");
                window.location.href="index.php";
                </script>';
                exit(); // Ensure no further code executes
            }

            // Prepare and execute the insertion query
            $sqlInsert = "INSERT INTO [studentloan].[dbo].[loanapplicant] 
                          (fullname, matricnum, nin, jambno, email, address, phone, current_session, current_semester, date_applied) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, GETDATE())";
            $paramsInsert = array($fullName, $matricNumber, $nin, $jamb, $email, $address, $phone, $Current_session, $Current_semester);
            $stmtInsert = sqlsrv_query($conn, $sqlInsert, $paramsInsert);

            if ($stmtInsert === false) {
                throw new Exception("Failed to insert application: " . print_r(sqlsrv_errors(), true));
            }

            // Free resources and close connection
            sqlsrv_free_stmt($stmtCheckSummary);
            sqlsrv_free_stmt($stmtCheck);
            sqlsrv_free_stmt($stmtInsert);
            sqlsrv_close($conn);

            // Show success message
            $successUrl = 'success.php?fullname=' . urlencode($fullName) . '&matricnum=' . urlencode($matricNumber);
            echo '<script type="text/javascript">
                 alert("Your application has been successfully submitted.");
                 window.location.href="' . $successUrl . '";
                 </script>';
            exit(); // Ensure no further code executes
        } else {
            echo '<script type="text/javascript">
            alert("You are not eligible for this application as no matching records were found.");
            window.location.href="index.php";
            </script>';
            exit(); // Ensure no further code executes
        }
    } catch (Exception $e) {
        $responseMessage = "Error: " . htmlspecialchars($e->getMessage());
        error_log($responseMessage); // Log error for debugging
        echo '<script type="text/javascript">
        alert("' . addslashes($responseMessage) . '");
        window.location.href="index.php";
        </script>';
        exit(); // Ensure no further code executes
    }
}
?>
