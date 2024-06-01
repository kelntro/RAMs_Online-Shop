<?php
session_start();
include "db.php";

if (isset($_SESSION["uid"])) {
    $user_id = $_SESSION["uid"];
    $trx_id = uniqid('', true); // Generating a unique transaction ID
    $p_status = 'Pending'; // Assuming initial payment status is pending

    $total_count = $_POST['total_count'];
    $prod_total = $_POST['total_price'];

    for ($i = 1; $i <= $total_count; $i++) {
        $prod_id = $_POST['prod_id_' . $i];
        $prod_qty = $_POST['prod_qty_' . $i];

        $sql = "INSERT INTO `orders` 
            (`user_id`, `product_id`, `qty`, `trx_id`, `p_status`) 
            VALUES ('$user_id', '$prod_id', '$prod_qty', '$trx_id', '$p_status')";

        if (!mysqli_query($con, $sql)) {
            echo (mysqli_error($con));
        }
    }

    $del_sql = "DELETE FROM cart WHERE user_id=$user_id";
    if (mysqli_query($con, $del_sql)) {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Checkout Success</title>
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
                        Hello <b>' . $_SESSION["name"] . '</b>, your payment process is successfully completed and your Transaction ID is <b>' . $trx_id . '</b>.
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
        ';
    } else {
        echo (mysqli_error($con));
    }
} else {
    echo "<script>window.location.href='index.php'</script>";
}

?>
