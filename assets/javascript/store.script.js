
//product cart on click script
$(".add-cart").on('click',function(){

    //check the status of the button 1=active 0=inactive
    if($(this).attr('status')==0){

        //if button is inactive change to active and add a class 'carted'
        $(this).attr('status',1);
        $(this).addClass('carted');

        //use the function 'getCookie()' from the main.script.js to check if user is currently logged in
        //if user is logged in alert success without login prompt
        //else alert success and prompt user to login to save change on database
        
        var curr_qty = $('.cart-btn .qty').html();
        curr_qty = parseInt(curr_qty) + 1;
        $('.cart-btn .qty').html(curr_qty);
        
        //notify adding to cart
        $('body').prepend('<div id="notify_carted" class="modal"><p>Your Item has been added to Cart! </p>'+
        '<p>click <a href="/farmorders_beta/index.php/store/view_cart" style="font-weight:bold; color:green;">here</a> to view cart</p></div>');
        $('#notify_carted').modal('show');
        
    }

    //else if button is active change to inactive and add remove the class 'carted'
    else{

        //if button is active change to inactive and remove the class 'carted'
        $(this).attr('status',0);
        $(this).removeClass('carted');

        //decrease the wishlist counter on the navigation menu
        curr_qty = $('.cart-btn .qty').html();
        if(curr_qty > 0){
            $('.cart-btn .qty').html(parseInt(curr_qty) - 1);
        }
        
        //notify removing from cart
        $('body').prepend('<div id="notify_uncarted" class="modal"><p>Your Item has been removed from the Cart! </p></div>');
        $('#notify_uncarted').modal('show');
    }

    //post the product id and status to a php script to add to session and database or remove from session and database based on the status
    $.post("/farmorders_beta/index.php/store/cart",
    {
        id: $(this).attr('id'),
        status: $(this).attr('status'),
        price: $(this).attr('price'),
        quantity: '1'
    });
});


//Increase quantity of product in cart
$('.qty-btn.plus').on('click', function(){
    curr_qty = $(this).next('.qty-input').val();
    $(this).next('.qty-input').val(parseInt(curr_qty) + 1);    
})

//Decrease quantity of product in cart
$('.qty-btn.minus').on('click', function(){
    curr_qty = $(this).prev('.qty-input').val();
    if(curr_qty != '1'){
        $(this).prev('.qty-input').val(parseInt(curr_qty) - 1);  
    }  
})

//remove item from cart list in the cart page
$('.remove_cart').on('click', function(){
    $.post("/farmorders_beta/index.php/store/cart",
    {
        id: $(this).attr('id'),
        status: $(this).attr('status')
    });
    $(this).parents('.item').remove();
    //decrease the cart counter on the navigation menu
    curr_qty = $('.cart-btn .qty').html();
        if(curr_qty > 0){
            $('.cart-btn .qty').html(parseInt(curr_qty) - 1);
        }

    //decrease the cart item counter on the cart page
    curr_qty = $('.cart-head .item-no').html();
    if(curr_qty != '0'){
        $('.cart-head .item-no').html(parseInt(curr_qty) - 1);
    }

    //decrease the cart item counter on the banner
    curr_qty = $('.cart-banner .item-no').html();
    if(curr_qty != '0'){
        $('.cart-banner .item-no').html(parseInt(curr_qty) - 1);
    }

    //decrease the price item on the summary
    price = $(this).attr('price');
    curr_price1 = $('.cart-summary .sub-total').html();
    curr_price2 = $('.cart-summary .total').html();
    if(curr_price1 != '0' && curr_price2 != '0'){
        $('.cart-summary .sub-total').html(parseInt(curr_price1) - parseInt(price));
        $('.cart-summary .total').html(parseInt(curr_price2) - parseInt(price));
    }
})

$('.wish.fa-trash').on('click', function(){
    $.post("/azizganiyu/index.php/store/wishlist",
    {
        id: $(this).attr('id'),
        status: $(this).attr('status')
    });
    $(this).parents('tr').remove();
    //decrease the wishlist counter on the navigation menu
    curr_qty = $('.link-wishlist .qty').html();
    $('.link-wishlist .qty').html(parseInt(curr_qty) - 1);
})

