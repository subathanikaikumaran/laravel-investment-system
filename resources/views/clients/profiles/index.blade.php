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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
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
                                                <a class="dropdown-item waves-light waves-effect" href="{{ url('profile-user-edit') }}">Edit Profile</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-light waves-effect" href="{{ url('profile-user-changepwd') }}">Change Password</a>
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

                                                                <p class="text-muted m-b-0"><?php
                                                                    $title = isset($data['user']->title) ? $data['user']->title : ""; 
                                                                    $fName = isset($data['user']->first_name) ? $data['user']->first_name : "";
                                                                    $lName = isset($data['user']->last_name) ? $data['user']->last_name : "";
                                                                    $name =  $title. " " . $fName . " " . $lName;
                                                                    echo  $name; ?></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>



                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <h6>Email</h6>
                                                                <p class="text-muted m-b-0"><?php echo isset($data['user']->email) ? "Email : " . $data['user']->email : ""; ?></p>

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <h6>Phone </h6>
                                                                <p class="text-muted m-b-0"><?php echo isset($data['user']->phone) ? 'Phone : ' . $data['user']->phone : 'Phone : -'; ?></p>

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <h6>NIC / Passport</h6>
                                                                <p class="text-muted m-b-0"><?php echo isset($data['user']->nic) ?  $data['user']->nic : ' -'; ?></p>
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
                                                                <h6>
                                                                    Profile currency

                                                                </h6>
                                                                <p class="text-muted m-b-0"><?php echo isset($data['currency']) ? $data['currency'] : "-"; ?></p>
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

                                                                <p class="text-muted m-b-0"><?php echo isset($data['user']->dob) ? 'Date of Birth : ' . date("d-M-Y", strtotime($data['user']->dob)) : "Date of Birth : -";  ?></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <div class="d-inline-block">
                                                                <h6 class="text-success">Share Link</h6>
                                                                <p class="text-muted m-b-0">
                                                                    <?php $link = isset($data['shareUrl']) ? $data['shareUrl'] : ""; ?>
                                                                    <a href="<?php echo $link; ?>" class="text-primary"><?php echo $link; ?>
                                                                    </a>
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
                            <div class="row">
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
                                                                            $payDate = isset($data['payActiveFrom']) ? $data['payActiveFrom'] : "0"; ?>


                                                                            <h6>Active Date</h6>
                                                                            <p class="text-muted m-b-0">
                                                                                <?php echo $payDate; ?>
                                                                            </p>

                                                                            <br />
                                                                            <h6>Payment
                                                                                <!-- <p class="text-muted m-b-0"> -->
                                                                                <?php echo isset($data['currentLevel']) ? ' Level : ' . $data['currentLevel'] : 'Level : -'; ?>
                                                                            </h6>
                                                                            <p class="text-muted m-b-0">
                                                                                <?php echo isset($data['payLast']) ? 'Last Payment : ' . $data['payLast'] : "Last Payment : 0"; ?></p>
                                                                            </p>

                                                                            <br />
                                                                            <h6>Bonus Active Status</h6>
                                                                            <!-- isBonusActive -->
                                                                            <?php $isBonusActive = isset($data['isBonusActive']) ? $data['isBonusActive'] : 0;
                                                                            if ($isBonusActive == 'Active') { ?>

                                                                                <p class="text-muted m-b-0">
                                                                                    Active <i class="fas fa-level-up-alt text-c-green m-l-10"></i>
                                                                                </p>

                                                                            <?php } else { ?>
                                                                                <p class="text-muted m-b-0">
                                                                                    Inactive <i class="fas fa-level-down-alt text-c-red m-l-10"></i>
                                                                                </p>
                                                                            <?php } ?>



                                                                            <br />
                                                                            <?php $bonusFrom = "";
                                                                            $bonusFrom = isset($data['bonusFrom']) ? $data['bonusFrom'] : "0"; ?>


                                                                            <h6>Bonus Active Date</h6>
                                                                            <p class="text-muted m-b-0">
                                                                                <?php echo $bonusFrom; ?>
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