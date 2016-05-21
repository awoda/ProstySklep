<?php 
include './directories.php';
include './style/template_header.php';

$output = "";

if (isset($_POST["array"]) && isset($_POST["email"]) && isset($_POST["name"]) && isset($_POST["surname"])) {

    $order = mysql_real_escape_string($_POST["array"]);
    $name = mysql_real_escape_string($_POST["name"]);
    $surname = mysql_real_escape_string($_POST["surname"]);
    $email = mysql_real_escape_string($_POST["email"]);


    require './storescripts/connect_to_mysql.php';

    $sql = "INSERT INTO transactions (product_id_array, payer_email, first_name, last_name, status)  VALUES('$order', '$email', '$name', '$surname', 0)";
    

    if (mysql_query($sql)) {
        $oid = mysql_insert_id();
        $salt = "somesalt";
        $hash = sha1($oid.$salt);
        mysql_query("UPDATE transactions SET hash='$hash' WHERE id='$oid'")or die(mysql_error());
        
        $output .= "<h2>Twoje zamowienie zostało utworzone!</h2><br>";
        $output .= "<h3>numer zamówienia: $oid </h2><br>";
        $output .= "Link do zamówienia: <br><b><a href='$home_page/status.php?oid=$hash'>$home_page/status?oid=$hash</a></b><br>";
        $output .= "Pod tym linkiem możesz śledzić stan zamówienia";
        
    } else {
        $output .= "Zamówienie nie zostało wprowadzone";
        $output .= mysql_error();
    }
}


else {
    
    $output = "<h2>Błąd - zamówienie nie istnieje</h2>";
     
}
;?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="thumbnail">
                <?php echo $output; ?> 
            </div>
        </div>
    </div>

    <?php include './style/template_footer.php'; ?>





