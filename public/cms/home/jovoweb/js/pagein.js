$(function () {
    //二级导航
    $(".com_header .new_head_nav li").hover(function () {
        $(this).children('div').stop(true, true).slideDown();
    }, function () {
        $(this).children('div').stop(true, true).slideUp();
    });

    //测导航动画
    $(".new_right_menu").hover(function () {
        $(this).stop().animate({
            margin: '0 0 10px -110px'
        });
    }, function () {
        $(this).stop().animate({
            margin: '0 0 10px 0'
        });
    });

    $(".new_right_menu_sm").hover(function () {
        $(this).children(".new_right_menu_ewm").stop(true, true).show(300);
    }, function () {
        $(this).children(".new_right_menu_ewm").stop(true, true).hide(300);
    });

});

function goTopEx() {
    var obj = document.getElementById("zhiding");

    function getScrollTop() {
        return $(window).scrollTop();
    }

    function setScrollTop(value) {
        $(window).scrollTop(value);
    }
    window.onscroll = function () {
        getScrollTop() > 0 ? obj.style.display = "" : obj.style.display = "block";
    }
    obj.onclick = function () {
        var goTop = setInterval(scrollMove, 10);

        function scrollMove() {
            setScrollTop(getScrollTop() / 1.1);
            if (getScrollTop() < 1) clearInterval(goTop);
        }
    }
}