<?php
/**
 * MediCare Plus - Ambulance Booking Page
 * Author: Prakhar Agrawal
 * Description: Public-facing ambulance booking form (no login required)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Book Ambulance | MediCare Plus</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png"/>
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

    <style>
        * { font-family: 'IBM Plex Sans', sans-serif; }

        body {
            background: linear-gradient(135deg, #b71c1c 0%, #880e4f 100%);
            min-height: 100vh;
        }

        /* ── Navbar ── */
        #mainNav {
            background: linear-gradient(to right, #1b5e20, #00897b);
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        /* ── Emergency Banner ── */
        .emergency-banner {
            background: rgba(255,255,255,0.12);
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            color: #fff;
            margin-top: 90px;
            margin-bottom: 10px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%   { box-shadow: 0 0 0 0 rgba(255,255,255,0.3); }
            70%  { box-shadow: 0 0 0 12px rgba(255,255,255,0); }
            100% { box-shadow: 0 0 0 0 rgba(255,255,255,0); }
        }
        .emergency-banner h2 {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: 1px;
        }
        .emergency-banner p {
            font-size: 1rem;
            opacity: 0.88;
            margin: 0;
        }
        .ambulance-icon {
            font-size: 3.5rem;
            display: block;
            margin-bottom: 10px;
            animation: shake 0.5s ease infinite alternate;
        }
        @keyframes shake {
            from { transform: translateX(-4px); }
            to   { transform: translateX(4px); }
        }

        /* ── Card ── */
        .booking-card {
            background: #fff;
            border-radius: 16px;
            padding: 36px 40px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.18);
            margin-bottom: 50px;
        }
        .booking-card h4 {
            color: #b71c1c;
            font-weight: 700;
            border-bottom: 2px solid #ffcdd2;
            padding-bottom: 10px;
            margin-bottom: 24px;
        }

        /* ── Form ── */
        label { font-weight: 600; color: #333; }
        .form-control:focus {
            border-color: #e53935;
            box-shadow: 0 0 0 0.2rem rgba(229,57,53,0.18);
        }
        .emergency-type-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 10px;
        }
        .emergency-type-grid label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            cursor: pointer;
            padding: 8px 10px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .emergency-type-grid input[type="radio"] { accent-color: #e53935; }
        .emergency-type-grid label:has(input:checked) {
            border-color: #e53935;
            background: #fff5f5;
            color: #b71c1c;
        }

        /* ── Submit Button ── */
        .btn-emergency {
            background: linear-gradient(to right, #e53935, #b71c1c);
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            border: none;
            border-radius: 8px;
            padding: 12px 0;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-emergency:hover {
            background: linear-gradient(to right, #b71c1c, #880e4f);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(183,28,28,0.4);
        }

        /* ── Alert Strip ── */
        .hotline-strip {
            background: rgba(255,255,255,0.18);
            color: #fff;
            text-align: center;
            padding: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 1rem;
            border-radius: 8px;
            margin-bottom: 16px;
        }
        .hotline-strip span { font-size: 1.3rem; margin-left: 8px; }

        /* ── Success State ── */
        .success-box {
            background: #e8f5e9;
            border: 2px solid #4caf50;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            color: #1b5e20;
            display: none;
        }
        .success-box.show { display: block; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <h4><i class="fa fa-heartbeat" aria-hidden="true"></i> &nbsp; MediCare Plus</h4>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item" style="margin-right:30px;">
                    <a class="nav-link" href="index.php" style="color:white;"><h6>HOME</h6></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html" style="color:white;"><h6>CONTACT</h6></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container" style="max-width: 760px;">

    <!-- Emergency Banner -->
    <div class="emergency-banner">
        <span class="ambulance-icon">🚑</span>
        <h2>Emergency Ambulance Service</h2>
        <p>Available 24/7 &nbsp;•&nbsp; Fast Response &nbsp;•&nbsp; Trained Medical Staff</p>
    </div>

    <!-- Hotline Strip -->
    <div class="hotline-strip">
        📞 Emergency Hotline: <span>108</span> &nbsp;|&nbsp; Hospital Direct: <span>+91 XXXXX XXXXX</span>
    </div>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success text-center" style="border-radius:12px; font-weight:600;">
        ✅ Your ambulance request has been received! Help is on the way. Stay calm and keep this number reachable.
    </div>
    <?php endif; ?>

    <!-- Booking Form Card -->
    <div class="booking-card">
        <h4><i class="fa fa-ambulance"></i> &nbsp; Book an Ambulance</h4>
        <p class="text-muted" style="margin-top:-10px; margin-bottom:20px; font-size:0.9rem;">
            Fill the form below. Our team will dispatch an ambulance immediately.
        </p>

        <form method="post" action="ambulance_func.php" onsubmit="return validateAmbulanceForm()">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Caller Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="caller_name"
                               placeholder="Your full name" required maxlength="60"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contact Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" name="contact" id="contactField"
                               placeholder="10-digit mobile number" maxlength="10" required/>
                        <small id="contactErr" class="text-danger" style="display:none;">
                            Please enter a valid 10-digit number.
                        </small>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Pickup Address <span class="text-danger">*</span></label>
                <textarea class="form-control" name="pickup_address" rows="2"
                          placeholder="House No., Street, Locality, Landmark..." required maxlength="255"></textarea>
            </div>

            <div class="form-group">
                <label>Drop Location (Hospital / Destination) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="drop_location"
                       placeholder="e.g. MediCare Plus Hospital, City Centre" required maxlength="255"/>
            </div>

            <div class="form-group">
                <label>Emergency Type <span class="text-danger">*</span></label>
                <div class="emergency-type-grid">
                    <label><input type="radio" name="emergency_type" value="Cardiac Arrest" required> ❤️ Cardiac Arrest</label>
                    <label><input type="radio" name="emergency_type" value="Accident / Trauma"> 🚗 Accident / Trauma</label>
                    <label><input type="radio" name="emergency_type" value="Stroke"> 🧠 Stroke</label>
                    <label><input type="radio" name="emergency_type" value="Breathing Difficulty"> 🫁 Breathing Difficulty</label>
                    <label><input type="radio" name="emergency_type" value="Pregnancy / Delivery"> 🤱 Pregnancy / Delivery</label>
                    <label><input type="radio" name="emergency_type" value="Other Emergency"> ⚠️ Other Emergency</label>
                </div>
            </div>

            <div class="form-group">
                <label>Patient Condition <small class="text-muted">(optional but helpful)</small></label>
                <textarea class="form-control" name="patient_condition" rows="2"
                          placeholder="e.g. Unconscious, heavy bleeding, chest pain for 10 mins..."
                          maxlength="300"></textarea>
            </div>

            <button type="submit" name="amb_submit" class="btn btn-emergency">
                <i class="fa fa-ambulance"></i> &nbsp; DISPATCH AMBULANCE NOW
            </button>

        </form>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script>
function validateAmbulanceForm() {
    var contact = document.getElementById('contactField').value;
    var errEl   = document.getElementById('contactErr');

    if (!/^[0-9]{10}$/.test(contact)) {
        errEl.style.display = 'block';
        return false;
    }
    errEl.style.display = 'none';

    var radios = document.getElementsByName('emergency_type');
    var selected = false;
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) { selected = true; break; }
    }
    if (!selected) {
        alert('Please select an Emergency Type.');
        return false;
    }
    return true;
}
</script>

</body>
</html>
