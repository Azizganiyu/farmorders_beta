</div>
</div>
</body>

<!-- Media preview -->
<div class="overlay"></div>
<div id='view_panel' class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="media_buttons">
                <button class="btn_close_prev btn btn-link btn-lg"><i class="fa fa-window-close"></i></button>
                <button class="delete_media btn btn-link btn-lg"><i class="fa fa-trash"></i></button>
                <button class="media_download btn btn-link btn-lg"><i class="fa fa-download"></i></button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class=" preview_container">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="media_info"></div>
        </div>
    </div>
</div>

<!-- Media select -->
<div id="media_select" class="container-fluid">
<button class="btn_close_prev btn btn-link btn-lg"><i class="fa fa-window-close"></i></button>
    <h4>Select Media</h4>
    <ul class="nav nav-tabs media_tabs">
    <li class="nav-item">
        <a class="nav-link" tabid="media_url">Insert Url</a>
    </li>
    <li class="nav-item">
        <a class="nav-link  active" tabid="media_pick">Pick Media</a>
    </li>
    </ul> 
    <div id="media_url" class="media_tab_content col-12 col-md-6">
        <div class="form-group">
            <input type="text" name="url" class="form-control media_url_input"  id="url" placeholder="Enter url"/>
        </div>
    </div>
    <div id="media_pick" class="media_tab_content">
    <h5>Loading.......</h5>
    </div>
    <button disabled class="btn btn-sm btn-primary text-right media_select_ok">OK</button>
</div>

<!--Footer area-->
<footer id="footer">
    <script src="<?php echo base_url; ?>assets/javascript/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url; ?>assets/javascript/jquery.form.min.js"></script>
    <script src="<?php echo base_url; ?>assets/javascript/menu.script.js"></script>
    <script src="<?php echo base_url; ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url; ?>assets/javascript/user.script.js"></script>
    <script src="<?php echo base_url; ?>assets/javascript/media.script.js"></script>
    <script src="<?php echo base_url; ?>assets/tinymce/tinymce.min.js"></script>
    <script src="<?php echo base_url; ?>assets/javascript/blog.script.js"></script>
    <script src="<?php echo base_url; ?>assets/javascript/store.script.js"></script>
</footer>
