<h4> All Media </h4>
<h6>Displaying all uploaded  medias</h6><br/>

<p class="media_head">Media Library <button class="add_new_btn btn  btn-sm">Add New </button> </p>

<div class="upload_box text-center col-10 offset-1">
    <?php echo validation_errors(); ?>
    <?php echo form_open_multipart('media/do_upload', 'id="upload_form"');?>
        <p>Upload files</p>
        <div class="file-input-wrapper">
            <input name="userfile" id="userfile" type="file" class="file_input" />
            <input type="button" class="btn" value="Select Files">
        </div>
        <p style="font-size:14px">Maximum upload file = <?php echo ini_get('upload_max_filesize');?></p>
        <div id="targetLayer"></div><br/>
    </form>
</div>

<div id="media_module">
    <?php
    $attributes = array('class' => 'user_search_form');
    echo form_open('media/display/'.$category, $attributes);
    ?>
        <input class="search_box" type="text" value="<?php echo $search_key ?>" name="search_key" placeholder="Search">
        <button class="search_btn" type="submit">Search</button>
    </form>
    <?php
    if($category == "all_media"){$option = "All Media";}else{$option = $category;}
    function current_cat($list, $option){
        if($list == $option){
            echo "selected";
        }
    }
    ?>
    <select class="form-control col-12 col-sm-6 col-md-2 media_category" id="category">
        <option <?php current_cat('ALL Media', $option) ?>>All Media</option>
        <option <?php current_cat('Images', $option) ?>>Images</option>
        <option <?php current_cat('Audios', $option) ?>>Audios</option>
        <option <?php current_cat('Videos', $option) ?>>Videos</option>
        <option <?php current_cat('Files', $option) ?>>Files</option>
    </select>


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
            <img class="image img-thumbnail" id='<?php echo  $file_item['id']; ?>' name="<?php echo $file_item['name']; ?>" size="<?php echo $file_item['size']; ?>" type="<?php echo $file_item['type']; ?>" width="<?php echo $file_item['width']; ?>" height="<?php echo $file_item['height']; ?>" extention="<?php echo $file_item['extention']; ?>" dateUploaded="<?php echo $file_item['date_uploaded']; ?>" path="<?php echo $file_item['path']; ?>" src='<?php echo $file_item['thumb_path']; ?>' alt='<?php echo $file_item['name']; ?>' />
        </div>

        <?php
            }
        }
        ?>
        <p><?php echo $links; ?></p>
    </div>
</div>


