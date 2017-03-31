//--------------------------------
/**
 * www.zhanqi.net
 */
// -------------------------
jQuery(function($) {
    
    // var loading = 'http://1.zhanqi.sinaapp.com/images/loading.gif';
    var loading = 'http://zhanqi.net/web/images/loading.gif';
    // if($.browser.msie && parseInt($.browser.version) < 9) {
    // browse
   /* if ($.browser.chrome) {
        var wh = $(window).height();
        $('img').each(function() {
            if ($(this).offset().top < wh) {
                $(this).attr('src', $(this).data('original'));
            } else {
                $(this).attr('src', loading).lazyload({
                    effect : 'fadeIn'
                });
            }
        });
    } else {*/
        $('img').attr('src', loading).lazyload({
            effect : 'fadeIn'
        });
 //   }

   // $('.thumbnail a').fancybox();

    $('#slug').focus();

    $('#footer').css('user-select', 'none');

    /**
     * captcha
     */
    $('.captcha-img').click(function() {
        this.src = 'captcha?t=' + new Date().getTime();
        $('#captcha').val('');
        $('#captcha').focus();
    });

    /**
     * 发表评论
     */
    $('#comment-submit').click(function() {
        if (!($('#author').val().trim())) {
            $('#author').focus();
            return false;
        }
        if (!($('#email').val().trim())) {
            $('#email').focus();
            return false;
        }
        if (!($('#captcha').val().trim())) {
            $('#captcha').focus();
            return false;
        }
        if (!($('#content').val().trim())) {
            $('#content').focus();
            return false;
        }

        $.post('comment/publish/', $('#comment-form').serialize(), function(json) {
            $('#comment-msg').text(json.msg).fadeIn();
            if (json.success === true) {
                $('#comment-form').submit();
                return true;
            } else {
                $('#comment-msg').text('评论发表失败').fadeIn();
                return false;
            }
        }, 'json');
        
        return false;
    });

    /**
     * 回到顶部
     */
    $(window).scroll(function() {
        if ($(window).scrollTop() > 100) {
            $('.gotop').fadeIn(600);
        } else {
            $('.gotop').fadeOut(600);
        }
    });

    /**
     * 回到顶部
     */
    $('.gotop').click(function() {
        $('html, body').animate({
            scrollTop : 0
        }, 500);
    });

    $('#comment-list').delegate('.pagination a', 'click', function() {
        var href = $(this).attr('href');
        var url = 'comment/';
        url += '?postId=' + $(this).parent().data('postId');
        url += '&pageNo=' + $(this).data('pageNo');
        $('#comment-list').load(url, function() {
            $('#comment-list img').attr('src', loading).lazyload({
                effect : 'fadeIn'
            });
            location.href = href;
        });
        return false;
    });

    $('#comments .reply a').click(function() {
        $('.cancel-reply').show();
        $('#parent-id').val($(this).parent().data('parent'));
        $(this).parent().parent().append($('#respond'));
    });

    $('.cancel-reply').click(function() {
        $('.cancel-reply').hide();
        $('#parent-id').val(0);
        $('#comments').append($('#respond'));
    });

    prettyPrint();

});