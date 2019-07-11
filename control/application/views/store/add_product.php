<h4> Add New Product </h4>
<h6>Create a new product </h6><br/>

<?php 
if(isset($info)){echo '<p>'.$info.'</p>';}
$attributes = array('class' => 'product_form');
echo form_open('store/add_product', $attributes);
?>
    <div class="row">
        <div class="col-12 col-md-10">
            <div class="form-group">
                <div class="text-danger"><?php echo form_error('product_name');?></div>
                <label for="product_name"> Title </label>
                <input type="text" name="product_name" class="form-control" value="<?php echo set_value('product_name');?>" id="product_name" placeholder="Product Name"/>
            </div>
            <div class="form-group">
                <div class="text-danger"><?php echo form_error('product_desc');?></div>
                <label for="product_desc" style="display:block;"> Description </label>
                <textarea name="product_desc" class="form-control"  id="product_desc"><?php echo htmlspecialchars_decode(set_value('product_desc'));?></textarea>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="form-group">
                <div class="product_category_list">
                    <h5> Category </h5><hr><br>
                    <?php

                    function checked($array, $cat)
                    {
                        if(in_array($cat, $array))
                        {
                            echo 'checked';
                        }
                    }
                    if($categories != false)
                    {
                        foreach($categories as $list)
                        {
                        ?>
                            <input type='checkbox' <?php @ checked(set_value('product_category[]'),$list['cat_name']); ?> value="<?php echo $list['cat_name'];?>" name = 'product_category[]' class='product_category_check'><?php echo $list['cat_name']; ?><br/>
                        <?php
                        }
                    }
                    else
                    {
                        echo 'No category found!';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="form-group">
                <div class="tags">
                    <h5> Tags  </h5><hr/><br>
                    <input type="text" class="tags form-control" max="2" name="tags" value="<?php echo set_value('tags');?>"/>
                    <em>Seperate tags with comma, all tags must be in lower case and no spaces. </em>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="form-group">
                <div class="product_data">
                    <h5> Product Datas</h5><hr/><br>
                    <div class="text-danger"><?php echo form_error('owner');?></div>
                    <label>Owner/Company</label>
                    <input type="text" class="form-control" name="owner" value="<?php echo set_value('owner');?>" placeholder="Name" />
                    <div class="text-danger"><?php echo form_error('price');?></div>
                    <label>Price (&#8358;)</label>
                    <input type="text" class="form-control" value="<?php echo set_value('price');?>" name="price" placeholder="0"/>
                    <label>Stock status</label>
                    <select class="form-control" name="stock_status" >
                        <option <?php if(set_value('stock_status') == '1' ) {echo "selected";}?> value="1">In stock </option>
                        <option <?php if(set_value('stock_status') == '0' ) {echo "selected";}?> value="0">Out of stock </option>
                    </select>
                    <div class="text-danger"><?php echo form_error('weight');?></div>
                    <label>Weight (kg)</label>
                    <input type="text" value="<?php echo set_value('weight');?>" class="form-control" name="weight" placeholder="0" />
                    <div class="text-danger"><?php echo form_error('dimension');?></div>
                    <label>Dimension (m)</label>
                    <input type="text" value="<?php echo set_value('dimension');?>" class="form-control" name="dimension" placeholder="0" /> 
                    <label>Deliverable?</label>
                    <select class="form-control" name="delivery" >
                        <option <?php if(set_value('delivery') == '1' ) {echo "selected";}?> value="1">Yes</option>
                        <option <?php if(set_value('delivery') == '0' ) {echo "selected";}?> value="0">No</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="form-group">
                <div class="attribute">
                    <h5> Product Attribute  </h5><hr/><br>
                    <span class="attribute_title">Visible </span> <input type="checkbox" <?php
                    if(isset($_POST['submit']))
                    {
                        if(set_value('visible') != null)
                        {
                            echo 'checked';
                        }  
                    }
                    else
                    {
                        echo 'checked';
                    }
                    ?> id="visible" class="" value="yes" name="visible" /> <br/>
                    <span class="attribute_title">Featured</span> <input type="checkbox" <?php if(set_value('featured') != null){echo 'checked';}?> id="visible" class="" value="yes" name="featured" /> <br/>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="form-group">
                <div class="product_image">
                    <h5> Product Featured Image  </h5><hr/><br>
                    <img src="<?php echo set_value('product_image');?>" width="200" class="product_image_preview" />
                    <input type="button" id= "set_featured_image" mediaid="product_image" class="btn btn-link btn-sm media_select" selecttype="images" value="Set featured image"  />
                    <input type="button" id= "remove_featured_image" class="btn btn-link btn-sm" value="Remove featured image" />
                    <input type="hidden" class="product_image_url" name="product_image" value="<?php echo set_value('product_image');?>"/>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="form-group">
                <div class="product_gallery" id="product_gallery">
                    <h5> Product Gallery  </h5><hr/><br>
                    <p><input type="button" id= "product_gallery_add" mediaid="product_gallery_add" class="btn btn-link btn-sm media_select" selecttype="images" value="Add product gallery images +"  /></p>
                    <input type="hidden" class="product_gallery_url" name="product_gallery" value="<?php echo set_value('product_gallery');?>"/>
                    <?php 
                    if(set_value('product_gallery') != null)
                    {
                        $src = explode('|', set_value('product_gallery'));
                        foreach($src as $src)
                        {
                            if(!empty($src))
                            {
                                echo '<div class="product_gallery"><img src ="'.$src.'" width = "100" class="img-fluid" /><button src ="'.$src.'" class=" remove_image btn btn-sm btn-link">Remove - </button></div>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary btn-sm" value="Publish" name="submit" />
    </div>
        
</form>
</div>