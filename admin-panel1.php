<!DOCTYPE html>
<?php 
/**
 * MediCare Plus - Receptionist Dashboard
 * Author: Prakhar Agrawal
 */
$databaseConnection = mysqli_connect("localhost","root","","myhmsdb");
include('newfunc.php');

// Add new doctor
if(isset($_POST['docsub'])) {
    $doctorName           = $_POST['doctor'];
    $doctorPassword       = $_POST['dpassword'];
    $doctorEmail          = $_POST['demail'];
    $doctorSpecialization = $_POST['special'];
    $consultationFees     = $_POST['docFees'];

    $addDoctorStatement = mysqli_prepare(
        $databaseConnection,
        "INSERT INTO doctb(username,password,email,spec,docFees) VALUES(?,?,?,?,?)"
    );
    mysqli_stmt_bind_param(
        $addDoctorStatement,
        "ssssi",
        $doctorName,
        $doctorPassword,
        $doctorEmail,
        $doctorSpecialization,
        $consultationFees
    );
    mysqli_stmt_execute($addDoctorStatement);

    if($addDoctorStatement) {
        echo "<script>alert('Doctor added successfully!');</script>";
    }
    mysqli_stmt_close($addDoctorStatement);
}

// Delete doctor
if(isset($_POST['docsub1'])) {
    $doctorEmail = $_POST['demail'];

    $deleteDoctorStatement = mysqli_prepare(
        $databaseConnection,
        "DELETE FROM doctb WHERE email=?"
    );
    mysqli_stmt_bind_param($deleteDoctorStatement, "s", $doctorEmail);
    mysqli_stmt_execute($deleteDoctorStatement);

    if($deleteDoctorStatement) {
        echo "<script>alert('Doctor removed successfully!');</script>";
    } else {
        echo "<script>alert('Unable to delete!');</script>";
    }
    mysqli_stmt_close($deleteDoctorStatement);
}
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MediCare Plus | Receptionist Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png"/>
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        * { font-family: 'IBM Plex Sans', sans-serif; }

        /* Navbar */
        .main-navbar {
            background: linear-gradient(to right, #1b5e20, #00897b);
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        /* Sidebar */
        .list-group-item.active {
            background-color: #1b5e20;
            border-color: #1b5e20;
            color: #fff;
        }

        .list-group-item:hover {
            background-color: #e8f5e9;
            color: #1b5e20;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(to right, #1b5e20, #00897b);
            border: none;
            border-radius: 8px;
        }

        .btn-primary:hover {
            opacity: 0.85;
            background: linear-gradient(to right, #1b5e20, #00897b);
        }

        .btn-danger {
            border-radius: 8px;
        }

        /* Welcome heading */
        .welcome-heading {
            text-align: center;
            color: #1b5e20;
            font-weight: 700;
            padding-bottom: 20px;
            font-size: 24px;
        }

        /* Dashboard cards */
        .dashboard-card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .dashboard-card .card-icon {
            font-size: 40px;
            color: #1b5e20;
            margin-bottom: 10px;
        }

        .dashboard-card h4 {
            color: #1b5e20;
            font-weight: 700;
        }

        .dashboard-card a {
            color: #00897b;
            font-weight: 600;
            text-decoration: none;
        }

        .dashboard-card a:hover {
            text-decoration: underline;
        }

        /* Tables */
        .table thead th {
            background: linear-gradient(to right, #1b5e20, #00897b);
            color: white;
            border: none;
        }

        .table tbody tr:hover {
            background-color: #e8f5e9;
        }

        /* Form inputs */
        .form-control {
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }

        .form-control:focus {
            border-color: #1b5e20;
            box-shadow: 0 0 6px rgba(27,94,32,0.3);
        }

        /* Text colors */
        .text-primary { color: #1b5e20 !important; }

        #inputbtn:hover { cursor: pointer; }
        button:hover    { cursor: pointer; }
    </style>

    <script>
        // Password match checker
        function checkPasswordMatch() {
            var password        = document.getElementById('dpassword').value;
            var confirmPassword = document.getElementById('cdpassword').value;
            var messageSpan     = document.getElementById('message');

            if (password === confirmPassword) {
                messageSpan.style.color   = '#5dd05d';
                messageSpan.innerHTML     = '✅ Matched';
            } else {
                messageSpan.style.color   = '#f55252';
                messageSpan.innerHTML     = '❌ Not Matching';
            }
        }

        // Allow alphabets only
        function allowAlphabetsOnly(event) {
            var keyCode = event.keyCode;
            return ((keyCode >= 65 && keyCode <= 90) ||
                     keyCode == 8 || keyCode == 32);
        }

        // Click tab helper
        function clickTab(tabId) {
            document.querySelector(tabId).click();
        }
    </script>
</head>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top main-navbar">
    <a class="navbar-brand" href="#">
        <i class="fa fa-heartbeat"></i> MediCare Plus
    </a>
    <button class="navbar-toggler" type="button"
            data-toggle="collapse"
            data-target="#navbarContent">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="logout1.php">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</nav>

<body style="padding-top:60px; background:#f4f6f9;">
    <div class="container-fluid" style="margin-top:20px;">

        <h3 class="welcome-heading">
            <i class="fa fa-hospital-o"></i> Welcome, Receptionist!
        </h3>

        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-2" style="margin-top:1%;">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active"
                       data-toggle="list" href="#list-dash" role="tab">
                        <i class="fa fa-tachometer"></i> Dashboard
                    </a>
                    <a class="list-group-item list-group-item-action"
                       data-toggle="list" href="#list-doc"
                       id="list-doc-list" role="tab">
                        <i class="fa fa-user-md"></i> Doctor List
                    </a>
                    <a class="list-group-item list-group-item-action"
                       data-toggle="list" href="#list-pat"
                       id="list-pat-list" role="tab">
                        <i class="fa fa-users"></i> Patient List
                    </a>
                    <a class="list-group-item list-group-item-action"
                       data-toggle="list" href="#list-app"
                       id="list-app-list" role="tab">
                        <i class="fa fa-calendar"></i> Appointment Details
                    </a>
                    <a class="list-group-item list-group-item-action"
                       data-toggle="list" href="#list-pres"
                       id="list-pres-list" role="tab">
                        <i class="fa fa-file-text"></i> Prescription List
                    </a>
                    <a class="list-group-item list-group-item-action"
                       data-toggle="list" href="#list-settings"
                       id="list-adoc-list" role="tab">
                        <i class="fa fa-plus"></i> Add Doctor
                    </a>
                    <a class="list-group-item list-group-item-action"
                       data-toggle="list" href="#list-settings1"
                       id="list-ddoc-list" role="tab">
                        <i class="fa fa-trash"></i> Delete Doctor
                    </a>
                    <a class="list-group-item list-group-item-action"
                       data-toggle="list" href="#list-mes"
                       id="list-mes-list" role="tab">
                        <i class="fa fa-envelope"></i> Queries
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10" style="margin-top:1%;">
                <div class="tab-content" id="nav-tabContent">

                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade show active"
                         id="list-dash" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="dashboard-card">
                                    <div class="card-icon">
                                        <i class="fa fa-user-md"></i>
                                    </div>
                                    <h4>Doctor List</h4>
                                    <a href="#list-doc"
                                       onclick="clickTab('#list-doc-list')">
                                        View Doctors
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-card">
                                    <div class="card-icon">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <h4>Patient List</h4>
                                    <a href="#list-pat"
                                       onclick="clickTab('#list-pat-list')">
                                        View Patients
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-card">
                                    <div class="card-icon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <h4>Appointment Details</h4>
                                    <a href="#list-app"
                                       onclick="clickTab('#list-app-list')">
                                        View Appointments
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-card">
                                    <div class="card-icon">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                    <h4>Prescription List</h4>
                                    <a href="#list-pres"
                                       onclick="clickTab('#list-pres-list')">
                                        View Prescriptions
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-card">
                                    <div class="card-icon">
                                        <i class="fa fa-stethoscope"></i>
                                    </div>
                                    <h4>Manage Doctors</h4>
                                    <a href="#list-settings"
                                       onclick="clickTab('#list-adoc-list')">
                                        Add
                                    </a>
                                    &nbsp;|&nbsp;
                                    <a href="#list-settings1"
                                       onclick="clickTab('#list-ddoc-list')">
                                        Delete
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-card">
                                    <div class="card-icon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <h4>Patient Queries</h4>
                                    <a href="#list-mes"
                                       onclick="clickTab('#list-mes-list')">
                                        View Queries
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Doctor List Tab -->
                    <div class="tab-pane fade" id="list-doc" role="tabpanel">
                        <h5 style="color:#1b5e20;font-weight:700;margin-bottom:20px;">
                            <i class="fa fa-user-md"></i> Doctor List
                        </h5>
                        <div class="col-md-8 mb-3">
                            <form action="doctorsearch.php" method="post">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text"
                                               name="doctor_contact"
                                               placeholder="Search by Email ID"
                                               class="form-control"/>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit"
                                               name="doctor_search_submit"
                                               class="btn btn-primary"
                                               value="Search"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>Specialization</th>
                                    <th>Email</th>
                                    <th>Fees</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $doctorListQuery  = "SELECT * FROM doctb";
                                $doctorListResult = mysqli_query(
                                    $databaseConnection,
                                    $doctorListQuery
                                );
                                while ($doctorRow = mysqli_fetch_array($doctorListResult)) {
                                    echo "<tr>
                                        <td>{$doctorRow['username']}</td>
                                        <td>{$doctorRow['spec']}</td>
                                        <td>{$doctorRow['email']}</td>
                                        <td>Rs. {$doctorRow['docFees']}</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Patient List Tab -->
                    <div class="tab-pane fade" id="list-pat" role="tabpanel">
                        <h5 style="color:#1b5e20;font-weight:700;margin-bottom:20px;">
                            <i class="fa fa-users"></i> Patient List
                        </h5>
                        <div class="col-md-8 mb-3">
                            <form action="patientsearch.php" method="post">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text"
                                               name="patient_contact"
                                               placeholder="Search by Contact"
                                               class="form-control"/>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit"
                                               name="patient_search_submit"
                                               class="btn btn-primary"
                                               value="Search"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Patient ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $patientListQuery  = "SELECT * FROM patreg";
                                $patientListResult = mysqli_query(
                                    $databaseConnection,
                                    $patientListQuery
                                );
                                while ($patientRow = mysqli_fetch_array($patientListResult)) {
                                    echo "<tr>
                                        <td>{$patientRow['pid']}</td>
                                        <td>{$patientRow['fname']}</td>
                                        <td>{$patientRow['lname']}</td>
                                        <td>{$patientRow['gender']}</td>
                                        <td>{$patientRow['email']}</td>
                                        <td>{$patientRow['contact']}</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Appointment Details Tab -->
                    <div class="tab-pane fade" id="list-app" role="tabpanel">
                        <h5 style="color:#1b5e20;font-weight:700;margin-bottom:20px;">
                            <i class="fa fa-calendar"></i> Appointment Details
                        </h5>
                        <div class="col-md-8 mb-3">
                            <form action="appsearch.php" method="post">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text"
                                               name="app_contact"
                                               placeholder="Search by Contact"
                                               class="form-control"/>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit"
                                               name="app_search_submit"
                                               class="btn btn-primary"
                                               value="Search"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>App ID</th>
                                    <th>Patient ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Doctor</th>
                                    <th>Fees</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $appointmentQuery  = "SELECT * FROM appointmenttb";
                                $appointmentResult = mysqli_query(
                                    $databaseConnection,
                                    $appointmentQuery
                                );
                                while ($appointmentRow = mysqli_fetch_array($appointmentResult)) {
                                    // Determine appointment status
                                    $userStatus   = $appointmentRow['userStatus'];
                                    $doctorStatus = $appointmentRow['doctorStatus'];

                                    if ($userStatus == 1 && $doctorStatus == 1) {
                                        $appointmentStatus = '<span class="badge badge-success">Active</span>';
                                    } elseif ($userStatus == 0 && $doctorStatus == 1) {
                                        $appointmentStatus = '<span class="badge badge-warning">Cancelled by Patient</span>';
                                    } elseif ($userStatus == 1 && $doctorStatus == 0) {
                                        $appointmentStatus = '<span class="badge badge-danger">Cancelled by Doctor</span>';
                                    } else {
                                        $appointmentStatus = '<span class="badge badge-secondary">Unknown</span>';
                                    }

                                    echo "<tr>
                                        <td>{$appointmentRow['ID']}</td>
                                        <td>{$appointmentRow['pid']}</td>
                                        <td>{$appointmentRow['fname']}</td>
                                        <td>{$appointmentRow['lname']}</td>
                                        <td>{$appointmentRow['email']}</td>
                                        <td>{$appointmentRow['contact']}</td>
                                        <td>{$appointmentRow['doctor']}</td>
                                        <td>Rs. {$appointmentRow['docFees']}</td>
                                        <td>{$appointmentRow['appdate']}</td>
                                        <td>{$appointmentRow['apptime']}</td>
                                        <td>{$appointmentStatus}</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Prescription List Tab -->
                    <div class="tab-pane fade" id="list-pres" role="tabpanel">
                        <h5 style="color:#1b5e20;font-weight:700;margin-bottom:20px;">
                            <i class="fa fa-file-text"></i> Prescription List
                        </h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Patient ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Date</th>
                                    <th>Disease</th>
                                    <th>Allergy</th>
                                    <th>Prescription</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $prescriptionQuery  = "SELECT * FROM prestb";
                                $prescriptionResult = mysqli_query(
                                    $databaseConnection,
                                    $prescriptionQuery
                                );
                                while ($prescriptionRow = mysqli_fetch_array($prescriptionResult)) {
                                    echo "<tr>
                                        <td>{$prescriptionRow['doctor']}</td>
                                        <td>{$prescriptionRow['pid']}</td>
                                        <td>{$prescriptionRow['fname']}</td>
                                        <td>{$prescriptionRow['lname']}</td>
                                        <td>{$prescriptionRow['appdate']}</td>
                                        <td>{$prescriptionRow['disease']}</td>
                                        <td>{$prescriptionRow['allergy']}</td>
                                        <td>{$prescriptionRow['prescription']}</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Add Doctor Tab -->
                    <div class="tab-pane fade"
                         id="list-settings" role="tabpanel">
                        <h5 style="color:#1b5e20;font-weight:700;margin-bottom:20px;">
                            <i class="fa fa-plus"></i> Add New Doctor
                        </h5>
                        <form method="post" action="admin-panel1.php"
                              style="max-width:600px;">
                            <div class="form-group">
                                <label>Doctor Name</label>
                                <input type="text"
                                       class="form-control"
                                       name="doctor"
                                       placeholder="Enter doctor name"
                                       onkeydown="return allowAlphabetsOnly(event);"
                                       required/>
                            </div>
                            <div class="form-group">
                                <label>Specialization</label>
                                <select name="special" class="form-control" required>
                                    <option value="" disabled selected>
                                        Select Specialization
                                    </option>
                                    <option value="General">General</option>
                                    <option value="Cardiologist">Cardiologist</option>
                                    <option value="Neurologist">Neurologist</option>
                                    <option value="Pediatrician">Pediatrician</option>
                                    <option value="Orthopedic">Orthopedic</option>
                                    <option value="Dermatologist">Dermatologist</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Email ID</label>
                                <input type="email"
                                       class="form-control"
                                       name="demail"
                                       placeholder="Enter email"
                                       required/>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password"
                                       class="form-control"
                                       name="dpassword"
                                       id="dpassword"
                                       placeholder="Enter password"
                                       onkeyup="checkPasswordMatch();"
                                       required/>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password"
                                       class="form-control"
                                       name="cdpassword"
                                       id="cdpassword"
                                       placeholder="Confirm password"
                                       onkeyup="checkPasswordMatch();"
                                       required/>
                                <span id="message" style="font-size:13px;"></span>
                            </div>
                            <div class="form-group">
                                <label>Consultation Fees (Rs.)</label>
                                <input type="number"
                                       class="form-control"
                                       name="docFees"
                                       placeholder="Enter fees"
                                       required/>
                            </div>
                            <button type="submit"
                                    name="docsub"
                                    class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add Doctor
                            </button>
                        </form>
                    </div>

                    <!-- Delete Doctor Tab -->
                    <div class="tab-pane fade"
                         id="list-settings1" role="tabpanel">
                        <h5 style="color:#1b5e20;font-weight:700;margin-bottom:20px;">
                            <i class="fa fa-trash"></i> Delete Doctor
                        </h5>
                        <form method="post" action="admin-panel1.php"
                              style="max-width:600px;">
                            <div class="form-group">
                                <label>Doctor Email ID</label>
                                <input type="email"
                                       class="form-control"
                                       name="demail"
                                       placeholder="Enter doctor email to delete"
                                       required/>
                            </div>
                            <button type="submit"
                                    name="docsub1"
                                    class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this doctor?')">
                                <i class="fa fa-trash"></i> Delete Doctor
                            </button>
                        </form>
                    </div>

                    <!-- Queries Tab -->
                    <div class="tab-pane fade"
                         id="list-mes" role="tabpanel">
                        <h5 style="color:#1b5e20;font-weight:700;margin-bottom:20px;">
                            <i class="fa fa-envelope"></i> Patient Queries
                        </h5>
                        <div class="col-md-8 mb-3">
                            <form action="messearch.php" method="post">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text"
                                               name="mes_contact"
                                               placeholder="Search by Contact"
                                               class="form-control"/>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit"
                                               name="mes_search_submit"
                                               class="btn btn-primary"
                                               value="Search"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $queriesQuery  = "SELECT * FROM contact";
                                $queriesResult = mysqli_query(
                                    $databaseConnection,
                                    $queriesQuery
                                );
                                while ($queryRow = mysqli_fetch_array($queriesResult)) {
                                    echo "<tr>
                                        <td>{$queryRow['name']}</td>
                                        <td>{$queryRow['email']}</td>
                                        <td>{$queryRow['contact']}</td>
                                        <td>{$queryRow['message']}</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
</body>
</html>