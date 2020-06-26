<?php  //custom helper functions::::

//uploads: the dir that has all our images
//incase its location ever needed to change we will store it in a global var:
$uploads_dirctory = "uploads";

// going back: ../

function set_message($msg){
	if(!empty($msg)){
		//Determine whether a variable is considered to be empty. A variable is considered empty if it does not exist or if its value equals FALSE. empty() does not generate a warning if the variable does not exist.

		//set msg as a sesion varible
		//btw we already started a session in config!!, thus, we only have to set an attribute
		$_SESSION['massege']= $msg;
	}else{
		$msg= "";
	}


}


function display_message(){
	//isset — Determine if a variable is declared and is different than NULL
	if(isset($_SESSION['massege'])){

		echo $_SESSION['massege'];
		unset($_SESSION['massege']);
	}
}

// Purpose: it works just like header but with clearer/meaningfull naming!
function redirect($location){
	header("Location: $location");
}



/*************************DATABASE FUNCTIONS*********************************************/

// Purpose: better naming.
function query($sql){
	// must indicate that we are refering to the global one (in config)
	global $connection;
	return mysqli_query($connection, $sql);
}


// Purpose: calling this function is easer that writng an if statment for every query check
function confirm ($result){	
	// must indicate that we are refering to the global one (in config)
	global $connection;		
	if(!$result){
    	die("QUERY FAILED!!!! " . mysqli_error($connection));
    }
}

// Purpose: prevent sql injection
function escape_string($string){
	global $connection;	
	//to escape a lot of stuff that is going to our database 
	return mysqli_real_escape_string($connection, $string);
}

// Purpose: better naming.
function fetch_array($result){
	return mysqli_fetch_array($result);
}

function last_id(){
	global $connection;
	return mysqli_insert_id($connection);


}
//test the connection:
//  if ($connection) {
//  	echo "connected!!"; }





/*************************FRONT-END FUNCTIONS*********************************************/



// Purpose: get all products from database.
function get_products(){
//we will use the functions defined above as follow:
$query = query("SELECT * FROM products");
confirm($query);

while ($row = fetch_array($query)){


$product_image = display_image($row['product_image']);
//this method will help us change:
//src="../../resources/uploads/{$row['product_image']}" 
//to:
//src="../../resources/$product_image" 


	// Herodoc will be used, to insert an html code without worring about double or single qoutations 

	//assign a varible to a heroduc
	//make sure you have no cpace after DELIMETER or it will give you an error
$product = <<<DELIMETER
<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"> <img src="../resources/{$product_image}" alt=""> </a>
        <div class="caption">
            <h4 class="pull-right">{$row['product_price']} $</h4>
            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
            </h4>
            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
             <a class="btn btn-primary" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
        </div>
        
    </div>
</div>
DELIMETER;

	echo $product;
}

}


function get_categories(){
$query = query("SELECT * FROM categories");
confirm($query);

	//$row is gunna act like an array in here (or a record):
while($row = fetch_array($query)){
$categories_links = <<<DELIMETER
<a href='category.php?id={$row['cat_id']}' class='list-group-item'> {$row['cat_title']}</a>
DELIMETER;
	echo $categories_links;
}

}


function get_products_in_cat_page(){
//we will use the functions defined above as follow:
$query = query("SELECT * FROM products WHERE product_category_id = " . escape_string($_GET['id']) ." ");
confirm($query);


 
while ($row = fetch_array($query)){
$product_image = display_image($row['product_image']);

	// Herodoc will be used, to insert an html code without worring about double or single qoutations 

	//assign a varible to a heroduc
	//make sure you have no cpace after DELIMETER or it will give you an error
$product = <<<DELIMETER
<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"> <img src="../resources/{$product_image}" alt=""> </a>
        <div class="caption">
            <h4 class="pull-right">{$row['product_price']} $</h4>
            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
            </h4>
            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
             <a class="btn btn-primary" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
   		</div>     
    </div>
</div>
DELIMETER;

	echo $product;
}
}

