//convert text area of product description to tinymce editor
tinymce.init({
    selector: 'textarea#product_desc',
    plugins: ['advlist wordcount media autolink link lists print emoticons spellchecker fullscreen image table textcolor'],
    a_plugin_option: true,
    height: 200,
    relative_urls: false,
    toolbar: 'bold italic | forecolor backcolor | link emoticons',
    branding: false,
    resize: false,
    menubar: false,
    a_configuration_option: 400
});


//show 'set featured image button if image has not been set
if($('.product_image_preview').attr('src')){
    $('#remove_featured_image').show();
}else{
    $('#set_featured_image').show();
}


//script to run when the ok button is clicked after selecting an image is selected
//retrieve the media source
//retrieve the media id to know purpose of media
$(document).on('click','.media_select_ok',function(){
    media_src = $(this).attr('media_src');
    media_id = $(this).attr('media_id');

    //if image is to be used for product gallery
    if(media_id == 'product_gallery_add'){
        $('#product_gallery').append('<div class="product_gallery"><img src ="'+media_src+'" width = "100" class="img-fluid" /><button src ="'+media_src+'" class=" remove_image btn btn-sm btn-link">Remove - </button></div>');
        url = $('.product_gallery_url').val();
        url += media_src+'|';
        $('.product_gallery_url').val(url);
    }

    //if image is to be used for product featured image
    else if(media_id == 'product_image'){
        $('.product_image_preview').attr('src',media_src);
        $('.product_image_url').val(media_src);
        $('#set_featured_image').hide();
        $('#remove_featured_image').show();
    }
    media_exit(); //close the image selector, a function declared in media.script.js
});


//script to run when trying to remove the product featured image
$('#remove_featured_image').on('click', function(){
    $('.product_image_preview').removeAttr('src');
    $('.product_image_url').val('');
    $(this).hide();
    $('#set_featured_image').show();
});


//script to run when trying to remove an image from the gallery
$(document).on('click', '.remove_image', function(){
    $(this).parent('div').remove();
    src = $(this).attr('src');
    src += '|';
    url = $('.product_gallery_url').val();
    new_url = url.replace(src,'');
    $('.product_gallery_url').val(new_url);
})
