@extends('layouts.auth')
@section('content')



<div class="card-block">
    <div class="row m-b-20">
        <div class="col-md-12">
            <h3 class="text-center">Sign In</h3>
        </div>
    </div>
    @if (count($errors) > 0)
    <div class="text-danger">
        @foreach ($errors->all() as $error)
        {{ $error }}
        @endforeach
    </div>
    <br />
    @endif
    <form novalidate method="POST" action="{{ route('login') }}" autocomplete="off" class="md-float-material form-material">
        @csrf
        <div class="form-group form-primary">
            <input type="email" class="form-control" maxlength="50" id="email" name="email" autocomplete="off" >
            <span class="form-bar"></span>
            <label class="float-label">Email <span class="required-field">*</span></label>
        </div>
        <div class="form-group form-primary">
            <input type="password"  maxlength="50" class="form-control" id="password" name="password" autocomplete="off">
            <span class="form-bar"></span>
            <label class="float-label">Password <span class="required-field">*</span></label>
        </div>
       
        <div class="row m-t-30">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">
                    Login <i class="icofont icofont-login"></i>
                </button>
            </div>
        </div>
    </form>
    <hr />
    <div class="row">
        <div class="col-md-10">
            <p class="text-inverse text-left m-b-0">Haven't yet an account?
                <a href="{{ route('register') }}"><b>Sign up</b></a>
            </p>
        </div>
        <div class="col-md-2">
            <img src="{{ asset('plugins/images/auth/Logo-small-bottom.png')}}" alt="small-logo.png">
        </div>
    </div>
</div>

@endsection