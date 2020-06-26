<?php require_once("config.php"); ?>

<?php 
// $_GET['add'] =id
//  $_SESSION['product_' . $_GET['add'] <= concatinates the product_id 
if(isset($_GET['add'])){
//the get request from pressing the add to cart btn
//btw we defined => add <=  in the get_products() function to be part of the url 

//.....href="cart.php?add={$row['product_id']}">Add to cart</a>;


	// it stors the id number
// that why we are concatnating the add here 
//$_SESSION['product_'. $_GET['add']] += 1;
//redirect("index.php");



$query = query("SELECT * FROM products WHERE product_id=" . escape_string($_GET['add']) . "");
confirm($query);

while ($row = fetch_array($query)) {
	//looping theough the product of the specefied array
	if ($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]){

		$_SESSION['product_'. $_GET['add']] += 1; // if it didnt exist it'll create it

		// the session attribute(key) is called product_1 , peoduct_2 ....etc. not called product_id. and its value is its quantity
		redirect("../public/checkout.php");
		// after redirecting to the checkout page, the message and anything alse needed will be delt with in the checkout page

	}else{
		set_message("We only have"." ". $row['product_quantity']. " " . "{$row['product_title']} " ." available");
		redirect("../public/checkout.php");
	}

}
}

//$_GET['remove'] =id 
if(isset($_GET['remove'])){
	$_SESSION['product_' . $_GET['remove']] -= 1; //mandatory

	if($_SESSION['product_'. $_GET['remove']] < 1){ //only if the new value equals 0 
		//to reset/update there values  
		unset($_SESSION['item_quantity']);
		unset($_SESSION['item_total']);

		redirect("../public/checkout.php");
	} else{
		redirect("../public/checkout.php");


	}
}


//$_GET['delete'] =id 

if(isset($_GET['delete'])){
	$_SESSION['product_' . $_GET['delete']] = '0'; //********* ********//
		unset($_SESSION['item_quantity']);
		unset($_SESSION['item_total']);
	
		redirect("../public/checkout.php");
	
}



function cart(){

//total should add the subtotals not each product's price!	
$total = 0;

$item_quantity = 0;
$item_name = 1;
$item_number = 1;
$amount = 1;
$quantity = 1;
	//******************pulling out the product id from the session**************************//
	//foreach ($variable as $key => $value) {
	
foreach ($_SESSION as $name => $value) {
	//current element(key) with its current value in the _session array 


	//method:  substr( string $string , int $start [, int $length ] ) : string
    //Returns the portion of string specified by the start and length parameters.




if($value > 0){ //quantity


    // look for a session element(key) that starts with product_
    //beacuse many diffrent things can be stored in a session
    //IMPORTANT: all products(keys) have the first 8 letters in commen but each ends with a diffrent _id 
    //thats why we have to do it this way
    
    //!!!extracting and compairing strings!!!

if (substr($name, 0, 8) == 'product_'){

$length = strlen($name);// note: the $name var includes the id in it
$id = substr($name, 8, $length); //extracting the id


$query = query("SELECT * FROM products WHERE product_id=" . escape_string($id). " ");
confirm($query);


while ($row = fetch_array($query)){

//mutibly the product's proce with quantity to get sub total
$sub = $row['product_price'] * $value;

$product_image = display_image($row['product_image']);
//number of all items in cart
$item_quantity += $value; 

$product = <<<DELIMETER
<tr>
<td>{$row['product_title']}<br>
<img width='100px'  src= "../resources/{$product_image}" alt=""> 
</td>
<td> &#36; {$row['product_price']} </td>
<td> {$value}</td>
<td> &#36; {$sub}</td>
<td><a class='btn btn-warning' href="../resources/cart.php?remove={$row['product_id']}"><span class='glyphicon glyphicon-minus'></span></a>
<a class='btn btn-success' href="../resources/cart.php?add={$row['product_id']}"><span class='glyphicon glyphicon-plus'></span></a>
<a class='btn btn-danger' href="../resources/cart.php?delete={$row['product_id']}"><span class='glyphicon glyphicon-remove'></span></a>
</tr>

<input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
<input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
<input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
<input type="hidden" name="quantity_{$quantity}" value="{$value}">
DELIMETER;


echo $product;

$item_name ++;
$item_number ++;
$amount ++;
$quantity ++;
}

// all values needed from above will be added to the session to be accessed from (((anywhere)))
$_SESSION['item_total'] = $total += $sub;
$_SESSION['item_quantity'] = $item_quantity;

}
}

}				

}

function show_paypal(){

//show paypal button only if a session is set whitch indecates somthing exists in the cart
//item quantity is used beacuse its created once an elemnt is added to cart
//so we will check id its enabled we will show the button
if (isset($_SESSION['item_quantity']) && $_SESSION['item_quantity'] >= 1){



$paypal_button =<<<DELIMETER
<input type="image" name="upload"
src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
alt="PayPal - The safer, easier way to pay online">
DELIMETER;

 return $paypal_button;
}
}





function process_transaction(){

if(isset($_GET['tx'])){

	$amount		 = $_GET['amt'];
	$currency	 = $_GET['cc'];
	$transaction = $_GET['tx'];
	$status 	 = $_GET['st'];
	//all the above are set by paypal in the redirect link(once paynebt is finished)

	$total = 0;
	$item_quantity = 0;


	foreach ($_SESSION as $name => $value) {
		if($value > 0){ 
			if (substr($name, 0, 8) == 'product_'){

				$length = strlen($name);// note: the $name var includes the id in it
				$id = substr($name, 8, $length); //extracting the id
				//echo $id . "id";


				// use the information recived by paypal to store them as an order record in orders table
				$send_order = query("INSERT INTO orders (order_amount, order_ts, order_status, order_currency) VALUES('{$amount}', '{$transaction}', '{$status}', '{$currency}')");
				//now an order is has been created, we need to pull it out, to use it in the report:
				//thus we will use this helper to extract the last record's id(the one just inserted)
				$last_id = last_id();
				// echo $last_id;
				confirm($send_order);





				//report is a record that stores ((((((a product that has been orderd))))): its id + the order id + quantity +subtotal......
				//for every single product ordered!!!!!!! <= by its id
				$query = query("SELECT * FROM products WHERE product_id=" . escape_string($id). " ");
				confirm($query);


		 		while ($row = fetch_array($query)){
		 		$sub = $row['product_price'] * $value;
		 		$product_price = $row['product_price'];
		 		$product_title = $row['product_title'];
		 		$item_quantity += $value;
				

				$insert_report = query("INSERT INTO reports(product_id, order_id, product_price, product_title , product_quantity)VALUES('{$id}','{$last_id}', '{$product_price}', '{$product_title}' ,'{$value}')");
		 		confirm($insert_report);

		 		}
			//$total += $sub;
	 		
	 		}
	 	}

	 }		
	//once thank you page is displyed the session should be destroyed		
	session_destroy();

} 
else{
 	redirect("index.php");
 
}


}
?>