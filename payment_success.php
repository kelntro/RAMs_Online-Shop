<?php
session_start();
if (!isset($_SESSION["uid"])) {
    header("location:index.php");
}

if (isset($_GET["st"])) {
    $trx_id = $_GET["tx"];
    $p_st = $_GET["st"];
    $amt = $_GET["amt"];
    $cc = $_GET["cc"];
    $cm_user_id = $_GET["cm"];
    $c_amt = $_COOKIE["ta"];

    if ($p_st == "Completed") {
        include_once("db.php");
        $sql = "SELECT p_id, qty FROM cart WHERE user_id = '$cm_user_id'";
        $query = mysqli_query($con, $sql);

        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_array($query)) {
                $product_id[] = $row["p_id"];
                $qty[] = $row["qty"];
            }

            for ($i = 0; $i < count($product_id); $i++) {
                $sql = "INSERT INTO orders (user_id, product_id, qty, trx_id, p_status) 
                        VALUES ('$cm_user_id', '" . $product_id[$i] . "', '" . $qty[$i] . "', '$trx_id', '$p_st')";
                mysqli_query($con, $sql);
            }

            $sql = "DELETE FROM cart WHERE user_id = '$cm_user_id'";
            if (mysqli_query($con, $sql)) {
?>
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Payment Success</title>
                    <!-- Include Bootstrap CSS -->
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                </head>
                <body>
                <!-- Modal HTML -->
                <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="successModalLabel">Payment Successful</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Hello <b><?php echo $_SESSION["name"]; ?></b>, your payment process is successfully completed and your Transaction ID is <b><?php echo $trx_id; ?></b>.
                            </div>
                            <div class="modal-footer">
                                <a href="index.php" class="btn btn-primary">Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Include jQuery and Bootstrap JS -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

                <!-- Script to show the modal on page load -->
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#successModal").modal("show");
                    });
                </script>
                </body>
                </html>

<?php
            }
        } else {
            header("location:index.php");
        }
    }
}
?>
