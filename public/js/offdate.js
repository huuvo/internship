/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , button Save, Add New
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/06/16
 *| Description   :How to display Button
 */

 // $(".btn_saves").click(function() {
 //      $('form').submit();

 // });
 $(".btn_backs").click(function() {
       window.location.href= 'offdatedetail';
 });

/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , SendMail
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/06/16
 *| Description   :How to display Send Mail
 */

  var sendMail = $(".btn_senat_mail");
  sendMail.click(function () {
  var data = $('#frDateoff').serialize();
  
	$.ajax({
			url : "sendemail",
          type: "POST",
          data: data,
          success: function(data) {
              alert('Sent Successfully!');
           },
           error: function() {
               alert('Submit Failed!')
           }
       });
   });

/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , doApprovalAndReject
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/06/15
 *| Description   : function calss declaration doApprovalAndReject
 */

function doApprovalAndReject(action) {

    var formData = new FormData($('#frDateoff')[0]);
    formData.append('action', action);

    $.ajax({
        type: 'POST',
        url: 'approval',
        data: formData,
        async:false,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (data) {
            alert(data.success);
            $("#day_left").val(data.day_left);
        }
    });
  }

  /**
 *|--------------------------------------------------------------------------
 *| UserDetaiL , Show date
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/06/16
 *| Description   : How to display date
 */
$(document).ready(function() {

   $('#offDateType').trigger('change');
});

$(document).on('change','#offDateType', function () {
 
  var isHidden = $('#offDateType').val() == 1 ||
    $('#offDateType').val() == 2 ||
    $('#offDateType').val() == 3;

  if(isHidden) {

    $('#block_date_to').hide();      
  }
  else {
    $('#block_date_to').show();
  }
});

/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL ,buttun Delete
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/06/16
 *| Description   : Declare button delete
 */
$(document).on('click','.btn-delete', function () {
  
    var data = new FormData($('#frDateoff')[0]);
    var deletes = confirm('Do you want delete the user?');
    if (deletes == true)
    {
        $.ajax({
            url         : "offdatedetail/delete",
            type        : "POST",
            data        : data,
            async       :false,
            processData : false,
            contentType : false,
            dataType    : "json",
            success     : function (data) {
               $("#showMessagge").html("");
              $("#showMessagge").append("<div class='alert alert-success'>" + data.success +"</div>");
            }
        });
    }
  });

/**
 *|--------------------------------------------------------------------------
 *| UserDetaiL ,buttun Delete
 *|--------------------------------------------------------------------------
 *| Package       : Internship
 *| @author       : Huuvh - INS215 - huuvh@ans-asia.com
 *| @created date : 2018/06/16
 *| Description   : Declare button delete
 */
$(document).on('click','.btn_saves', function () {
  
    var data = new FormData($('#frDateoff')[0]);
    var saves = confirm('Do you want save the user?');
    if (saves == true)
    {
        $.ajax({
            url         : "saveUserOffDate",
            type        : "POST",
            data        : data,
            async       :false,
            processData : false,
            contentType : false,
            dataType    : "json",
            success     : function (data) {
              $("#showMessagge").html("");
              $("#hiddenRowNumber").val(data.row_number);
              $("#showMessagge").append("<div class='alert alert-success'>" + data.success +"</div>");
            },
             error: function (data) {
                $("#showMessagge").html("");
                  var dataErrors  = data.responseJSON;
                  var size    = $('li').length;
                  var alertDanger = $("<div class='alert alert-danger'>");
                  var value = "<ul>";

                  if (size == 0) {
                      $.each(dataErrors.errors, function (index, val) {
                        value+= "<li>" + val + "</li>";
                      });
                  }else {
                      $('li').remove(); 
                       $.each(dataErrors.errors, function (index, val) {
                            value+= "<li>" + val + "</li>";
                      });
                  }

                  value+= "</ul>";
                  alertDanger.append(value);
                  $("#showMessagge").append(alertDanger);
              }
        });
    }
  });