// require.config(configParams);
function deepExtend(target, ...sources) {
    for (var i = 0; i < sources.length; i++) {
        var source = sources[i];
        for (var key in source) {
            if (source.hasOwnProperty(key)) {
                if (typeof source[key] === 'object' && source[key] !== null) {
                    if (!target.hasOwnProperty(key)) {
                        target[key] = Array.isArray(source[key]) ? [] : {};
                    }
                    deepExtend(target[key], source[key]);
                } else {
                    target[key] = source[key];
                }
            }
        }
    }
    return target;
}
var config = deepExtend(configParams, {
    baseUrl: '/cms/home/js',
    paths: {
        swiper: '/cms/home/js/idangerous.swiper2.7.6.min',
        superSlide: '/cms/home/js/jquery.SuperSlide.2.1.3',
        waypoint: '/cms/home/js/jishu/waypoints.min',
        countto: '/cms/home/js/jishu/jquery.countto.min',
        common: '/cms/home/common/index',
    },
    shim: {
        common: ['layui'],
        swiper: ['jquery'],
        superSlide: ['jquery'],
        countto: ['jquery']
    }
});
require.config(config);
require(["jquery", "wow", "waypoint", "countto"], function($, wow) {
    new wow().init();
    // var downOver = false;
    // var counter = $('.counter');
    // if (counter.length) {
    //     counter.waypoint(function (direction) {
    //         if (direction === 'down' && !downOver) {
    //             downOver = true;
    //             counter.countTo();
    //         }
    //     }, { offset: '100%'});
    // }

    //二级导航
    $(".com_header .new_head_nav li").mouseenter(function () {
        $(this).children('div').slideDown();
    }).mouseleave(function () {
        $(this).children('div').stop().slideUp();
    });
    if (typeof (menuIndex) != "undefined") {
        $(".new_head_nav li").each(function () {
            if ($(this).data("id") === menuIndex) {
                $(".new_head_nav li").removeClass("active");
                $(this).addClass("active");
            }
        });
    }
    // 所有专题的案例展示板块取得滑动组件
    // if($(".anli_sw")[0]) {
    //     var $sysSw1 = $(".anli_sw");
    //     var $sw1Slide = $sysSw1.find(".swiper-slide");
    //     var $maskImg = $('<div class="qrCode"><img src="/Jzw/Tpl/Home/Default/webimages/case/code.jpg"><p>扫码了解更多优质案例</p></div>');
    //     for(var i=0;i<$sw1Slide.length;i++){
    //         $($sw1Slide[i]).children().append($maskImg.clone(true)[0]);
    //     }
    // }
});