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
                        <h5 class="m-b-10">Customer Profile</h5>
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
                        <div class="col-xl-6 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="m-b-10">Personal Details</h5>
                                    <span>All my <code>personal </code>details</span>
                                    <div class="card-header-right">
                                        <div class="dropdown-primary dropdown open">
                                            <button class="btn btn-floating btn-dark-teal btn-sm" type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa fa-wrench open-card-option"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                                <a class="dropdown-item waves-light waves-effect" href="{{ url('customer-deposit-create/'.$id) }}">Add Payment</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-light waves-effect" href="{{ url('admin-deposit/'.$id) }}">Payment History</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-light waves-effect" href="{{ url('client-user/changepwd/'.$id) }}">Change Password</a>
                                            </div>
                                        </div>
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
                                                                <h6><?php echo isset($data['user']->first_name) ? $data['user']->first_name : "";                                                                    ?> ,
                                                                    <span style="font-size: small; ">
                                                                        <?php echo isset($data['user']->id) ? ' Id : ' . $data['user']->id : ""; ?>
                                                                    </span>
                                                                </h6>

                                                                <p class="text-muted m-b-0"><?php $fName = isset($data['user']->first_name) ? $data['user']->first_name : "";
                                                                                            $lName = isset($data['user']->last_name) ? $data['user']->last_name : "";
                                                                                            $name = $fName . " " . $lName;
                                                                                            echo  $name; ?></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <h6>Contact Details
                                                                </h6>

                                                                <p class="text-muted m-b-0"><?php echo isset($data['user']->email) ? 'Email : ' . $data['user']->email : 'Email : -'; ?></p>
                                                                <p class="text-muted m-b-0"><?php echo isset($data['user']->phone) ? 'Phone : ' . $data['user']->phone : 'Phone : -'; ?></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <h6>NIC / Passport
                                                                </h6>
                                                                <p class="text-muted m-b-0"><?php echo isset($data['user']->nic) ?  $data['user']->nic : '-'; ?></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>


                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <h6>
                                                                    Account active status
                                                                </h6>
                                                                <p class="text-muted m-b-0">
                                                                    <?php if (isset($data['user']->active) && $data['user']->active == 1) { ?>
                                                                        Active <i class="fas fa-level-up-alt text-c-green m-l-10"></i>
                                                                    <?php } else { ?>
                                                                        Inactive <i class="fas fa-level-down-alt text-c-red m-l-10"></i>
                                                                    <?php } ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <h6><?php echo isset($data['gender']) ? 'Gender : ' . $data['gender'] : 'Gender : '; ?>
                                                                </h6>

                                                                <p class="text-muted m-b-0"><?php echo isset($data['user']->dob) ? 'DOB : ' . date("d-M-Y", strtotime($data['user']->dob)) : "DOB : -";  ?></p>
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

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Questions & Answers</h5>
                                </div>
                                <div class="card-block accordion-block">
                                    <div id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="accordion-panel">
                                            <div class="accordion-heading" role="tab" id="headingOne">
                                                <h3 class="card-title accordion-title">
                                                    <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                        Questions 1
                                                    </a>
                                                </h3>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingOne" style="">
                                                <div class="accordion-content accordion-desc">
                                                    <p>
                                                        <?php echo isset($questions[0]['description']) ? $questions[0]['description'] : "";
                                                        $id = 0;
                                                        $ans = "";
                                                        $id = isset($questions[0]['id']) ? $questions[0]['id'] : 0;
                                                        $ans = isset($answers[$id]) ? $answers[$id] : "";

                                                        ?>
                                                        <br />
                                                        <br />
                                                        Answer :
                                                        <?php echo isset($ans) ? $ans : ""; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-panel">
                                            <div class="accordion-heading" role="tab" id="headingTwo">
                                                <h3 class="card-title accordion-title">
                                                    <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Questions 2
                                                    </a>
                                                </h3>
                                            </div>
                                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" style="">
                                                <div class="accordion-content accordion-desc">
                                                    <p>
                                                        <?php echo isset($questions[1]['description']) ? $questions[1]['description'] : "";
                                                        $id = 0;
                                                        $ans = "";
                                                        $id = isset($questions[1]['id']) ? $questions[1]['id'] : 0;
                                                        $ans = isset($answers[$id]) ? $answers[$id] : "";

                                                        ?>
                                                        <br />
                                                        <br />
                                                        Answer :
                                                        <?php echo isset($ans) ? $ans : ""; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-panel">
                                            <div class=" accordion-heading" role="tab" id="headingThree">
                                                <h3 class="card-title accordion-title">
                                                    <a class="accordion-msg waves-effect waves-dark scale_active collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        Questions 3
                                                    </a>
                                                </h3>
                                            </div>
                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" style="">
                                                <div class="accordion-content accordion-desc">
                                                    <p>
                                                        <?php echo isset($questions[2]['description']) ? $questions[2]['description'] : "";
                                                        $id = 0;
                                                        $ans = "";
                                                        $id = isset($questions[2]['id']) ? $questions[2]['id'] : 0;
                                                        $ans = isset($answers[$id]) ? $answers[$id] : "";

                                                        ?>
                                                        <br />
                                                        <br />
                                                        Answer :
                                                        <?php echo isset($ans) ? $ans : ""; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="col-xl-6 col-md-6">
                            <div class="row">
                                <div class="col-xl-12 col-md-12">
                                    <div class="card proj-progress-card">
                                        <div class="card-block">

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

                                                                        if ($sts == 'Active') { ?>
                                                                            <h6>Active Status</h6>

                                                                            <p class="text-muted m-b-0">
                                                                                Active <i class="fas fa-level-up-alt text-c-green m-l-10"></i>
                                                                            </p>

                                                                            <br />
                                                                            <?php $payDate = "";
                                                                            $payDate = isset($data['user']->pay_active_date) ? $data['user']->pay_active_date : ""; ?>


                                                                            <h6>Active Date</h6>
                                                                            <p class="text-muted m-b-0">
                                                                                <?php echo date("d-M-Y", strtotime($payDate)); ?>
                                                                            </p>

                                                                            <br />

                                                                            <h6>Profile currency
                                                                            </h6>
                                                                            <p class="text-muted m-b-0">
                                                                                <?php echo isset($data['currency']) ? $data['currency'] : ""; ?></p>
                                                                            </p>
                                                                            <br />
                                                                            <h6>Payment
                                                                                <!-- <p class="text-muted m-b-0"> -->
                                                                                <?php echo isset($data['currentLevel']) ? ' Level : ' . $data['currentLevel'] : 'Level : -'; ?>
                                                                            </h6>
                                                                            <p class="text-muted m-b-0">
                                                                                <?php echo isset($data['payLast']) ? 'Last Payment : ' . date("d-M-Y", strtotime($data['payLast'])) : "Last Payment : 0"; ?></p>
                                                                            </p>
                                                                        <?php
                                                                            // Inactive
                                                                        } else { ?>
                                                                            <h6>Active Status</h6>
                                                                            <p class="text-muted m-b-0">
                                                                                Inactive <i class="fas fa-level-down-alt text-c-red m-l-10"></i>
                                                                            </p>
                                                                        <?php  } ?>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php if ($sts == 'Active') { ?>
                                                <div class="progress">
                                                    <div class="progress-bar bg-c-green" style="width:100%"></div>
                                                </div>
                                            <?php  } else { ?>
                                                <div class="progress">
                                                    <div class="progress-bar bg-c-red" style="width:50%"></div>
                                                </div>
                                            <?php  } ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12">
                                    <div class="card proj-progress-card">
                                        <div class="card-block">

                                            <h6>Address Details</h6>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="d-inline-block align-middle">
                                                                    <div class="d-inline-block">

                                                                        <h6>Address Street 1</h6>
                                                                        <p class="text-muted m-b-0">
                                                                            <?php echo isset($data['user']->address_street_1) ?  $data['user']->address_street_1 : "-"; ?></p>
                                                                        </p>

                                                                        <h6>Address Street 2</h6>
                                                                        <p class="text-muted m-b-0">
                                                                            <?php echo isset($data['user']->address_street_2) ?  $data['user']->address_street_2 : "-"; ?></p>
                                                                        </p>

                                                                        <h6>Town / City</h6>
                                                                        <p class="text-muted m-b-0">
                                                                            <?php echo isset($data['user']->city) ?  $data['user']->city : "-"; ?></p>
                                                                        </p>


                                                                        <h6>Province</h6>
                                                                        <p class="text-muted m-b-0">
                                                                            <?php echo isset($data['user']->province) ?  $data['user']->province : "-"; ?></p>
                                                                        </p>


                                                                        <h6>Country</h6>
                                                                        <p class="text-muted m-b-0">
                                                                            <?php echo isset($data['user']->country) ?  $data['user']->country : "-"; ?></p>
                                                                        </p>

                                                                        <h6>Postal Code / Zip Code</h6>
                                                                        <p class="text-muted m-b-0">
                                                                            <?php echo isset($data['user']->postalcode) ?  $data['user']->postalcode : "-"; ?></p>
                                                                        </p>


                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="progress">
                                                <?php if ((isset($data['user']->address_street_1) && $data['user']->address_street_1 != "") &&
                                                    (isset($data['user']->city) && $data['user']->city != "") &&
                                                    (isset($data['user']->province) && $data['user']->province != "") &&
                                                    (isset($data['user']->country) && $data['user']->country != "") &&
                                                    (isset($data['user']->postalcode) && $data['user']->postalcode != "")
                                                ) { ?>
                                                    <div class="progress-bar bg-c-green" style="width:100%"></div>
                                                <?php } else { ?>
                                                    <div class="progress-bar bg-c-red" style="width:75%"></div>
                                                <?php }  ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>


                            <div class="row">
                                <div class="col-xl-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="m-b-10">Team Details</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="table-responsive">
                                                <table class="table table-hover m-b-0 without-header">
                                                    <tbody>
                                                        <?php
                                                        if (isset($data['myTeam']) && !empty($data['myTeam'])) {
                                                            foreach ($data['myTeam'] as $key => $value) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-inline-block align-middle">
                                                                            <?php if (isset($value['gender']) && $value['gender'] == 1) { ?>
                                                                                <img src="{{ asset('plugins//images/avatar-2.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                                            <?php } else { ?>
                                                                                <img src="{{ asset('plugins//images/avatar-4.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                                            <?php } ?>
                                                                            <div class="d-inline-block">
                                                                                <h6><?php echo isset($value['name']) ? $value['name'] : ""; ?> ,
                                                                                    <span style="font-size: small; ">
                                                                                        <?php echo isset($value['id']) ? ' Id : ' . $value['id'] : ""; ?>
                                                                                    </span>
                                                                                </h6>

                                                                                <p class="text-muted m-b-0"><?php echo isset($value['phone']) ? 'Phone : ' . $value['phone'] : ""; ?></p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <h6 class="f-w-700">
                                                                            <?php if (isset($value['payActive']) && $value['payActive'] == "Active") { ?>
                                                                                <?= $value['payActive'] ?><i class="fas fa-level-up-alt text-c-green m-l-10"></i>
                                                                            <?php } else { ?>
                                                                                <?= $value['payActive'] ?><i class="fas fa-level-down-alt text-c-red m-l-10"></i>
                                                                            <?php } ?>
                                                                        </h6>
                                                                        <p class="text-muted m-b-0"><?php echo isset($value['regAt']) ? 'Reg : ' . $value['regAt'] : ""; ?></p>
                                                                    </td>
                                                                </tr>

                                                            <?php }
                                                        } else { ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="d-inline-block align-middle">
                                                                        <!-- <img src="{{ asset('plugins//images/avatar-4.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15"> -->
                                                                        <div class="d-inline-block">
                                                                            <h6>Not Found</h6>
                                                                            <p class="text-muted m-b-0">There are no member under this customer.</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                        <?php }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>





                        <div class="col-xl-6 col-md-6">
                            <div class="row">




                                <div class="col-xl-12 col-md-12">


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
                                                                        <h6>Basic Balance</h6>
                                                                        <p class="text-muted m-b-0">Payment
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
                                                                        <h6>Total Balance</h6>
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
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>



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
@endsection