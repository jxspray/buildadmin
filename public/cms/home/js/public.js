// 初始化
$(function () {
  //右侧导航1==========
  var rWidth = [];
  var i_new = 0;
  $('.right_nav_box li').each(function () {
    rWidth[i_new] = $(this).width();
    i_new++;
  });
  $(".right_nav").hide();
  $('.right_nav_box li').hover(function () {
    var _this = $(this);
    var _thiswidth = -rWidth[_this.index()] + 30;
    _this.stop().animate({
      'left': _thiswidth
    }, 800);
  }, function () {
    var _this = $(this);
    var _thisindex = $(this).index();
    _this.stop().animate({
      'left': 0
    }, 500);
  });
  var _height = $('.slideBox').outerHeight() / 2;
  $(window).scroll(function () {
    var scroll_top = $(this).scrollTop();
    if (scroll_top > _height) {
      $('.right_nav').fadeIn();
    } else {
      $('.right_nav').fadeOut();
    }
  })
  /*返回顶部*/
  $('.right_nav .fh_top').click(function () {
    $('html,body').animate({
      scrollTop: 0
    }, '500');
  });
  //右侧导航1==========END
  //右侧导航2==========
  $(window).scroll(function () {
    if ($(window).scrollTop() > 600) {
      $(".sys_rightbox2").show(500);
    } else {
      $(".sys_rightbox2").hide(500);
    }
  });
  //测导航动画
  $(".sys_rightbox2 .new_right_menu").hover(function () {
    $(this).stop().animate({
      margin: '0 0 10px -120px'
    });
  }, function () {
    $(this).stop().animate({
      margin: '0 0 10px 0'
    });
  });
  $(".sys_rightbox2  .new_right_menu_sm").hover(function () {
    $(this).children(".sys_rightbox2 .new_right_menu_ewm").stop(true, true).show(300);
  }, function () {
    $(this).children(".sys_rightbox2 .new_right_menu_ewm").stop(true, true).hide(300);
  });
  /*返回顶部*/
  $('.sys_rightbox2 .zhiding').click(function () {
    $('html,body').animate({
      scrollTop: 0
    }, '500');
  });
  //右侧导航2==========END
  //右侧导航3==========
  $(window).scroll(function () {
    if ($(window).scrollTop() > 600) {
      $(".sys_rightbox3").show(500);
    } else {
      $(".sys_rightbox3").hide(500);
    }
  });
  $('.sys_rightbox3 .backtop').click(function () {
    $('html,body').animate({
      scrollTop: 0
    }, '500');
  });
  //右侧导航3==========END
  
    //右侧导航5==========
    let sysRightbox5 = $(".sys_rightbox5");
    let backtop5 = sysRightbox5.find(".backtop");
    $(window).scroll(function () {
      if ($(window).scrollTop() > 470) {
        sysRightbox5.fadeIn(500);
      } else {
        sysRightbox5.fadeOut(500);
      }
    });
    backtop5.click(function () {
      $('html,body').animate({
        scrollTop: 0
      }, '500');
    });
    //右侧导航5==========END
});


//滚动动画==========
var a, b, c;
a = $(window).height();
$(window).scroll(function () {
  var b = $(this).scrollTop();
  $(".animation_fiu>div").each(function () {
    c = $(this).offset().top;
    if (c > window.screen.availHeight) {
      if (a + b > c) {
        $(this).addClass("fade_in_up");
      }
    }
  });
  $(".animation_fi>div").each(function () {
    c = $(this).offset().top;
    if (c > window.screen.availHeight) {
      if (a + b > c) {
        $(this).addClass("fade_in");
      }
    }
  });
});
//滚动动画==========END

// tab 
function sys_setTab(name, cursel, n) {
  for (i = 0; i < n; i++) {
    var menu = document.getElementById(name + i);
    var con = document.getElementById("con_" + name + "_" + i);
    menu.className = i == cursel ? "active" : "";
    con.style.display = i == cursel ? "block" : "none";
  }
}

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