<?php
include './check_admin.php';
include '../style/template_header_admin.php';
include '../directories.php';

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}


session_destroy();
?>

<?php include '../style/template_sidebar_admin.php'; ?>
<div class="col-md-9">
    <div class="thumbnail">
        <div class="caption-full">
            <h4><span class="label label-primary">INFORMACJA</span></h4>
            <p><h3>Zostałeś prawidłowo wylogowany!</h3></p>
            <p align="right"><a href="../index.php" class="btn btn-primary" role="button">Kliknij tutaj!</a></p>
        </div>
    </div>
</div>
</div>

<?php include '../style/template_footer_admin.php'; ?>