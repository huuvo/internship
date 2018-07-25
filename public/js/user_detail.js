$(".btn_save").click(function() {
      $('form').submit();

    });

    $(".btn_add").click(function(){
      $('form#frUser input').val("");

      localStorage.setItem('imgData', '');

    });
    $(".btn_back").click(function() {
       window.location.href= '{{url('user/search/index')}}';
    });

    $("#deleteUser").click(function() {
      var userId = $('#hiddenUserId').val();
      if (userId != null)
      {
        window.location.href = "/userdetail/delete/" + userId ;
      }
    });

   /* Handling data load whenrefer userid*/
    $("#userId" ).keyup(function() {
      var userId = $("#userId").val().trim();
      var postData = { "userId" : userId };

      $.ajax({
        type: 'GET',
        url: '{{url('userdetailbyid')}}',
        data: postData,
        dataType: 'json',
        success: function(data)
        {
          if (!$.isEmptyObject(data)) {

            $.each(data, function(key, value) {

              $('#hiddenUserId').val(value.user_cd);
              var urlImg = '{{URL::asset('upload/img') }}' + '/'+ value.avatar ;
              $('#imgAvatar').attr("src", urlImg);
              $("#hiddenAvatar").val(getBase64Image(document.getElementById("imgAvatar")));
              localStorage.setItem('imgData', urlImg);
              $("#shortname").val(value.user_ab);
              $("#kataname").val(value.user_kn);
              $("#fullnames").val(value.user_nm);
              $("#Birth_day").val(value.birth_day);
              $("#gender").val(value.gender);
              $("#address").val(value.user_adr);
              $("#passwords").val(value.password);
              $("#subject").val(value.note);
            });
          }
        }
      });
    });

  function getBase64Image(img) {
      var canvas = document.createElement("canvas");
      canvas.width = img.width;
      canvas.height = img.height;
      var ctx = canvas.getContext("2d");
      ctx.drawImage(img, 0, 0);
      var dataURL = canvas.toDataURL("image/png");
      return dataURL
  }

  function setDefaultValueByUserId(userId) {

      $('#hiddenUserId').val(userId);

      if(userId != '') {
        
        $('#imgAvatar').attr("src", "");
        localStorage.setItem('imgData', "");
      }

      $("#shortname").val("");
      $("#kataname").val("");
      $("#fullnames").val("");
      $("#Birth_day").val("");
      $("#gender").val(3);
      $("#address").val("");
      $("#passwords").val("");
      $("#subject").val("");
    }