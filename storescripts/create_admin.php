<?php


if (isset($_POST["login"])&& isset($_POST["password"])&&isset($_POST["repassword"]))
{
    $login = $_POST["login"];
    $pass = $_POST["password"];
    $repass = $_POST["repassword"];
    
    if (strcmp($pass, $repass)==0)
    {
        
        require './connect_to_mysql.php';

        $sql = "INSERT INTO admin (username, password)  VALUES('$login', '$pass')";

        if (mysql_query($sql)){ 
            echo "user $login created!"; 
        } else { 
            echo "CRITICAL ERROR: admin has not been created.";
            mysql_error();
        }
    }

    
}

;?>
<br></br>
<form action="create_admin.php" method="POST">
    login:
    <input type="text" name="login" value="">
    password:
    <input type="password" name="password" value="">
    re-enter password:
    <input type="password" name="repassword" value="">
    <br><br>
<input type="submit" value="Create">
</form>
</form>
    

