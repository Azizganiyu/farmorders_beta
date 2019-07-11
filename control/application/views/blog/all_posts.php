<h4> All Posts </h4>
<h6>Displaying all published posts</h6><br/>
<p><a href="<?php echo base_url.'index.php/blog/new_post/';?>"><input type="button" class="btn btn-primary btn-sm" value="Add New" /></a></p>
<?php
        $attributes = array('class' => 'user_search_form');
        echo form_open('blog/view_all_posts/', $attributes);
        ?>
            <input class="search_box" type="text" value="<?php echo $search_key ?>" name="search_key" placeholder="Search">
            <button class="search_btn" type="submit">Search</button>
        </form>
<div class="row">
    <div class="col-12">
        <?php
        echo form_open('blog/delete_posts/');
        ?>
        <input type="submit" id="delete_checked" class="btn btn-sm btn-secondary" value="Delete">
        
        <table class="table users_table table-responsive table-hover table-striped">
        
            <thead class="">
            <tr>
                <th><input class="check_all checkboxes" type="checkbox"></th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Date</th>
                <th></th>
                <th></th>

            </tr>
            </thead>
            <tbody>
            
                <?php
                if($posts != false)
                {
                    foreach($posts as $row)
                    {
                        echo '<tr>';
                        echo '<td><input class="checkboxes" name="item_delete[]" value="'.$row['id'].'" type="checkbox"></td>';
                        echo '<td><a href="'.base_url.'index.php/blog/edit_post/'.$row['id'].'">'.$row['post_title'].'</a></td>';
                        echo '<td>'.$row['post_author'].'</td>';
                        echo '<td>'.$row['post_category'].'</td>';
                        echo '<td>'.$row['post_date'].'</td>';
                        echo '<td><a href="'.base_url.'index.php/blog/edit_post/'.$row['id'].'"><input type="button" class="btn btn-sm btn-link" value="View/Edit"></a></td>';
                        echo '<td><input url="'.base_url.'index.php/blog/delete_posts/'.$row['id'].'" id="delete" type="button" class=" delete_btn btn btn-sm btn-link text-danger" value="Delete"></td>';
                        echo '</tr>';
                    }
                }
                else
                {
                    echo '<tr>';
                    echo '<td colspan="100"> No Posts found! </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
            <tfoot class="">
                <tr>
                    <th><input class="check_all checkboxes" type="checkbox"></th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
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

