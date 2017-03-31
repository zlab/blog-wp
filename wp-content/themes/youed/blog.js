//--------------------------------
/**
 * www.zhanqi.net
 */
// -------------------------
jQuery(function($) {

    // 图片居中
    $('.content p img').each(function() {
        $(this).parents('p').css('text-align', 'center');
    });

    // lazyload
    var loading = 'http://zhanqi.net/web/images/loading.gif';
    $('img').attr('src', loading).lazyload({
        effect : 'fadeIn'
    });

    // fix chrome
    if ($.browser.chrome) {
        var wh = $(window).height();
        $('img').each(function() {
            if ($(this).offset().top < wh) {
                $(this).trigger('appear');
            }
        });
    }

    $('#slug').focus();

    $('.footer, label').css('user-select', 'none');

    /**
     * 验证码
     */
    $('.captcha img').click(function() {
        this.src = 'captcha?t=' + new Date().getTime();
        $('#captcha').val('');
        $('#captcha').focus();
    });

    /**
     * 发表评论
     */
    $('#respond .submit').click(function() {
        if (!($('#author').val().trim())) {
            $('#author').focus();
            $('form .msg').text('名字不能为空').fadeIn();
            return false;
        }
        if (!($('#email').val().trim())) {
            $('#email').focus();
            $('form .msg').text('邮箱不能为空').fadeIn();
            return false;
        }
        if (!($('#captcha').val().trim())) {
            $('#captcha').focus();
            $('form .msg').text('验证码不能为空').fadeIn();
            return false;
        }
        if (!($('#content').val().trim())) {
            $('#content').focus();
            $('form .msg').text('评论内容不能为空').fadeIn();
            return false;
        }

        $(this).attr('disabled', 'disabled');
        $.post('comment/publish/', $('#respond form').serialize(), function(json) {
            $('form .msg').text(json.msg).fadeIn();
            $('#respond .submit').removeAttr('disabled');
            if (json.success === true) {
                location.reload($('#location').val());
                return true;
            } else {
                // $('form .msg').text(json.msg).fadeIn();
                return false;
            }
        }, 'json');

        return false;
    });

    // 回复
    $('.reply').click(function() {
        $(this).next().show();
        $('#parent-id').val($(this).data('parent'));
        $(this).parent().parent().append($('#respond'));
    });

    // 取消回复
    $('.cancel-reply').click(function() {
        $(this).hide();
        $('#parent-id').val(0);
        $('#comments').append($('#respond'));
    });

});

/**
 * SyntaxHighlighter
 */
jQuery(function($) {
    $.extend(SyntaxHighlighter.config.strings, {
        expandSource : '展开代码',
        viewSource : '查看代码',
        copyToClipboard : '复制代码',
        copyToClipboardConfirmation : '代码已复制到剪切板',
        print : '打印',
        help : '关于',
        alert : ''
    });

    SyntaxHighlighter.highlight({
        // 'pad-line-numbers' : 2,
        'class-name' : 'code',
        'gutter' : false,
        'auto-links' : false
    });

    $('.syntaxhighlighter2').each(function(i, e) {
        e.onmouseover = null;
        e.onmouseout = null;
    }).find('.bar').addClass('show');
});

/**
 * highslide
 */
jQuery(function($) {

    // lang
    $.extend(hs.lang, {
        restoreTitle : ''
    });

    // settings
    $.extend(hs, {
        graphicsDir : 'http://zhanqi.net/web/highslide/graphics/',
        expandCursor : null,
        restoreCursor : null,
        anchor : 'auto',
        align : 'center',
        transitions : [ 'expand', 'crossfade' ],
        outlineType : 'rounded-white',
        fadeInOut : true,
        outlineWhileAnimating : true,
        showCredits : false,
        captionEval : 'this.thumb.alt',
        numberPosition : 'caption',
        // dimmingDuration : 0,
        dimmingOpacity : 0.5
    });

    // event
    $('.highslide').click(function() {
        return hs.expand(this);
    });

});

/**
 * go top
 */
jQuery(function($) {
    /* Scroll tools */
    jQuery(document).ready(function($) {
        var s = $('.go').offset().top;
        $(window).scroll(function() {
            $(".go").animate({
                top : $(window).scrollTop() + s + "px"
            }, {
                queue : false,
                duration : 500
            });
        });

        $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
        $('.go .top').click(function() {
            $body.animate({
                scrollTop : 0
            });
        });
        $('.go .bottom').click(function() {
            $body.animate({
                scrollTop : $('.copyright').offset().top
            });
        });
        $('.go .comments').click(function() {
            $body.animate({
                scrollTop : $('#comments').offset().top
            });
        });
    });
});