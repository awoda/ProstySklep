<?php
include './style/template_header.php';
include './directories.php';
include './storescripts/connect_to_mysql.php';

session_start();

?>

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 1 (dodanie do koszyka)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
    $wasFound = false;
    $i = 0;
    
    if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {

        $_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));
    } else {

        foreach ($_SESSION["cart_array"] as $each_item) {
            $i++;
            while (list($key, $value) = each($each_item)) {
                if ($key == "item_id" && $value == $pid) {
                    
                    array_splice($_SESSION["cart_array"], $i - 1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
                    $wasFound = true;
                } 
            } 
        } 
        if ($wasFound == false) {
            array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => 1));
        }
    }
    header("location: cart.php");
    exit();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 2 (czyszczenie koszyka)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
    unset($_SESSION["cart_array"]);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 3 (zmiana ilości)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
  
	$item_to_adjust = $_POST['item_to_adjust'];
	$quantity = $_POST['quantity'];
	$quantity = preg_replace('#[^0-9]#i', '', $quantity); 
	if ($quantity >= 100) { $quantity = 99; }
	if ($quantity < 1) { $quantity = 1; }
	if ($quantity == "") { $quantity = 1; }
	$i = 0;
	foreach ($_SESSION["cart_array"] as $each_item) { 
		      $i++;
		      while (list($key, $value) = each($each_item)) {
				  if ($key == "item_id" && $value == $item_to_adjust) {
					  // Jesli przedmiot juz jest w koszyku, inkrementujemy jego ilość
					  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
				  } 
		      } 
	} 
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 4 (usunięcie przedmiotu z koszyka)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {

 	$key_to_remove = $_POST['index_to_remove'];
	if (count($_SESSION["cart_array"]) <= 1) {
		unset($_SESSION["cart_array"]);
	} else {
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION["cart_array"]);
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 5  (wyświetlenie koszyka)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$cartOutput = "";
$dynamicList = "";
$cartTotal = "";
$product_id_array = '';

if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
    $cartOutput = "<h2 align='center'>Twój koszyk jest pusty!</h2>";
} else {

    $i = 0; 
    foreach ($_SESSION["cart_array"] as $each_item) { 
		$item_id = $each_item['item_id'];
		$sql = mysql_query("SELECT * FROM products WHERE id='$item_id' LIMIT 1");
		while ($row = mysql_fetch_array($sql)) {
			$product_name = $row["product_name"];
			$price = $row["price"];
			$details = $row["details"];
                        $details = substr($details,0,200).' ...';
		}
		$pricetotal = $price * $each_item['quantity'];
		$cartTotal = $pricetotal + $cartTotal;

		$product_id_array .= "$item_id-".$each_item['quantity'].","; 
		
                // Dynamic table row assembly
                
                $img = "./inventory_images/$item_id.jpg";  
                if (!@getimagesize($img)) {
                    $img = "./style/images/no-photo.jpg";      
                }

                $cartOutput .= 
                '<div class="col-md-12 container-fluid">
                    <div class="thumbnail container-fluid">
                        <div class="col-md-3"> <img class="img-rounded" src="'.$img.'" alt=""></div>
                        <div class="caption-full">

                            <div class="container-fluid">   

                                <div class="col-md-7 container-fluid">
                                    <h4><a href="product.php?id='.$item_id.'">'.$product_name.'</a> <span class="label label-success">'.$price.' zł</span></h4>
                                    </h4>
                                    <p> '.$details.'<br /></p>
                                </div>

                                <div class="col-md-2" align="right">


                                    <form action="cart.php" method="POST">
                                        <h4 ><span class="label label-success">'.$pricetotal.' zł</span></h4>
                                        Ilość:
                                        <input name="quantity" type="text" value="'. $each_item['quantity'].'" size="1" maxlength="2" />
                                        <button class="btn btn-success btn-sm" name="adjustBtn' . $item_id . '"><span class="glyphicon glyphicon-ok"></span></button>
                                        <input name="item_to_adjust" type="hidden" value="' . $item_id . '" />
                                    </form>
                                    </br>
                                    <form action="cart.php" method="POST">
                                        <input name="index_to_remove" type="hidden" value="' . $i . '" />
                                  
                                        <div><button class="btn btn-danger btn-mg"><span class="glyphicon glyphicon-remove"></span> Usuń!</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
                
                
		$i++; 
    }
    
}

;?>

        <style type="text/css">a {text-decoration: none}</style>

        <h1 class="center-block" align="center"> Twój koszyk </h1>
        
        <div class="container thumbnail">

            <!-- Code HERE -->
            <?php
            echo $cartOutput; 
            
            if (isset($_SESSION["cart_array"])){
            echo 
                '   <div class="container-fluid">
                    <div align="right" ><h3><b>RAZEM:</b><br></br><span class="label label-success">'.$cartTotal.' zł</span></h3></div></br>
                    <div class="pull-left"><a href="cart.php?cmd=emptycart" class="btn btn-warning" role="button">Opróżnij koszyk</a></div>
                    <div class="pull-right"><a href="summary.php?array='.$product_id_array.'" class="btn btn-primary" role="button">Zamów!</a></div>
                    <br></br>
                </div>';}
            ;?>
            
            
        </div>


        <!-- //Code HERE -->


<?php include './style/template_footer.php'; ?>
