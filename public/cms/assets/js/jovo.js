var nopicpath = "/Jzw/Tpl/Home/Default/Public/nopic.jpg"; //默认图片
var layer;
$(function () {
    //显示默认图片
    $(".pics").find("img").each(function () {
        if ($(this).attr("src") == "") {
            $(this).attr("src", nopicpath);
        }
    });
    // 获取当前域名
    var domain = document.domain;
    // 获取当前图片域名
    $('.contentInfo img').each(function () {
        var src = $(this).attr("src");
        var str = new RegExp("^(http|https)://");
        var res = str.test(src);//test方法返回值为(true或者false)
        if (res) {
            // 检查是否为当前网站的域名
            var str = new RegExp("^(http|https)://" + domain);
            var res = str.test(src);//test方法返回值为(true或者false)
            if (!res) {
                $(this).attr('referrerPolicy', 'no-referrer');
                var obj = $(this);
                obj.attr('src', src + "?v=1");
                // checkImgExists(src).then(() => {
                //     //success callback
                //     console.log('有效链接')
                //     obj.attr('src', src + "?v=1");
                // }).catch(() => {
                //     //fail callback
                //     console.log('无效链接')
                //     obj.attr('src', src + "?v=1");
                // })
            }
        }
    });
});
function checkImgExists(imgurl) {
    return new Promise(function (resolve, reject) {
        var ImgObj = new Image()
        ImgObj.src = imgurl
        ImgObj.onload = function (res) {
            resolve(res)
        }
        ImgObj.onerror = function (err) {
            reject(err)
        }
    })
}

//滚动条开启与关闭
function closeScroll() {
    $(".page").height(document.body.clientWidth);
    $(".page").css({ "overflow-x": "hidden", "overflow-y": "hidden" });
}
function openScroll() {
    $(".page").css("height", "auto");
    $(".page").css({ "overflow-x": "auto", "overflow-y": "auto" });
}
/* 
* url 目标url 
* arg 需要替换的参数名称 
* arg_val 替换后的参数的值 
* return url 参数替换后的url 
*/
function changeURLArg(url, arg, arg_val) {
    var pattern = arg + '=([^&]*)';
    var replaceText = arg + '=' + arg_val;
    if (url.match(pattern)) {
        var tmp = '/(' + arg + '=)([^&]*)/gi';
        tmp = url.replace(eval(tmp), replaceText);
        return tmp;
    } else {
        if (url.match('[\?]')) {
            return url + '&' + replaceText;
        } else {
            return url + '?' + replaceText;
        }
    }
    return url + '\n' + arg + '\n' + arg_val;
}
//验证手机格式
function isPhone(str) {
    var pattern = "(^(13\\d|14\\d|15\\d|16\\d|17\\d|18\\d|19\\d)\\d{8})$";
    var check = new RegExp(pattern);
    return check.test(str);
}
//验证只能输入字母和数字
function isZMorNum(str) {
    var reg = /^[0-9a-zA-Z]*$/g;
    return reg.test(str);
}
//验证邮箱格式
function isEmail(str) {
    var reg = /^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/;
    return reg.test(str);
}
//验证身份证格式
function isIDCard(str) {
    var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
    return reg.test(str);
}
//是否为正整数
function isZInt(str) {
    var reg = /^[0-9]\d*$/;
    return reg.test(str);
}
//是否为字母
function isZM(str) {
    var reg = /^[a-zA-Z]+$/;
    return reg.test(str);
}
//是否为数字
function isNum(str) {
    var reg = /^[0-9]*$/;
    return reg.test(str);
}
//是否为数字和小数点
function isNumDian(str) {
    var reg = /^\d+(\.\d+)?$/;
    return reg.test(str);
}
//打印页面
function preview() {
    bdhtml = window.document.body.innerHTML;
    sprnstr = "<!--startprint-->";
    eprnstr = "<!--endprint-->";
    prnhtml = bdhtml.substr(bdhtml.indexOf(sprnstr) + 17);
    prnhtml = prnhtml.substring(0, prnhtml.indexOf(eprnstr));
    window.document.body.innerHTML = prnhtml;
    window.print();
}
//C#取时间JSON格式转换
function ChangeDateFormat(jsondate) {
    jsondate = jsondate.replace("/Date(", "").replace(")/", "");
    if (jsondate.indexOf("+") > 0) {
        jsondate = jsondate.substring(0, jsondate.indexOf("+"));
    }
    else if (jsondate.indexOf("-") > 0) {
        jsondate = jsondate.substring(0, jsondate.indexOf("-"));
    }

    var date = new Date(parseInt(jsondate, 10));
    var month = date.getMonth() + 1 < 10 ? "0" + (date.getMonth() + 1) : date.getMonth() + 1;
    var currentDate = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();

    return date.getFullYear()
        + "年"
        + month
        + "月"
        + currentDate
        + "日"
        + " "
        + date.getHours()
        + ":"
        + date.getMinutes()
        + ":"
        + date.getSeconds();
}

