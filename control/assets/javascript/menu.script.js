//function to open and close the side bar
function open_menu()
{
    //get current menu width
    var menu_width = $('#side_nav').css('width');

    //if window width is greater than ''576px' (tabs and desktop)
    if($(window).width() > "576")
    {

        //if nav is hidden, display nav
        if(menu_width === '0px'){
            $('#side_nav ').css({
                'width':'200px'
            });

            //shift page to accomodate side nav
            $('.module').css({
                'margin-left':'200px'
            });
        }

        //if navbar is already shown
        else
        {
            //hide nav
            $('#side_nav').css({
                'width':'0'
            });

            //re-adjust page to fit windows
            $('.module').css({
                'margin-left':'0'  
            });
        }

    //if browser window is less than '576px'
    }
    else
    {
        ////if nav is hidden, display nav
        if(menu_width === '0px')
        {
            $('#side_nav ').css({
                'width':'200px'
            });
        }

        //if navbar is already shown, hide nav
        else
        {
            $('#side_nav').css({
                'width':'0'
            });
        }
    }
}

//-------------------------------------------------------------------------------------------------

//drop down manipulation
$('.side_drop').on('click', function(){
    var parent = $(this).parents('li')
    var status = parent.next('ul').css('display');
    if(status == "none"){
        $('.secondary_nav').css('display','none');
        $('.side_drop').removeClass('fa-caret-up').addClass('fa-caret-down');
        parent.next('ul').slideDown(500);
        $(this).removeClass('fa-caret-down').addClass('fa-caret-up');
    }else{
        parent.next('ul').slideUp(500);
        $(this).removeClass('fa-caret-up').addClass('fa-caret-down');
    }
});
$('.primary_nav').on('mouseover', function(){
   $(this).addClass('sub_menu_show');
});

//--------------------------------------------------------------------------------------------------

//fix active menu when logged in user is visiting a profile that is not his
$('.user_account .secondary_nav li:contains("All Users")').addClass('active');
$('.active').parents('ul').show();

//---------------------------------------------------------------------------------------------------

//change arrow up or down on click
$('.active').parents('ul').prev('li').css('color','#007bff').children('.fa-caret-down').removeClass('.fa-caret-down').addClass('fa-caret-up');

//---------------------------------------------------------------------------------------------------
