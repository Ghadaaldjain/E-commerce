<?php require_once("../../config.php"); 


 if (isset($_GET['id'])) {

$id = $_GET['id'];

$query = query("DELETE FROM users WHERE user_id=" . escape_string($id). " ");
confirm($query);
set_message("User Deleted");
redirect("../../../public/admin/index.php?users");

//beacuse the product page is defined in the index
 }else{

set_message("User was not Deleted");
redirect("../../../public/admin/index.php?users");
}



 ?>