@extends('master')

@section('assets')
	<link rel="stylesheet" href="{{ URL::asset('css/date_search.css') }}">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	 <script src="{{ URL::asset('js/off_date_search.js') }}"></script>
@endsection
@section('content')

	<div class="header">

		<div class="header-content">
			<div class="header-title">
				<h4>OffDay Search</h4>
			</div>

			<div class="heading-elements">
				<div class="heading-btn-group">
					<a class="btn_adds">
						<i class="glyphicon glyphicon-plus-sign"></i>
						<span class="btn-save-title">Add</span>
					</a>
					<a class="btn_usersearchs">
						<i class="glyphicon glyphicon-search"></i>
						<span class="btn-save-title">Search</span>
					</a>
					<a class="offday_btn_backs">
						<i class="glyphicon glyphicon-share-alt"></i>
						<span class="btn-save-title">Back</span>
					</a>
				</div>
			</div>

		</div>
	</div>
	<div class="clear"></div>
	<div class="content-wrapper">
		<div class="wrapper-usersearch">
			<div class="listsearch">
				<i class="glyphicon glyphicon-triangle-bottom"></i>
	        	<span class="span-menu"> Search condition </span>
	        </div>
			<form id="formSearch" class="formid" method="post">
				{{ csrf_field() }}
				<div class="row">
					<div class="content-lable">
						<label for="requester">Requester</label>
							<select class="requester" name="requester[]"  id="requester" multiple="multiple" style="width:  20%">
							<option value=""></option>}
								@foreach($users as $user)
							<option value="{{ $user->user_cd }}">{{ $user->user_cd }} : {{ $user->user_nm }}</option>
								@endforeach
							
						</select>
						<input id="rownumber" name="rownumber" type="text" value="" hidden="true" class="form-group">
						<label for="approver" style="margin-left: 7%"> Approver</label>
						{{-- <select name="approver" id="approver"> --}}
						<select class="approver"  id="approver" name="approver" style="width:  10%">
							<option value=""></option>}
							@foreach($users as $user)
								<option id="approver" value="{{ $user->user_cd }}">{{ $user->user_cd }} : {{ $user->user_nm }}</option>
							@endforeach
						</select>
						<label for="Approval"> Approval</label>
						<select class="Approval"  id="Approval" name="Approval" >
					{{-- 	<select name="Approval" id="Approval"> --}}
							<option value=""></option>}
							@foreach($approvals as $approval)
							<option id="approval" value="{{ $approval->number }}">{{ $approval->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row">
					<div class="content-lable">
						<label for="dayoff">Day Off</label>
						<input type="date" id="date_from" name="date_from" value="{{Session::get('date_from')}}" />
						<span id="block_date_to">
						<span>~</span>
						<input type="date" id="date_to" name="date_to" value="{{Session::get('date_to')}}" />
						</span>
						<label for="offDateType" style="margin-left: 25px">Day off Type</label>
						<select  id="offDateType" name="offDateType">
							<option value=""></option>
							@foreach ($offDateTypes as $offDateType)
		    				<option value="{{$offDateType->number}}" @if (Session::get('offDateType') == $offDateType->number)@endif>{{$offDateType->name}}</option>
							@endforeach
						</select>
						<label for="salaryType"> Salary Type</label>
						<select name="salaryType">
								<option value=""></option>
								@foreach ($salaryTypes as $salaryType)
		    						 <option value="{{$salaryType->number}}" @if (Session::get('salaryType') == $salaryType->number)@endif>{{$salaryType->name}}</option>
								@endforeach
						</select>
				</div>
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
						@if(!is_null($offDateSearch))
							{{ $offDateSearch->firstItem() }}
						@else
						0
						@endif
						 ~
					@if(!is_null($offDateSearch))
						{{$offDateSearch->lastItem()}} of {{$offDateSearch->total()}}
					@else
						0 of 0
					@endif
					entries
				</h3>
			</div>

			<div class="container" style="width: 100%;">
				@if(!is_null($offDateSearch))
					{!! $offDateSearch->render() !!}
				@endif
			</div>

			<table class="table table-striped table-hover table-bordered">
				<thead>
					<tr>
						<th>Requester</th>
		                <th>Off Date</th>
		                <th>Off Type</th>
		                <th>Reason</th>
		                <th>Salary Type</th>
		                <th>Approved</th>
		                <th>Approver</th>
		                <th>Date Off Left</th>
					</tr>
				</thead>
				<tbody>
					@if(!is_null($offDateSearch))
						@foreach ($offDateSearch as $itemOffDateSearch)
						<tr>
							<td>
								<a href="{{url('OffDateDetail/'. $itemOffDateSearch->user_cd)}}">
									{{$itemOffDateSearch->user_cd}}
								</a>
							</td>
							<td>{{$itemOffDateSearch->date_off_from}}</td>
							<td>{{$itemOffDateSearch->offdate_type}}</td>
							<td>{{$itemOffDateSearch->reason}}</td>
							<td>{{$itemOffDateSearch->offdate_salary_type}}</td>
							<td>
									<button data-toggle="modal" data-target="#view-modal" data-id="{{$itemOffDateSearch->user_cd}}" id="getUser" class="btn btn-sm btn-info">
										<i class="glyphicon glyphicon-eye-open"></i> {{$itemOffDateSearch->approval}}
									</button>
									
							</td>
							{{-- <td>{{$itemOffDateSearch->approval}}</td> --}}
							<td>{{$itemOffDateSearch->approval_id}}</td>
							<td>{{$itemOffDateSearch->day_left}}</td>
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
				@if(!is_null($offDateSearch))
					{!! $offDateSearch->render() !!}
				@endif
			</div>
			</div
		</div>
		<script type="text/javascript">
			$.ajaxSetup({
			  headers: {
			    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
			});
			 $(".btn-info").click(function() {

		     var uid = $(this).data('id'); 
		     $.ajax({
				  url : '{{url('viewapprover')}}',
	         	  type: "POST",
	          	  data: 'id='+uid,
	          	  dataType: 'html',
		          success: function(data) {
		             console.log(data);
		           },
		           error: function() {
		               alert('Failed!')
		           }
	       		});
		});
		</script>

		<div id="view-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" 	style="display: none;">
		<div class="modal-dialog modal-lg">
		  	<div class="modal-content">
			    <div class="modal-header">
			    	<h4 class="modal-title">Approver List</h4>
			      <button type="button" class="btn btn-info" data-dismiss="modal">Back</button>
			    </div>
			    <div class="modal-body">
			      	<table id="table-modal" class="table table-striped table-hover table-bordered" width="100%">
			          	<thead>
			          		<tr>
				                <th>Approver</th>
				                <th>Status</th>
				                <th>Date</th>
				                <th>Note</th>
			              </tr>
			          	</thead>
			          	<tbody>
			          	@if(!is_null($offDateSearch))
						@foreach ($offDateSearch as $itemOffDateSearch)
			          	<tr>
			          		<td>{{$itemOffDateSearch->user_cd}}</td>
			              	<td>{{$itemOffDateSearch->approval}}</td>
			              	<td>{{$itemOffDateSearch->date_off_from}}</td>
			              	<td>{{$itemOffDateSearch->reason}}</td>

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
			    </div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	</div>	

@endsection