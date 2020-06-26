

<?php add_user(); ?>
<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Add Uswe
   

</h1>
</div>
               

<!-- enctype="multipart/form-data" this attribute enables us to send multimedia files in the form -->
<form action="" method="post" enctype="multipart/form-data">


<div class="col-md-8">

<div class="form-group">
    <label for="user-name">Username </label>
        <input type="text" name="username" class="form-control">
       
    </div>


  <div class="form-group">
      <label for="user-name">Email </label>
          <input type="text" name="email" class="form-control">
         
      </div>

  <div class="form-group">
      <label for="user-name">Password </label>
          <input type="password" name="password" class="form-control">
         
      </div>

</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">




    <!-- Product Image -->
    <div class="form-group">
        <label for="product-title">User Image</label>
        <input type="file" name="file">
      
    </div>


     
     <div class="form-group">
<!--        <input type="submit" name="delete" class="btn btn-danger btn-lg" value="Delete"> -->
        <input type="submit" name="add" class="btn btn-primary btn-lg" value="Add">
    </div>

</aside><!--SIDEBAR-->


    
</form>


</div>

      