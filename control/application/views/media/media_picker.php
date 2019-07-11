<p><a href="<?php echo base_url.'index.php/Media/add_new'?>" target="_blank"><button class="add_new_btn btn  btn-sm">Add New </button></a></p>
<?php
$attributes = array('class' => 'user_search_form media_pick_search_form');
echo form_open('media/media_picker/'.$category, $attributes);
?>
    <input class="search_box" type="text" value="<?php echo $search_key ?>" name="search_key" placeholder="Search">
    <button class="search_btn media_pick_search_btn" type="submit">Search</button>
</form>

<div class='row' id="image_container">
    <?php 
    if (count($files) == 0) 
    {
        echo "No files found";
    }
    else
    {
        foreach($files as $file_item)
        {
    ?>

    <div class="col-6 col-sm-4 col-md-3 col-lg-2 image_parent">
        <div class=" col-8 media_name"><?php echo substr($file_item['name'], 0, 5).'....'; ?></div>
        <img class=" media_item img-thumbnail" id='<?php echo  $file_item['id']; ?>' name="<?php echo $file_item['name']; ?>" size="<?php echo $file_item['size']; ?>" type="<?php echo $file_item['type']; ?>" width="<?php echo $file_item['width']; ?>" height="<?php echo $file_item['height']; ?>" extention="<?php echo $file_item['extention']; ?>" dateUploaded="<?php echo $file_item['date_uploaded']; ?>" path="<?php echo $file_item['path']; ?>" src='<?php echo $file_item['thumb_path']; ?>' alt='<?php echo $file_item['name']; ?>' />
    </div>

    <?php
        }
    }
    ?>
    <p><?php echo $links; ?></p>
</div>