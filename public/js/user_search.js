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