// 判断字符串是否为json格式
function isJSON(str) {
    console.log(str)
    if (typeof str == 'string') {
        try {
            JSON.parse(str);
            return true;
        } catch (e) {
            console.log(e);
            return false;
        }
    }

    console.log('It is not a string!')

}

//判断是否为微信浏览
function is_weixn() {
    var ua = navigator.userAgent.toLowerCase();
    if (ua.match(/MicroMessenger/i) == "micromessenger") {
        return true;
    } else {
        return false;
    }
}

/**
 * 客服链接统一打开
 * 放置model_foot.html
 * <a style="display:none;" id="aFootKefu" href="http://wpa.qq.com/msgrd?v=3&uin={$qq}&site={$site_name}&menu=yes"></a>
 */
function sayKeFu() {
    var path = $("#aFootKefu").attr("href");
    var newTab = window.open('about:blank');
    $.ajax({
        success: function (data) {
            if (data) newTab.location.href = path;
        }
    });
}

// =============================================百度地图=================================================
//加载联系我们地图PC
function loadContactMap(id, markerArr, map) {
    map.enableScrollWheelZoom(true);
    //向地图中添加缩放控件
    var ctrlNav = new window.BMap.NavigationControl({ anchor: BMAP_ANCHOR_TOP_LEFT, type: BMAP_NAVIGATION_CONTROL_LARGE });
    map.addControl(ctrlNav);
    //向地图中添加缩略图控件
    var ctrlOve = new window.BMap.OverviewMapControl({ anchor: BMAP_ANCHOR_BOTTOM_RIGHT, isOpen: 1 });
    map.addControl(ctrlOve);
    //向地图中添加比例尺控件
    var ctrlSca = new window.BMap.ScaleControl({ anchor: BMAP_ANCHOR_BOTTOM_LEFT });
    map.addControl(ctrlSca);
    //绘制点
    for (var i = 0; i < markerArr.length; i++) {
        var point = markerArr[i].point.value;
        addInfoWindow(addMarker(new window.BMap.Point(point.split(",")[0], point.split(",")[1]), i), markerArr[i], i);
    }
}

function addMarker(point, index) {
    var myIcon = new BMap.Icon("http://api.map.baidu.com/img/markers.png", new BMap.Size(23, 25), { offset: new BMap.Size(10, 25), imageOffset: new BMap.Size(0, 0 - index * 25) });
    var marker = new BMap.Marker(point, { icon: myIcon });
    map.addOverlay(marker);
    return marker;
}
// 添加信息窗口
function addInfoWindow(marker, poi) {
    //pop弹窗标题
    var title = '<div id="map_title_my">' + poi.title.value + '</div>';
    //pop弹窗信息
    var html = [];
    html.push('<table cellspacing="0" id="map_content_my"><tbody>' +
        '<tr><td>' + poi.address.name + ':</td><td>' + poi.address.value + '</td></tr>' +
        '<tr><td>' + poi.tel.name + ':</td><td>' + poi.tel.value + '</td></tr>' +
        '</tbody></table>');
    var infoWindow = new BMap.InfoWindow(html.join(""), { title: title, width: 200 });

    var openInfoWinFun = function () { marker.openInfoWindow(infoWindow); };
    marker.addEventListener("click", openInfoWinFun);
    map.openInfoWindow(infoWindow, map.getCenter());
    return openInfoWinFun;
}
// =============================================百度地图 END=================================================

