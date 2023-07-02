$(document).ready(function() {
  var panelOne = 600,
    panelTwo = $('.form-panel.two')[0].scrollHeight+200;

  $('.form-panel.two').not('.form-panel.two.active').on('click', function(e) {

    $('.form-toggle').addClass('visible');
    $('.form-panel.one').addClass('hidden');
    $('.form-panel.two').addClass('active');
    $('.form').animate({
      'height': panelTwo
    }, 200);
  });

  $('.form-toggle').on('click', function(e) {
    
    $(this).removeClass('visible');
    $('.form-panel.one').removeClass('hidden');
    $('.form-panel.two').removeClass('active');
    $('.form').animate({
      'height': panelOne
    }, 200);
  });
});