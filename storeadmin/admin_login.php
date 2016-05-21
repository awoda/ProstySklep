<?php
session_start();
if (isset($_SESSION["manager"])) {
    header("location: index.php");
    exit();
}
?>
<?php

if (isset($_POST["login"]) && isset($_POST["password"])) {

    $manager = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["login"]); // filter everything but numbers and letters
    $password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password"]); // filter everything but numbers and letters


  
    include "../storescripts/connect_to_mysql.php";
    $sql = mysql_query("SELECT id FROM admin WHERE username='$manager' AND password='$password' LIMIT 1"); // query the person
    // ------- Sprawdzenie osoby w bazie ---------

    $existCount = mysql_num_rows($sql); 

    if ($existCount == 1) { // zliczenie danych w tabeli
        while ($row = mysql_fetch_array($sql)) {
            $id = $row["id"];
        }
        $_SESSION["id"] = $id;
        $_SESSION["manager"] = $manager;
        $_SESSION["password"] = $password;
        header("location: index.php");
        exit();
    } else {
        include '../style/template_header_admin.php';
        echo '<div align="center"><h3>Te informacje są nieprawidłowe</h3></div>';
        echo '<p align="center"><a href="index.php" class="btn btn-success" role="button">Spróbuj jeszcze raz</a>     <a href="../" class="btn btn-danger" role="button">Wyjdź</a></p>';
        exit();
    }
}

include '../style/template_header_admin.php';
include '../directories.php';
?>


<!DOCTYPE html>
<style type="text/css">a {text-decoration: none}</style>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>Bootstrap Login Form</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/styles.css" rel="stylesheet">
    </head>
    <body>
        <!--login modal-->
        <div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <a href="../" style="text-decoration: none"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></a>
                        <h1 class="text-center">Login</h1>
                    </div>
                    <div class="modal-body">
                        <form class="form col-md-12 center-block" action="admin_login.php" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control input-lg" placeholder="Login" name="login">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control input-lg" placeholder="Hasło" name="password">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-lg btn-block">Zaloguj</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <div class="col-md-12">
                            <button class="btn" data-dismiss="modal" aria-hidden="true"><a href="../index.php" style="text-decoration: none">Anuluj</a></button>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
        <!-- script references -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>