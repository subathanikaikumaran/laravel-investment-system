@extends('layouts.app')

@section('content')
<?php //print_r($data); exit;
?>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Profile</h5>
                        <p class="m-b-0">Welcome to Investment System</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="">Dashboard</a>
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


                        <div class="col-xl-5 col-md-6">
                            <div class="card table-card">
                                <div class="card-header">
                                    <h5>Personal Details</h5>
                                    <div class="card-header-right">
                                        <a href="{{ route('withdraw.create') }}"><i class="fa fa fa-wrench open-card-option" style="color: #607d8b;"></i></a>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-b-0 without-header">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <h6>Name</h6>
                                                                <p class="text-muted m-b-0">
                                                                    <?php 
                                                                    $fName =isset($data['user']->first_name) ? $data['user']->first_name : "";
                                                                    $lName =isset($data['user']->last_name) ? $data['user']->last_name : "";
                                                                    $name = $fName." ".$lName;
                                                                    echo  $name; ?>
                                                                    <?php echo isset($data['user']->id) ? " , Id : " . $data['user']->id : ""; ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <h6>Email</h6>
                                                                <p class="text-muted m-b-0">
                                                                    <?php echo isset($data['user']->email) ? $data['user']->email : ""; ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <h6>Contact Number</h6>
                                                                <p class="text-muted m-b-0">
                                                                    <?php echo isset($data['user']->phone) ? $data['user']->phone : ""; ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <h6>Date of Birth</h6>
                                                                <p class="text-muted m-b-0">
                                                                    <?php echo isset($data['user']->dob) ? $data['user']->dob : ""; ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <h6>Gender</h6>
                                                                <p class="text-muted m-b-0">
                                                                    <?php echo isset($data['gender']) ? $data['gender'] : ""; ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6">
                            <div class="card proj-progress-card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6">
                                            <h6>Address Details</h6>
                                            <h6 class="m-b-30 f-w-700">
                                                Not Found
                                                <span class="text-c-red m-l-10">
                                                    0%
                                                </span>
                                            </h6>
                                            <div class="progress">
                                                <div class="progress-bar bg-c-red" style="width:0%"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6">
                                            <h6>Bank Details</h6>
                                            <h6 class="m-b-30 f-w-700">
                                                Not Found
                                                <span class="text-c-red m-l-10">
                                                    0%
                                                </span>
                                            </h6>
                                            <div class="progress">
                                                <div class="progress-bar bg-c-red" style="width:0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card proj-progress-card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6">
                                            <h6>Payment Details</h6>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="d-inline-block align-middle">
                                                                    <div class="d-inline-block">
                                                                        <?php $sts = "";
                                                                        $sts = isset($data['payActive']) ? $data['payActive'] : "";
                                                                        if ($sts = 'Active') { ?>
                                                                            <h6>Active Status</h6>
                                                                            <p class="text-muted m-b-0">
                                                                                <?php echo $sts; ?>
                                                                            </p>
                                                                            <br/>
                                                                            <?php $payDate = ""; 
                                                                            $payDate = isset($data['user']->pay_active_date) ? $data['user']->pay_active_date : "0"; ?>
                                                                            <h6>Active Date</h6>
                                                                            <p class="text-muted m-b-0">
                                                                                <?php echo  $payDate; ?>
                                                                            </p>
                                                                        <?php  } else { ?>
                                                                            <h6>Active Status</h6>
                                                                            <p class="text-muted m-b-0">
                                                                                <?php echo isset($data['user']->username) ? $data['user']->username : ""; ?>
                                                                                <?php echo isset($data['user']->id) ? " , Id : " . $data['user']->id : ""; ?>
                                                                            </p>
                                                                        <?php  } ?>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>   
                                            <?php if ($sts = 'Active') { ?>
                                                <div class="progress">
                                                    <div class="progress-bar bg-c-green" style="width:100%"></div>
                                                </div>
                                            <?php  } else { ?>
                                                <div class="progress">
                                                    <div class="progress-bar bg-c-red" style="width:0%"></div>
                                                </div>
                                            <?php  } ?>
                                        </div>
                                        <div class="col-xl-6 col-md-6">
                                            <h6>Bank Details</h6>
                                            
                                            <h6 class="m-b-30 f-w-700">
                                                Not F0und
                                                <span class="text-c-red m-l-10">
                                                    0%
                                                </span>
                                            </h6>
                                            <div class="progress">
                                                <div class="progress-bar bg-c-red" style="width:0%"></div>
                                            </div>
                                        </div>
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