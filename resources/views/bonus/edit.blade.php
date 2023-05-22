@extends('layouts.app')

@section('content')
<?php
date_default_timezone_set('Asia/Colombo');
$date = date('Y-m-d');

$date = isset($bonus->date) ? date('Y-m-d', strtotime($bonus->date)) : 0;
$isMonthly = isset($bonus->is_monthy_bonus) ? $bonus->is_monthy_bonus : 0;
$level = isset($bonus->level) ? $bonus->level : 0;

if (old('isMonthly')) {
    $isMonthly = old('isMonthly');
}
if (old('level')) {
    $level = old('level');
}
?>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Bonus Details</h5>
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
                        
                        <li class="breadcrumb-item"><a href="{{ route('admin-bonus') }}">Bonus Details</a>
                        </li>
                        <li class="breadcrumb-item">Edit Bonus Detail
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
                                    <h5>Edit Bonus Detail</h5>
                                    <span>Edit<code> Bonus </code>details</span>
                                </div>
                                <div class="card-block">

                                    @if ($cerror = Session::get('error'))
                                    <div class="text-danger">
                                        Error! - {{ $cerror }}
                                    </div>
                                    <br />
                                    @endif
                                    {!! Form::open(array('route' => 'admin.bonus.update','id'=>'frmprofile','method'=>'PUT','class'=>'md-float-material form-material','enctype' => 'multipart/form-data')) !!}
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ isset($bonus->id)?$bonus->id:'' }}" />
                                                                      
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <input maxlength="30" required value="{{old('type', isset($bonus->type)?$bonus->type:'')}}" type="text" name="type" class="form-control" autocomplete="new-type">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Bonus Name <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('type', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <input maxlength="10" required value="{{old('amount', isset($bonus->ini_amount)?$bonus->ini_amount:'')}}" onkeypress="return isMaxamountKey(event)" type="text" name="amount" class="form-control" autocomplete="new-amount">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Initial Amount <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('amount', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <input oninput="validatecommissionrate(this)" onkeypress="return isCommissionKey(event)" maxlength="5" required value="{{old('basic_bonus', isset($bonus->basic_bonus)?$bonus->basic_bonus:'')}}" onkeypress="return isMaxamountKey(event)" type="text" name="basic_bonus" class="form-control" autocomplete="new-basic_bonus">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Basic Bonus <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('basic_bonus', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br/>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <select name="isMonthly" required id="isMonthly" class="form-control">

                                                    <option value="1" <?php if ($isMonthly  == 1) {
                                                                            echo 'selected';
                                                                       } ?>>Monthly</option>
                                                    <option value="2" <?php if ($isMonthly  == 2) {
                                                                            echo 'selected';
                                                                        } ?>>Yearly</option>

                                                </select>
                                                <span class="form-bar"></span>
                                                <label class="float-label">Is Monthly/Yearly <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('isMonthly', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <input oninput="validatecommissionrate(this)" onkeypress="return isCommissionKey(event)" maxlength="5" required value="{{old('monthly_bonus', isset($bonus->monthly_bonus)?$bonus->monthly_bonus:'')}}" onkeypress="return isMaxamountKey(event)" type="text" name="monthly_bonus" class="form-control" autocomplete="new-monthly_bonus">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Monthly/Yearly Bonus <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('monthly_bonus', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br/>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <select name="level" required id="level" class="form-control">
                                                    <option value="0" <?php if ($level == 0) {
                                                                            echo 'selected';
                                                                       } ?>>Select</option>
                                                    <option value="1" <?php if ($level  == 1) {
                                                                            echo 'selected';
                                                                       } ?>>Ring 1</option>
                                                    <option value="2" <?php if ($level  == 2) {
                                                                            echo 'selected';
                                                                        } ?>>Ring 2</option>
                                                    <option value="3" <?php if ($level  == 3) {
                                                                            echo 'selected';
                                                                        } ?>>Ring 3</option>
                                                    <option value="4" <?php if ($level  == 4) {
                                                                            echo 'selected';
                                                                        } ?>>Ring 4</option>

                                                </select>
                                                <span class="form-bar"></span>
                                                <label class="float-label">Level <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('level', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <?php date_default_timezone_set('Asia/Colombo');
                                                      $today = date('Y-m-d'); ?>
                                                <input type="date" name="date" id="date" class="form-control fill" value="{{ $date }}" autocomplete="new-date">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Date</label>
                                                <div class="text-danger-error">
                                                    {!! $errors->first('date', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <textarea class="form-control" name="description" maxlength="200">{{old('description', isset($bonus->description)?$bonus->description:'')}}</textarea>
                                                <span class="form-bar"></span>
                                                <label class="float-label">Description</label>
                                                <div class="text-danger-error">
                                                    {!! $errors->first('description', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group form-info">
                                        <button type="submit" class="btn btn-dark-teal waves-effect waves-light">Save<i class="icofont icofont-diskette"></i></button>
                                        <a onclick="cancelConfirmation(event)" class="btn btn-blue-gray waves-effect waves-light" style="color: white;" href="{{ url('admin-bonus') }}">Cancel<i class="icofont icofont-close-squared-alt"></i></a>
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
    function isMaxamountKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
    }

    function isCommissionKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
    }

    var validatecommissionrate = function(e) {
        var t = e.value;
        if (t > 100) {
            e.value = 0;
        } else {
            e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
        }
    }
</script>

@endpush