/**
*|--------------------------------------------------------------------------
*| UserDetaiL , Submit
*|--------------------------------------------------------------------------
*| Package       : Internship
*| @author       : Huuvh - INS215 - huuvh@ans-asia.com
*| @created date : 2018/05/24
*| Description   :submit
*/
$(document).ready(function() {

  if ($('#error').val() > 0) {

    var dataImageUrl = localStorage.getItem('imgData');

    if( dataImageUrl != '') {
      $('#imgAvatar').attr('src', dataImageUrl);
    }
  }else {
    localStorage.setItem('imgData', '');
  }

  var imgAvatar = document.getElementById('imgAvatar');

    imgAvatar.addEventListener('click', function(e) {
      $('#avatar').click();
      readImageURL($('#avatar')) ;
    });
});

/*xu ly uploadavtar */
function readImageURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {

      var imgData = e.target.result;

      $('#imgAvatar').attr('src', imgData);
      
      localStorage.setItem('imgData', imgData);
    };

    reader.readAsDataURL(input.files[0]);
  }
}