$(document).on('submit', '.review-form form', function(e){
    e.preventDefault();
    $(this).ajaxSubmit(
        { 
            target:   '.submit-loader', //where to show login info

            beforeSubmit: function()
            {
               $('.submit-loader').html('<div class="lds-dual-ring"></div>');
            },

            success:function ()
            {  
                if($('.submit-loader').html() == "Thanks for your review!"){
                    $('.submit-loader').css({'color':'rgb(12, 180, 12)', 'margin-top':'10px'});
                    window.location.reload();
                }else{
                    $('.submit-loader').css({'color':'rgb(206, 36, 36)', 'margin-top':'10px'});
                }
            }
        }
    );
});

$('.product-gallery .thumb img').on('click', function(){
    $('.thumb').removeClass('active');
    $(this).parents('.thumb').addClass('active');
    image_src = $(this).attr('src');
    $('.image-preview img').attr('src', image_src);
})

$('.review-form .fa-thumbs-up').on('click', function(){
    $('.review-form .fa-thumbs-down').removeClass('rating-down');
    $(this).addClass('rating-up');
    $('.rating-input').val('liked');
})
$('.review-form .fa-thumbs-down').on('click', function(){
    $('.review-form .fa-thumbs-up').removeClass('rating-up');
    $(this).addClass('rating-down');
    $('.rating-input').val('disliked');
})







//---------------------------------------------------------------------------------------------------

