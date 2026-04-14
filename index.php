<?php
/**
 * MediCare Plus - Main Registration Page
 * Author: Prakhar Agrawal
 * Description: Patient registration, Doctor login,
 *              and Receptionist login page
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MediCare Plus | Your Health Our Priority</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png"/>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

    <style>
        * {
            font-family: 'IBM Plex Sans', sans-serif;
        }
        body {
            background: linear-gradient(to right, #1b5e20, #00897b);
            min-height: 100vh;
        }
        #mainNav {
            background: linear-gradient(to right, #1b5e20, #00897b);
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        .welcome-section {
            text-align: center;
            color: #fff;
            margin-top: 12%;
        }
        .welcome-section img {
            width: 140px;
            margin-bottom: 20px;
            animation: floatAnimation 1s infinite alternate;
        }
        .welcome-section h3 {
            font-size: 24px;
            font-weight: 700;
        }
        .welcome-section p {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 8px;
        }
        @keyframes floatAnimation {
            0%   { transform: translateY(0); }
            100% { transform: translateY(-15px); }
        }
        .registration-card {
            background: #f8f9fa;
            border-top-left-radius: 10% 50%;
            border-bottom-left-radius: 10% 50%;
            padding: 30px;
            margin-top: 40px;
        }
        .nav-tabs {
            border: none;
            background: #1b5e20;
            border-radius: 1.5rem;
            width: 80%;
            margin: 20px auto;
        }
        .nav-tabs .nav-link {
            color: #fff;
            font-weight: 600;
            border: none;
            padding: 8px 16px;
            border-radius: 1.5rem;
        }
        .nav-tabs .nav-link.active {
            color: #1b5e20;
            background: #fff;
            border: 2px solid #1b5e20;
            border-radius: 1.5rem;
        }
        .nav-tabs .nav-link:hover {
            background: #2e7d32;
            border-radius: 1.5rem;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 10px;
            font-size: 14px;
            transition: border 0.3s ease;
        }
        .form-control:focus {
            border-color: #1b5e20;
            box-shadow: 0 0 6px rgba(27,94,32,0.3);
        }
        .registerButton {
            float: right;
            margin-top: 10px;
            border: none;
            border-radius: 1.5rem;
            padding: 10px 30px;
            background: linear-gradient(to right, #1b5e20, #00897b);
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }
        .registerButton:hover {
            opacity: 0.85;
        }
        .section-heading {
            text-align: center;
            margin-top: 8%;
            margin-bottom: -10%;
            color: #1b5e20;
            font-weight: 700;
        }
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 3px;
            display: block;
        }
        .success-message {
            color: green;
            font-size: 12px;
            margin-top: 3px;
            display: block;
        }
        .password-match {
            font-size: 12px;
            margin-top: 3px;
        }
        .login-link {
            color: #1b5e20;
            font-weight: 600;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
            color: #00897b;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="index.php" style="margin-left:-65px;">
                <h4>
                    <i class="fa fa-heartbeat" aria-hidden="true"></i>
                    &nbsp; MediCare Plus
                </h4>
            </a>
            <button class="navbar-toggler" type="button"
                    data-toggle="collapse"
                    data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item" style="margin-right:40px;">
                        <a class="nav-link" href="index.php" style="color:white;">
                            <h6>HOME</h6>
                        </a>
                    </li>
                    <!-- <li class="nav-item" style="margin-right:40px;">
                        <a class="nav-link" href="services.html" style="color:white;">
                            <h6>ABOUT US</h6>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html" style="color:white;">
                            <h6>CONTACT</h6>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container register" style="margin-top:3%;padding:3%;">
        <div class="row">

            <!-- Left Welcome Section -->
            <div class="col-md-3 welcome-section">
                <img src="https://cdn-icons-png.flaticon.com/512/2967/2967484.png"
                     alt="MediCare Plus"/>
                <h3>Welcome!</h3>
                <p>Your health is our<br>top priority.</p>
            </div>

            <!-- Right Registration Card -->
            <div class="col-md-9 registration-card">

                <!-- Tabs -->
                <ul class="nav nav-tabs nav-justified"
                    id="registrationTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active"
                           data-toggle="tab"
                           href="#patientTab"
                           role="tab">Patient</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           data-toggle="tab"
                           href="#doctorTab"
                           role="tab">Doctor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           data-toggle="tab"
                           href="#receptionistTab"
                           role="tab">Receptionist</a>
                    </li>
                </ul>

                <div class="tab-content" id="registrationTabContent">

                    <!-- Patient Registration Tab -->
                    <div class="tab-pane fade show active"
                         id="patientTab" role="tabpanel">
                        <h3 class="section-heading">Register as Patient</h3>
                        <form method="post" action="func2.php"
                              onsubmit="return validatePatientRegistration()">
                            <div class="row" style="padding:8%;margin-top:8%;">

                                <!-- Left column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text"
                                               class="form-control"
                                               placeholder="First Name *"
                                               name="fname"
                                               id="firstNameInput"
                                               onkeydown="return allowAlphabetsOnly(event);"/>
                                        <span id="firstNameError"
                                              class="error-message"></span>
                                    </div>

                                    <div class="form-group">
                                        <input type="email"
                                               class="form-control"
                                               placeholder="Your Email *"
                                               name="email"
                                               id="patientEmailInput"
                                               onblur="checkEmailAvailability(this.value)"/>
                                        <span id="emailAvailabilityMessage"
                                              class="error-message"></span>
                                    </div>

                                    <div class="form-group">
                                        <input type="password"
                                               class="form-control"
                                               placeholder="Password *"
                                               id="passwordInput"
                                               name="password"
                                               onkeyup="checkPasswordMatch();"/>
                                    </div>

                                    <div class="form-group">
                                        <label class="radio inline">
                                            <input type="radio"
                                                   name="gender"
                                                   value="Male" checked>
                                            <span> Male </span>
                                        </label>
                                        <label class="radio inline">
                                            <input type="radio"
                                                   name="gender"
                                                   value="Female">
                                            <span> Female </span>
                                        </label>
                                        <br><br>
                                        <a href="index1.php" class="login-link">
                                            Already have an account?
                                        </a>
                                    </div>
                                </div>

                                <!-- Right column -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text"
                                               class="form-control"
                                               placeholder="Last Name *"
                                               name="lname"
                                               id="lastNameInput"
                                               onkeydown="return allowAlphabetsOnly(event);"/>
                                        <span id="lastNameError"
                                              class="error-message"></span>
                                    </div>

                                    <div class="form-group">
                                        <input type="tel"
                                               minlength="10"
                                               maxlength="10"
                                               name="contact"
                                               id="contactInput"
                                               class="form-control"
                                               placeholder="Your Phone *"/>
                                        <span id="contactError"
                                              class="error-message"></span>
                                    </div>

                                    <div class="form-group">
                                        <input type="password"
                                               class="form-control"
                                               id="confirmPasswordInput"
                                               placeholder="Confirm Password *"
                                               name="cpassword"
                                               onkeyup="checkPasswordMatch();"/>
                                        <span id="passwordMatchMessage"
                                              class="password-match"></span>
                                    </div>

                                    <input type="submit"
                                           class="registerButton"
                                           name="patsub1"
                                           value="Register"/>
                                </div>

                            </div>
                        </form>
                    </div>

                    <!-- Doctor Login Tab -->
                    <div class="tab-pane fade"
                         id="doctorTab" role="tabpanel">
                        <h3 class="section-heading">Login as Doctor</h3>
                        <form method="post" action="func1.php">
                            <div class="row" style="padding:8%;margin-top:8%;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text"
                                               class="form-control"
                                               placeholder="Username *"
                                               name="username3"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password"
                                               class="form-control"
                                               placeholder="Password *"
                                               name="password3"/>
                                    </div>
                                    <input type="submit"
                                           class="registerButton"
                                           name="docsub1"
                                           value="Login"/>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Receptionist Login Tab -->
                    <div class="tab-pane fade"
                         id="receptionistTab" role="tabpanel">
                        <h3 class="section-heading">Login as Receptionist</h3>
                        <form method="post" action="func3.php">
                            <div class="row" style="padding:8%;margin-top:8%;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text"
                                               class="form-control"
                                               placeholder="Username *"
                                               name="username1"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password"
                                               class="form-control"
                                               placeholder="Password *"
                                               name="password2"/>
                                    </div>
                                    <input type="submit"
                                           class="registerButton"
                                           name="adsub"
                                           value="Login"/>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
    // Allow alphabets only in name fields
    function allowAlphabetsOnly(event) {
        var keyCode = event.keyCode;
        return ((keyCode >= 65 && keyCode <= 90) ||
                keyCode == 8 || keyCode == 32);
    }

    // Check password match in real time
    function checkPasswordMatch() {
        var passwordValue        = document.getElementById('passwordInput').value;
        var confirmPasswordValue = document.getElementById('confirmPasswordInput').value;
        var matchMessage         = document.getElementById('passwordMatchMessage');

        if (confirmPasswordValue.length === 0) {
            matchMessage.innerHTML = '';
            return;
        }
        if (passwordValue === confirmPasswordValue) {
            matchMessage.style.color = 'green';
            matchMessage.innerHTML   = '✅ Passwords match!';
        } else {
            matchMessage.style.color = 'red';
            matchMessage.innerHTML   = '❌ Passwords do not match!';
        }
    }

    // NEW FEATURE - Check email availability in real time
    function checkEmailAvailability(emailValue) {
        var messageElement = document.getElementById('emailAvailabilityMessage');

        if (emailValue.length === 0) {
            messageElement.innerHTML = '';
            return;
        }

        messageElement.innerHTML   = '⏳ Checking email...';
        messageElement.style.color = 'orange';

        var formData = new FormData();
        formData.append('check_email', 1);
        formData.append('email_to_check', emailValue);

        fetch('func.php', {
            method: 'POST',
            body: formData
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.status === 'exists') {
                messageElement.style.color = 'red';
                messageElement.innerHTML   = '❌ ' + data.message +
                    ' <a href="index1.php">Login instead?</a>';
            } else {
                messageElement.style.color = 'green';
                messageElement.innerHTML   = '✅ Email is available!';
            }
        })
        .catch(function(error) {
            messageElement.innerHTML = '';
        });
    }

    // Full form validation before submit
    function validatePatientRegistration() {
        var firstName   = document.getElementById('firstNameInput').value;
        var lastName    = document.getElementById('lastNameInput').value;
        var contact     = document.getElementById('contactInput').value;
        var password    = document.getElementById('passwordInput').value;
        var isFormValid = true;

        // Clear old errors
        document.getElementById('firstNameError').innerHTML = '';
        document.getElementById('lastNameError').innerHTML  = '';
        document.getElementById('contactError').innerHTML   = '';

        if (firstName.trim() === '') {
            document.getElementById('firstNameError').innerHTML =
                '❌ First name is required';
            isFormValid = false;
        }

        if (lastName.trim() === '') {
            document.getElementById('lastNameError').innerHTML =
                '❌ Last name is required';
            isFormValid = false;
        }

        if (contact.length !== 10) {
            document.getElementById('contactError').innerHTML =
                '❌ Phone must be exactly 10 digits';
            isFormValid = false;
        }

        if (password.length < 6) {
            alert('Password must be at least 6 characters!');
            isFormValid = false;
        }

        return isFormValid;
    }
    </script>

    <?php include('chatbot.php'); ?>

</body>
</html>