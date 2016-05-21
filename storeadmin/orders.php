<?php
include "./check_admin.php";
include '../style/template_header_admin.php';
include '../directories.php';


$transaction_list = "";
$sql = mysql_query("SELECT * FROM transactions ORDER BY status");
$productCount = mysql_num_rows($sql); 
if ($productCount > 0) {
    while ($row = mysql_fetch_array($sql)) {
        $id = $row["id"];
        $imie = $row["first_name"];
        $nazwisko = $row["last_name"];
        $price = $row["price"];
        $email = $row["payer_email"];
        $hash = $row["hash"];
        $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
        $status = $row["status"];
        
        if (intval($status) == 0) {
            $transaction_list .= "<a href=$home_page/status.php?oid=$hash>ID zamówienia: $id</a> - <strong>$imie $nazwisko</strong> - $email  - <span class='label label-default'><b> Oczekiwanie na akceptacje</b></span>&nbsp; &nbsp; &nbsp; <br>";
        } elseif (intval($status) == 1) {
            $transaction_list .= "<a href=$home_page/status.php?oid=$hash>ID zamówienia: $id</a> - <strong>$imie $nazwisko</strong> - $email  - <span class='label label-warning'><b> Kompletowanie towaru</b></span>&nbsp; &nbsp; &nbsp; <br>";
        } elseif (intval($status) == 2) {
            $transaction_list .= "<a href=$home_page/status.php?oid=$hash>ID zamówienia: $id</a> - <strong>$imie $nazwisko</strong> - $email  - <span class='label label-info'><b> Gotowe do odbioru</b></span>&nbsp; &nbsp; &nbsp; <br>";
        } elseif (intval($status) == 3) {
            $transaction_list .= "<a href=$home_page/status.php?oid=$hash>ID zamówienia: $id</a> - <strong>$imie $nazwisko</strong> - $email  - <span class='label label-success'><b> Odebrane</b></span>&nbsp; &nbsp; &nbsp; <br>";
        } elseif (intval($status) == 4) {
            $transaction_list .= "<a href=$home_page/status.php?oid=$hash>ID zamówienia: $id</a> - <strong>$imie $nazwisko</strong> - $email  - <span class='label label-danger'><b> Odrzucone</b></span>&nbsp; &nbsp; &nbsp; <br>";
        }
    }
} else {
    $transaction_list = "Nic tu nie ma, może chciałbyś coś dodać?";
}
?>

<?php include '../style/template_sidebar_admin.php'; ?>
<div class="col-md-9">
    <div class="thumbnail">

        <div class="caption-full">
            <h4><b>Lista zamówień</b></a>
            </h4>
            <?php echo $transaction_list ;?>
        </div>
    </div>
</div>

<?php include '../style/template_footer_admin.php'; ?>
