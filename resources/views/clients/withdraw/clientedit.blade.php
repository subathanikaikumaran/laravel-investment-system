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
                        <h5 class="m-b-10">Withdraw Request Management</h5>
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
                        <li class="breadcrumb-item"><a href="{{ route('finance-summary') }}">Finance</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('withdraw') }}">Withdraw</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">




                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Edit Withdraw Request</h5>
                                </div>
                                <div class="card-block">

                                    @if ($cerror = Session::get('error'))
                                    <div class="text-danger">
                                        Error! - {{ $cerror }}
                                    </div>
                                    <br />
                                    @endif
                                    {!! Form::open(array('route' => 'withdraw.update','id'=>'frmprofile','method'=>'PUT','class'=>'md-float-material form-material','enctype' => 'multipart/form-data')) !!}
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ isset($withdraw->id)?$withdraw->id:'' }}" />
                                    <input type="hidden" name="old_amount" id="old_amount" value="{{ isset($withdraw->amount)?$withdraw->amount:'' }}" />
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <input maxlength="10" required value="{{old('amount', isset($withdraw->amount)?$withdraw->amount:'')}}" onkeypress="return isMaxamountKey(event)" type="text" name="amount" class="form-control">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Amount</label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('amount', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    


                                    <div class="row">
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-dark-teal waves-effect waves-light">Send<i class="icofont icofont-diskette"></i></button>
                                            <a onclick="cancelConfirmation(event)" class="btn btn-blue-gray waves-effect waves-light" style="color: white;" href="{{ url('withdraw') }}">Cancel<i class="icofont icofont-close-squared-alt"></i></a>
                                        </div>
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