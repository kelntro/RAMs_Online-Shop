<?php
session_start();
include("../db.php");

error_reporting(0);
if (isset($_GET['action']) && $_GET['action'] != "" && $_GET['action'] == 'delete') {
  $order_id = $_GET['order_id'];

  // Delete query
  mysqli_query($con, "DELETE FROM orders WHERE order_id='$order_id'") or die("Delete query is incorrect...");
}

// Pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;

if ($page == "" || $page == "1") {
  $page1 = 0;
} else {
  $page1 = ($page * 10) - 10;
}

include "sidenav.php";
include "topheader.php";
?>
<!-- End Navbar -->
<div class="content">
  <div class="container-fluid">
    <!-- your content here -->
    <div class="col-md-14">
      <div class="card ">
        <div class="card-header card-header-primary">
          <h4 class="card-title">Orders / Page <?php echo $page; ?> </h4>
        </div>
        <div class="card-body">
          <div class="table-responsive ps">
            <table class="table table-hover tablesorter " id="">
              <thead class=" text-primary">
                <tr>
                  <th>Order ID</th>
                  <th>User ID</th>
                  <th>Product ID</th>
                  <th>Quantity</th>
                  <th>Transaction ID</th>
                  <th>Payment Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $result = mysqli_query($con, "SELECT * FROM orders LIMIT $page1,10") or die("Query 1 incorrect.....");

                while ($row = mysqli_fetch_array($result)) {
                  echo "<tr>
                          <td>{$row['order_id']}</td>
                          <td>{$row['user_id']}</td>
                          <td>{$row['product_id']}</td>
                          <td>{$row['qty']}</td>
                          <td>{$row['trx_id']}</td>
                          <td>{$row['p_status']}</td>
                          <td>
                            <a class='btn btn-danger' href='orders.php?order_id={$row['order_id']}&action=delete'>Complete</a>
                          </td>
                        </tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
