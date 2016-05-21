<?php
include "./style/template_header.php";
include "./storescripts/connect_to_mysql.php";

if (isset($_GET["category"])){
    $category = $_GET["category"];
}
else
    $category = "";


$product = "";
$sql = mysql_query("SELECT * FROM products WHERE category = '$category' ORDER BY id DESC");
$productCount = mysql_num_rows($sql); 
if ($productCount > 0) {
    while ($row = mysql_fetch_array($sql)) {
        $id = $row["id"];
        $product_name = $row["product_name"];
        $price = $row["price"];
        $details = $row["details"];
        $details_short = substr($details,0,200).' ...';
        $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));


        $img = "./inventory_images/$id.jpg";  
        if (!@getimagesize($img)) {
            $img = "./style/images/no-photo.jpg";         
        }



        $product .= '<div class="col-md-12">
            <div class="thumbnail container-fluid">
                <div class="col-md-3"> <img class="img-rounded" src="' . $img . '" alt=""></div>
                <div class="caption-full">
                
                    <h4 class="pull-right">' . $price . 'zł</h4>
                    <h4><a href="product.php?id=' . $id . '">' . $product_name . '</a>
                    </h4>
                    <p> ' . $details_short . ' <br /></p>
                </div>
            </div>
        </div>';
    }
} else {
    $product = "Nie ma takiego produktu";
}
mysql_close();
?>


<!-- Page Content -->
<div class="container">

    <div class="row">

        <?php include './style/template_sidebar.php'?>
        
        <div class="row col-md-9">
            <?php echo $product; ?>
        </div>
    </div>
</div>
<!-- /.container -->


<?php include "./style/template_footer.php" ?>;