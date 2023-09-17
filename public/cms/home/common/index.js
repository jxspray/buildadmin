
$(function () {
    // 网站兼容提示
    if (
        navigator.appName == "Microsoft Internet Explorer"
        && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE6.0"
        || navigator.appName == "Microsoft Internet Explorer"
        && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE7.0"
        || navigator.appName == "Microsoft Internet Explorer"
        && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE8.0"
        || navigator.appName == "Microsoft Internet Explorer"
        && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE9.0"
    ) checkBowerTip2();
    $('#checkBowerTip').click(function () { $(this).hide(); });

    layui.use(['layer', 'form']);
    //视频处理
    $(".videoIFrame").attr("width", 800).attr("height", 600);
});
//=======================================通用JS========================================
// 版本1
function checkBowerTip() {
    var $checkbower = $('<div id="checkBowerTip" style="display:block;z-index: 9999;width: 100%;padding:15px;height:auto;background: #fff9e8;border:1px solid #ffe08c;text-align: center;font-size: 14px;color:#333;position:fixed;top: 0;">' +
        '<span style="padding-right: 6%;font-family: 微软雅黑">当前浏览器版本过低，影响整体的访问体验。建议升级到IE9以上版本，或者切换极速模式，或者下载<a style="font-size: 14px;color:#ff6700;" target="view_window" href="http://chrome.360.cn/">360浏览器</a>，<a style="font-size: 14px;color:#ff6700;" target="view_window" href="http://www.google.cn/intl/zh-CN/chrome/browser/desktop/index.html">谷歌浏览器</a>等</span>' +
        '<img title="关闭" style="cursor: pointer;padding: 0 10px;" src="/Public/Images/close_ie.png"/>' +
        '</div>');
    $('body').html('');
    $('body').prepend($checkbower);
    $checkbower.width(window.innerWidth);
    $checkbower.find('img').eq(0).click(function () {
        $checkbower.addClass('hidden');
    });
    if ($checkbower.width() < 400) $checkbower.css({
        'font-size': '12px',
        'padding': '5px 0',
        'text-align': 'left'
    }).find('span').eq(0).css('padding-right', '10px')
}

//版本2，直接清空
function checkBowerTip2() {
    var $checkbower = $('<html><head><title></title></head><body><div class="ieshow"><p class="top">你正在使用的浏览器内核版本过低，<span>微软已经不再提供技术支持</span>，为避免可能存在的安全隐患，请尽快升级你的浏览器或者安装更安全的浏览器访问</p><ul><li><a href="https://www.google.cn/chrome/" target="_blank"><img src="/Jzw/Tpl/Home/Default/images/sys/1.png"></a><p>谷歌浏览器</p></li><li><a href="https://browser.360.cn/" target="_blank"><img src="/Jzw/Tpl/Home/Default/images/sys/4.png"></a><p>360浏览器</p></li><li><a href="http://www.firefox.com.cn/" target="_blank"><img src="/Jzw/Tpl/Home/Default/images/sys/2.png"></a><p>火狐浏览器</p></li><li><a href="https://www.apple.com/safari/" target="_blank"><img src="/Jzw/Tpl/Home/Default/images/sys/3.png"></a><p>Safari</p><p class="tip">只支持 Mac 电脑</p></li></ul><p class="foot">如果你正在使用的是双核浏览器，比如QQ浏览器，搜狗浏览器，360浏览器。可以使用浏览器的极速模式来继续访问</p></div></body></html>');
    $('body').html('');
    $('body').prepend($checkbower);
}