//a list of all country names with country code and phone code
var allCountries = [ [ "Afghanistan (‫افغانستان‬‎)", "af", "93" ], [ "Albania (Shqipëri)", "al", "355" ], [ "Algeria (‫الجزائر‬‎)", "dz", "213" ], [ "American Samoa", "as", "1684" ], [ "Andorra", "ad", "376" ], [ "Angola", "ao", "244" ], [ "Anguilla", "ai", "1264" ], [ "Antigua and Barbuda", "ag", "1268" ], [ "Argentina", "ar", "54" ], [ "Armenia (Հայաստան)", "am", "374" ], [ "Aruba", "aw", "297" ], [ "Australia", "au", "61", 0 ], [ "Austria (Österreich)", "at", "43" ], [ "Azerbaijan (Azərbaycan)", "az", "994" ], [ "Bahamas", "bs", "1242" ], [ "Bahrain (‫البحرين‬‎)", "bh", "973" ], [ "Bangladesh (বাংলাদেশ)", "bd", "880" ], [ "Barbados", "bb", "1246" ], [ "Belarus (Беларусь)", "by", "375" ], [ "Belgium (België)", "be", "32" ], [ "Belize", "bz", "501" ], [ "Benin (Bénin)", "bj", "229" ], [ "Bermuda", "bm", "1441" ], [ "Bhutan (འབྲུག)", "bt", "975" ], [ "Bolivia", "bo", "591" ], [ "Bosnia and Herzegovina (Босна и Херцеговина)", "ba", "387" ], [ "Botswana", "bw", "267" ], [ "Brazil (Brasil)", "br", "55" ], [ "British Indian Ocean Territory", "io", "246" ], [ "British Virgin Islands", "vg", "1284" ], [ "Brunei", "bn", "673" ], [ "Bulgaria (България)", "bg", "359" ], [ "Burkina Faso", "bf", "226" ], [ "Burundi (Uburundi)", "bi", "257" ], [ "Cambodia (កម្ពុជា)", "kh", "855" ], [ "Cameroon (Cameroun)", "cm", "237" ], [ "Canada", "ca", "1", 1, [ "204", "226", "236", "249", "250", "289", "306", "343", "365", "387", "403", "416", "418", "431", "437", "438", "450", "506", "514", "519", "548", "579", "581", "587", "604", "613", "639", "647", "672", "705", "709", "742", "778", "780", "782", "807", "819", "825", "867", "873", "902", "905" ] ], [ "Cape Verde (Kabu Verdi)", "cv", "238" ], [ "Caribbean Netherlands", "bq", "599", 1 ], [ "Cayman Islands", "ky", "1345" ], [ "Central African Republic (République centrafricaine)", "cf", "236" ], [ "Chad (Tchad)", "td", "235" ], [ "Chile", "cl", "56" ], [ "China (中国)", "cn", "86" ], [ "Christmas Island", "cx", "61", 2 ], [ "Cocos (Keeling) Islands", "cc", "61", 1 ], [ "Colombia", "co", "57" ], [ "Comoros (‫جزر القمر‬‎)", "km", "269" ], [ "Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)", "cd", "243" ], [ "Congo (Republic) (Congo-Brazzaville)", "cg", "242" ], [ "Cook Islands", "ck", "682" ], [ "Costa Rica", "cr", "506" ], [ "Côte d’Ivoire", "ci", "225" ], [ "Croatia (Hrvatska)", "hr", "385" ], [ "Cuba", "cu", "53" ], [ "Curaçao", "cw", "599", 0 ], [ "Cyprus (Κύπρος)", "cy", "357" ], [ "Czech Republic (Česká republika)", "cz", "420" ], [ "Denmark (Danmark)", "dk", "45" ], [ "Djibouti", "dj", "253" ], [ "Dominica", "dm", "1767" ], [ "Dominican Republic (República Dominicana)", "do", "1", 2, [ "809", "829", "849" ] ], [ "Ecuador", "ec", "593" ], [ "Egypt (‫مصر‬‎)", "eg", "20" ], [ "El Salvador", "sv", "503" ], [ "Equatorial Guinea (Guinea Ecuatorial)", "gq", "240" ], [ "Eritrea", "er", "291" ], [ "Estonia (Eesti)", "ee", "372" ], [ "Ethiopia", "et", "251" ], [ "Falkland Islands (Islas Malvinas)", "fk", "500" ], [ "Faroe Islands (Føroyar)", "fo", "298" ], [ "Fiji", "fj", "679" ], [ "Finland (Suomi)", "fi", "358", 0 ], [ "France", "fr", "33" ], [ "French Guiana (Guyane française)", "gf", "594" ], [ "French Polynesia (Polynésie française)", "pf", "689" ], [ "Gabon", "ga", "241" ], [ "Gambia", "gm", "220" ], [ "Georgia (საქართველო)", "ge", "995" ], [ "Germany (Deutschland)", "de", "49" ], [ "Ghana (Gaana)", "gh", "233" ], [ "Gibraltar", "gi", "350" ], [ "Greece (Ελλάδα)", "gr", "30" ], [ "land (Kalaallit Nunaat)", "gl", "299" ], [ "Grenada", "gd", "1473" ], [ "Guadeloupe", "gp", "590", 0 ], [ "Guam", "gu", "1671" ], [ "Guatemala", "gt", "502" ], [ "Guernsey", "gg", "44", 1 ], [ "Guinea (Guinée)", "gn", "224" ], [ "Guinea-Bissau (Guiné Bissau)", "gw", "245" ], [ "Guyana", "gy", "592" ], [ "Haiti", "ht", "509" ], [ "Honduras", "hn", "504" ], [ "Hong Kong (香港)", "hk", "852" ], [ "Hungary (Magyarország)", "hu", "36" ], [ "Iceland (Ísland)", "is", "354" ], [ "India (भारत)", "in", "91" ], [ "Indonesia", "id", "62" ], [ "Iran (‫ایران‬‎)", "ir", "98" ], [ "Iraq (‫العراق‬‎)", "iq", "964" ], [ "Ireland", "ie", "353" ], [ "Isle of Man", "im", "44", 2 ], [ "Israel (‫ישראל‬‎)", "il", "972" ], [ "Italy (Italia)", "it", "39", 0 ], [ "Jamaica", "jm", "1", 4, [ "876", "658" ] ], [ "Japan (日本)", "jp", "81" ], [ "Jersey", "je", "44", 3 ], [ "Jordan (‫الأردن‬‎)", "jo", "962" ], [ "Kazakhstan (Казахстан)", "kz", "7", 1 ], [ "Kenya", "ke", "254" ], [ "Kiribati", "ki", "686" ], [ "Kosovo", "xk", "383" ], [ "Kuwait (‫الكويت‬‎)", "kw", "965" ], [ "Kyrgyzstan (Кыргызстан)", "kg", "996" ], [ "Laos (ລາວ)", "la", "856" ], [ "Latvia (Latvija)", "lv", "371" ], [ "Lebanon (‫لبنان‬‎)", "lb", "961" ], [ "Lesotho", "ls", "266" ], [ "Liberia", "lr", "231" ], [ "Libya (‫ليبيا‬‎)", "ly", "218" ], [ "Liechtenstein", "li", "423" ], [ "Lithuania (Lietuva)", "lt", "370" ], [ "Luxembourg", "lu", "352" ], [ "Macau (澳門)", "mo", "853" ], [ "Macedonia (FYROM) (Македонија)", "mk", "389" ], [ "Madagascar (Madagasikara)", "mg", "261" ], [ "Malawi", "mw", "265" ], [ "Malaysia", "my", "60" ], [ "Maldives", "mv", "960" ], [ "Mali", "ml", "223" ], [ "Malta", "mt", "356" ], [ "Marshall Islands", "mh", "692" ], [ "Martinique", "mq", "596" ], [ "Mauritania (‫موريتانيا‬‎)", "mr", "222" ], [ "Mauritius (Moris)", "mu", "230" ], [ "Mayotte", "yt", "262", 1 ], [ "Mexico (México)", "mx", "52" ], [ "Micronesia", "fm", "691" ], [ "Moldova (Republica Moldova)", "md", "373" ], [ "Monaco", "mc", "377" ], [ "Mongolia (Монгол)", "mn", "976" ], [ "Montenegro (Crna Gora)", "me", "382" ], [ "Montserrat", "ms", "1664" ], [ "Morocco (‫المغرب‬‎)", "ma", "212", 0 ], [ "Mozambique (Moçambique)", "mz", "258" ], [ "Myanmar (Burma) (မြန်မာ)", "mm", "95" ], [ "Namibia (Namibië)", "na", "264" ], [ "Nauru", "nr", "674" ], [ "Nepal (नेपाल)", "np", "977" ], [ "Netherlands (Nederland)", "nl", "31" ], [ "New Caledonia (Nouvelle-Calédonie)", "nc", "687" ], [ "New Zealand", "nz", "64" ], [ "Nicaragua", "ni", "505" ], [ "Niger (Nijar)", "ne", "227" ], [ "Nigeria", "ng", "234" ], [ "Niue", "nu", "683" ], [ "Norfolk Island", "nf", "672" ], [ "North Korea (조선 민주주의 인민 공화국)", "kp", "850" ], [ "Northern Mariana Islands", "mp", "1670" ], [ "Norway (Norge)", "no", "47", 0 ], [ "Oman (‫عُمان‬‎)", "om", "968" ], [ "Pakistan (‫پاکستان‬‎)", "pk", "92" ], [ "Palau", "pw", "680" ], [ "Palestine (‫فلسطين‬‎)", "ps", "970" ], [ "Panama (Panamá)", "pa", "507" ], [ "Papua New Guinea", "pg", "675" ], [ "Paraguay", "py", "595" ], [ "Peru (Perú)", "pe", "51" ], [ "Philippines", "ph", "63" ], [ "Poland (Polska)", "pl", "48" ], [ "Portugal", "pt", "351" ], [ "Puerto Rico", "pr", "1", 3, [ "787", "939" ] ], [ "Qatar (‫قطر‬‎)", "qa", "974" ], [ "Réunion (La Réunion)", "re", "262", 0 ], [ "Romania (România)", "ro", "40" ], [ "Russia (Россия)", "ru", "7", 0 ], [ "Rwanda", "rw", "250" ], [ "Saint Barthélemy", "bl", "590", 1 ], [ "Saint Helena", "sh", "290" ], [ "Saint Kitts and Nevis", "kn", "1869" ], [ "Saint Lucia", "lc", "1758" ], [ "Saint Martin (Saint-Martin (partie française))", "mf", "590", 2 ], [ "Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)", "pm", "508" ], [ "Saint Vincent and the Grenadines", "vc", "1784" ], [ "Samoa", "ws", "685" ], [ "San Marino", "sm", "378" ], [ "São Tomé and Príncipe (São Tomé e Príncipe)", "st", "239" ], [ "Saudi Arabia (‫المملكة العربية السعودية‬‎)", "sa", "966" ], [ "Senegal (Sénégal)", "sn", "221" ], [ "Serbia (Србија)", "rs", "381" ], [ "Seychelles", "sc", "248" ], [ "Sierra Leone", "sl", "232" ], [ "Singapore", "sg", "65" ], [ "Sint Maarten", "sx", "1721" ], [ "Slovakia (Slovensko)", "sk", "421" ], [ "Slovenia (Slovenija)", "si", "386" ], [ "Solomon Islands", "sb", "677" ], [ "Somalia (Soomaaliya)", "so", "252" ], [ "South Africa", "za", "27" ], [ "South Korea (대한민국)", "kr", "82" ], [ "South Sudan (‫جنوب السودان‬‎)", "ss", "211" ], [ "Spain (España)", "es", "34" ], [ "Sri Lanka (ශ්‍රී ලංකාව)", "lk", "94" ], [ "Sudan (‫السودان‬‎)", "sd", "249" ], [ "Suriname", "sr", "597" ], [ "Svalbard and Jan Mayen", "sj", "47", 1 ], [ "Swaziland", "sz", "268" ], [ "Sweden (Sverige)", "se", "46" ], [ "Switzerland (Schweiz)", "ch", "41" ], [ "Syria (‫سوريا‬‎)", "sy", "963" ], [ "Taiwan (台灣)", "tw", "886" ], [ "Tajikistan", "tj", "992" ], [ "Tanzania", "tz", "255" ], [ "Thailand (ไทย)", "th", "66" ], [ "Timor-Leste", "tl", "670" ], [ "Togo", "tg", "228" ], [ "Tokelau", "tk", "690" ], [ "Tonga", "to", "676" ], [ "Trinidad and Tobago", "tt", "1868" ], [ "Tunisia (‫تونس‬‎)", "tn", "216" ], [ "Turkey (Türkiye)", "tr", "90" ], [ "Turkmenistan", "tm", "993" ], [ "Turks and Caicos Islands", "tc", "1649" ], [ "Tuvalu", "tv", "688" ], [ "U.S. Virgin Islands", "vi", "1340" ], [ "Uganda", "ug", "256" ], [ "Ukraine (Україна)", "ua", "380" ], [ "United Arab Emirates (‫الإمارات العربية المتحدة‬‎)", "ae", "971" ], [ "United Kingdom", "gb", "44", 0 ], [ "United States", "us", "1", 0 ], [ "Uruguay", "uy", "598" ], [ "Uzbekistan (Oʻzbekiston)", "uz", "998" ], [ "Vanuatu", "vu", "678" ], [ "Vatican City (Città del Vaticano)", "va", "39", 1 ], [ "Venezuela", "ve", "58" ], [ "Vietnam (Việt Nam)", "vn", "84" ], [ "Wallis and Futuna (Wallis-et-Futuna)", "wf", "681" ], [ "Western Sahara (‫الصحراء الغربية‬‎)", "eh", "212", 1 ], [ "Yemen (‫اليمن‬‎)", "ye", "967" ], [ "Zambia", "zm", "260" ], [ "Zimbabwe", "zw", "263" ], [ "Åland Islands", "ax", "358", 1 ] ];

//create an html select option of all country names
var list = ' ';
for (var i=0, len=allCountries.length; i<len; i++){
    list += '<option>'+allCountries[i][0]+'</option>';
}
$('#country').append(list);

/*function to get the index of a country on the list
 *returns the index
 */
function country_index(country){
    for (var i=0, len=allCountries.length; i<len; i++){ 
        if(allCountries[i][0] == country){
            return i;
        }
    }
}

//-------------------------------------------------------------------------------------------

//function to update hidden field country_code and field phone_code on country select
function country_update(){
    var country = $('#country').val();
    var index = country_index(country);
    var country_code = allCountries[index][1];
    country_code = country_code.toUpperCase();
    $('#country_code').val(country_code);
    var phone_code = allCountries[index][2];
    $('#phone_code').val('+'+phone_code);
}
country_update();

//when user change country, re-update fields
$('#country').on('change', function(){
    country_update();
});

//------------------------------------------------------------------------------------

