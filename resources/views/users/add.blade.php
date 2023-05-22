@extends('layouts.app')

@section('content')
<?php
// print_r($mypayment); exit;
?>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Admin Users</h5>
                        <p class="m-b-0">Welcome to Investment System</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                <i class="icofont icofont-home"></i>
                            </a>
                        </li>

                        <li class="breadcrumb-item"><a href="{{ route('admin-user') }}">Users</a>
                        </li>
                        <li class="breadcrumb-item">Add User
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper" style="padding: 3px;">

                <div class="page-body">
                    <div class="row">

                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Add New Admin User</h5>
                                    <span>Admin<code> User </code>details</span>
                                </div>
                                <div class="card-block">

                                    @if ($cerror = Session::get('error'))
                                    <div class="text-danger">
                                        Error! - {{ $cerror }}
                                    </div>
                                    <br />
                                    @endif
                                    {!! Form::open(array('route' => 'admin.user.save','id'=>'frmprofile','method'=>'POST','class'=>'md-float-material form-material','enctype' => 'multipart/form-data')) !!}
                                    @csrf
                                    <br/>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <input maxlength="50" required value="{{old('first_name')}}" type="text" name="first_name" class="form-control" autocomplete="new-first_name">
                                                <span class="form-bar"></span>
                                                <label class="float-label">First Name<span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('first_name', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <input maxlength="50" required value="{{old('last_name')}}" type="text" name="last_name" class="form-control" autocomplete="new-last_name">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Last Name<span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('last_name', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <input maxlength="50" required value="{{old('email')}}" type="email" name="email" class="form-control" autocomplete="new-email">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Email<span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('email', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <input maxlength="50" required value="{{old('phone')}}" type="text" name="phone"  onkeypress="return isNumberKey(event)"  class="form-control" autocomplete="new-phone">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Phone / Mobile<span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('phone', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <input type="password" name="user_password" value="{{ old('user_password' )}}" class="form-control" autocomplete="new-password">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Password <span class="required-field">*</span></label>
                                                
                                                <div class="text-danger-error">
                                                    {!! $errors->first('user_password', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <input type="password" name="confirm_password" value="{{ old('confirm_password') }}" class="form-control" autocomplete="new-confirm-password">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Confirm Password <span class="required-field">*</span></label>
                                                
                                                <div class="text-danger-error">
                                                    {!! $errors->first('confirm_password', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    



                                    <div class="form-group form-info">
                                        <button type="submit" class="btn btn-dark-teal waves-effect waves-light">Save<i class="icofont icofont-diskette"></i></button>
                                        <a onclick="cancelConfirmation(event)" class="btn btn-blue-gray waves-effect waves-light" style="color: white;" href="{{ url('admin-user') }}">Cancel<i class="icofont icofont-close-squared-alt"></i></a>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>





                    </div>
                </div>
            </div>
            <div id="styleSelector">
            </div>
        </div>
    </div>
</div>
@endsection
@push('moreJs')
<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
@endpush