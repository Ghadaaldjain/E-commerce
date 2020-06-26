
<h1 class="page-header">
  All Categories

</h1>

<h1 class= "text-center bg-success"> <?php display_message(); ?></h1>
<div class="col-md-4">
    
    <form action="" method="post">
    
        <div class="form-group">
            <label for="category-title">Title</label>
            <input type="text" class="form-control" name="cat_title">
        </div>

        <div class="form-group">          
            <input type="submit" name="add" class="btn btn-primary" value="Add Category">
            <?php add_category();   ?>
        </div>      


    </form>
</div>




<div class="col-md-8">

    <table class="table">
        <thead>

            <tr>
                <th>id</th>
                <th>Title</th>
            </tr>
        </thead>
        <?php show_categories_in_admin(); ?>


        <tbody>

        </tbody>

    </table>

</div>
