<?php
include '../directories.php';

echo '<div class="container">
    <div class="row">
        <div class="col-md-3">
            <p class="lead">WSI.pl</p>
            <div class="list-group">
                <a href="' . $home_dir . 'storeadmin/inventory_list.php" class="list-group-item">Zarzadzaj inwentarzem</a>
                <a href="' . $home_dir . 'storeadmin/orders.php" class="list-group-item">Sprawdz aktualne zamówienia</a>
                <a href="' . $home_dir . 'storeadmin/admin_logout.php" class="list-group-item">Wyloguj</a>

            </div>
        </div>';

?>

