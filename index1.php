<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Patient Login | MediCare Plus</title>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <style>
      * { font-family: 'IBM Plex Sans', sans-serif; }
      body {
        background: linear-gradient(to right, #1b5e20, #00897b);
        min-height: 100vh;
      }
      #mainNav {
        background: linear-gradient(to right, #1b5e20, #00897b);
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
      }
      .login-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        margin-top: 100px;
      }
      .login-card h3 {
        color: #1b5e20;
        font-weight: 700;
        margin-bottom: 30px;
      }
      .hospital-icon {
        color: #1b5e20;
        font-size: 50px;
        margin-bottom: 15px;
      }
      .form-control {
        border-radius: 10px;
        border: 2px solid #e0e0e0;
        padding: 12px;
        font-size: 14px;
        transition: border 0.3s ease;
      }
      .form-control:focus {
        border-color: #1b5e20;
        box-shadow: 0 0 8px rgba(27,94,32,0.3);
      }
      .btn-login {
        background: linear-gradient(to right, #1b5e20, #00897b);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px;
        width: 100%;
        font-size: 16px;
        font-weight: 600;
        margin-top: 20px;
        cursor: pointer;
        transition: opacity 0.3s ease;
      }
      .btn-login:hover {
        opacity: 0.85;
        color: white;
      }
      .left-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-top: 150px;
        color: white;
        text-align: center;
      }
      .left-section img {
        width: 180px;
        margin-bottom: 20px;
        animation: mover 1s infinite alternate;
      }
      .left-section h3 { font-size: 26px; font-weight: 700; }
      .left-section p  { font-size: 16px; opacity: 0.9; margin-top: 10px; }
      @keyframes mover {
        0%   { transform: translateY(0); }
        100% { transform: translateY(-20px); }
      }
      .back-link { text-align: center; margin-top: 15px; }
      .back-link a { color: #1b5e20; font-weight: 600; text-decoration: none; }
      .back-link a:hover { text-decoration: underline; }
      label { font-weight: 600; color: #444; margin-bottom: 5px; }
      .error-msg {
        color: red;
        font-size: 13px;
        margin-top: 4px;
        display: block;
      }
    </style>
  </head>
  <body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="index.php" style="margin-left:-65px;">
          <h4><i class="fa fa-user-plus"></i>&nbsp; MediCare Plus</h4>
        </a>
        <button class="navbar-toggler" type="button"
          data-toggle="collapse" data-target="#navbarResponsive">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item" style="margin-right:40px;">
              <a class="nav-link" href="index.php" style="color:white;"><h6>HOME</h6></a>
            </li>
            <!-- <li class="nav-item" style="margin-right:40px;">
              <a class="nav-link" href="services.html" style="color:white;"><h6>ABOUT US</h6></a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link" href="contact.html" style="color:white;"><h6>CONTACT</h6></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
      <div class="row">

        <!-- Left Side -->
        <div class="col-md-6">
          <div class="left-section">
            <img src="https://cdn-icons-png.flaticon.com/512/2967/2967484.png"
              alt="Ambulance"/>
            <h3>We are here for you!</h3>
            <p>Your health is our top priority.<br>
               Login to manage your appointments.</p>
          </div>
        </div>

        <!-- Right Side Login Card -->
        <div class="col-md-5 offset-md-1">
          <div class="login-card">
            <center>
              <i class="fa fa-hospital-o hospital-icon"></i>
              <h3>Patient Login</h3>
            </center>

            <!-- onsubmit calls our validation function -->
            <form method="POST" action="func.php" onsubmit="return validateLogin()">

              <div class="form-group">
                <label>Email Address</label>
                <!-- id="emailField" added here -->
                <input type="text"
                  id="emailField"
                  name="email"
                  class="form-control"
                  placeholder="Enter your email"/>
                <!-- error message will show here -->
                <span id="emailError" class="error-msg"></span>
              </div>

              <div class="form-group">
                <label>Password</label>
                <!-- id="passField" added here -->
                <input type="password"
                  id="passField"
                  class="form-control"
                  name="password2"
                  placeholder="Enter your password"/>
                <!-- error message will show here -->
                <span id="passError" class="error-msg"></span>
              </div>

              <button type="submit" name="patsub" class="btn-login">
                Login
              </button>
            </form>

            <div class="back-link">
              <p>Don't have an account?
                <a href="index.php">Register here</a></p>
            </div>
          </div>
        </div>

      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>

    <script>
    function validateLogin() {
      // Get what user typed
      var email    = document.getElementById('emailField').value;
      var password = document.getElementById('passField').value;

      // Get the error message boxes
      var emailError = document.getElementById('emailError');
      var passError  = document.getElementById('passError');

      // Clear old errors first
      emailError.innerHTML = '';
      passError.innerHTML  = '';

      var isValid = true;

      // Rule 1 - email cannot be empty
      if (email == '') {
        emailError.innerHTML = '❌ Please enter your email';
        isValid = false;
      }

      // Rule 2 - password must be 6 or more characters
      if (password.length < 6) {
        passError.innerHTML = '❌ Password must be at least 6 characters';
        isValid = false;
      }

      // if isValid is true = form submits
      // if isValid is false = form stops and shows errors
      return isValid;
    }
    </script>

  </body>
</html>