<?php
$username = $_POST['usr_name'];
$password = $_POST['usr_passwd'];
$birthday = date('y-m-d', strtotime($_POST['usr_birthday']));
$email = $_POST['usr_email'];

if(!empty($username) || !empty($password) || !empty($birthday) || !empty($email)) {
    $host = "localhost:3307";
    $dbUsername = "root";
    $dbPassword = " ";
    $dbname = "usr_details";

    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if(mysqli_connect_error()){
        die('Connect Error(' . mysqli_connect_error() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT usremail From customer Where usremail = ? Limit 1";
        $INSERT = "INSERT Into customer (username, password, birthday, usremail) values(?,?,?,?)";

        //Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if($rnum==0){
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssss", $username, $password, $birthday, $email);
            $stmt->execute();
            //echo '<script>alert("Your Email ID is register now you can Login")</script>';
            echo '<center><p><a href="login.html"><b>Your Email ID is register now you can Login<b></a></p></center>';
        } else {
            //echo '<script>alert("Someone already resgister using this email") </script>';
            //echo '<p><a href="javascript:history.go(-1)" title="Return to previous page">« Go back</a></p>';
            echo '<center><p><a href="signup.html"><b>Someone already resgister using this email!<b></a></p></center>';
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo '<script>alert("All field are required")</script>';
    die();
}
?>