function get_products_in_shop_page(){
//we will use the functions defined above as follow:
$query = query("SELECT * FROM products ");
confirm($query);


 
while ($row = fetch_array($query)){

$product_image = display_image($row['product_image']);


	// Herodoc will be used, to insert an html code without worring about double or single qoutations 
	//assign a varible to a heroduc
	//make sure you have no cpace after DELIMETER or it will give you an error
$product = <<<DELIMETER
<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"> <img src="../resources/{$product_image}" alt=""> </a>
        <div class="caption">
            <h4 class="pull-right">{$row['product_price']} $</h4>
            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
            </h4>
            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
             <a class="btn btn-primary" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
   		</div>     
    </div>
</div>
DELIMETER;

	echo $product;
}
}





/*************************BACK-END FUNCTIONS*********************************************/



function login_ussr(){
	if(isset($_POST['submit'])){
		$username = escape_string($_POST['username']);
		$password = escape_string($_POST['password']);
  
		$query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");
		confirm($query);

		//check if we got any matching rows back 
		//if we got a zero that means no user in the db with these credentials
		if(mysqli_num_rows($query) == 0){
			set_message("Your credentials are wrong");
			redirect("login.php");
		} else {
			$_SESSION['username'] = $username;
			set_message("Welcome {$username}");
			redirect("admin");
		}

	}

}



function send_message(){
	if(isset($_POST['submit'])){
		////isset — Determine if a variable is declared and is different than NULL
		$to 		= "ghada.ed@live.com";
		$from_name 	= $_POST['name'];
		$email 	    = $_POST['email'];
		$subject    = $_POST['subject'];
		$message    = $_POST['message'];


		$headers = "FROM: {$from_name} {$email}";


		$result = mail($to, $subject, $message, $headers);

		if(!$result){

			set_message("Sorry the email was not deliverd");
			//after we set it using this method, it will be stored as session attribute that can be called in the html page using display method
			redirect("contact.php");
		}else {
			set_message("Your message has been sent");
			redirect("contact.php");
		}
  
  
		
	}

}


/*************************ADMIN FUNCTIONS*********************************************/



/**********************ORDERS*********************************/





function display_orders(){
$query = query("SELECT * FROM orders");

confirm($query);

	//$row is gunna act like an array in here (or a record):
while($row = fetch_array($query)){
$orders = <<<DELIMETER
<tr>
<td>{$row['order_id']}</td>
<td>{$row['order_amount']}</td>
<td>{$row['order_ts']}</td>
<td>{$row['order_currency']}</td>
<td>{$row['order_status']}</td>
<td><a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id={$row['order_id']}" ><span class="glyphicon glyphicon-remove"> </span></a></td>
</tr>
DELIMETER;
	echo $orders;
}

}


function admin_access(){

$admin_button = <<<DELIMETER
<li>
<a href="admin">Admin</a> 
</li>
DELIMETER;
	echo $admin_button;
}


/**********************PRODUCT********************************/





function get_products_in_admin(){
$query = query("SELECT * FROM products");
confirm($query);

while ($row = fetch_array($query)){

//get category name by id:
$category = show_product_category_title($row['product_category_id']);


$product_image = display_image($row['product_image']);
//this method will help us change:
//src="../../resources/uploads/{$row['product_image']}" 
//to:
//src="../../resources/$product_image" 





// Herodoc will be used, to insert an html code without worring about double or single qoutations 
//assign a varible to a heroduc
//make sure you have no space after DELIMETER or it will give you an !!error!!
$product = <<<DELIMETER
<tr>
<td>{$row['product_id']}</td>
<td>{$row['product_title']}<br>
<a href="index.php?edit_product&id={$row['product_id']}"> <img width= '100px' src="../../resources/$product_image" alt="no"/></a>
</td>
<td>{$category}</td>
<td>{$row['product_price']}</td>
<td>{$row['product_quantity']}</td>
<td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}" ><span class="glyphicon glyphicon-remove"> </span></a></td>
</tr>
DELIMETER;

	echo $product;
}
}


//this function will take the category id in a product record and retrive the ((((name of the category)))
function show_product_category_title($product_category_id){

	$category_query = query("SELECT * FROM categories WHERE cat_id = '{$product_category_id}'");
	confirm($category_query);


	while ($category_row = fetch_array($category_query)) {
		return $category_row['cat_title'];
	}

}

