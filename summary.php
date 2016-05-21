
<?php 
include './style/template_header.php';

if(isset($_GET["array"])){
    
    $array = $_GET["array"];
     
    $output = '<form class="form-inline" method="POST" action="order.php">
                    <fieldset>

                        <!-- Form Name -->
                        <legend>Zamówienie</legend>

                        <!-- Text input-->
                        <div class="control-group">
                            <label class="control-label" for="name">Imie</label>
                            <div class="controls">
                                <input id="name" name="name" type="text" placeholder="Imie" class="input-xlarge" required="">

                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="control-group">
                            <label class="control-label" for="surname">Nazwisko</label>
                            <div class="controls">
                                <input id="surname" name="surname" type="text" placeholder="Nazwisko" class="input-xlarge" required="">

                            </div>
                        </div>

                        <!-- Appended Input-->
                        <div class="control-group">
                            <label class="control-label" for="email">E-mail</label>
                            <div class="controls">
                                <div class="input-append">
                                    <input id="email" name="email" class="input-xlarge" placeholder="E-mail" type="text" required="true">
                                </div>

                            </div>
                        </div>
                        
                        <input type="hidden" name="array" value="'.$array.'">
                               
                        <!-- Button (Double) -->
                        <div class="control-group">
                            <label class="control-label" for="make_order"></label>
                            <div class="controls">
                                <button id="make_order" name="make_order" class="btn btn-success">Zamawiam</button>
                                <a href="cart.php" name="cancel_order" class="btn btn-danger" role="button">Rezygnuje</a>
                                
                            </div>
                            
                        </div>

                    </fieldset>
                </form>';
}
else{
    $output = "<h1>Wystapił błąd, spróbuj ponownie</h1>";
}
?>

<div class="container">

    <div class="row">

        <div class="col-md-12">
            <div>
                
                <?php echo $output ;?>
                
            </div>
        </div>

    </div>

<?php include './style/template_footer.php'; ?>