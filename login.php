<?php
$email = $_POST['email'];
$password = $_POST['password'];

// Database connection here
$con = new mysqli("localhost:3307", "root", " ", "usr_details");
if($con->connect_error) {
    die("Failed to connect : " . $con->connect_error);
} else {
    $stmt = $con->prepare("select * from customer where usremail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if($stmt_result->num_rows > 0) {
        $data = $stmt_result->fetch_assoc();
        if ($data['password'] === $password){
            header('Location:home.html');
        } else {
            echo '<script>alert("Your Email ID or Password is Incorrect!")</script>';
        }
    } else {
        echo '<script>alert("Your Email ID or Password is Incorrect!")</script>';
        header('Location:login.html');
    }
    
    }
?>