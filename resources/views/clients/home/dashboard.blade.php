@extends('layouts.app')

@section('content')

<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard</h5>
                        <p class="m-b-0">Welcome to Investment System</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Dashboard</a>
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

                        <div class="col-xl-4 col-md-12">
                            <div class="card mat-stat-card">
                                <div class="card-block">
                                    <div class="row align-items-center b-b-default">
                                        <div class="col-sm-6 b-r-default p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-share-alt text-c-purple f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($data['invidedBy']) ? $data['invidedBy'] : "My Self"; ?></h5>
                                                    <p class="text-muted m-b-0">Invited By</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-sitemap text-c-green f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($data['myTeamCount']) ? $data['myTeamCount'] : "0"; ?></h5>
                                                    <p class="text-muted m-b-0">My Team</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-signal text-c-red f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($data['payActive']) ? $data['payActive'] : "Inactive"; ?></h5>
                                                    <p class="text-muted m-b-0">Current Status</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-wifi text-c-blue f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($data['payActiveFrom']) ? $data['payActiveFrom'] : "0"; ?></h5>
                                                    <p class="text-muted m-b-0">Active From</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-md-12">
                            <div class="card mat-stat-card">
                                <div class="card-block">
                                    <div class="row align-items-center b-b-default">
                                        <div class="col-sm-6 b-r-default p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="far fa-user text-c-purple f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($data['currentLevel']) ? $data['currentLevel'] : "0"; ?></h5>
                                                    <p class="text-muted m-b-0">Current Level</p>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-volume-down text-c-green f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($data['payLast']) ? $data['payLast'] : "0"; ?></h5>
                                                    <p class="text-muted m-b-0">Last Payment</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="far fa-file-alt text-c-red f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($data['isBonusActive']) ? $data['isBonusActive'] : "-"; ?></h5>
                                                    <p class="text-muted m-b-0">Bonus Status</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="far fa-envelope-open text-c-blue f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($data['bonusFrom']) ? $data['bonusFrom'] : "0"; ?></h5>
                                                    <p class="text-muted m-b-0">Bonus From</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-md-12">
                            <div class="card mat-stat-card">
                                <div class="card-block">
                                    <div class="row align-items-center b-b-default">
                                        <div class="col-sm-6 b-r-default p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-money-bill-alt text-c-purple f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($data['totalPay']) ? '$'.number_format($data['totalPay'], 2, '.', ',') : 0; ?></h5>
                                                    <p class="text-muted m-b-0">Initial Amount</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="far fa-money-bill-alt text-c-green f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($data['totalWithdraw']) ? '$'.$data['totalWithdraw'] : 0; ?></h5>
                                                    <p class="text-muted m-b-0">Total Withdraw</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-shopping-bag text-c-red f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($data['totalBonus']) ? '$'.$data['totalBonus'] : 0; ?></h5>
                                                    <p class="text-muted m-b-0">Total Bonus</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fab fa-bitcoin text-c-blue f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($data['balanceBonus']) ? '$'.$data['balanceBonus'] : 0; ?></h5>
                                                    <p class="text-muted m-b-0">Balance Bonus</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- <div class="col-xl-4 col-md-12">
                            <div class="card mat-clr-stat-card text-white green ">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-3 text-center bg-c-green">
                                            <i class="fas fa-star mat-icon f-24"></i>
                                        </div>
                                        <div class="col-9 cst-cont">
                                            <h5>4000+</h5>
                                            <p class="m-b-0">Ratings Received</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-12">
                            <div class="card mat-clr-stat-card text-white blue">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-3 text-center bg-c-blue">
                                            <i class="fas fa-trophy mat-icon f-24"></i>
                                        </div>
                                        <div class="col-9 cst-cont">
                                            <h5>17</h5>
                                            <p class="m-b-0">Achievements</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->






                        <div class="col-xl-6 col-md-12">
                            <div class="card table-card">
                                <div class="card-header">
                                    <h5>My Team - <?php if (isset($data['myTeamCount'])) {
                                                        echo $data['myTeamCount'] . "/6";
                                                    } ?></h5>
                                    <div class="card-header-right">
                                    </div>
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
                                                                        <h6><?php echo isset($value['name']) ? $value['name'] : ""; ?> 
                                                                            <!-- , <span style="font-size: small; "> -->
                                                                                <?php // echo isset($value['id']) ? ' Id : ' . $value['id'] : ""; ?>
                                                                            <!-- </span> -->
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
                                                                    <p class="text-muted m-b-0">There are no member under me.</p>
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
            </div>
            <div id="styleSelector">
            </div>
        </div>
    </div>
</div>
@endsection