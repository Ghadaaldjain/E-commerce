<?php require_once("../../config.php"); 


 if (isset($_GET['id'])) {

$id = $_GET['id'];

$query = query("DELETE FROM categories WHERE cat_id=" . escape_string($id). " ");
confirm($query);
set_message("Category Deleted");
redirect("../../../public/admin/index.php?categories");

//beacuse the product page is defined in the index
 }else{

set_message("Category was not Deleted");
redirect("../../../public/admin/index.php?categories");
}



 ?>