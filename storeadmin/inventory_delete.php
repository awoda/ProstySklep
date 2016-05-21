<?php

include "./check_admin.php";
include "../style/template_header_admin.php";
include '../directories.php';

if (isset($_GET['deleteid'])) {
    echo '<h1 align="center">Czy na pewno chcesz usunąć produkt o ID ' . $_GET['deleteid'] . '?</h1></br>';
    echo '<p align="center"><a href="./inventory_delete.php?yesdelete=' . $_GET['deleteid'] . '" class="btn btn-success" role="button">Yes</a>     <a href="./inventory_list.php" class="btn btn-danger" role="button">No</a></p>';
}
if (isset($_GET['yesdelete'])) {
    $id_to_delete = $_GET['yesdelete'];
    $sql = mysql_query("DELETE FROM products WHERE id='$id_to_delete' LIMIT 1") or die(mysql_error());
    $pictodelete = ("../inventory_images/$id_to_delete.jpg");
    if (file_exists($pictodelete)) {
        unlink($pictodelete);
    }
    header("location: inventory_list.php");
}
?>

<?php

include "../style/template_footer_admin.php";
