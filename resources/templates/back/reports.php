
<div class="row">

<h1 class="page-header">
All Reports

</h1>

<h1 class= "text-center bg-success"> <?php display_message(); ?></h1>

<table class="table table-hover">

    <thead>
        <tr>
        <th>Id</th>
        <th>Product Id</th>
        <th>Order Id</th>
        <th>Price</th>
        <th>Product title</th>
        <th>Product quantity</th>
        </tr>
    </thead>
    <tbody>
     <?php get_reports(); ?> 
    </tbody>
</table>


</div>


