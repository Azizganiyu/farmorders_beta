<?php
if (isset($post_error))
{
    echo $post_error;
}
else
{
?>
<h4> Edit Post </h4>
<h6>Make changes to current post</h6><br/>

<?php 
if(isset($info)){echo '<p>'.$info.'</p>';}
$attributes = array('class' => 'post_form');
echo form_open('blog/edit_post/'.$post['id'], $attributes);
?>
    <div class="col-12 col-md-10">
        <div class="form-group">
            <div class="text-danger"><?php echo form_error('post_title');?></div>
            <label for="post_title"> Title </label>
            <input type="text" name="post_title" class="form-control" value="<?php if(set_value('post_title')){echo set_value('post_title');}else{echo $post['post_title'];}?>" id="post_title" placeholder="Title"/>
        </div>
        <div class="form-group">
            <div class="text-danger"><?php echo form_error('post_content');?></div>
            <label for="post_content" style="display:block;"> Content </label>
            <div class="btn-group btn-group-sm add_post_media">
                <button type="button" mediaid="content_media" class="btn btn-primary media_select" selecttype="images"><i class="fas fa-image"></i> Image</button>
                <button type="button" mediaid="content_media" class="btn btn-success media_select" selecttype="audios"><i class="fas fa-music"></i> Audio</button>
                <button type="button" mediaid="content_media" class="btn btn-danger media_select" selecttype="videos"><i class="fas fa-film"></i> Video</button>
            </div> 
            <textarea name="post_content" class="form-control"  id="post_content">
                <?php 
                if(set_value('post_content')){
                    echo htmlspecialchars_decode(set_value('post_content'));
                }else{
                    echo htmlspecialchars_decode($post['post_body']);
                }?>
            </textarea>
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
                        <input type='checkbox' <?php
                        if(set_value('post_category[]'))
                        {
                         checked(set_value('post_category[]'),$list['cat_name']); 
                        }
                        else
                        {
                            $post_category = explode("|", $post['post_category']);
                            checked($post_category,$list['cat_name']); 
                        }
                         ?>
                          value="<?php echo $list['cat_name'];?>" name = 'post_category[]' class='post_category_check'><?php echo $list['cat_name']; ?><br/>
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
                <input type="text" class="tags form-control" name="tags" value="<?php if(set_value('tags')){echo set_value('tags');}else{echo $post['tags'];}?>"/>
                <em>Seperate tags with comma, all tags must be in lower case and no spaces. </em>
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="Attribute">
                <label> Post Attribute  </label><hr/><br>
                <span class="attribute_title">Visible </span> <input type="checkbox" <?php if($post['visibility'] == 1){echo 'checked';}?> id="visible" class="" value="yes" name="visible" /> <br/>
                <span class="attribute_title">Featured</span> <input type="checkbox" <?php if($post['featured'] == 1){echo 'checked';}?> id="visible" class="" value="yes" name="featured" /> <br/>
            </div>
        </div>
        <div class="form-group col-md-6">
            <div class="post_image">
                <label> Post Image  </label><hr/><br>
                <img src="<?php 
                if(set_value('post_image'))
                {
                    echo set_value('post_image');
                }
                else
                {
                    echo $post['post_image_url'];
                }
                ?>" width="300" class="post_image_preview" />
                <input type="button" id= "set_post_image" mediaid="post_image" class="btn btn-link btn-sm media_select" selecttype="images" value="Set post image"  />
                <input type="button" id= "remove_post_image" class="btn btn-link btn-sm" value="Remove post image" />
                <input type="hidden" class="post_image_url" name="post_image" value="<?php 
                if(set_value('post_image'))
                {
                    echo set_value('post_image');
                }
                else
                {
                    echo $post['post_image_url'];
                }
                ?>"/>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary btn-sm" value="Update" name="submit" />
        </div>
        </form>
    </div>
<?php
}
?>