//=====================layer=========================
$(function () {
    if (!visitPort.isAndroid && !visitPort.isPhone) layui.use(['layer', 'form'], function () {
        layer = layui.layer;
    });
})
//封装ajax
var ajaxLoadIndex;
var ajaxLoadOpen = 1;
var before_request = 1;
function myajax(url, data, dataType, type, async, responseFun) {
    $.ajax({
        url: url,
        data: data,
        dataType: dataType,
        type: type,
        async: async,
        success: responseFun,
        beforeSend: beforeSend,
        error: error,
        complete: complete
    });
}

function beforeSend() {
    if (before_request == 0) return false; // 上一次请求没回来 不进行下一次请求
    before_request = 0;
    //Loading层
    if (ajaxLoadOpen == 1) {
        if (visitPort.isAndroid || visitPort.isPhone) {
            ajaxLoadIndex = layer.open({ type: 2 });
        } else {
            ajaxLoadIndex = layer.load(1, {
                shade: [0.1, '#fff'] //0.1透明度的白色背景
            });
        }
    }
}
function error() {
    layer.open({ content: '请求失败', skin: 'msg', time: 2 });
}
function complete() {
    before_request = 1;
    myajax_close();
}
function myajax_close() {
    if (ajaxLoadOpen == 1)
        layer.close(ajaxLoadIndex);
    else
        ajaxLoadOpen = 1;
}
function showErrorMsg(msg) {
    layer.open({ content: '<div style="padding:4px 6px;">' + msg + '</div>', skin: 'msg', time: 2 });
}
function la_open(content, icon, callback) {
    if (visitPort.isAndroid || visitPort.isPhone) wap_open(content, icon, callback);
    else pc_open(content, icon, callback);
}
function pc_open(content, icon, callback, la_open_title, la_open_time) {
    if (la_open_title == "") la_open_title = "提示";
    if (la_open_time == 0) la_open_time = 2000;
    var param = { content: content, icon: icon, title: la_open_title, time: la_open_time };
    if (typeof (callback) == "undefined") layer.open({ content: content, icon: icon, title: la_open_title, time: la_open_time });
    else layer.open({ content: content, icon: icon, title: la_open_title, time: la_open_time, end: function () { callback() } });
}
//封装layer弹窗
//标题，内容，图标（0警告，1正确，2错误）
function wap_open(content, icon, callback) {
    var iconStr = '';
    var iconArr = { 0: 'oy_war', 1: 'oy_yes', 2: 'oy_no' };
    iconStr = '<img src="/Public/Js/layui/mobile/img/' + iconArr[icon] + '.png"  style="width:50px;" />';
    content = '<span style="font-size:.28rem;font-family: 微软雅黑;display:block;margin-top:6px;max-width: 136px;color:#fff;">' + content + '<span>';
    if (typeof (callback) == "undefined") {
        layer.open({ content: '<div style="padding:4px 6px;">' + iconStr + content + '</div>', skin: 'msg', time: 2 });
    }
    else {
        layer.open({ content: '<div style="padding:4px 6px;">' + iconStr + content + '</div>', skin: 'msg', time: 2, end: function () { callback() } });
    }
}
//询问框
function la_confirm(msg, b1, b2, btn1, btn2) {
    if (b1 == "") {
        b1 = "确认";
    }
    if (b2 == "") {
        b2 = "取消";
    }
    //询问框
    layer.open({
        content: msg, btn: [b1, b2], yes: function (index) {
            btn1();
        }, no: function () {
            btn2();
        }
    });
}
//=====================layer END=========================


var visitPort = function () {
    var ua = navigator.userAgent,
        isWindowsPhone = /(?:Windows Phone)/.test(ua),
        isSymbian = /(?:SymbianOS)/.test(ua) || isWindowsPhone,
        isAndroid = /(?:Android)/.test(ua),
        isFireFox = /(?:Firefox)/.test(ua),
        isChrome = /(?:Chrome|CriOS)/.test(ua),
        isTablet = /(?:iPad|PlayBook)/.test(ua) || (isAndroid && !/(?:Mobile)/.test(ua)) || (isFireFox && /(?:Tablet)/.test(ua)),
        isPhone = /(?:iPhone)/.test(ua) && !isTablet,
        isPc = !isPhone && !isAndroid && !isSymbian;
    return {
        isTablet: isTablet,
        isPhone: isPhone,
        isAndroid: isAndroid,
        isPc: isPc
    };

}();
