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
					<li><a href="logout"><span class="glyphicon glyphicon-log-out"></span>Log out</a></li>
				</ul>
			</div>
		</nav>
		
		<div class="col-md-4" style="height: 400px; float: left; margin-top: 70px;">
			 
			 <h4 style="margin-left: 70px;">Hello, 
			 {{Session::get('user')}} 
			 </h4>
			 
			  <div class="list-group" style="width: 300px; margin-left: 70px;">

				<a href="#" class="list-group-item active"><span class="badge">{{$notif_count}}</span>Notifications</a>

			  </div>
			
		</div>
		
		<div ng-app="app" ng-init='notifs={{$notif_list}}' class="col-md-8"style="margin-top: 70px;">
			
			<div class="container-fluid" style=" border-radius: 10px; margin-top: 30px; padding-left: 0px;">
			@if($notif_count==0)
				<h2 style="color: red;"> Sorry, you have no notifications yet.</h2>
			@else
				<span style="font-size: 1.7em;">Search: </span><input type="text" ng-model="notifFilter.sender" style="margin-bottom: 50px; font-size: 2em;">
				<div class="list-group">
					
					<div class="list-group-item" ng-repeat="notif in notifs | filter:notifFilter">
					
						<h4 class="list-group-item-heading" >[[notif.sender]]</h4>
    					<p class="list-group-item-text" style="color: blue; font-size: 1.2em;">[[notif.data]]<br>
    					<span style="font-size: 0.7em; color: red;">[[notif.time]]</span></p>
					</div>
				</div>
			@endif
		</div>

		<script>

			var sampleApp = angular.module('app', [], function($interpolateProvider) {
        										$interpolateProvider.startSymbol('[[');
        										$interpolateProvider.endSymbol(']]');
    										});
		</script>

@stop