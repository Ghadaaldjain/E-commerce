<?php require_once("../../config.php"); 


 if (isset($_GET['id'])) {

$id = $_GET['id'];

$query = query("DELETE FROM orders WHERE order_id=" . escape_string($id). " ");
confirm($query);
set_message("Order Deleted");
redirect("../../../public/admin/index.php?orders");

//beacuse the order page is defined in the index
 }else{

set_message("Order was not Deleted");
redirect("../../../public/admin/index.php?orders");
}



 ?>