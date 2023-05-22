@extends('layouts.auth')
@section('content')

<form method="POST" action="{{ route('register') }}" class="md-float-material form-material">
@csrf

<div class="card-block">
    <div class="row m-b-20">
        <div class="col-md-12">
            <h3 class="text-center txt-primary">Sign up</h3>
        </div>
    </div>
    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
    <div class="form-group form-primary">
        <p class="text-success">
        Invited you : Suresh
        </p>
    </div>
    <div class="form-group form-primary">
        <input type="text" name="user-name" class="form-control">
        <span class="form-bar"></span>
        <label class="float-label">Username</label>
    </div>
    <div class="form-group form-primary">
        <input type="text" name="email" class="form-control">
        <span class="form-bar"></span>
        <label class="float-label">Email</label>
    </div>
    <div class="form-group form-primary">
        <input type="text" name="email" class="form-control">
        <span class="form-bar"></span>
        <label class="float-label">Phone/Mobile</label>
    </div>


    <div class="row">
        <div class="col-sm-6">
            <div class="form-group form-primary">
                <select name="gender" class="form-control">
                    <option value=""></option>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
                <span class="form-bar"></span>
                <label class="float-label">Gender</label>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-primary">
                <input type="date" name="dob" class="form-control">
                <span class="form-bar"></span>
                <label class="float-label">Date of Birth</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group form-primary">
                <input type="password" name="password" class="form-control">
                <span class="form-bar"></span>
                <label class="float-label">Password</label>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group form-primary">
                <input type="password" name="confirm-password" class="form-control">
                <span class="form-bar"></span>
                <label class="float-label">Confirm Password</label>
            </div>
        </div>
    </div>
    <div class="row m-t-30">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign up now</button>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-10">
            <p class="text-inverse text-left m-b-0">Already have an account?<a href="index.html"><b>Login</b></a></p>
        </div>
        <div class="col-md-2">
            <img src="{{ asset('plugins/images/auth/Logo-small-bottom.png')}}" alt="small-logo.png">
        </div>
    </div>
</div>
</form>
@endsection