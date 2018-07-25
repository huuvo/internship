<!DOCTYPE html>
</body>
</html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Management User</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
	<script src="{{ URL::asset('js/jquery-1.12.4.js') }}"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  @yield('assets')
</head> 

<body>
  @yield('content')
  <script src="{{ URL::asset('js/offdate.js') }}"></script>
  <script type="text/javascript">

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
    // for search
    $(".btn_usersearch").click(function() {
      $('#formSearch').attr('action', '{{url('user/search/list')}}');
      $('#formSearch').submit();
    });

    $(".btn_report").click(function() {

      var datas = $('#formSearch').serialize();
      $.ajax({
        type: 'GET',
        url: '{{url('user/exportexcel')}}',
        data: datas,
        async:false,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (data) {
          var userData = data.userData;
          console.log(userData);
          if (userData.length == 0) {
            $.alert({
              title: 'List User Master',
              content: 'Currently can not shown data!',
            });
          }else {
            window.location= 'http://' + window.location.hostname + (window.location.port ? ':' + window.location.port: '') +'/' + data['path'];

          }
        }
      })
    });

    $(".btn_clear").click(function() {
      window.location = '{{url('user/search/index')}}';
    });

    $("#toggle").click(function() {

      $(this).toggleClass( 'glyphicon-triangle-bottom glyphicon-triangle-top' );
      $('.table').toggle();
    });

    $(".btn_usersearchs").click(function() {
      alert('You want to find information')
      $('#formSearch').attr('action', 'list');
      $('#formSearch').submit();
    });


    $(".offday_btn_backs").click(function() {
      window.location = 'index';
    });
  </script>
</body>
</html>