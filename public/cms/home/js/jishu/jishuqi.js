var downOver = false;
$(function(){
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