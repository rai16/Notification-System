@extends('layout')


@section('header')
    <link rel="stylesheet" type="text/css" href="css/auth.css"> 
@stop


@section('content')


    <div class="col-sm-5">
            <h1 id="header_name"> <span style="font-size: 1.3em;"><b>Admin</b></span>Panel</h1>
        </div>
        
        
        <div class="container col-md-offset-4 col-md-4" id="login_div">
            
                    <h2 style="margin-left: 160px; color: white;">Login</h2>
                    
                     <form method="POST" action="/verify_login">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="username" style="color: white;">Username:</label>
                            <input type="text" class="form-control" name="username" value="{{ old('username') }}" id="username" required>
                        </div>
                        <div class="form-group">
                            <label for="pwd" style="color: white;">Password:</label>
                            <input type="password" class="form-control" name ="password" id="password" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg" id="login_btn">Login</button>
                        
                        </div>

                    </form>
                    
                    
        </div>
        
        
        <div class="container col-md-offset-4 col-md-4">
            <h3 style="color: white; float: left; margin-top: 36px;"> Don't have an account yet? </h3>
            <button type="button" class="btn btn-primary btn-lg"  data-toggle="modal" data-target="#registerModal"  style="margin-top: 23px; margin-left: 15px;">Register</button>
        
            <div id="registerModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title" style="float: left; margin: 19px;">Register</h2>
                        </div>
                        
                        <div class="modal-body">
                            
                            <form class="form-horizontal" method="POST" action="/verify_register">

                             <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="checkbox">
                                    <label class="col-sm-offset-1">
                                        <input type="checkbox" name="user_type" id="user_type" onclick="$(this).attr('value', this.checked ? 1 : 0)">Admin User
                                    </label>
                                </div>
                            
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="name">Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="name" placeholder="Enter name" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="uname">Username:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="uname" value="{{ old('uname') }}" class="form-control" id="uname" placeholder="Enter a username" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="pass">Passowrd:</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="pass" class="form-control" id="pass" placeholder="Enter your password" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="cpass">Confirm Passowrd:</label>
                                    <div class="col-sm-9">
                                        <input type="password" name="conf_pass" class="form-control" id="cpass" placeholder="Retype your password" required>
                                    </div>
                                </div>
                        
                        </div>
                        
                        <div class="modal-footer">
                            <p style="color: red; font-family: Avant Garde,Avantgarde; margin: 21px; " id="register_error"></p>
                            <button type="submit" class="btn btn-primary btn-large" id="register_btn">Submit</button>
                        </form>
                            <button type="button" class="btn btn-default btn-large" data-dismiss="modal">Close</button>
                        </div>
                        
                    </div>

                </div>
            </div>

        
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

        </div>
        
            
@stop


@section('footer')
    <script src="js/auth.js"></script>
@stop






