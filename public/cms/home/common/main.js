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
    }
});
require.config(config);
require(["jquery"], function($) {
    if (typeof (menuIndex) != "undefined") {
        $(".new_head_nav li").each(function () {
            if ($(this).data("id") == menuIndex) {
                $(".new_head_nav li").removeClass("active");
                $(this).addClass("active");
            }
        });
    }
});
var downOver = false;
require(["jquery", "waypoint", "countto"], function($, waypoint, countto) {
    if ($('.counter').length) {
        var counter = $('.counter');
        counter.waypoint(function (direction) {
            if (direction == 'down' && !downOver) {
                downOver = true;
                counter.countTo();
            }
        }, { offset: '100%'});
    }
});