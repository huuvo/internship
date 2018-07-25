<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<p>Kính gửi ban điều hành công ty,</p></br>
	<p>Tôi xin đăng kí nghỉ với nội dung như sau:</p></br>
	<div>
		<p> Họ và tên: {{$users->user_cd}}</p></<br>
		<p> Mã nhân viên : {{$users->user_nm}}</p></<br>
		<p> Thời gian nghĩ : Từ<span> {{$date_off_from}}</span>Đến <span>{{$date_off_to}}</span></p></<br>
		<p> Lý do : {{$reason}}</p>
	</div>
	<p> Ghi chú : {{$note}}</p>
	<p>Thanks and best regards</p>
	</<br>
	<div>
	<p style="font-size: 20px">∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞∞</p>
		<img src="https://s33.postimg.cc/e9c22imvz/logo-ans.png">
		<p style="margin-bottom: 20px;"><strong>A.N.S Asia Co. Ltd. Danang Branch</strong></p>
		<p>Tel   : (0236) 356 69 69</p>
		<p>Mail  : {{$email}} </p>
		<p>URL : http://www.ans-asia.com</p>
		<p style="margin-top: 20px">7F, PVComBank Building, Plot A2.1 30/4 Street,<br>Hai Chau District, Danang, Vietnam</p>
	</div>
</body>
</html>