function add_product(){
	if (isset($_POST['publish'])) {// form method= post,  and the sumbit btn name is publish, which will be imediatly set in the post array since its an input type; with everything else





		//extract from post array:
		$product_title 			= escape_string($_POST['product_title']);
		$product_category_id 	= escape_string($_POST['product_category_id']);
		$product_price 			= escape_string($_POST['product_price']);
		$product_quantity		= escape_string($_POST['product_quantity']);
		$product_description 	= escape_string($_POST['product_description']);
		$short_desc 			= escape_string($_POST['short_desc']);
		//extract from files array: (since its an image)
		$product_image 			= escape_string($_FILES['file']['name']);// file is the name of the input tag and name is the name
		$image_temp_location 	= escape_string($_FILES['file']['tmp_name']);//tmp_name is the temprory location where the file will be stored before being send to the db

		//$_FILES is a super global variable which can be used to upload files.


		move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image );

//move_uploaded_file ( string $filename , string $destination ) : bool
//This function checks to ensure that the file designated by filename is a valid upload file (meaning that it was uploaded via PHP's (((((HTTP POST))))) upload mechanism). If the file is valid, it will be moved to the filename given by destination.

		$query = query("INSERT INTO products(product_title, product_category_id , product_price, product_quantity, product_description, product_image, short_desc) VALUES('{$product_title}','{$product_category_id}', '{$product_price}', '{$product_quantity}', '{$product_description}', '{$product_image}', '{$short_desc}')");
			
				
		confirm($query);
		$last_id = last_id();
		set_message("New Product with id {$last_id}  Created");
		redirect("index.php?products");



	}
}

//this function will create the menu to select a category in the add_product page
//by retriving all categories; displaying there names but setteing the value to there ids
function show_categories_add_product_page(){
$query = query("SELECT * FROM categories");
confirm($query);

	//$row is gunna act like an array in here (or a record):
while($row = fetch_array($query)){
$categories_options = <<<DELIMETER
<option value="{$row['cat_id']}">{$row['cat_title']}</option>
DELIMETER;
	echo $categories_options;
}


}


function display_image($picture){
	global $uploads_dirctory;
	return $uploads_dirctory . DS . $picture;

}



function update_product(){
	if (isset($_POST['update'])) {// form method= post,  and the sumbit btn name is publish, which will be imediatly set in the post array since its an input type; with everything else





		//extract from post array:
		$product_title 			= escape_string($_POST['product_title']);
		$product_category_id 	= escape_string($_POST['product_category_id']);
		$product_price 			= escape_string($_POST['product_price']);
		$product_quantity		= escape_string($_POST['product_quantity']);
		$product_description 	= escape_string($_POST['product_description']);
		$short_desc 			= escape_string($_POST['short_desc']);
		//extract from files array: (since its an image)
		$product_image 			= escape_string($_FILES['file']['name']);// file is the name of the input tag and name is the name
		$image_temp_location 	= escape_string($_FILES['file']['tmp_name']);//tmp_name is the temprory location where the file 


		//since we are updating, the temprory location is not neccerly filled(we are still using the old chosen photo from the db)
		//thus we need to check first then either create a query to get if from the database
		//or assign thr one in temrory location
		if(empty($product_image)){

			$get_pic = query("SELECT product_image FROM products WHERE product_id = " . escape_string($_GET['id']) . " ");
			confirm($get_pic);
			while($pic = fetch_array($get_pic)){
				$product_image = $pic['product_image'];
			}
		}
			move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image );
		
 

// updating query is going to be saperated on mutible strings (that will be concatnated). to make it easier tp read
		$query 	 =		 "UPDATE products SET ";

		$query  .= 		"product_title 			= '{$product_title}'		, ";
		$query  .= 		"product_category_id 	= '{$product_category_id}'	, ";
		$query 	.= 		"product_price 			= '{$product_price}'		, ";
		$query 	.= 		"product_quantity 		= '{$product_quantity}'		, ";
		$query 	.= 		"product_description 	= '{$product_description}'	, ";
		$query 	.= 		"short_desc 			= '{$short_desc}'			, ";
		$query 	.= 		"product_image 			= '{$product_image}'		  ";

		$query 	.= 		"WHERE product_id=" . escape_string($_GET['id']) . " ";
		
		$sent_update_quary = query($query);	
		confirm($sent_update_quary);

 
		set_message("Product has been updated");
		redirect("index.php?products");



	}
}








