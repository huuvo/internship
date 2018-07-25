@extends('master')

@section('assets')
	<link rel="stylesheet" href="{{ URL::asset('css/date_detail.css') }}">
@endsection
<header id="header" class="">
	<div class="header-content">
			<div class="header-title">
				<h4>Day off Master</h4>
			</div>
			<div class="heading-elements">
				<div class="heading-btn-group">
					<a  class="btn_add" href="{{ url('offdatedetail') }}">
						<i class="glyphicon glyphicon-plus-sign btn-add-icon"></i>
						<span>Add New</span>
					</a>
					<a class="btn_senat_mail">
						<i class="glyphicon glyphicon-envelope"></i>
						<span class="btn-save-title">Sent mail</span>
					</a>
					<a class="btn_appoval" onclick="return doApprovalAndReject('approval');">
						<i class="glyphicon glyphicon-check"></i>
						<span class="btn-save-title">Appoval</span>
					</a>
					<a class="btn_ reject" onclick="return doApprovalAndReject('reject');">
						<i class="glyphicon glyphicon-ban-circle"></i>
						<span class="btn-save-title"> Reject</span>
					</a>
					<a class="btn_saves">
						<i class="glyphicon glyphicon-ok-sign btn-save-icon"></i>
						<span class="btn-save-title">Save</span>
					</a>
					<a class="btn-delete">
						<i class="glyphicon glyphicon-remove-sign btn-detele-icon"></i>
						<span class="btn-detele-title">Delete</span>
					</a>
					<a class="btn_backs">
						<i  class="glyphicon glyphicon-share-alt btn-back-icon"></i>
						<span class="btn-back-title">Back</span>
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div class="content-wrapper">
		<div class="content-title">
			<div class="title-off">
				<h3>Day off Information</h3>
			</div>
		</div>
		<form action="{{route('saveUserOffDate')}}" id="frDateoff" class="frDateoff" method="post" enctype="multipart/form-data" accept-charset="utf-8">
		{{ csrf_field() }}
		<!-- ERROR MESSAGE -->
				<input type="hidden" id="error" name="error" value="@if(isset($errors)){{count($errors)}}@endif" />

				<div id="showMessagge">
				</div>
				<div class="row-number">
			      	<input type="hidden" name="row_number" id="hiddenRowNumber" value="{{$row_number}}" class="form-control">
			    </div>
			     @csrf
				<div class="row">
					<div class="content-lable">
						<label for="userid" >Requester </label>
						<input type="text" id="userId" name="user_cd" autocomplete="false" value="{{ $requester }}" />
					</div>
				</div>
				<div class="row">
					<div class="content-lable">
						<label for="day_left"> Off dayleft</label>
						<input type="text" name="day_left" id="day_left" value="{{$userDateOffLeft}}" /><span>Day</span>
						<label for="approver" style="margin-left: 60px;"> Approver</label>
						<select name="approver" id="approver" style="width: 20%;">
							<option value=""></option>}
							@foreach($approvers as $approvers)
               					<option value="{{$approvers->user_cd}}" @if (old('approver') == $approvers->user_cd) selected="selected" @endif>{{$approvers->user_cd}}:{{$approvers->user_nm}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row">
					<div class="content-lable">
						<label for="offDateType">Day off Type</label>
						<select  id="offDateType" name="offDateType" style="width: 174px;">
							<option value=""></option>
							@foreach ($offDateTypes as $offDateType)
		    				<option value="{{$offDateType->number}}" @if (old('offDateType') == $offDateType->number) selected="selected" @endif>{{$offDateType->name}}</option>
							@endforeach
						</select>
						<label for="salaryType" style="margin-left: 85px"> Salary Type</label>
						<select name="salaryType" style="width: 170px;">
								<option value=""></option>
								@foreach ($salaryTypes as $salaryType)
		    						 <option value="{{$salaryType->number}}" @if (old('salaryType') == $salaryType->number) selected="selected" @endif>{{$salaryType->name}}</option>
								@endforeach
						</select>
					</div>
				</div>
				<div class="row">
					<div class="content-lable">
						<label for="dayoff">Day Off</label>
						<input type="date" id="date_from" name="date_from" value="{{old('date_from')}}" />
						<span id="block_date_to">
						<span>~</span>
						<input type="date" id="date_to" name="date_to" value="{{old('date_to')}}" />
						</span>
					</select>
				</div>
			</div>
			<div class="row">
					<div class="content-lable">
						<label for="note">Reason</label>
						<textarea id="subject"  class="reason" name="reason" >{{old('reason')}}</textarea>
					</div>
			</div>
			<div class="row">
					<div class="content-lable">
						<label for="note">Note</label>
						<textarea id="subject"  class="note" name="note" >{{old('note')}}</textarea>
					</div>
			</div>

		</form>
	</div>
</header>
<!-- /header -->
