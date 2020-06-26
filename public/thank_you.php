<!-- thank_you.php?amt=24.20&cc=USD&st=Completed&tx=5LU91766UY180703C -->
<!-- Configuration-->

<?php require_once("../resources/config.php"); ?>

<!-- includeing the cart.php to call the cart function-->
<?php require_once("../resources/cart.php"); ?>

<!-- Header-->
<?php include(TEMPLATE_FRONT .  "/header.php");?>

<?php 

	process_transaction();

?>



<!-- Page Content -->
<div class="container">
	<h1 class="test-center"> THANK YOU </h1>
</div>
    <!-- /.container -->





<?php include(TEMPLATE_FRONT .  "/footer.php");?>
