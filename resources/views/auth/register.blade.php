@extends('layouts.auth')
@section('content')

<form method="POST" action="{{ route('register.save') }}" autocomplete="off" class="md-float-material form-material">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ isset($id)?$id:'' }}" />
    <div class="card-block">
        <div class="row m-b-20">
            <div class="col-md-12">
                <h3 class="text-center txt-primary">Sign up</h3>
            </div>
        </div>
        @if ($cerror = Session::get('error'))
        <div class="text-danger">
            Error! - {{ $cerror }}
        </div>
        <br />
        @endif

        <div class="form-group form-primary">
            <select name="title" class="form-control" required>
                <option value="0"></option>
                <option value="Mr." <?php if (old('title') == "Mr.") {
                                        echo 'selected';
                                    } ?>>Mr.</option>
                <option value="Mrs." <?php if (old('title') == "Mrs.") {
                                            echo 'selected';
                                        } ?>>Mrs.</option>
                <option value="Miss." <?php if (old('title') == "Miss.") {
                                            echo 'selected';
                                        } ?>>Miss.</option>
            </select>
            <span class="form-bar"></span>
            <label class="float-label">Title <span class="required-field">*</span></label>
            <div class="text-danger-error">
                {!! $errors->first('title', ':message') !!}
            </div>
        </div>

        <div class="form-group form-primary">
            <input type="text" maxlength="100" required name="first_name" class="form-control" value="{{old('first_name')}}" autocomplete="new-first_name">
            <span class="form-bar"></span>
            <label class="float-label">First Name <span class="required-field">*</span></label>
            <div class="text-danger-error">
                {!! $errors->first('first_name', ':message') !!}
            </div>
        </div>
        <div class="form-group form-primary">
            <input type="text" maxlength="100" required name="last_name" class="form-control" value="{{old('last_name')}}" autocomplete="new-last_name">
            <span class="form-bar"></span>
            <label class="float-label">Last Name <span class="required-field">*</span></label>
            <div class="text-danger-error">
                {!! $errors->first('last_name', ':message') !!}
            </div>
        </div>
        <div class="form-group form-primary">
            <input type="text" maxlength="50" required name="email" class="form-control" value="{{old('email')}}" autocomplete="new-email">
            <span class="form-bar"></span>
            <label class="float-label">Email <span class="required-field">*</span></label>
            <div class="text-danger-error">
                {!! $errors->first('email', ':message') !!}
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group form-primary">
                    <span class="form-bar"></span>
                    <input required type="password" maxlength="50" name="user_password" value="{{old('user_password')}}" class="form-control" autocomplete="new-password">
                    <span class="form-bar"></span>
                    <label class="float-label">Password <span class="required-field">*</span></label>
                    <div class="text-danger-error">
                        {!! $errors->first('user_password', ':message') !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group form-primary">
                    <input type="password" maxlength="50" required name="confirm_password" value="{{old('confirm_password')}}" class="form-control" autocomplete="new-confirm-password">
                    <span class="form-bar"></span>
                    <label class="float-label">Confirm Password <span class="required-field">*</span></label>
                    <div class="text-danger-error">
                        {!! $errors->first('confirm_password', ':message') !!}
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-sm-6">
                <div class="form-group form-primary">
                    <select name="country" class="form-control" required>
                        <option value="0"></option>
                        <option value="Australia" <?php if (old('country') == "Australia") {
                                                        echo 'selected';
                                                    } ?>>Australia</option>
                        <option value="Canada" <?php if (old('country') == "Canada") {
                                                    echo 'selected';
                                                } ?>>Canada</option>
                        <option value="India" <?php if (old('country') == "India") {
                                                    echo 'selected';
                                                } ?>>India</option>
                        <option value="Malaysia" <?php if (old('country') == "Malaysia") {
                                                        echo 'selected';
                                                    } ?>>Malaysia</option>
                        <option value="Sri Lanka" <?php if (old('country') == "Sri Lanka") {
                                                        echo 'selected';
                                                    } ?>>Sri Lanka</option>
                        
                    </select>
                    <span class="form-bar"></span>
                    <label class="float-label">Country <span class="required-field">*</span></label>
                    <div class="text-danger-error">
                        {!! $errors->first('country', ':message') !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group form-primary">
                    <select name="gender" class="form-control" required>
                        <option value="0"></option>
                        <option value="1" <?php if (old('gender') == 1) {
                                                echo 'selected';
                                            } ?>>Female</option>
                        <option value="2" <?php if (old('gender') == 2) {
                                                echo 'selected';
                                            } ?>>Male</option>
                    </select>
                    <span class="form-bar"></span>
                    <label class="float-label">Gender <span class="required-field">*</span></label>
                    <div class="text-danger-error">
                        {!! $errors->first('gender', ':message') !!}
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group form-primary">
            <input type="text" maxlength="12" required name="phone" class="form-control" value="{{old('phone')}}" onkeypress="return isNumberKey(event)" autocomplete="new-phone">
            <span class="form-bar"></span>
            <label class="float-label">Phone / Mobile <span class="required-field">*</span></label>
            <div class="text-danger-error">
                {!! $errors->first('phone', ':message') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group form-info">
                    <input maxlength="20" required value="{{old('nic')}}" type="text" name="nic" class="form-control" autocomplete="new-nic">
                    <span class="form-bar"></span>
                    <label class="float-label">NIC / Passport <span class="required-field">*</span></label>

                    <div class="text-danger-error">
                        {!! $errors->first('nic', ':message') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-t-30">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">
                    Sign up <i class="icofont icofont-login"></i>
                </button>
                <!-- <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign up now</button> -->
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-10">
                <p class="text-inverse text-left m-b-0">Already have an account? <a href="{{ route('login') }}"><b>Login</b></a></p>
            </div>
            <div class="col-md-2">
                <img src="{{ asset('plugins/images/auth/Logo-small-bottom.png')}}" alt="small-logo.png">
            </div>
        </div>
    </div>
</form>
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