<h1>test </h1>
<?php 

if (isset($_GET['id'])) {
$query = query("SELECT * FROM categories WHERE cat_id =" . escape_string($_GET['id']) . " ");
confirm($query);


while ($row = fetch_array($query)) {
    $cat_title        = escape_string($row['cat_title']);
   
}
 update_category(); 



}


 ?>
<div class="col-sm-12">

    <div class="row">
    <h1 class="page-header">
       Edit Category
       

    </h1>
    </div>
               
    <form action="" method="post" >

        <div class="col-lg-8">

            <div class="form-group">
                <label for="category-title">Category Title </label>
                <input type="text" name="cat_title" class="form-control" value=" <?php echo $cat_title; ?>">
                   
            </div>

            
        </div>

<!-- SIDEBAR-->


    <aside id="admin_sidebar" class="col-md-4">

         
         <div class="form-group">
            <input type="submit" name="update" class="btn btn-primary btn-lg" value="Update">
        </div> 
    </aside>
</form>
</div>


