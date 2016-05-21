<?php include './check_admin.php'; ?>
<?php include '../style/template_header_admin.php'; ?>
<?php include '../directories.php'; ?>; 
<?php

if (isset($_POST['product_name'])) {

    $product_name = mysql_real_escape_string($_POST['product_name']);
    $price = mysql_real_escape_string($_POST['price']);
    $category = mysql_real_escape_string($_POST['category']);
    $subcategory = "";
    $details = mysql_real_escape_string($_POST['details']);
    
    $sql = mysql_query("SELECT id FROM products WHERE product_name='$product_name' LIMIT 1");
    $productMatch = mysql_num_rows($sql); // count the output amount
    if ($productMatch > 0) {
        echo 'Taki produkt już istnieje w systemie!, <a href="inventory_list.php">kliknij tutaj</a>';
        exit();
    }
   
    $sql = mysql_query("INSERT INTO products (product_name, price, details, category, subcategory, date_added) 
        VALUES('$product_name','$price','$details','$category','$subcategory',now())") or die(mysql_error());
    $pid = mysql_insert_id();
     
    $newname = "$pid.jpg";
    move_uploaded_file($_FILES['fileField']['tmp_name'], "../inventory_images/$newname");
    header("location: add_product.php");
    exit();
}
?>
<script src="../js/jquery.min.js"></script>
<script src="../js/script.js"></script>


<?php include '../style/template_sidebar_admin.php'; ?>
<div class="col-md-9">
    <div class="thumbnail">

        <div class="caption-full">
            <form action="add_product.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
                <table width="90%" border="0" cellspacing="0" cellpadding="6" align="center">
                    <tr>
                        <td width="20%" align="right">Nazwa produktu</td>
                        <td width="80%"><label>
                                <input name="product_name" type="text" id="product_name" size="64" required />
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Cena</td>
                        <td><label>
                                <input name="price" type="text" id="price" size="12" required onchange="checkThis(this.value);"/>
                                PLN
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Kategoria</td>
                        <td><label>
                                <select name="category" id="category">
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
                        <td align="right">Opis produktu</td>
                        <td><label>
                                <textarea name="details" id="details" cols="64" rows="5" required=""></textarea>
                            </label></td>
                    </tr>
                    <tr>
                        <td align="right">Zdjecie</td>
                        <td><label>
                                <input type="file" name="fileField" id="fileField" />
                            </label></td>
                    </tr>      
                    <tr>
                        <td>&nbsp;</td>
                        <td><label>
                                <input type="submit" name="button" id="button" value="Dodaj!"/>
                            </label></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
</div>

</div>




<?php include '../style/template_footer_admin.php' ?>;
