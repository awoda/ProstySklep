<?php
include './check_admin.php';
include '../directories.php';


if (isset($_POST['product_name'])) {

    $pid = mysql_real_escape_string($_POST['thisID']);
    $product_name = mysql_real_escape_string($_POST['product_name']);
    $price = mysql_real_escape_string($_POST['price']);
    $category = mysql_real_escape_string($_POST['category']);
    $subcategory = mysql_real_escape_string($_POST['subcategory']);
    $details = mysql_real_escape_string($_POST['details']);
    $sql = mysql_query("UPDATE products SET product_name='$product_name', price='$price', details='$details', category='$category', subcategory='$subcategory' WHERE id='$pid'");
    if ($_FILES['fileField']['tmp_name'] != "") { 
        $newname = "$pid.jpg";
        move_uploaded_file($_FILES['fileField']['tmp_name'], "../inventory_images/$newname");
    }
    header("location: inventory_list.php");
    exit();
}
?>
<?php

if (isset($_GET['pid'])) {
    $targetID = $_GET['pid'];
    $sql = mysql_query("SELECT * FROM products WHERE id='$targetID' LIMIT 1");
    $productCount = mysql_num_rows($sql); 
    if ($productCount > 0) {
        while ($row = mysql_fetch_array($sql)) {

            $product_name = $row["product_name"];
            $price = $row["price"];
            $category = $row["category"];
            $subcategory = "";
            $details = $row["details"];
            $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
        }
    } else {
        echo "Niestety, ten produkt nie istnieje w bazie :-(";
        exit();
    }
}
?>
<?php include_once("../style/template_header_admin.php"); ?>

<script src="../js/jquery.min.js"></script>
<script src="../js/script.js"></script>

<div class="container">

    <?php include '../style/template_sidebar_admin.php'; ?>
    <div class="col-md-9">
        <div class="thumbnail">
            <a name="inventoryForm" id="inventoryForm"></a>
            <h3 align="center">
                Modyfikuj produkt
            </h3>
            <form action="inventory_edit.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
                <table width="90%" border="0" cellspacing="0" cellpadding="6" align="center">
                    <tr>
                        <td width="20%" align="right">Nazwa produktu</td>
                        <td width="80%"><label>
                                <input name="product_name" type="text" id="product_name" size="64" value="<?php echo $product_name; ?>" />
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Cena</td>
                        <td><label>
                                <input name="price" type="text" id="price" size="12" required onchange="checkThis(this.value);" value="<?php echo $price; ?>" />PLN
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Kategoria</td>
                        <td><label>
                                <select name="category" id="category">
                                    <option value=""></option>
                                    <option value="apple">Strefa APPLE</option>
                                    <option value="laptopy">Laptopy i komputery</option>
                                    <option value="mobilne">Urządzenia mobilne</option>
                                    <option value="podzespoly">Podzespoły komputerowe</option>
                                    <option value="peryferia">Urządzenia peryferyjne</option>
                                    <option value="fotografia">Fotografia i akcesoria</option>
                                    <option value="konsole">Konsole i akcesoria</option>
                                    <option value="akcesoria">Akcesoria</option>
                                </select>
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Opis</td>
                        <td><label>
                                <textarea name="details" id="details" cols="64" rows="5"><?php echo $details; ?></textarea>
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Zdjęcie</td>
                        <td><label>
                                <input type="file" name="fileField" id="fileField" />
                            </label></td>
                    </tr>      
                    <tr>
                        <td>&nbsp;</td>
                        <td><label>
                                <input name="thisID" type="hidden" value="<?php echo $targetID; ?>" />
                                <input type="submit" name="button" id="button" value="Zapisz zmiany" />
                            </label></td>
                    </tr>
                </table>
            </form>
            <br />
            <br />
        </div>
    </div>
</div>
</div>
</div>

</div>  

<?php include_once("../style/template_footer_admin.php"); ?>


