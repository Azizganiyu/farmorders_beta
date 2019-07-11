<h4> Categories </h4>
<h6>Add new category for blog posts </h6><br/>

<?php 
if(isset($info)){echo '<p>'.$info.'</p>';}
$attributes = array('class' => 'blog_cat_form');
echo form_open('blog/category', $attributes);
?>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <div class="text-danger"><?php echo form_error('cat_name');?></div>
            <label for="cat_name"> Category Name </label>
            <input type="text" name="cat_name" class="form-control" value="<?php echo set_value('cat_name');?>" id="cat_name" placeholder="Category Name"/>
        </div>
        <div class="form-group col-md-6">
            <label for="cat_parent"> Set Parent  </label>
            <select name="cat_parent" class="form-control" id="cat_parent">
                <option value="0">None</option>
                <?php
                if($categories != false)
                {
                    foreach($categories as $list)
                    {
                        echo "<option value='".$list['id']."'>".$list['cat_name']."</option>";
                    }
                }
                ?>
                
            </select>
        </div>
        <div class="form-group">
            <div class="text-danger"><?php echo form_error('cat_desc');?></div>
            <label for="cat_desc"> Category Description </label>
            <textarea name="cat_desc" class="form-control"  id="cat_desc"></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary btn-sm" value="Add Category" name="submit" />
        </div>
        </form>
    </div>

    <div class"col-12">
        <hr style="border-color:gray" />
        <br/>
        <h4>All Categories </h4><br/>
                <?php
                echo form_open('blog/delete_category/');
                ?>
                <input type="submit" id="delete_checked" class="btn btn-sm btn-secondary" value="Delete">
                
                <table class="table users_table table-responsive table-hover table-striped">
                
                    <thead class="">
                    <tr>
                        <th><input class="check_all checkboxes" type="checkbox"></th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Date Added</th>
                        <th></th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                    
                        <?php
                        if($categories != false)
                        {
                            foreach($categories as $row)
                            {
                                echo '<tr>';
                                echo '<td><input class="checkboxes" name="category_delete[]" value="'.$row['id'].'" type="checkbox"></td>';
                                echo '<td><a href="'.base_url.'index.php/blog/edit_category/'.$row['id'].'">'.$row['cat_name'].'</a></td>';
                                echo '<td>'.$row['cat_desc'].'</td>';
                                echo '<td>'.$row['date_added'].'</td>';
                                echo '<td><a href="'.base_url.'index.php/blog/edit_category/'.$row['id'].'"><input type="button" class="btn btn-sm btn-link" value="Edit"></a></td>';
                                echo '<td><input url="'.base_url.'index.php/blog/delete_category/'.$row['id'].'" id="delete" type="button" class=" delete_btn btn btn-sm btn-link text-danger" value="Delete"></td>';
                                echo '</tr>';
                            }
                        }
                        else
                        {
                            echo '<tr>';
                            echo '<td colspan="100"> No categories found! </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                    <tfoot class="">
                        <tr>
                            <th><input class="check_all checkboxes" type="checkbox"></th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Date added</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
                </form>
    </div>