 <?php include './directories.php';?>

<?php echo '<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WSI.pl - Wielki Sklep Internetowy</title>

    <!-- Bootstrap Core CSS -->
    <link href="' . $home_dir . 'css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="' . $home_dir . 'css/shop-item.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="' . $home_dir . 'js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="' . $home_dir . 'js/bootstrap.min.js"></script>

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top nopadding">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <a class="navbar-brand" href="' . $home_dir . 'index.php">WSI.pl</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="' . $home_dir . 'index.php"><span class="glyphicon glyphicon-home"></span> Sklep<span class="sr-only">(current)</span></a></li>
        <li><a href="' . $home_dir . 'under_dev.php"><span class="glyphicon glyphicon-info-sign"></span> O nas</a></li>
        <li><a href="' . $home_dir . 'under_dev.php"><span class="glyphicon glyphicon-envelope"></span> Kontakt</a></li>
        <li><a href="' . $home_dir . 'under_dev.php"><span class="glyphicon glyphicon-question-sign"></span> FAQ</a></li>

      </ul>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="./cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Koszyk</a></li>
     
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>'; ?>
