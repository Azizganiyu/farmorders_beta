//convert text area of post content to tinymce editor
tinymce.init({
    selector: 'textarea#post_content',
    plugins: ['advlist wordcount media autolink link lists print emoticons spellchecker fullscreen image table textcolor'],
    a_plugin_option: true,
    height: 400,
    relative_urls: false,
    toolbar: 'undo redo print | styleselect | bold italic | table link fullscreen | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor emoticons',
    branding: false,
    resize: false,
    menubar: false,
    a_configuration_option: 400
});


//show post featured image button depending on if image has already been set
if($('.post_image_preview').attr('src')){
    $('#remove_post_image').show();
}else{
    $('#set_post_image').show();
}


//script to run when the ok button is clicked after selecting an image is selected
//retrieve the media type selected
//retrieve the media source
//retrieve the media id to know purpose of media
$(document).on('click','.media_select_ok',function(){
    media_type = $(this).attr('media_type');
    media_src = $(this).attr('media_src');
    media_id = $(this).attr('media_id');

    //if media is to be used in post content
    if(media_id == 'content_media'){
        if(media_type == 'images'){
            file = '<img src ="'+media_src+'" width = "300" class="img-fluid" />';
        }else if(media_type == 'audios'){
            file = '<audio src ="'+media_src+'" width = "300" controls preload="auto" />';
        }else if(media_type == 'videos'){
            file = '<video src ="'+media_src+'" width = "300" controls preload="auto" />';
        }
        tinymce.activeEditor.execCommand('mceInsertContent', false, file);
    }
    
    //else if media is to be used as featured image of post
    else if(media_id == 'post_image'){
        $('.post_image_preview').attr('src',media_src);
        $('.post_image_url').val(media_src);
        $('#set_post_image').hide();
        $('#remove_post_image').show();
    }
    media_exit(); //close the image selector, a function declared in media.script.js
});


//script to run when trying to remove the post featured image
$('#remove_post_image').on('click', function(){
    $('.post_image_preview').removeAttr('src');
    $('.post_image_url').val('');
    $(this).hide();
    $('#set_post_image').show();
});
