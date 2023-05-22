@extends('layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<style media="screen">
    .ui-autocomplete {
        height: 200px;
        width: 200px;
        overflow-y: scroll;
        overflow-x: scroll;
    }
</style>
<?php 
date_default_timezone_set('Asia/Colombo');
$date = date('Y-m-d'); 

$date= isset($payment->date)?$payment->date:0;
// $currency= isset($payment->currency)?$payment->currency:0;
if(old('date')){
    $date=old('date');
}
$initial = 0;
$initial = isset($payment->is_initial)?$payment->is_initial:0;
$bonus_type = isset($bonusType)?$bonusType:0;
if(old('bonus_type')){
    $bonus_type=old('bonus_type');
}
?>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Deposit Payments</h5>
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
                        <li class="breadcrumb-item"><a href="{{ route('admin-deposit') }}">Deposit Payments</a>
                        </li>
                        <li class="breadcrumb-item">Edit Payment
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
                                    <h5>Edit Deposit Payment Details</h5>
                                    <span><code>Deposit </code>payment details</span>
                                </div>
                                <div class="card-block">

                                    @if ($cerror = Session::get('error'))
                                    <div class="text-danger">
                                        Error! - {{ $cerror }}
                                    </div>
                                    <br />
                                    @endif
                                    {!! Form::open(array('route' => 'admin.deposit.update','id'=>'frmprofile','method'=>'PUT','class'=>'md-float-material form-material','enctype' => 'multipart/form-data')) !!}
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ isset($payment->id)?$payment->id:'' }}" />
                                    <input type="hidden" name="initial" value="{{ $initial }}" />                             
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <input maxlength="10" readonly required value="{{old('user_id',isset($payment->user_id)?$payment->user_id:'')}}" type="text" name="user_id" class="form-control" autocomplete="new-user_id">
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
                                    <?php if ($initial == 1) {
                                        if (isset($bonus)) {
                                    ?>
                                            <br />
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-info">
                                                        <select name="bonus_type" required id="bonus_type" class="form-control">
                                                            <option value=""></option>
                                                            @foreach($bonus as $b)
                                                                <option value="{{ $b->id }}" <?php if ($bonus_type == $b->id) {
                                                                            echo 'selected';
                                                                        } ?> >{{ $b->type }} , Ring - {{ $b->level }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="form-bar"></span>
                                                        <label class="float-label">Bonus Type <span class="required-field">*</span></label>

                                                        <div class="text-danger-error">
                                                            {!! $errors->first('bonus_type', ':message') !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php }
                                    } ?>
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
                                        <a onclick="cancelConfirmation(event)" class="btn btn-blue-gray waves-effect waves-light" style="color: white;" href="{{ url('admin-deposit') }}">Cancel<i class="icofont icofont-close-squared-alt"></i></a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    function isMaxamountKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
    }
    $('#user_id').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: 'showUser',
                dataType: "json",
                type: "POST",
                data: {
                    searchWord: request.term,
                    _token: '{{csrf_token()}}'
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        console.log('sssdsd');
                        return {
                            label: item.label_desc,
                            value: item.value,
                            id: item.value
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 1,
        change: function(event, ui) {
            if (!ui.item) {
                $("#user_id").val("");
            }
        }
    });
</script>
@endpush