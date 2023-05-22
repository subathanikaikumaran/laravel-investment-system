@extends('layouts.app')

@section('content')
<?php
$userTitle=0;
// print_r($mypayment); exit;
if (old('title')) {
    $userTitle = old('title');
}
?>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Customers</h5>
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
                        <li class="breadcrumb-item">Add New Customer
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
                                    <h5 class="m-b-10">Add New Customer</h5>
                                    <span>New<code> Customer </code>details</span>
                                </div>
                                <div class="card-block">

                                    @if ($cerror = Session::get('error'))
                                    <div class="text-danger">
                                        Error! - {{ $cerror }}
                                    </div>
                                    <br />
                                    @endif
                                    {!! Form::open(array('route' => 'client.user.save','id'=>'frmprofile','method'=>'POST','class'=>'md-float-material form-material','enctype' => 'multipart/form-data')) !!}
                                    @csrf
                                    <br />
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group form-primary">
                                                <select name="title" class="form-control" required>
                                                    <option value="0"></option>
                                                    <option value="Mr." <?php if ($userTitle == "Mr.") {
                                                                            echo 'selected';
                                                                        } ?>>Mr.</option>
                                                    <option value="Mrs." <?php if ($userTitle == "Mrs.") {
                                                                                echo 'selected';
                                                                            } ?>>Mrs.</option>
                                                    <option value="Miss." <?php if ($userTitle == "Miss.") {
                                                                                echo 'selected';
                                                                            } ?>>Miss.</option>
                                                </select>
                                                <span class="form-bar"></span>
                                                <label class="float-label">Title <span class="required-field">*</span></label>
                                                <div class="text-danger-error">
                                                    {!! $errors->first('title', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                                <input maxlength="12" required value="{{old('phone')}}" type="text" name="phone" onkeypress="return isNumberKey(event)" class="form-control" autocomplete="new-phone">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Phone / Mobile <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('phone', ':message') !!}
                                                </div>
                                            </div>
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

                                   
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <select name="gender" required class="form-control">
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
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <input type="date" name="dob" value="{{old('dob')}}" class="form-control fill" autocomplete="new-dob">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Date of Birth </label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('dob', ':message') !!}
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


                                    <br />
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <input maxlength="100"  value="{{old('address_street_1')}}" type="text" name="address_street_1" class="form-control" autocomplete="new-address_street_1">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Address Street 1</label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('address_street_1', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <input maxlength="100" value="{{old('address_street_2')}}" type="text" name="address_street_2" class="form-control" autocomplete="new-address_street_2">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Address Street 2</label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('address_street_2', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <input maxlength="100"  value="{{old('city')}}" type="text" name="city" class="form-control" autocomplete="new-city">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Town / City</label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('city', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <input maxlength="100"  value="{{old('province')}}" type="text" name="province" class="form-control" autocomplete="new-province">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Province</label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('province', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <input maxlength="100" required value="{{old('country')}}" type="text" name="country" class="form-control" autocomplete="new-country">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Country <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('country', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group form-info">
                                                <input maxlength="100"  value="{{old('postalcode')}}" type="text" name="postalcode" class="form-control" autocomplete="new-postalcode">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Postal Code / Zip Code</label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('postalcode', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                   




                                    <div class="form-group form-info">
                                        <button type="submit" class="btn btn-dark-teal waves-effect waves-light">Save<i class="icofont icofont-diskette"></i></button>
                                        <a onclick="cancelConfirmation(event)" class="btn btn-blue-gray waves-effect waves-light" style="color: white;" href="{{ url('client-user') }}">Cancel<i class="icofont icofont-close-squared-alt"></i></a>
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