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
                        <h5 class="m-b-10">Temp Discount Setting</h5>
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
                                    <h5>Temp Discount Setting</h5>
                                    <span>This setting created for <code>Temp Usage </code></span>
                                </div>
                                <div class="card-block">

                                    @if ($cerror = Session::get('error'))
                                    <div class="text-danger">
                                        Error! - {{ $cerror }}
                                    </div>
                                    <br />
                                    @endif
                                    {!! Form::open(array('route' => 'clientdiscount.user.update','id'=>'frmprofile','method'=>'PUT','class'=>'md-float-material form-material','enctype' => 'multipart/form-data')) !!}
                                    @csrf
                                    <br />
                                    <input type="hidden" name="id" id="id" value="{{ isset($id)?$id:'' }}" />
                                    
                                    <div class="form-group form-info">
                                        <button type="submit" class="btn btn-dark-teal waves-effect waves-light">Add Other Bonus<i class="icofont icofont-diskette"></i></button>
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