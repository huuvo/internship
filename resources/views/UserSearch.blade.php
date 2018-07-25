@extends('master')

@section('assets')
	<link rel="stylesheet" href="{{ URL::asset('css/user_search.css') }}">
@endsection
@section('content')

	<div class="header">

		<div class="header-content">
			<div class="header-title">
				<h4>User</h4>
			</div>

			<div class="heading-elements">
				<div class="heading-btn-group">
					<a class="btn_clear">
						<i class="glyphicon glyphicon-erase"></i>
						<span class="btn-save-title">Clear</span>
					</a>
					<a class="btn_usersearch">
						<i class="glyphicon glyphicon-search"></i>
						<span class="btn-save-title">Search</span>
					</a>
					<a class="btn_report">
						<i class="glyphicon glyphicon-paste"></i>
						<span class="btn-save-title">Report</span>
					</a>
				</div>
			</div>

		</div>
	</div>
	<div class="clear"></div>
	<div class="content-wrapper">
		<div class="wrapper-usersearch">
			<form id="formSearch" method="post">
				{{ csrf_field() }}
				<div class="row">
					<div class="content-lable">
						<label for="userid" >Employee Id </label>
						<input type="text" name="user_cd" value="{{Session::get('user_cd')}}" id="userid" />
						<label for="userid">Full Name</label>
						<input type="text" name="user_nm" value="{{Session::get('user_nm')}}" />
					</div>
				</div>
				<div class="row">
					<div class="content-lable">
						<label for="userid"> Short Name</label>
						<input type="text" name="user_ab" value="{{Session::get('user_ab')}}" />
						<label for="userid">Kata Name</label>
						<input type="text" name="user_kn" value="{{Session::get('user_kn')}}" />
					</div>
				</div>
				<div class="row">
					<div class="content-lable">
						<label for="userid">Address</label>
						<input type="tex" id="address" name="user_adr" value="{{Session::get('user_adr')}}" style="width: 70%;"  placeholder="" >
					</div>
				</div>
				<div class="row">
					<div class="content-lable">
						<label for="userid">Birth Day</label>
						<input type="date" name="birth_day" value="{{Session::get('birth_day')}}" >
						<label for="userid" style="margin-left: 60px"> Gender</label>
						<select name="gender">
							<option value='' />
						</option>
						@foreach ($library as $itemLibrary)
						@if(Session::get('gender')== $itemLibrary->number)
						<option value='{{$itemLibrary->number}}' selected="true">
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
			</div>
		</form>
		<div class="content-title">
			<div class="title-list">
				<i class="glyphicon glyphicon-triangle-bottom" id="toggle"></i>
				<span>List user</span>
			</div>

		</div>
		<div class="container-parse">
			<div class="parse-title">
				<h3>

					Showing
						@if(!is_null($usersearch))
							{{ $usersearch->firstItem() }}
						@else
						0
						@endif
						 ~
					@if(!is_null($usersearch))
						{{$usersearch->lastItem()}} of {{$usersearch->total()}}
					@else
						0 of 0
					@endif
					entries
				</h3>
			</div>

			<div class="container" style="width: 100%;">
				@if(!is_null($usersearch))
					{!! $usersearch->render() !!}
				@endif
			</div>

			<table class="table table-striped table-hover table-bordered">
				<thead>
					<tr>
						<th><input type="checkbox" name="" value="" placeholder=""></th>
						<th>Employee ID</th>
						<th>Full Name</th>
						<th>Short Name</th>
						<th>Kata Name</th>
						<th>Address</th>
						<th>BirthDay</th>
						<th>Gender</th>
					</tr>
				</thead>
				<tbody>
					@if(!is_null($usersearch))
						@foreach ($usersearch as $itemUsersearch)
						<tr>
							<td><input type="checkbox" name="" value="" placeholder=""></td>
							<td>
								<a href="{{url('userdetail/'. $itemUsersearch->user_cd)}}">
									{{$itemUsersearch->user_cd}}
								</a>
							</td>
							<td>{{$itemUsersearch->user_nm}}</td>
							<td>{{$itemUsersearch->user_ab}}</td>
							<td>{{$itemUsersearch->user_kn}}</td>
							<td>{{$itemUsersearch->user_adr}}</td>
							<td>
								@if($itemUsersearch->birth_day !=null)
									{{ date('d/m/Y', strtotime($itemUsersearch->birth_day))}}
								@endif
							</td>

							@foreach ($library as $itemLibrary)

							@if($itemUsersearch->gender == $itemLibrary->number)
							<td>{{$itemLibrary->name}}</td>

							@endif
							@endforeach
						</tr>
						@endforeach
					@else
						<tr>
							<td colspan="8">
								User list is empty
							</td>
						</tr>
					@endif

				</tbody>
			</table>
			<div class="container" style="width: 100%;">
				@if(!is_null($usersearch))
					{!! $usersearch->render() !!}
				@endif
			</div>
			</div
		</div>
	</div>
@endsection