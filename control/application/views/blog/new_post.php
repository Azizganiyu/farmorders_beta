<h4> Post </h4>
<h6>Create a new post </h6><br/>

<?php 
if(isset($info)){echo '<p>'.$info.'</p>';}
$attributes = array('class' => 'post_form');
echo form_open('blog/new_post', $attributes);
?>
    <div class="col-12 col-md-10">
        <div class="form-group">
            <div class="text-danger"><?php echo form_error('post_title');?></div>
            <label for="post_title"> Title </label>
            <input type="text" name="post_title" class="form-control" value="<?php echo set_value('post_title');?>" id="post_title" placeholder="Title"/>
        </div>
        <div class="form-group">
            <div class="text-danger"><?php echo form_error('post_content');?></div>
            <label for="post_content" style="display:block;"> Content </label>
            <div class="btn-group btn-group-sm add_post_media">
                <button type="button" mediaid="content_media" class="btn btn-primary media_select" selecttype="images"><i class="fas fa-image"></i> Image</button>
                <button type="button" mediaid="content_media" class="btn btn-success media_select" selecttype="audios"><i class="fas fa-music"></i> Audio</button>
                <button type="button" mediaid="content_media" class="btn btn-danger media_select" selecttype="videos"><i class="fas fa-film"></i> Video</button>
            </div> 
            <textarea name="post_content" class="form-control"  id="post_content"><?php echo htmlspecialchars_decode(set_value('post_content'));?></textarea>
        </div>
        <div class="form-group col-md-6">
            <div class="post_category">
                <label for="post_category"> Category  </label><hr><br>
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
                        <input type='checkbox' <?php @ checked(set_value('post_category[]'),$list['cat_name']); ?> value="<?php echo $list['cat_name'];?>" name = 'post_category[]' class='post_category_check'><?php echo $list['cat_name']; ?><br/>
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
        <div class="form-group col-md-6">
            <div class="tags">
                <label> Tags  </label><hr/><br>
                <input type="text" class="tags form-control" max="2" name="tags" value="<?php echo set_value('tags');?>"/>
                <em>Seperate tags with comma, all tags must be in lower case and no spaces. </em>
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="Attribute">
                <label> Post Attribute  </label><hr/><br>
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
                    ?>  id="visible" class="" value="yes" name="visible" /> <br/>
                <span class="attribute_title">Featured</span> <input type="checkbox" <?php if(set_value('featured') != null){echo 'checked';}?> id="visible" class="" value="yes" name="featured" /> <br/>
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="post_image">
                <label> Post Image  </label><hr/><br>
                <img src="<?php echo set_value('post_image');?>" width="300" class="post_image_preview" />
                <input type="button" id= "set_post_image" mediaid="post_image" class="btn btn-link btn-sm media_select" selecttype="images" value="Set post image"  />
                <input type="button" id= "remove_post_image" class="btn btn-link btn-sm" value="Remove post image" />
                <input type="hidden" class="post_image_url" name="post_image" value="<?php echo set_value('post_image');?>"/>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary btn-sm" value="Publish" name="submit" />
        </div>
        </form>
    </div>