<?php
include './style/template_header.php';
include './storescripts/connect_to_mysql.php';

$status_label = "";
$output = "";

session_start();
$existCount = 0;

if (isset($_SESSION["manager"])) {

    $managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); 
    $manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]); 
    $password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); 

    include "../storescripts/connect_to_mysql.php";
    $sql = mysql_query("SELECT * FROM admin WHERE id='$managerID' AND username='$manager' AND password='$password' LIMIT 1"); // query the person
    // ------- Upewnienie sie że osoba istnieje w bazie---------
    $existCount = mysql_num_rows($sql); 
    if ($existCount == 0) { 
        echo "Ta sesja logowania nie istnieje w bazie.";
        exit();
    }
    
    
}
else
{
    
}

if (isset($_GET["change"])&&isset($_GET["status"])&&$existCount>0){
    
    
    $var = $_GET["status"];
    $varInt = intval($var);
    $oid = $_GET["oid"];
    
    mysql_query("UPDATE transactions SET status='$varInt' WHERE hash='$oid'")or die(mysql_error());
    
}



if (isset($_GET["oid"])) {

    $hash = $_GET["oid"];

    $sql = mysql_query("SELECT * FROM transactions WHERE hash='$hash' LIMIT 1");

    $transactionCount = mysql_num_rows($sql);
    if ($transactionCount > 0) {

        $row = mysql_fetch_array($sql);
        $status = $row["status"];
        $oid = $row["id"];
        $array = $row["product_id_array"];
        $email = $row["payer_email"];
        $firstname = $row["first_name"];
        $lastname = $row["last_name"];

        
        //ustawianie labela statusu
        if (intval($status) == 0) {
        $status_label = '<div align="right" ><h3><b>Status:</b><br></br><span class="label label-default">Oczekuje na zatwierdzenie</span></h3></div></br>';
        } elseif (intval($status) == 1) {
        $status_label = '<div align="right" ><h3><b>Status:</b><br></br><span class="label label-warning">Kompletowanie towaru</span></h3></div></br>';
        } elseif (intval($status) == 2) {
        $status_label = '<div align="right" ><h3><b>Status:</b><br></br><span class="label label-info">Gotowe do odbioru</span></h3></div></br>';
        } elseif (intval($status) == 3) {
        $status_label = '<div align="right" ><h3><b>Status:</b><br></br><span class="label label-success">Odebrane</span></h3></div></br>';
        } elseif (intval($status) == 4) {
        $status_label = '<div align="right" ><h3><b>Status:</b><br></br><span class="label label-danger">Odrzucone</span></h3></div></br>';
        }




        //wyciagniecie z array informacji o zamowionych produktach      
        $arrayexplode = explode(",",$array);
        $amount = count($arrayexplode)-1; // ilosc pozycji w zamowieniu
        
        for($i = 0 ; $i<$amount ; $i++){
            
            $array2explode = explode("-", $arrayexplode[$i]);

            $sql = mysql_query("SELECT * FROM products WHERE id='$array2explode[0]' LIMIT 1");

            $transactionCount = mysql_num_rows($sql);
            if ($transactionCount > 0) {

                $quantity = $array2explode[1];
                $id = $array2explode[0];
                
                
                $row = mysql_fetch_array($sql);
                
                $product_name = $row["product_name"];
                $price = $row["price"];
                $pricetotal = intval($price) * intval($quantity);
                $details = $row["details"];
                $details = substr($details,0,200).' ...';
                

            };

            // Dynamic table row assembly
                
                $img = "./inventory_images/$id.jpg"; //orginal image url from  db 
                if (!@getimagesize($img)) {
                    $img = "./style/images/no-photo.jpg";         //if image not found this will display
                }

                $cartOutput .= 
                '<div class="col-md-12 container-fluid">
                    <div class="thumbnail container-fluid">
                        <div class="col-md-3"> <img class="img-rounded" src="'.$img.'" alt=""></div>
                        <div class="caption-full">

                            <div class="container-fluid">   

                                <div class="col-md-7 container-fluid">
                                    <h4><a href="product.php?id='.$id.'">'.$product_name.'</a> <span class="label label-success">'.$price.' zł x '.$quantity.'</span></h4>
                                    </h4>
                                    <p> '.$details.'<br /></p>
                                </div>
                                <div class="col-md-2" align="right">
                                        <h2><span class="label label-success">'.$pricetotal.' zł</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        
    } }
    else {
        echo "Niestety, to zamówienie nie istnieje";
        exit();
    }
} else {
    $output = "<h1> Nie znaleziono zamówienia</h1>";
}
;?>


<div class="container">

    <div class="row">

        <h1 class="center-block" align="center"> Twoje zamówienie o numerze: <?php echo $oid;?></h1>

        <div class="container thumbnail">

            <!-- Code HERE -->
            <?php
            echo $cartOutput; 

            
            $edit = "";
            
            if ($existCount>0){
                                
                $edit = '
                         <div align="right" ><h3><b>Nowy status:</b><br></br>
                         <div class="pull-left"><a href='.$home_dir.'storeadmin/orders.php class="btn btn-primary" role="button">Powrót</a></div>
                         <div class="pull-right"><a href="status.php?oid='.$hash.'&&change=yes&&status=0" class="btn btn-default" role="button">Oczekuje na zatwierdzenie</a></div>
                         <div class="pull-right"><a href="status.php?oid='.$hash.'&&change=yes&&status=1" class="btn btn-warning" role="button">Kompletowanie towaru</a></div>
                         <div class="pull-right"><a href="status.php?oid='.$hash.'&&change=yes&&status=2" class="btn btn-info" role="button">Gotowe do odbioru</a></div>
                         <div class="pull-right"><a href="status.php?oid='.$hash.'&&change=yes&&status=3" class="btn btn-success" role="button">Odebrane</a></div>
                         <div class="pull-right"><a href="status.php?oid='.$hash.'&&change=yes&&status=4" class="btn btn-danger" role="button">Odrzucone</a></div>
                         </div>'; 
            }

            echo'
                <div class="container-fluid">
                                ' . $status_label . '
                                ' . $edit . '
                                <br></br>
                </div>';

            ;
            ?>


        </div>
    </div>

</div>

<?php include './style/template_footer.php'; ?>

