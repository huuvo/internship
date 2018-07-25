@extends('master')

@section('assets')
	<link rel="stylesheet" href="{{ URL::asset('css/user_detail.css') }}">
	<script src="{{ URL::asset('js/user_img.js') }}"></script>

@endsection
@section('content')

<div class="content-click">
	<div class="col-12">
	<!-- Process buttons -->
		<div class="pane-title">
			<div class="pane-name">
			   <h1>User Master</h1>
			</div>
		<div class="heading-btn-group">
			<a class="btn_save">
				<i class="glyphicon glyphicon-ok-sign btn-save-icon"></i>
				<span class="btn-save-title">Save</span>
			</a>
			<a id="deleteUser" class="btn-delete">
				<i class="glyphicon glyphicon-remove-sign btn-detele-icon"></i>
				<span class="btn-detele-title">Delete</span>
			</a>
			<a href="{{url('userdetail')}}" class="btn_add">
				<i class="glyphicon glyphicon-plus-sign btn-add-icon"></i>
				<span>Add New</span>
			</a>
			<a class="btn_back">
				<i  class="glyphicon glyphicon-share-alt btn-back-icon"></i>
				<span class="btn-back-title">Back</span>
			</a>
		</div>
	  	</div>
	 </div>
 </div>
 <div class="clear"></div>
 </div>
 </div>
 <!-- panel-body -->
<div class="content">
	<form action="{{route('saveUser')}}" id="frUser" method="post" enctype="multipart/form-data" accept-charset="utf-8">
		{{ csrf_field() }}
		<!-- ERROR MESSAGE -->
		<input type="hidden" id="error" name="error" value="@if(isset($errors)){{count($errors)}}@endif" />
		@if (count($errors) > 0)
			<div class ="alert alert-danger">
				@foreach ($errors->all() as $err)
			 		{{$err}}<br />
				@endforeach
			</div>
		@endif

		@if(Session::has('success'))
			<div class="alert alert-success">
				{{Session::get('success')}}
			</div>
		@elseif(Session::has('deleteSuccess'))
			<div class="alert alert-success">
				{{Session::get('deleteSuccess')}}
			</div>
		@elseif(Session::has('notFound'))
		<div class="alert alert-danger">
			{{Session::get('notFound')}}
		</div>
		@elseif(Session::has('message'))
		<div class="alert alert-danger">
			{{Session::get('message')}}
		</div>
		@endif
		<!-- Where to enter user information in from -->
		<div class="row">
			<div class="content-lable">
				<label for="userid"> User ID</label>
			</div>
			<div class="content-input">

				<input type="text" id="userId" name="userid" autocomplete="false"
					value="@if(isset($userDetail)){{$userDetail->user_cd}}@else{{old('userid')}}@endif"
					@if(isset($userDetail)){{'readonly'}} @endif />

				<input type="hidden" id="hiddenUserId" name="hiddenUserId"
					value="@if(isset($userDetail)){{$userDetail->user_cd}}@endif" />
			</div>
			<div class="upload-btn-wrapper">
					<input type="file" id="avatar" name="avatar" accept="image/png,image/jpg,image/jpeg"
						onchange="readImageURL(this);" style="display: none;" />

         			<img id="imgAvatar"
         				src="@if(isset($userDetail)){{URL::asset('upload/img') . '/'. $userDetail->avatar}}@else{{old('avatar')}}@endif" alt=""/>

         			<input type="hidden" id="hiddenAvatar" name="imgAvatar"
						value="@if(isset($userDetail)){{URL::asset('upload/img') . '/'. $userDetail->avatar}}@else{{old('avatar')}}@endif" />
			    </div>
		</div>
		<div class="row">
			<div class="content-lable">
				<label for="shortname"> Short Name</label>
			</div>
			<div class="content-input">
				<input type="text" id="shortname" name="shortname" style="width: 25%;" value="@if(isset($userDetail)){{$userDetail->user_ab}}@else{{old('shortname')}}@endif" placeholder="" />
			</div>
		</div>
		<div class="row">
			<div class="content-lable">
				<label for="kataname"> Kata Name</label>
			</div>
			<div class="content-input">
				<input type="text" id="kataname" name="kataname" tyle="width: 25%;" value="@if(isset($userDetail)){{$userDetail->user_kn}}@else{{old('kataname')}}@endif" placeholder="" />
			</div>
		</div>
		<div class="row">
			<div class="content-lable">
				<label for="fullname"> Full Name</label>
			</div>
			<div class="content-input">
				<input type="text" id="fullnames" name="fullnames" value="@if(isset($userDetail)  && !$errors->has('fullnames')){{$userDetail->user_nm}}@else{{old('fullnames')}}@endif" placeholder="">
			</div>
		</div>
		<div class=row-list>
			<ul>
				<li class="list-left">
					<label for="birthday">Birth day</label>
					<input type="date" id="Birth_day" name="birthday" value="@if(isset($userDetail)){{$userDetail->birth_day}}@else{{old('birthday')}}@endif" />
				</li>
				<li class="list-right">
					<label for="gender"">Gender</label>
					<div class="content-input">
					<select id="gender" name="gender">
		          		@foreach ($library as $itemLibrary)
		          			@if(isset($userDetail) && $userDetail->gender == $itemLibrary->number)
    						 <option value='{{$itemLibrary->number}}' selected='true' >
    						 	{{$itemLibrary->name}}
    						 </option>
    						 @else
    						  <option value='{{$itemLibrary->number}}'>
    						 	{{$itemLibrary->name}}
    						 </option>
    						 @endif
						@endforeach
			    </select>
			</div>
				</li>
			</ul>
		</div>
		<div class="clear">
		<div class="row">
			<div class="content-lable">
				<label for="address">Address</label>
			</div>
			<div class="content-input">
				<input type="text" id="address" name="address" style="width: 70%;" value="@if(isset($userDetail)){{$userDetail->user_adr}}@else{{old('address')}}@endif" placeholder="">
			</div>
		</div>
		<div class="row">
			<div class="content-lable">
				<label for="fullname">Password</label>
			</div>
			<div class="content-input">
				<input id ="passwords" class="input" type="password" name="passwords" style="width: 25%;" value="@if(isset($userDetail) && !$errors->has('passwords')){{$userDetail->password}}@endif"  placeholder="">
			</div>
		</div>
		<div class="row">
			<div class="content-lable">
				<label for="note">Note</label>
			</div>
			<div class="content-input">
				<textarea id="subject"  class="note" name="note" >@if(isset($userDetail)){{$userDetail->note}}@else{{old('note') }} @endif</textarea>
			</div>
		</div>
	</form>
</div>
@endsection