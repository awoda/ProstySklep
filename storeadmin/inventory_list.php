<?php
include "./check_admin.php";
include '../style/template_header_admin.php';
include '../directories.php';


$product_list = "";
$sql = mysql_query("SELECT * FROM products ORDER BY id DESC");
$productCount = mysql_num_rows($sql); 
if ($productCount > 0) {
    while ($row = mysql_fetch_array($sql)) {
        $id = $row["id"];
        $product_name = $row["product_name"];
        $price = $row["price"];
        $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
        $product_list .= "Product ID: $id - <strong>$product_name</strong> - $price PLN - <em>Dodany $date_added</em> &nbsp; &nbsp; &nbsp; <a href='inventory_edit.php?pid=$id'>edit</a> &bull; <a href='./inventory_delete.php?deleteid=$id'>delete</a><br />";
    }
} else {
    $product_list = "Nic tu nie ma, może chciałbyś coś dodać?";
}
?>


<?php include '../style/template_sidebar_admin.php'; ?>
<div class="col-md-9">
    <div class="thumbnail">
        <div class ="container-fluid">
            <p align="right"> <a href="add_product.php"><span class="label label-primary"><b>+ Dodaj przedmiot</b></span><br></a></p>
            <?php echo $product_list; ?>
        </div>
    </div>
</div>
</div>

<?php
include '../style/template_footer_admin.php';
