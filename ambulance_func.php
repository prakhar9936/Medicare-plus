<?php
/**
 * MediCare Plus - Ambulance Booking Handler
 * Author: Prakhar Agrawal
 * Handles: public ambulance booking form submission
 */

session_start();

$db = mysqli_connect("localhost", "root", "", "myhmsdb");
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// ── Book Ambulance (public form) ─────────────────────────────
if (isset($_POST['amb_submit'])) {

    $name      = trim(mysqli_real_escape_string($db, $_POST['caller_name']));
    $contact   = trim(mysqli_real_escape_string($db, $_POST['contact']));
    $pickup    = trim(mysqli_real_escape_string($db, $_POST['pickup_address']));
    $drop      = trim(mysqli_real_escape_string($db, $_POST['drop_location']));
    $emergency = trim(mysqli_real_escape_string($db, $_POST['emergency_type']));
    $condition = trim(mysqli_real_escape_string($db, $_POST['patient_condition']));

    if (empty($name) || empty($contact) || empty($pickup) || empty($drop) || empty($emergency)) {
        echo "<script>alert('Please fill all required fields.'); window.history.back();</script>";
        exit;
    }

    if (!preg_match('/^[0-9]{10}$/', $contact)) {
        echo "<script>alert('Please enter a valid 10-digit contact number.'); window.history.back();</script>";
        exit;
    }

    $sql = "INSERT INTO ambulancetb (caller_name, contact, pickup_address, drop_location, emergency_type, patient_condition)
            VALUES ('$name', '$contact', '$pickup', '$drop', '$emergency', '$condition')";

    if (mysqli_query($db, $sql)) {
        echo "<script>
            alert('🚑 Ambulance booked successfully! Help is on the way. Stay calm.');
            window.location.href = 'ambulance.php?success=1';
        </script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.history.back();</script>";
    }
    exit;
}

// ── Admin: Update Ambulance Status ───────────────────────────
if (isset($_POST['amb_status_update'])) {
    $id     = (int)$_POST['amb_id'];
    $status = mysqli_real_escape_string($db, $_POST['new_status']);

    $allowed = ['Pending', 'Dispatched', 'Completed', 'Cancelled'];
    if (!in_array($status, $allowed)) {
        echo "<script>alert('Invalid status.'); window.history.back();</script>";
        exit;
    }

    $sql = "UPDATE ambulancetb SET status='$status' WHERE id=$id";
    mysqli_query($db, $sql);
    header("Location: admin-panel1.php");
    exit;
}

// ── Admin: Delete Ambulance Request ──────────────────────────
if (isset($_GET['del_amb'])) {
    $id = (int)$_GET['del_amb'];
    mysqli_query($db, "DELETE FROM ambulancetb WHERE id=$id");
    header("Location: admin-panel1.php");
    exit;
}

mysqli_close($db);
