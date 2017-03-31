//--------------------------------
/**
 * www.zhanqi.net
 */
//-------------------------

jQuery(function($){
    
    //$('.post:gt(0)').find('.thumbnail img, .post-content img').each(function(){
    var wh = $(window).height();
    $('.post img').each(function() {
        if($(this).offset().top < wh){
            $(this).attr('src', $(this).data('original'));
        }else{
            $(this).attr('src', 'http://1.zhanqi.sinaapp.com/images/loading.gif').lazyload({
                effect:'fadeIn'
            });
        }
    });
    
    $('.more-link').each(function(){
        $(this).attr('href', this.href.replace(/#.*/,''));
    });
    
    $('.thumbnail a').fancybox();
    
    $('#s').focus();
    
    $(window).scroll(function(){
        if ($(window).scrollTop() > 100){
            $(".gotop").fadeIn(600);
        } else {
            $(".gotop").fadeOut(600);
        }
    });
    
    $('.gotop').click(function(){
        $('html, body').animate({
            scrollTop:0
        },500);
    });
    
    $('.fn a').attr('target', '_blank');
    
    // comment form
    $('#commentform #author, #commentform #email, #commentform #url,#commentform #comment').each(function(){
        // init
        if (!$(this).val()) {
            $(this).prevAll('label').show();
        } else {
            $(this).prevAll('label').hide();
        }
        
        // event
        $(this).focus(function(){
            $(this).prevAll('label').hide();
        }).blur(function(){
            if (!$(this).val()) {
                $(this).prevAll('label').show();
            }
        });
    });
    //prettyPrint();
});