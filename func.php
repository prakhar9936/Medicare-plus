<?php
/**
 * MediCare Plus - Main Authentication & Logic Handler
 * Author: Prakhar Agrawal
 * Description: Handles patient login, registration logic,
 *              doctor management and appointment operations
 */

session_start();

// Database connection
$databaseConnection = mysqli_connect("localhost", "root", "", "myhmsdb");

// Check if connection was successful
if (!$databaseConnection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// ================================================================
// FEATURE 1 - Patient Login Handler
// ================================================================
if (isset($_POST['patsub'])) {

    // Get and clean user input
    $patientEmail    = trim($_POST['email']);
    $patientPassword = trim($_POST['password2']);

    // Validate inputs are not empty
    if (empty($patientEmail) || empty($patientPassword)) {
        echo("<script>
                alert('Please fill in all fields!');
                window.location.href = 'index1.php';
              </script>");
        exit();
    }

    // Prepared statement to prevent SQL injection
    $loginStatement = mysqli_prepare(
        $databaseConnection,
        "SELECT * FROM patreg WHERE email = ? AND password = ?"
    );

    // Bind parameters safely
    mysqli_stmt_bind_param($loginStatement, "ss", $patientEmail, $patientPassword);

    // Execute the query
    mysqli_stmt_execute($loginStatement);

    // Get result
    $loginResult = mysqli_stmt_get_result($loginStatement);

    if (mysqli_num_rows($loginResult) >= 1) {

        // Fetch patient data
        $patientData = mysqli_fetch_array($loginResult, MYSQLI_ASSOC);

        // Store patient info in session
        $_SESSION['pid']             = $patientData['pid'];
        $_SESSION['username']        = $patientData['fname'] . " " . $patientData['lname'];
        $_SESSION['firstName']       = $patientData['fname'];
        $_SESSION['lastName']        = $patientData['lname'];
        $_SESSION['patientGender']   = $patientData['gender'];
        $_SESSION['patientContact']  = $patientData['contact'];
        $_SESSION['patientEmail']    = $patientData['email'];
        $_SESSION['loginTime']       = date('Y-m-d H:i:s');

        // Redirect to patient dashboard
        header("Location: admin-panel.php");
        exit();

    } else {
        // Login failed
        echo("<script>
                alert('Invalid email or password. Please try again!');
                window.location.href = 'index1.php';
              </script>");
        exit();
    }

    // Close statement
    mysqli_stmt_close($loginStatement);
}

// ================================================================
// FEATURE 2 - Update Appointment Payment Status
// ================================================================
if (isset($_POST['update_data'])) {

    $patientContact   = trim($_POST['contact']);
    $paymentStatus    = trim($_POST['status']);

    // Prepared statement for safe update
    $updateStatement = mysqli_prepare(
        $databaseConnection,
        "UPDATE appointmenttb SET payment = ? WHERE contact = ?"
    );

    mysqli_stmt_bind_param($updateStatement, "ss", $paymentStatus, $patientContact);
    mysqli_stmt_execute($updateStatement);

    if ($updateStatement) {
        header("Location: updated.php");
        exit();
    }

    mysqli_stmt_close($updateStatement);
}

// ================================================================
// FEATURE 3 - Add New Doctor
// ================================================================
if (isset($_POST['doc_sub'])) {

    $doctorUsername     = trim($_POST['doctor']);
    $doctorPassword     = trim($_POST['dpassword']);
    $doctorEmail        = trim($_POST['demail']);
    $doctorFees         = trim($_POST['docFees']);
    $doctorSpecialization = trim($_POST['spec'] ?? 'General');

    // Check if doctor already exists
    $checkStatement = mysqli_prepare(
        $databaseConnection,
        "SELECT * FROM doctb WHERE username = ?"
    );
    mysqli_stmt_bind_param($checkStatement, "s", $doctorUsername);
    mysqli_stmt_execute($checkStatement);
    $checkResult = mysqli_stmt_get_result($checkStatement);

    if (mysqli_num_rows($checkResult) > 0) {
        echo("<script>
                alert('Doctor already exists!');
                window.location.href = 'admin-panel1.php';
              </script>");
        exit();
    }

    // Insert new doctor with prepared statement
    $insertDoctorStatement = mysqli_prepare(
        $databaseConnection,
        "INSERT INTO doctb (username, password, email, spec, docFees)
         VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $insertDoctorStatement,
        "ssssi",
        $doctorUsername,
        $doctorPassword,
        $doctorEmail,
        $doctorSpecialization,
        $doctorFees
    );

    mysqli_stmt_execute($insertDoctorStatement);

    if ($insertDoctorStatement) {
        echo("<script>
                alert('Doctor added successfully!');
                window.location.href = 'admin-panel1.php';
              </script>");
        exit();
    }

    mysqli_stmt_close($insertDoctorStatement);
}

// ================================================================
// NEW FEATURE - Check if Email Already Registered (AJAX)
// This is a brand new feature not in original project!
// ================================================================
if (isset($_POST['check_email'])) {

    $emailToCheck = trim($_POST['email_to_check']);

    $emailCheckStatement = mysqli_prepare(
        $databaseConnection,
        "SELECT pid FROM patreg WHERE email = ?"
    );

    mysqli_stmt_bind_param($emailCheckStatement, "s", $emailToCheck);
    mysqli_stmt_execute($emailCheckStatement);
    $emailCheckResult = mysqli_stmt_get_result($emailCheckStatement);

    if (mysqli_num_rows($emailCheckResult) > 0) {
        echo json_encode([
            'status'  => 'exists',
            'message' => 'This email is already registered!'
        ]);
    } else {
        echo json_encode([
            'status'  => 'available',
            'message' => 'Email is available'
        ]);
    }

    mysqli_stmt_close($emailCheckStatement);
    exit();
}

// ================================================================
// NEW FEATURE - Get Appointment Count for Dashboard Stats
// Brand new feature - shows total appointments today
// ================================================================
function getTodayAppointmentCount($databaseConnection) {
    $todayDate = date('Y-m-d');

    $countStatement = mysqli_prepare(
        $databaseConnection,
        "SELECT COUNT(*) as totalAppointments
         FROM appointmenttb
         WHERE appdate = ?"
    );

    mysqli_stmt_bind_param($countStatement, "s", $todayDate);
    mysqli_stmt_execute($countStatement);
    $countResult = mysqli_stmt_get_result($countStatement);
    $countData   = mysqli_fetch_assoc($countResult);

    return $countData['totalAppointments'];
}

// ================================================================
// NEW FEATURE - Get Total Registered Patients Count
// ================================================================
function getTotalPatientCount($databaseConnection) {
    $patientCountResult = mysqli_query(
        $databaseConnection,
        "SELECT COUNT(*) as totalPatients FROM patreg"
    );
    $patientCountData = mysqli_fetch_assoc($patientCountResult);
    return $patientCountData['totalPatients'];
}

// ================================================================
// NEW FEATURE - Get Total Doctor Count
// ================================================================
function getTotalDoctorCount($databaseConnection) {
    $doctorCountResult = mysqli_query(
        $databaseConnection,
        "SELECT COUNT(*) as totalDoctors FROM doctb"
    );
    $doctorCountData = mysqli_fetch_assoc($doctorCountResult);
    return $doctorCountData['totalDoctors'];
}

// ================================================================
// Display Doctors Dropdown for Appointment Form
// ================================================================
function displayDoctorOptions($databaseConnection) {
    global $databaseConnection;

    $doctorListQuery  = "SELECT username, spec, docFees FROM doctb";
    $doctorListResult = mysqli_query($databaseConnection, $doctorListQuery);

    while ($doctorRow = mysqli_fetch_array($doctorListResult)) {
        $doctorName           = $doctorRow['username'];
        $doctorSpecialization = $doctorRow['spec'];
        $consultationFees     = $doctorRow['docFees'];

        echo '<option value="' . $doctorName . '" data-price="' . $consultationFees . '">'
            . $doctorName . ' (' . $doctorSpecialization . ') - Rs.' . $consultationFees
            . '</option>';
    }
}
?>