<?php
session_start();
include("../db.php");
include "sidenav.php";
include "topheader.php";

if (isset($_POST['btn_save'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $user_password = $_POST['password'];
    $mobile = $_POST['phone'];
    $address1 = $_POST['city'];
    $address2 = $_POST['country'];

    // Check if the email already exists
    $check_email_query = "SELECT email FROM user_info WHERE email = ?";
    $check_stmt = $con->prepare($check_email_query);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Email already exists
        echo "<script>alert('Error: Email already exists.');</script>";
    } else {
        // Email does not exist, proceed with the insert
        $stmt = $con->prepare("INSERT INTO user_info (first_name, last_name, email, password, mobile, address1, address2) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $first_name, $last_name, $email, $user_password, $mobile, $address1, $address2);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('User successfully added.');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }

    $check_stmt->close();
    mysqli_close($con);

    echo "<script>window.location.href = 'manageuser.php';</script>";
}
?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
        <!-- your content here -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Add Users</h4>
                    <p class="card-category">Complete User profile</p>
                </div>
                <div class="card-body">
                    <form action="" method="post" name="form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">First Name</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Phone Number</label>
                                    <input type="text" id="phone" name="phone" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">City</label>
                                    <input type="text" name="city" id="city" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Country</label>
                                    <input type="text" name="country" id="country" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="btn_save" id="btn_save" class="btn btn-primary pull-right">Add User</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('.bmd-form-group input');

        inputs.forEach(input => {
            input.addEventListener('input', function () {
                if (this.value !== '') {
                    this.parentNode.classList.add('is-filled');
                } else {
                    this.parentNode.classList.remove('is-filled');
                }
            });
        });
    });
</script>
