<h4> All Products </h4>
<h6>Displaying all Products</h6><br/>
<p><a href="<?php echo base_url.'index.php/store/view_cartadd_product/';?>"><input type="button" class="btn btn-primary btn-sm" value="Add New" /></a></p>
<?php
        $attributes = array('class' => 'user_search_form');
        echo form_open('store/view_products/', $attributes);
        ?>
            <input class="search_box" type="text" value="<?php echo $search_key ?>" name="search_key" placeholder="Search">
            <button class="search_btn" type="submit">Search</button>
        </form>
<div class="row">
    <div class="col-12">
        <?php
        echo form_open('store/delete_products/');
        ?>
        <input type="submit" id="delete_checked" class="btn btn-sm btn-secondary" value="Delete">
        
        <table class="products_table table users_table table-responsive table-hover table-striped">
        
            <thead class="">
            <tr>
                <th><input class="check_all checkboxes" type="checkbox"></th>
                <th><i class="fa fa-image"></i></th>
                <th>Name</th>
                <th>Stock</th>
                <th>Price (&#8358;)</th>
                <th>Categories</th>
                <th>Tags</th>
                <th>Date</th>
                <th></th>
                <th></th>

            </tr>
            </thead>
            <tbody>
            
                <?php
                if($products != false)
                {
                    foreach($products as $row)
                    {
                        if($row['stock_status'] == 1)
                        {
                            $stock = 'In stock';
                        }
                        elseif($row['stock_status'] == 0)
                        {
                            $stock = 'Out of stock';
                        }
                        echo '<tr>';
                        echo '<td><input class="checkboxes" name="item_delete[]" value="'.$row['id'].'" type="checkbox"></td>';
                        echo '<td><img src="'.$row['product_image_url'].'" alt="No Image" </td>';
                        echo '<td><a href="'.base_url.'index.php/store/edit_product/'.$row['id'].'">'.$row['product_name'].'</a></td>';
                        echo '<td>'.$stock.'</td>';
                        echo '<td>'.$row['price'].'</td>';
                        echo '<td>'.$row['product_category'].'</td>';
                        echo '<td>'.$row['tags'].'</td>';
                        echo '<td>Published<br>'.$row['date_added'].'</td>';
                        echo '<td><a href="'.base_url.'index.php/store/edit_product/'.$row['id'].'"><input type="button" class="btn btn-sm btn-link" value="View/Edit"></a></td>';
                        echo '<td><input url="'.base_url.'index.php/store/delete_products/'.$row['id'].'" id="delete" type="button" class=" delete_btn btn btn-sm btn-link text-danger" value="Delete"></td>';
                        echo '</tr>';
                    }
                }
                else
                {
                    echo '<tr>';
                    echo '<td colspan="100"> No Products found! </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
            <tfoot class="">
                <tr>
                    <th><input class="check_all checkboxes" type="checkbox"></th>
                    <th><i class="fa fa-image"></i></th>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Categories</th>
                    <th>Tags</th>
                    <th>Date</th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        </form>
    </div>
</div>
<p><?php echo $links; ?></p>

