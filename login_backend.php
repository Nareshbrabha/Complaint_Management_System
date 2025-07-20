<?php
session_start();
include('db.php'); // Include the database connection file

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Get faculty department from form data

    // Query to check if faculty ID and password match
    $query = "SELECT * FROM faculty WHERE id = '$faculty_id' AND pass = '$password'";
    $result = mysqli_query($conn, $query);

    $user = mysqli_fetch_array($result);

    if($user['role']=='eo'){
        $_SESSION['eo_id'] = $faculty_id;
        header("Location: eo.php"); 
        exit();
    }

    elseif($user['role']=='manager'){
        $_SESSION['manager_id'] = $faculty_id;
        header("Location: manager.php"); 
        exit();
    }

    elseif($user['role']=='hod'){
        $_SESSION['faculty_dept'] = $faculty_dept;
        $_SESSION['hod_id'] = $faculty_id;
        header("Location: hod.php"); 
        exit();
    }


elseif($user['role']=='infra'){
    // If user exists
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['faculty_id'] = $faculty_id; // Store faculty ID in session
        
        header("Location: completedtable.php"); // Redirect to the completedtable page
        exit();
    } else {
        // Invalid credentials
        echo "<script>alert('Invalid Faculty ID or Password. Please try again.'); window.location.href='flogin.php';</script>";
    }
}

} else {
    header("Location: flogin.php"); // Redirect back to login page if accessed without form submission
    exit();
}

$fac_id = $_SESSION['faculty_id'];

if(isset($_POST['fac'])) {
    $sql8 =  "SELECT * FROM faculty WHERE dept=(SELECT department FROM faculty_details WHERE faculty_id='$fac_id')";
    $result8 = mysqli_query($conn, $sql8);

    $options = '';
    $options .= '<option value="">Select a Faculty</option>';



    while ($row = mysqli_fetch_assoc($result8)) {
        $options .= '<option value="' . $row['id'] . '">' . $row['id'] . ' - ' . $row['name'] . '</option>';

    }


    echo $options;
    exit();  
}
