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
                        <h5 class="m-b-10">Change Password</h5>
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

                        <li class="breadcrumb-item"><a href="{{ route('client-user') }}">Customers</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ url('client-user/view/'.$id) }}">Customers View</a>
                        </li>
                        <li class="breadcrumb-item">Password Change
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
                        

                       


                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Customer account change password</h5>
                                </div>
                                <div class="card-block">

                                    @if ($cerror = Session::get('error'))
                                    <div class="text-danger">
                                        Error! - {{ $cerror }}
                                    </div>
                                    <br />
                                    @endif
                                    {!! Form::open(array('route' => 'client.user.changepwd','id'=>'frmprofile','method'=>'PUT','class'=>'md-float-material form-material','enctype' => 'multipart/form-data')) !!}
                                    @csrf
                                    <br />
                                    <input type="hidden" name="id" id="id" value="{{ isset($id)?$id:'' }}" />
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <input required type="password" name="user_password" value="{{ old('user_password' )}}" class="form-control" autocomplete="new-password">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Password <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('user_password', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <input required type="password" name="confirm_password" value="{{ old('confirm_password') }}" class="form-control" autocomplete="new-confirm-password">
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
                                        <a onclick="cancelConfirmation(event)" class="btn btn-blue-gray waves-effect waves-light" style="color: white;" href="{{ url('client-user/view/'.$id) }}">Cancel<i class="icofont icofont-close-squared-alt"></i></a>
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