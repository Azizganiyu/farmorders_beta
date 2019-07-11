<?php
if (isset($category_error))
{
    echo $category_error;
}
else
{
?>
<h4> Edit Category </h4>
<h6>Make change to current category</h6><br/>

<?php 
if(isset($info)){echo '<p>'.$info.'</p>';}
$attributes = array('class' => 'blog_cat_form');
echo form_open('blog/edit_category/'.$category['id'], $attributes);
?>
    <div class="col-12 col-md-6">
        <div class="form-group">
            <div class="text-danger"><?php echo form_error('cat_name');?></div>
            <label for="cat_name"> Category Name </label>
            <input type="text" name="cat_name" class="form-control" value="<?php echo $category['cat_name'];?>" id="cat_name" placeholder="Category Name"/>
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
                        if($list['cat_name'] != $category['cat_name'])
                        {
                        ?>
                     
                            <option <?php if($list['cat_name'] == $cat_parent['cat_name']){ echo 'selected';}?> value='<?php echo $list['id'] ?>'> <?php echo $list['cat_name'] ?></option>

                    <?php 
                        }  
                    }
                }
                ?>
                
            </select>
        </div>
        <div class="form-group">
            <div class="text-danger"><?php echo form_error('cat_desc');?></div>
            <label for="cat_desc"> Category Description </label>
            <textarea name="cat_desc" class="form-control"  id="cat_desc"><?php echo $category['cat_desc']; ?></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary btn-sm" value="Update Category" name="submit" />
        </div>
        </form>
    </div>
<?php
}
?>