/**********************CATEGORY********************************/


function show_categories_in_admin(){
$query = query("SELECT * FROM categories");
confirm($query);

while ($row = fetch_array($query)){
// Herodoc will be used, to insert an html code without worring about double or single qoutations 
//assign a varible to a heroduc
//make sure you have no space after DELIMETER or it will give you an !!error!!
$category = <<<DELIMETER
<tr>
<td>{$row['cat_id']}</td>
<td> <a href="index.php?edit_category&id={$row['cat_id']}">{$row['cat_title']}</a></td><br>
<td><a class="btn btn-danger" href="../../resources/templates/back/delete_category.php?id={$row['cat_id']}"><span class="glyphicon glyphicon-remove"> </span></a></td>
</tr>
DELIMETER;

	echo $category;
}
}



function add_category(){

if (isset($_POST['add'])){

	$cat_title = escape_string($_POST['cat_title']);
	if (empty($cat_title) || $cat_title == " "){
		echo " <h1> TITLE CANNOT BE EMPTY</h1>";
	}else{

	$query = query("INSERT INTO categories(cat_title) VALUES('{$cat_title}')");
			
				
		confirm($query);

		set_message("New Category Created");
		redirect("index.php?categories");
}


}
}

function update_category(){

if(isset($_POST['update'])){
		$cat_title 	= escape_string($_POST['cat_title']);

		$query 	 =		"UPDATE categories SET cat_title = '{$cat_title}' ";
		$query 	.= 		"WHERE cat_id=" . escape_string($_GET['id']) . " ";
		
		$sent_update_quary = query($query);	
		confirm($sent_update_quary);

 
		set_message("Category has been updated");
		redirect("index.php?categories");


}}





/**********************USER*********************************/



function display_users(){

$query = query("SELECT * FROM users");
confirm($query);

while ($row = fetch_array($query)){

$user_id 	= $row['user_id'];
$username 	= $row['username'];
$email		= $row['email'];
$password 	= $row['password'];

$user = <<<DELIMETER
<tr>
<td>{$user_id}</td>
<td>{$username}</td>
<td>{$email}</td>

<td><a class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id={$row['user_id']}"><span class="glyphicon glyphicon-remove"> </span></a></td>
</tr>
DELIMETER;

	echo $user;
}
}

function add_user(){
	if(isset($_POST['add'])){


		$username	= escape_string($_POST['username']);
		$email 		= escape_string($_POST['email']);
		$password 	= escape_string($_POST['password']);

		$user_photo = escape_string($_FILES['file']['name']);// file is the name of the input tag and name is the name
		$photo_temp = escape_string($_FILES['file']['tmp_name']);//tmp_name is the temprory location where the file will be stored before being send to the db

		//$_FILES is a super global variable which can be used to upload files.


		move_uploaded_file($photo_temp, UPLOAD_DIRECTORY . DS . $user_photo );

//move_uploaded_file ( string $filename , string $destination ) : bool
//This function checks to ensure that the file designated by filename is a valid upload file (meaning that it was uploaded via PHP's (((((HTTP POST))))) upload mechanism). If the file is valid, it will be moved to the filename given by destination.

		$query = query("INSERT INTO users(username, email , password, user_photo) VALUES('{$username}','{$email}', '{$password}', '{$user_photo}')");				
		confirm($query);
		set_message("New User  Created");
		redirect("index.php?users");




}}



/**********************REPORTS********************************/


function get_reports(){
$query = query("SELECT * FROM reports");
confirm($query);

while ($row = fetch_array($query)){

$report = <<<DELIMETER
<tr>
<td>{$row['report_id']}</td>
<td>{$row['product_id']}<br>
<td>{$row['order_id']}<br>
<td>{$row['product_price']}<br>
<td>{$row['product_title']}<br>
<td>{$row['product_quantity']}<br>
<td><a class="btn btn-danger" href="../../resources/templates/back/delete_report.php?id={$row['report_id']}" ><span class="glyphicon glyphicon-remove"> </span></a></td>
</tr>
DELIMETER;

	echo $report;
}
}
?>