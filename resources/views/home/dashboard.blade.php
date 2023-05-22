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
                                                <i class="fas fa-address-book text-c-green f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($user['totalUser']) ? $user['totalUser'] : 0; ?></h5>
                                                    <p class="text-muted m-b-0">All Users</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                   <i class="far fa-user text-c-purple f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($user['totalActive']) ? $user['totalActive'] : 0; ?></h5>
                                                    <p class="text-muted m-b-0">Team Fill User</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-sitemap text-c-green f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($team) ? $team : 0; ?></h5>
                                                    <p class="text-muted m-b-0">Team</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-handshake text-c-purple f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($individual) ? $individual : 0; ?></h5>
                                                    <p class="text-muted m-b-0">Individual</p>
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
                                                    <i class="fas fa-signal text-c-yellow f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($userStatus['totalActive']) ? $userStatus['totalActive'] : 0; ?></h5>
                                                    <p class="text-muted m-b-0">Active</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-wifi text-c-blue f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($userStatus['totalInActive']) ? $userStatus['totalInActive'] : 0; ?></h5>
                                                    <p class="text-muted m-b-0">Inactive</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-battery-full text-c-green f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($userStatus['totalPayActive']) ? $userStatus['totalPayActive'] : 0; ?></h5>
                                                    <p class="text-muted m-b-0">Pay Active</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="fas fa-battery-quarter text-c-red f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($userStatus['totalPayInActive']) ? $userStatus['totalPayInActive'] : 0; ?></h5>
                                                    <p class="text-muted m-b-0">Pay Inactive</p>
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
                                                    <h5><?php echo isset($income['totalAmount']) ? '$'.number_format($income['totalAmount'], 2, '.', ',') : 0; ?></h5>
                                                    <p class="text-muted m-b-0">Income Amount</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 p-b-20 p-t-20">
                                            <div class="row align-items-center text-center">
                                                <div class="col-4 p-r-0">
                                                    <i class="far fa-money-bill-alt text-c-green f-24"></i>
                                                </div>
                                                <div class="col-8 p-l-0">
                                                    <h5><?php echo isset($income['totalCount']) ? '$'.$income['totalCount'] : 0; ?></h5>
                                                    <p class="text-muted m-b-0">Income Count</p>
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
                                                    <h5><?php echo isset($totalBonus)?'$'.$totalBonus:0; ?></h5>
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
                                                    <h5><?php 
                                                    $balance =0;
                                                    $totalWithdraw=isset($totalWithdraw)?$totalWithdraw:0;
                                                    $totalBonus=isset($totalBonus)?$totalBonus:0;
                                                    if($totalWithdraw!=0){
                                                        $balance = $totalBonus-$totalWithdraw;
                                                    } else {
                                                        $balance = $totalBonus;
                                                    }
                                                    
                                                    echo '$'.$balance; ?></h5>
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
                                    <h5>Top performance</h5>                                   
                                </div>
                                <div class="card-block">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-b-0 without-header">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                      Not Found
                                                    </td>
                                                </tr>
                                                <!-- <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <img src="{{ asset('plugins//images/avatar-2.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                            <div class="d-inline-block">
                                                                <h6>James Alexander</h6>
                                                                <p class="text-muted m-b-0">Sales executive , EL</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <h6 class="f-w-700">$89.051<i class="fas fa-level-up-alt text-c-green m-l-10"></i></h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <img src="{{ asset('plugins//images/avatar-4.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                            <div class="d-inline-block">
                                                                <h6>Shirley Hoe</h6>
                                                                <p class="text-muted m-b-0">Sales executive , NY</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <h6 class="f-w-700">$89.051<i class="fas fa-level-up-alt text-c-green m-l-10"></i></h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-inline-block align-middle">
                                                            <img src="{{ asset('plugins//images/avatar-2.jpg')}}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                            <div class="d-inline-block">
                                                                <h6>Nick Xander</h6>
                                                                <p class="text-muted m-b-0">Sales executive , EL</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-right">
                                                        <h6 class="f-w-700">$89.051<i class="fas fa-level-up-alt text-c-green m-l-10"></i></h6>
                                                    </td>
                                                </tr> -->
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="col-xl-6 col-md-12">
                            <div class="row">
                                <!-- sale card start -->
                                 <!-- Daily -->
                                <div class="col-md-6">
                                    <div class="card bg-c-green total-card">
                                        <div class="card-block">
                                            <div class="text-left">
                                                <h4><?php echo isset($dailyIncomePayment['totalAmount']) ? '$'.number_format($dailyIncomePayment['totalAmount'], 2, '.', ',') : 0; ?></h4>

                                                <p class="m-0">Income Status Daily</p>
                                            </div>
                                            <span class="label bg-c-green value-badges"><?php echo isset($dailyIncomePayment['totalCount']) ? $dailyIncomePayment['totalCount'] : 0; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-c-red total-card">
                                        <div class="card-block">
                                            <div class="text-left">
                                                <h4><?php echo isset($dailyOutcomePayment['totalAmount']) ? '$'.number_format($dailyOutcomePayment['totalAmount'], 2, '.', ',') : 0; ?></h4>
                                                <p class="m-0">Outcome Status Daily</p>
                                            </div>
                                            <span class="label bg-c-red value-badges"><?php echo isset($dailyOutcomePayment['totalCount']) ? $dailyOutcomePayment['totalCount'] : 0; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-center order-visitor-card">
                                        <div class="card-block">
                                            <h6 class="m-b-0">New User</h6>
                                            <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>
                                                <?php echo isset($userCurrentMonth['cmNewUser']) ? $userCurrentMonth['cmNewUser'] : 0; ?>
                                            </h4>
                                            <p class="m-b-0">Current Month</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card text-center order-visitor-card">
                                        <div class="card-block">
                                            <h6 class="m-b-0">Active User</h6>
                                            <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>
                                                <?php echo isset($userCurrentMonth['cmActiveUser']) ? $userCurrentMonth['cmActiveUser'] : 0; ?>
                                            </h4>
                                            <p class="m-b-0">Current Month</p>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="card text-center order-visitor-card">
                                        <div class="card-block">
                                            <h6 class="m-b-0">Payment Active User</h6>
                                            <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>
                                                <?php echo isset($userCurrentMonth['cmPayActiveUser']) ? $userCurrentMonth['cmPayActiveUser'] :0; ?>
                                            </h4>
                                            <p class="m-b-0">Current Month</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card text-center order-visitor-card">
                                        <div class="card-block">
                                            <h6 class="m-b-0">Payment Inactive User</h6>
                                            <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-down m-r-15 text-c-red"></i>
                                                <?php echo isset($userCurrentMonth['cmPayInActiveUser']) ? $userCurrentMonth['cmPayInActiveUser'] : 0; ?>
                                            </h4>
                                            <p class="m-b-0">Current Month</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- sale card end -->
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="row">
                                <!-- Month -->
                                <div class="col-md-3">
                                    <div class="card bg-c-green total-card" style="background-color: #9c27b0;">
                                        <div class="card-block">
                                            <div class="text-left">
                                                <h4><?php echo isset($monthlyIncomePayment['totalAmount']) ? '$'.number_format($monthlyIncomePayment['totalAmount'], 2, '.', ',') : 0; ?></h4>

                                                <p class="m-0">Income Status Monthly</p>
                                            </div>
                                            <span class="label bg-c-green value-badges"  style="background-color: #9c27b0;"><?php echo isset($monthlyIncomePayment['totalCount']) ? $monthlyIncomePayment['totalCount'] : 0; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-c-red total-card"  style="background-color: #e83e8c;">
                                        <div class="card-block">
                                            <div class="text-left">
                                                <h4><?php echo isset($monthlyOutcomePayment['totalAmount']) ? '$'.number_format($monthlyOutcomePayment['totalAmount'], 2, '.', ',') : 0; ?></h4>
                                                <p class="m-0">Outcome Status Monthly</p>
                                            </div>
                                            <span class="label bg-c-red value-badges"  style="background-color: #e83e8c;"><?php echo isset($monthlyOutcomePayment['totalCount']) ? $monthlyOutcomePayment['totalCount'] : 0; ?></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Year -->
                                <div class="col-md-3">
                                    <div class="card bg-c-green total-card" style="background-color: #3d9cdd;" >
                                        <div class="card-block">
                                            <div class="text-left">
                                                <h4><?php echo isset($yearlyIncomePayment['totalAmount']) ? '$'.number_format($yearlyIncomePayment['totalAmount'], 2, '.', ',') : 0; ?></h4>

                                                <p class="m-0">Income Status Yearly</p>
                                            </div>
                                            <span class="label bg-c-green value-badges" style="background-color: #3d9cdd;" ><?php echo isset($yearlyIncomePayment['totalCount']) ? $yearlyIncomePayment['totalCount'] : 0; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-c-red total-card"  style="background-color: #00bcd4;">
                                        <div class="card-block">
                                            <div class="text-left">
                                                <h4><?php echo isset($yearlyOutcomePayment['totalAmount']) ? '$'.number_format($yearlyOutcomePayment['totalAmount'], 2, '.', ',') : 0; ?></h4>
                                                <p class="m-0">Outcome Status Yearly</p>
                                            </div>
                                            <span class="label bg-c-red value-badges"  style="background-color: #00bcd4;"><?php echo isset($yearlyOutcomePayment['totalCount']) ? $yearlyOutcomePayment['totalCount'] : 0; ?></span>
                                        </div>
                                    </div>
                                </div>


                                <!-- sale card end -->
                            </div>
                        </div>


                        <!-- <div class="col-xl-12">
                            <div class="card proj-progress-card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-xl-3 col-md-6">
                                            <h6>Successfull Task</h6>
                                            <h5 class="m-b-30 f-w-700">89%<span class="text-c-green m-l-10">+0.99%</span></h5>
                                            <div class="progress">
                                                <div class="progress-bar bg-c-green" style="width:85%"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <h6>Completed Task</h6>
                                            <h5 class="m-b-30 f-w-700">4,569<span class="text-c-red m-l-10">-0.5%</span></h5>
                                            <div class="progress">
                                                <div class="progress-bar bg-c-blue" style="width:65%"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <h6>Published Project</h6>
                                            <h5 class="m-b-30 f-w-700">532<span class="text-c-green m-l-10">+1.69%</span></h5>
                                            <div class="progress">
                                                <div class="progress-bar bg-c-red" style="width:25%"></div>
                                            </div>
                                        </div>


                                        <div class="col-xl-3 col-md-6">
                                            <h6>Ongoing Project</h6>
                                            <h5 class="m-b-30 f-w-700">365<span class="text-c-green m-l-10">+0.35%</span></h5>
                                            <div class="progress">
                                                <div class="progress-bar bg-c-yellow" style="width:45%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->



                    </div>
                </div>
            </div>
            <div id="styleSelector">
            </div>
        </div>
    </div>
</div>
@endsection