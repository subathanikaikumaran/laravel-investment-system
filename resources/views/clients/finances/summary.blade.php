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
                        <h5 class="m-b-10">Finances Wallet</h5>
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
                    @include('layouts.notification')
                        <div class="col-xl-6 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-b-10">Payment Details</h5>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-b-0 without-header">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <img src="{{ asset('plugins//images/balance.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                            <div class="d-inline-block">
                                                                <h6>Initial Payment</h6>
                                                                <p class="text-muted m-b-0">1st Payment
                                                                    <i class="fas fa-paper-plane text-c-blue m-l-10"></i>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <h6 class="f-w-700">
                                                            <?php
                                                            if (isset($mypayment['deposite'])) {
                                                                echo '$ ' . number_format($mypayment['deposite'], 2, ".", ",");
                                                            } else {
                                                                echo '$ 0.00';
                                                            } ?>
                                                            <i class="fas fa-level-up-alt text-c-green m-l-10"></i>
                                                        </h6>
                                                        <p class="text-muted m-b-0">Total</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <img src="{{ asset('plugins//images/bonus.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                            <div class="d-inline-block">
                                                                <h6>Earned Bonus</h6>
                                                                <p class="text-muted m-b-0">Bonus
                                                                    <i class="fas fa-sync text-c-green m-l-10"></i>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <h6 class="f-w-700">
                                                            <?php
                                                            if (isset($mypayment['bonus'])) {
                                                                echo '$ ' . number_format($mypayment['bonus'], 2, ".", ",");
                                                            } else {
                                                                echo '$ 0.00';
                                                            } ?>
                                                            <i class="fas fa-level-up-alt text-c-green m-l-10"></i>
                                                        </h6>
                                                        <p class="text-muted m-b-0">Available</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <img src="{{ asset('plugins//images/total.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                            <div class="d-inline-block">
                                                                <h6>Any Other Bonus</h6>
                                                                <p class="text-muted m-b-0">
                                                                    <?php
                                                                    if (isset($mypayment['totalBalance'])) {
                                                                        echo '$ ' . number_format($mypayment['totalBalance'], 2, ".", ",");
                                                                    } else {
                                                                        echo '$ 0.00';
                                                                    } ?>
                                                                    <i class="fas fa-level-up-alt text-c-green m-l-10"></i>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <h6 class="f-w-700">
                                                            <?php
                                                            if (isset($mypayment['availableBalance'])) {
                                                                echo '$ ' . number_format($mypayment['availableBalance'], 2, ".", ",");
                                                            } else {
                                                                echo '$ 0.00 ';
                                                            } ?>
                                                            <i class="fas fa-level-up-alt text-c-green m-l-10"></i>
                                                        </h6>
                                                        <p class="text-muted m-b-0">Available</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <img src="{{ asset('plugins//images/withdraw.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                            <div class="d-inline-block">
                                                                <h6>Total Withdraw</h6>
                                                                <p class="text-muted m-b-0">
                                                                    <?php
                                                                    if (isset($mypayment['withdraw'])) {
                                                                        echo '$ ' . number_format($mypayment['withdraw'], 2, ".", ",");
                                                                    } else {
                                                                        echo '$ 0.00 ';
                                                                    } ?> <i class="fas fa-level-down-alt text-c-red m-l-10"></i> </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <h6 class="f-w-700">
                                                            <?php
                                                            if (isset($mypayment['availablewithdraw'])) {
                                                                echo '$ ' . number_format($mypayment['availablewithdraw'], 2, ".", ",");
                                                            } else {
                                                                echo '$ 0.00';
                                                            } ?><i class="fas fa-level-up-alt text-c-red m-l-10"></i></h6>
                                                        <p class="text-muted m-b-0">Available</p>
                                                    </td>
                                                </tr>


                                                <?php
                                                if (isset($mypayment['availablewithdraw']) && $mypayment['availablewithdraw'] > 50) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <div class="d-inline-block align-middle">
                                                                <div class="d-inline-block">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <a href="{{ route('withdraw.create') }}">
                                                                <button class="btn btn-dark-teal waves-effect waves-light">Withraw Request</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>


                                            </tbody>
                                        </table>

                                    </div>
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