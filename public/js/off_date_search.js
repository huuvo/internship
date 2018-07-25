
$(".btn_usersearchs").click(function() {
  $('#formSearch').attr('action', 'offdate/search/list');
  $('#formSearch').submit();
});


$(".btn_backs").click(function() {
  window.location = 'offdate/search/index';
});

$("#toggle").click(function() {

  $(this).toggleClass( 'glyphicon-triangle-bottom glyphicon-triangle-top' );
  $('.table').toggle();
});
$(document).ready(function() {
    $('.requester').select2();
    $('.approver').select2();
});
