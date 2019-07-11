    //jquery scripts for medias

    //function to execute when an image is clicked
    function image_events(){
        var id = $(this).attr('id');//get image id
        var directory = $(this).attr('name')+$(this).attr('extention'); //set a full image name
        $('.delete_media').attr({id:id, directory:directory}); //add attributes to delete btn

        var media_src = $(this).attr('path'); //get image full path
        $('.media_download').attr({id:id, media_src:media_src}) //add attributes to download btn
        
        //let overlay be the height of page document
        var document_height = $(document).height();
        $('.overlay').css({
            'visibility':'visible',
            'height':document_height
        });

        //show the view panel
        $('#view_panel').css({'visibility':'visible'});

        //get all the image detail from attributes and add to media_info
        name = '<p><span class="title">Name :</span><span class="detail">'+$('#'+id).attr('name')+'</span></p>';
        type = '<p><span class="title">Type :</span><span class="detail">'+$('#'+id).attr('type')+'</span></p>';
        size = '<p><span class="title">Size :</span><span class="detail">'+$('#'+id).attr('size')+'kb</span></p>';
        extention = '<p><span class="title">Extention :</span><span class="detail">'+$('#'+id).attr('extention')+'</span></p>';
        width = '<p><span class="title">Width :</span><span class="detail">'+$('#'+id).attr('width')+'px</span></p>';
        height = '<p><span class="title">Height :</span><span class="detail">'+$('#'+id).attr('height')+'px</span></p>';
        path = '<p><span class="title">Path :</span><span class="detail">'+$('#'+id).attr('path')+'</span></p>';
        date_uploaded = '<p><span class="title">Date Uploaded :</span><span class="detail">'+$('#'+id).attr('dateUploaded')+'</span></p>';
        $('.media_info').html(name+type+size+extention+width+height+path+date_uploaded);

        //add image to view panel
        $('.preview_container').append('<img src="'+$(this).attr('path')+'"  class="image_preview" />');

        //set height of view_panel using window height as base
        var windows_height = $(window).height();
        $('#view_panel').css('height',windows_height-50);

        //adjust view_panel when window is resized to fit to new window size
        $(window).resize(function(){
            var windows_height = $(window).height();
            $('#view_panel').css('height',windows_height-50);
        });

        //on image preview hide the body vertical scroll
        $('body').css('overflow','hidden');
    }

    //-----------------------------------------------------------------------------------------------------------

    //function to execute when an audio is clicked
    function audio_events(){
        var id = $(this).attr('id'); //get audio id
        var directory = $(this).attr('name')+$(this).attr('extention'); //set a full audio name
        $('.delete_media').attr({id:id, directory:directory});//add attributes to delete btn

        var media_src = $(this).attr('path');//get audio full path
        $('.media_download').attr({id:id, media_src:media_src});//add attributes to download btn

        //show the view panel
        $('#view_panel').css({'visibility':'visible'});

        //let overlay be the height of page document
        var document_height = $(document).height();
        $('.overlay').css({
            'visibility':'visible',
            'height':document_height
        });

        //get all the audio detail from attributes and add to media_info
        name = '<p><span class="title">Name :</span><span class="detail">'+$('#'+id).attr('name')+'</span></p>';
        type = '<p><span class="title">Type :</span><span class="detail">'+$('#'+id).attr('type')+'</span></p>';
        size = '<p><span class="title">Size :</span><span class="detail">'+$('#'+id).attr('size')+'kb</span></p>';
        extention = '<p><span class="title">Extention :</span><span class="detail">'+$('#'+id).attr('extention')+'</span></p>';
        path = '<p><span class="title">Path :</span><span class="detail">'+$('#'+id).attr('path')+'</span></p>';
        date_uploaded = '<p><span class="title">Date Uploaded :</span><span class="detail">'+$('#'+id).attr('dateUploaded')+'</span></p>';
        $('.media_info').html(name+type+size+extention+path+date_uploaded);

        //add audio to view panel
        $('.preview_container').append('<audio src="'+$(this).attr('path')+'" preload="auto" controls class="audio_preview" />');

        //set height of view_panel using window height as base
        var windows_height = $(window).height();
        $('#view_panel').css('height',windows_height-50);

        //adjust view_panel when window is resized to fit to new window size
        $(window).resize(function(){
            var windows_height = $(window).height();
            $('#view_panel').css('height',windows_height-50);
        });

        //on audio preview hide the body vertical scroll
        $('body').css('overflow','hidden');
    }

    //---------------------------------------------------------------------------------------------------------

    //function to execute when a video is clicked
    function video_events(){
        var id = $(this).attr('id');//get video id
        var directory = $(this).attr('name')+$(this).attr('extention');//set a full video name
        $('.delete_media').attr({id:id, directory:directory});//add attributes to delete btn

        var media_src = $(this).attr('path');//get video full path
        $('.media_download').attr({id:id, media_src:media_src})//add attributes to download btn

        $('#view_panel').css({'visibility':'visible'}); //show the view panel

        //let overlay be the height of page document
        var document_height = $(document).height();
        $('.overlay').css({
            'visibility':'visible',
            'height':document_height
        });

        //get all the video detail from attributes and add to media_info
        name = '<p><span class="title">Name :</span><span class="detail">'+$('#'+id).attr('name')+'</span></p>';
        type = '<p><span class="title">Type :</span><span class="detail">'+$('#'+id).attr('type')+'</span></p>';
        size = '<p><span class="title">Size :</span><span class="detail">'+$('#'+id).attr('size')+'kb</span></p>';
        extention = '<p><span class="title">Extention :</span><span class="detail">'+$('#'+id).attr('extention')+'</span></p>';
        path = '<p><span class="title">Path :</span><span class="detail">'+$('#'+id).attr('path')+'</span></p>';
        date_uploaded = '<p><span class="title">Date Uploaded :</span><span class="detail">'+$('#'+id).attr('dateUploaded')+'</span></p>';
        $('.media_info').html(name+type+size+extention+path+date_uploaded);

        //add video to view panel
        $('.preview_container').append('<video src="'+$(this).attr('path')+'" controls class="video_preview" />');

        //set height of view_panel using window height as base
        var windows_height = $(window).height();
        $('#view_panel').css('height',windows_height-50);

        //adjust view_panel when window is resized to fit to new window size
        $(window).resize(function(){
            var windows_height = $(window).height();
            $('#view_panel').css('height',windows_height-50);
        });

        //on video preview hide the body vertical scroll
        $('body').css('overflow','hidden');
    }

    //--------------------------------------------------------------------------------------------------

    //function to execute when a file is clicked
    function file_events(){
        var id = $(this).attr('id');//get file id
        var directory = $(this).attr('name')+$(this).attr('extention');//set a full file name
        $('.delete_media').attr({id:id, directory:directory});//add attributes to delete btn

        var media_src = $(this).attr('path');//get file full path
        $('.media_download').attr({id:id, media_src:media_src})//add attributes to download btn

        $('#view_panel').css({'visibility':'visible'});//show the view panel

        //let overlay be the height of page document
        var document_height = $(document).height();
        $('.overlay').css({
            'visibility':'visible',
            'height':document_height
        });

        //get all the file detail from attributes and add to media_info
        name = '<p><span class="title">Name :</span><span class="detail">'+$('#'+id).attr('name')+'</span></p>';
        type = '<p><span class="title">Type :</span><span class="detail">'+$('#'+id).attr('type')+'</span></p>';
        size = '<p><span class="title">Size :</span><span class="detail">'+$('#'+id).attr('size')+'kb</span></p>';
        extention = '<p><span class="title">Extention :</span><span class="detail">'+$('#'+id).attr('extention')+'</span></p>';
        path = '<p><span class="title">Path :</span><span class="detail">'+$('#'+id).attr('path')+'</span></p>';
        date_uploaded = '<p><span class="title">Date Uploaded :</span><span class="detail">'+$('#'+id).attr('dateUploaded')+'</span></p>';
        $('.media_info').html(name+type+size+extention+path+date_uploaded);

        //add file to view panel
        $('.preview_container').append('<img src="'+$(this).attr('src')+'"  class="file_preview" />');

        //let set height of view_panel using window height as base
        var windows_height = $(window).height();
        $('#view_panel').css('height',windows_height-50);

        //adjust view_panel when window is resized to fit to new window size
        $(window).resize(function(){
            var windows_height = $(window).height();
            $('#view_panel').css('height',windows_height-50);
        });

        //on file preview hide the body vertical scroll
        $('body').css('overflow','hidden');
    }

    //----------------------------------------------------------------------------------------------------------------

    //function to read selected image for upload
    function readURL(input){
		if(input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
                $('.temp_image').attr('src', e.target.result); //set temp src for image while uploading
                $('.temp_image').attr('alt', input.files[0].name); //set temp alt for image while uploading
			};
			reader.readAsDataURL(input.files[0]);
		}
    }

    //------------------------------------------------------------------------------------------------------------------

    // function to be executed when a view panel or media_select panel is closed
    function media_exit(){
        $('#view_panel').css('visibility','hidden'); //if view panel, hide
        $('.overlay').css('visibility','hidden'); // hide the overlay
        $('.image_preview').remove(); //if previewing image, remove
        $('.audio_preview').remove(); //if previewing audio, remove
        $('.video_preview').remove(); //if previewing video, remove
        $('.file_preview').remove(); //if previewing file, remove
        $('#media_select').hide(); //if media select, hide
        $('body').css('overflow','scroll');//show body scroll again
    }

    //------------------------------------------------------------------------------------------------------------------

    //initiaized media functions
    function init(){

        //prepend new Dom's image container to show upload progress and upload new media via ajax when a media is selected
        $('#userfile').change(function(){
            $('#image_container').prepend(
                '<div class="col-6 col-sm-4 col-md-3 col-lg-2 image_parent "><div id="upload_cover"></div><div class="progress"><div class="progress-bar"></div></div><img class=" image temp_image" src="" alt="" /></div>'
            );

            //read selected image to show temp image from browser
            readURL(this);

            //start uploading via ajax
            $('#upload_form').ajaxSubmit(
                { 
                    target:   '#targetLayer', //where to show upload info from uploading php script

                    //set initial progress bar width to 0
                    beforeSubmit: function()
                    {
                      $("#progress-bar").width('0%');
                    },

                    //show uploading progress by increasing progressbar width by percentComplete
                    uploadProgress: function (event, position, total, percentComplete)
                    {	
                        $("#upload_cover").css({
                            'width':'85%',
                            'height':'150px',
                            'background-color':'black',
                            'position':'absolute',
                            'opacity' : '0.7'
    
    
                        })
                        $(".progress-bar").width(percentComplete + '%');
                        $(".progress-bar").html(percentComplete +'%');
                    },

                    //after successful upload refresh image_container to display new uploaded file
                    success:function ()
                    {
                        $('.progress').hide();
                        $('#upload_cover').hide();
                        $('.temp_image').removeClass('temp_image');
                        if($('body').hasClass('all_media') == true){
                            $('#image_container').load(location.href+" #image_container>*","");
                        }
                    },
                    resetForm: true 
                }
            );
    
        });

        //reload media page via ajax to show requested category
        $(document).on('change', '#category', function(){
            category = $(this).val();
            if(category == 'All Media'){category = "all_media";}
            $('#media_module').load("/farmorders_beta/control/index.php/media/display/"+category+" #media_module>*","");
        })

        //show upload box when the 'add new' button is clicked
        $(document).on('click', '.add_new_btn', function(){
            status = $('.upload_box').css('display');
            if(status === 'none'){
                $('.upload_box').slideDown(700);
            }else{
                $('.upload_box').slideUp(700);
            }
        });

        //preview media based on the type of media selected
        $(document).on('click','.image[type="images"]', image_events);
        $(document).on('click','.image[type="audios"]', audio_events);
        $(document).on('click','.image[type="videos"]', video_events);
        $(document).on('click','.image[type="files"]', file_events);

        //close media preview when the overlay is clicked
        $(document).on('click', '.overlay,.btn_close_prev', function(){
            media_exit();
        });

        //delete media when the delete button is clicked
        $(document).on('click','.delete_media', function(){
            var id = $(this).attr('id'); //get the media id
            var directory = $(this).attr('directory'); //get the media full name

            //confirm delete first
            if(confirm('Are you sure you want to delete this image'))
            {
                $.post('/farmorders_beta/control/index.php/Media/delete_media',{ id: id, directory:directory }); //post media detail to php method to delete media
                $('#'+id).parents('.image_parent').remove(); //remove media from Dom
                media_exit(); //exit preview
            }
        });

        //download media when the download button is clicked
        $(document).on('click','.media_download', function(){
            var directory = $(this).attr('media_src'); //get media path
            window.location.href = directory; //go to media to perform downlad or read
        })
        
    }

    //on document load execute the init function
    $(function(){
        init();
    });

    //-------------------------------------------------------------------------------------------------------------

    //MEDIA SELECT SECTION

    //display new panel containing media when the 'media_select' button is clicked
    $(document).on('click','.media_select', function(){
        var document_height = $(document).height();
        $('.overlay').css({
            'visibility':'visible',
            'height':document_height
        });
        $('#media_select').show();
        $('.media_tab_content').css('display','none');
        var type = $(this).attr('selecttype');
        var id = $(this).attr('mediaid');
        $('#media_pick').show();
        $('#media_pick').load('/farmorders_beta/control/index.php/media/media_picker/'+type, "");
        $('body').css('overflow','hidden');
        $('.media_select_ok').attr('media_type',type); //return media type as type attribute to 'ok' button
        $('.media_select_ok').attr('media_id',id); //return media id as id attribute to 'ok' button

    })

    //navigate media_select tabs for url or media pick
    $(document).on('click', '.media_tabs .nav-link', function(){
        $('.media_tabs .nav-link').removeClass('active');
        $('.media_tab_content').css('display','none');
        $(this).addClass('active');
        $('.media_item').removeClass('media_selected');
        $('.media_url_input').val('');
        $('.media_select_ok').attr('disabled','');
        tab_content = $(this).attr('tabid');
        $('#'+tab_content).show();
    })

    //events to trigger when a media item is clicked
    $(document).on('click', '.media_item', function(){
        if($(this).hasClass('media_selected')){ //check if the item has already been selected
            $(this).removeClass('media_selected'); //remove the class to dissable selection
            $('.media_select_ok').attr('disabled',''); //disable the 'ok' button
            $('.media_select_ok').attr('media_src',''); //remove selected media src from 'ok' button
        }else{ 
            //if media has not been selected before
            $('.media_item').removeClass('media_selected'); //remove previously selected media if any
            $(this).addClass('media_selected'); //select the clicked media
            $('.media_select_ok').removeAttr('disabled'); //enable the 'ok' button
            media_src = $(this).attr('path') //get the selected media path
            $('.media_select_ok').attr('media_src',media_src); //return media path as src attribute to 'ok' button
        }
    })

    //Enable the 'ok' button when user type in url instead of media pick
    $(document).on('focus keyup','.media_url_input', function(){
        $('.media_select_ok').removeAttr('disabled');
        media_src = $(this).val() //get the typed media path
        $('.media_select_ok').attr('media_src',media_src); //return media path as src attribute to 'ok' button
    })

    //resize media pick section height to fit window, using window height as base
    window_height = $(window).height();
    if($(window).width() > "576")
    {
        $('#media_url, #media_pick').height(window_height-300);
    }else{
        $('#media_url, #media_pick').height(window_height-240);
    }

    //on window resize, resize media pick section height to fit window
    $(window).resize(function(){
        window_height = $(window).height();
        if($(window).width() > "576")
        {
            $('#media_url, #media_pick').height(window_height-300);
        }else{
            $('#media_url, #media_pick').height(window_height-240);
        }
    })

    //transverse page with ajax to avoid reloading page
    $(document).on('click','.media_pick_pagination a',function(e){
        e.preventDefault();
        href = $(this).attr('href');
        $('#media_pick').load(href, "");
        //alert(href);
    })

    //submit search query with ajax
    $(document).on('click','.media_pick_search_btn',function(e){
        e.preventDefault();
        $('.media_pick_search_form').ajaxSubmit(
            { 
                target:   '#media_pick', 
                resetForm: true 
            }
        );
    })

    //close media_select when 'add new' btn is clicked
    $(document).on('click','.add_new_btn', function(){media_exit()})

    //----------------------------------------------------------------------------------------------------------------
