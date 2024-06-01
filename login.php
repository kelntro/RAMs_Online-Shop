<?php
include "db.php";

session_start();

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $password = $_POST["password"];
    
    // Check if the credentials are admin/admin123
    if ($email === "admin@gmail.com" && $password === "admin123") {
        $_SESSION["uid"] = "admin";
        $_SESSION["name"] = "Administrator";
        echo "login_success";
        echo "<script> location.href='admin/index.php'; </script>";
        exit();
    }

    $sql = "SELECT * FROM user_info WHERE email = '$email' AND password = '$password'";
    $run_query = mysqli_query($con, $sql);
    $count = mysqli_num_rows($run_query);
    $row = mysqli_fetch_array($run_query);
    
    if ($row != null) {
        $_SESSION["uid"] = $row["user_id"];
        $_SESSION["name"] = $row["first_name"];
        $ip_add = getenv("REMOTE_ADDR");

        if ($count == 1) {
            // Redirect to index.php after successful login
            echo "<script>window.location.href='index.php';</script>";
            echo "<script>$('#login').modal('hide');</script>";
            exit;
        }
    } else {
        echo "<div style='text-align: center;'><span style='color:red;'>Invalid email or password</span></div>";
        exit();
    }
}
?>
