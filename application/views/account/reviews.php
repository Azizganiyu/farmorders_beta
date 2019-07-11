<section class="account-banner">
    <div class="container">

    <div class="line"></div>
    <h2 class="title">Your Reviews</h2>
    

</section>

<section class="review">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table style="width:100%" class="table table-responsive w-100 d-block d-md-table">
                    <thead>
                        <tr>
                            <td>Product Name</td>
                            <td>Opinion</td>
                            <td>Comment</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if( $reviews == false)
                        {
                            echo "<tr>";
                            echo "<td colspan='4' style='text-align:center'>You made no reviews</td>";
                            echo "</tr>";
                        }
                        else
                        {
                            foreach($reviews as $review)
                            {
                                echo "<tr>";
                                echo "<td>".$review['product_name']."</td>";
                                echo "<td>".$review['rating']."</td>";
                                echo "<td>".$review['comment']."</td>";
                                echo "<td><a href='".base_url."/index.php/account/del_review/".$review['id']."'><button class='btn btn-sm btn-danger'><i class='fa fa-trash'> </i></button></a></td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>