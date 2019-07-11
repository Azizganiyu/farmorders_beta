<h4> Add New Media </h4>
<h6>Add new media to library</h6><br/>

<div class="upload_box_new text-center col-10 offset-1">
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
    <div class='row' id="image_container">
        

    </div>
</div>


