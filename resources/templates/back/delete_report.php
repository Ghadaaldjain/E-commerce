<?php require_once("../../config.php"); 


 if (isset($_GET['id'])) {

$id = $_GET['id'];

$query = query("DELETE FROM reports WHERE report_id=" . escape_string($id). " ");
confirm($query);
set_message("Report Deleted");
redirect("../../../public/admin/index.php?reports");

//beacuse the order page is defined in the index
 }else{

set_message("Report was not Deleted");
redirect("../../../public/admin/index.php?reports");
}



 ?>