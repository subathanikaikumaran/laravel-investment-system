@extends('layouts.app')

@section('content')
<?php 
date_default_timezone_set('Asia/Colombo');
$date = date('Y-m-d'); 

$date= isset($payment->date)?$payment->date:0;
// $currency= isset($payment->currency)?$payment->currency:0;
if(old('date')){
    $date=old('date');
}

// if(old('currency')){
//     $currency=old('currency');
// }
?>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Withdraw Payments</h5>
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
                        <li class="breadcrumb-item"><a href="{{ route('admin-withdraw') }}">Withdraw Payments</a>
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
                                    <h5>Edit Withdraw Payment Details</h5>
                                    <span><code>Withdraw </code>payment details</span>
                                </div>
                                <div class="card-block">

                                    @if ($cerror = Session::get('error'))
                                    <div class="text-danger">
                                        Error! - {{ $cerror }}
                                    </div>
                                    <br />
                                    @endif
                                    {!! Form::open(array('route' => 'admin.withdraw.update','id'=>'frmprofile','method'=>'PUT','class'=>'md-float-material form-material','enctype' => 'multipart/form-data')) !!}
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ isset($payment->id)?$payment->id:'' }}" />
                                                                       
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <input maxlength="10" required value="{{old('user_id',isset($payment->user_id)?$payment->user_id:'')}}" type="text" name="user_id" class="form-control" autocomplete="new-user_id">
                                                <span class="form-bar"></span>
                                                <label class="float-label">User Name <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('user_id', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <input maxlength="10" required value="{{old('amount',isset($payment->amount)?$payment->amount:'')}}" onkeypress="return isMaxamountKey(event)" type="text" name="amount" class="form-control" autocomplete="new-amount">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Amount <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('amount', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <br/>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <select name="currency" required id="currency" class="form-control">

                                                    <option value="1" <?php //if ($currency == 1) {
                                                                            //echo 'selected';
                                                                        //} ?>>LKR</option>
                                                    <option value="2" <?php //if ($currency == 2) {
                                                                           // echo 'selected';
                                                                       // } ?>>USD</option>
                                                    <option value="3" <?php //if ($currency == 3) {
                                                                            //echo 'selected';
                                                                       // } ?>>GBP</option>
                                                    <option value="4" <?php //if ($currency == 4) {
                                                                            //echo 'selected';
                                                                        //} ?>>EUR</option>

                                                </select>
                                                <span class="form-bar"></span>
                                                <label class="float-label">Currency <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('amount', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                
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
                                                <textarea class="form-control" name="description" maxlength="200">{{old('description',isset($payment->description)?$payment->description:'')}}</textarea>
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
                                        <a onclick="cancelConfirmation(event)" class="btn btn-blue-gray waves-effect waves-light" style="color: white;" href="{{ url('admin-withdraw') }}">Cancel<i class="icofont icofont-close-squared-alt"></i></a>
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
</script>
@endpush