<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

if (empty($_SESSION['user_id'])) {
    header('location:login.php');
} else {
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>My Orders</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
        .indent-small { margin-left: 5px; }
        .form-group.internal { margin-bottom: 0; }
        .dialog-panel { margin: 10px; }
        .datepicker-dropdown { z-index: 200 !important; }
        .panel-body {
            background: #e5e5e5;
            font: 600 15px "Open Sans", Arial, sans-serif;
        }
        label.control-label {
            font-weight: 600;
            color: #777;
        }
        @media only screen and (max-width: 760px),
        (min-device-width: 768px) and (max-device-width: 1024px) {
            /* Add any necessary responsive styles here */
        }
    </style>
</head>
<body>
    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php"> 
                    <img class="img-rounded" src="images/icn.png" alt=""> 
                </a>
                <div class="collapse navbar-toggleable-md float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> 
                            <a class="nav-link active" href="index.php">Home</a>
                        </li>
                        <li class="nav-item"> 
                            <a class="nav-link active" href="restaurants.php">Restaurants</a>
                        </li>
                        <?php
                        if (empty($_SESSION["user_id"])) {
                            echo '<li class="nav-item"><a href="login.php" class="nav-link active">Login</a></li>
                                  <li class="nav-item"><a href="registration.php" class="nav-link active">Register</a></li>';
                        } else {
                            echo '<li class="nav-item"><a href="your_orders.php" class="nav-link active">My Orders</a></li>';
                            echo '<li class="nav-item"><a href="logout.php" class="nav-link active">Logout</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="page-wrapper">
        <div class="inner-page-hero bg-image" data-image-src="images/img/pimg.jpg"></div>
        <section class="restaurants-page">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="bg-gray">
                            <div class="row">
                                <table class="table table-bordered table-hover">
                                    <thead style="background: #404040; color:white;">
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $query_res = mysqli_query($db, "SELECT * FROM users_orders WHERE u_id='" . $_SESSION['user_id'] . "'");
                                        if (!mysqli_num_rows($query_res) > 0) {
                                            echo '<td colspan="6"><center>You have No orders Placed yet. </center></td>';
                                        } else {
                                            while ($row = mysqli_fetch_array($query_res)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['title']; ?></td>
                                            <td><?php echo $row['quantity']; ?></td>
                                            <td>$<?php echo $row['price']; ?></td>
                                            <td>
                                                <?php
                                                $status = $row['status'];
                                                if ($status == "" || $status == "NULL") {
                                                    echo '<button class="btn btn-info">Dispatch</button>';
                                                } elseif ($status == "in process") {
                                                    echo '<button class="btn btn-warning">On The Way!</button>';
                                                } elseif ($status == "closed") {
                                                    echo '<button class="btn btn-success">Delivered</button>';
                                                } elseif ($status == "rejected") {
                                                    echo '<button class="btn btn-danger">Cancelled</button>';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $row['date']; ?></td>
                                            <td>
                                                <a href="delete_orders.php?order_del=<?php echo $row['o_id']; ?>" onclick="return confirm('Are you sure you want to cancel your order?');" class="btn btn-danger btn-xs">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer">
            <div class="row bottom-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 payment-options color-gray">
                            <h5>Payment Options</h5>
                            <ul>
                                <li><a href="#"><img src="images/paypal.png" alt="Paypal"></a></li>
                                <li><a href="#"><img src="images/mastercard.png" alt="Mastercard"></a></li>
                                <li><a href="#"><img src="images/maestro.png" alt="Maestro"></a></li>
                                <li><a href="#"><img src="images/stripe.png" alt="Stripe"></a></li>
                                <li><a href="#"><img src="images/bitcoin.png" alt="Bitcoin"></a></li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-4 address color-gray">
                            <h5>Address</h5>
                            <p>1086 Stockert Hollow Road, Seattle</p>
                            <h5>Phone: 75696969855</h5>
                        </div>
                        <div class="col-xs-12 col-sm-5 additional-info color-gray">
                            <h5>Additional Information</h5>
                            <p>Join thousands of other restaurants who benefit from having partnered with us.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
</body>
</html>
<?php } ?>
