@extends('layout')

@section('header')
    <link rel="stylesheet" type="text/css" href="css/admin_display.css"> 
@stop


@section('content')

	<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					
					<a class="navbar-brand" href="#"><h3 style="font-family: Avant Garde,Avantgarde,Century Gothic,CenturyGothic,AppleGothic,sans-serif; margin-top: 0px; margin-left: 5px;"><b>Admin</b> Panel</h3></a>
				</div>
				
		
				<ul class="nav navbar-nav navbar-right">
					<li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span>Log out</a></li>
				</ul>
			</div>
		</nav>
		
		<div class="col-md-4" style="height: 400px; float: left; margin-top: 70px;">
			 
			 <h4 style="margin-left: 70px;">Hello, 
			 {{Session::get('user')}} 
			 </h4>
			 
			  <div class="list-group" style="width: 300px; margin-left: 70px;">
				<a href="#" class="list-group-item active"><span class="badge">{{$user_count}}</span>Users</a>

				<a href="/users/admin/{{Session::get('id')}}/history" class="list-group-item"><span class="badge">{{$notif_count}}</span>History</a>

			  </div>
			
		</div>
		
		<div ng-app="app" ng-init='users={{$user_list}}' class="col-md-8"style="margin-top: 70px;">
		
			<div class="container-fluid" style=" border-radius: 10px; margin-top: 30px; padding-left: 0px;"></input>

			<span style="font-size: 1.7em;">Search: </span>
			<input type="text" ng-model="userFilter.username" style="font-size: 2em; margin-bottom: 50px;">
			<hr>
			@if(Session::has('errors'))
					<div class="alert alert-danger" style="margin-top: 20px;">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						{{Session::get('errors')}}
					</div>
				@endif

				@if(Session::has('success'))
                	<div class="alert alert-success" style="margin-top: 20px;">
                	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                		{{Session::get('success')}}
                	</div>
                @endif

			<form method="POST" action="{{Session::get('id')}}/send">

				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group">
  					<label for="message">Message:</label>
  					<textarea class="form-control" name="message" rows="5" id="message"></textarea>
				</div>
				<hr>
				<button type="submit" class="btn btn-lg btn-success" style="float: left;">Send</button>
				<button type="button" class="btn btn-md btn-primary" id="select_all" style="float: right; ">Select All</button>
				<button type="button" class="btn btn-md btn-danger" id="unselect_all" style="float: right; margin-right: 15px;">Unselect All</button>

				<div style="clear: both;"></div>
				<hr>
				
					<div class="checkbox" ng-repeat="x in users | filter: userFilter">
						<label style="font-size: 1.4em; font-weight: bold;"><input type="checkbox" name="[[x.username]]" onclick="$(this).attr('value', this.checked ? 1 : 0)">  [[x.username]] </label>
					</div>
				
				<hr>
				
			</form>

		</div>

		<script>
			var sampleApp = angular.module('app', [], function($interpolateProvider) {
        										$interpolateProvider.startSymbol('[[');
        										$interpolateProvider.endSymbol(']]');
    										}
    							);

			$("#select_all").on('click',function(e){
				$("input:checkbox").each(function() {
    				this.checked = true;
				});

			});

			$("#unselect_all").on('click',function(e){

				$("input:checkbox").each(function() {
    			this.checked = false;
				});

			});
		</script>
@stop


