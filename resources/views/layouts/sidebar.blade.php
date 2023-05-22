<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="">
            <div class="main-menu-header">
                <?php
                if (Auth::user()->is_admin == 2) {
                    $gender = Auth::user()->gender;
                    if ($gender == 1) { // female?>
                        <img class="img-80 img-radius" src="{{ asset('plugins/images/fm.jpg')}}" alt="User-Profile-Image">
                    <?php } else if ($gender == 2) { //male ?>
                        <img class="img-80 img-radius" src="{{ asset('plugins/images/male.jpg')}}" alt="User-Profile-Image">
                    <?php  } else { ?>
                        <img class="img-80 img-radius" src="{{ asset('plugins/images/male.jpg')}}" alt="User-Profile-Image">
                    <?php  } ?>
                <?php  } else { ?>
                    <img class="img-80 img-radius" src="{{ asset('plugins/images/male.jpg')}}" alt="User-Profile-Image">
                <?php  }
                ?>

                <div class="user-details">
                    <span id="more-details"><?php $login = "Admin";
                                            if (Auth::user()->first_name) {
                                                $login = Auth::user()->first_name;
                                            }
                                            echo $login;
                                            ?></span>
                </div>
            </div>
        </div>

        <?php $isAdmin = 2;
        $isAdmin = Auth::user()->is_admin;
        if ($isAdmin == 2) {
        ?>


            <div class="pcoded-navigation-label">Dashboard</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu {{ Request::is('dashboard')  ? ' active pcoded-trigger' : '' }}">
                    <a href="{{ url('dashboard') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                        <span class="pcoded-mtext">Dashboard</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
            <div class="pcoded-navigation-label">Finance Management</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu  {{ Request::is('finance-summary')  ? ' active pcoded-trigger' : '' }}  OR {{ Request::is('payment')  ? ' active pcoded-trigger' : '' }}  OR {{ Request::is('withdraw')  ? ' active pcoded-trigger' : '' }}  OR {{ Request::is('withdraw-create')  ? ' active pcoded-trigger' : '' }}  OR {{ Request::is('withdraw/*')  ? ' active pcoded-trigger' : '' }}">
                    <a href="javascript:void(0)" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-bar-chart-alt"></i><b>A</b></span>
                        <span class="pcoded-mtext">Finance</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ Request::is('finance-summary')  ? 'active' : '' }} ">
                            <a href="{{ url('finance-summary') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Wallet</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ Request::is('payment')  ? 'active' : '' }} ">
                            <a href="{{ url('payment') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Payment History </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ Request::is('withdraw')  ? 'active' : '' }} OR {{ Request::is('withdraw-save')  ? 'active' : '' }} OR  {{ Request::is('withdraw-create')  ? 'active' : '' }} OR {{ Request::is('withdraw/*')  ? 'active' : '' }} ">
                            <a href="{{ url('withdraw') }}" class="waves-effect waves-dark">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Withdraw Request</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="pcoded-navigation-label">Profile Management</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="pcoded-hasmenu {{ Request::is('profile')  ? ' active pcoded-trigger' : '' }} 
                OR {{ Request::is('profile-user-changepwd')  ? ' active pcoded-trigger' : '' }}
                OR {{ Request::is('profile-user-edit')  ? ' active pcoded-trigger' : '' }}
                ">


                    <a href="{{ url('profile') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                        <span class="pcoded-mtext">Profile</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
    </div>

<?php } else { ?>
    <div class="pcoded-navigation-label">Dashboard</div>
    <ul class="pcoded-item pcoded-left-item">
        <li class="pcoded-hasmenu {{ Request::is('home')  ? ' active pcoded-trigger' : '' }}">
            <a href="{{ url('home') }}" class="waves-effect waves-dark">
                <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                <span class="pcoded-mtext">Dashboard</span>
                <span class="pcoded-mcaret"></span>
            </a>
        </li>
    </ul>
    <div class="pcoded-navigation-label">Finance Management</div>
    <ul class="pcoded-item pcoded-left-item">
        <li class="pcoded-hasmenu  {{ Request::is('admin-deposit')  ? ' active pcoded-trigger' : '' }}  
            OR {{ Request::is('admin-deposit-create')  ? ' active pcoded-trigger' : '' }}  
            OR {{ Request::is('admin-deposit/edit/*')  ? ' active pcoded-trigger' : '' }} 
            OR {{ Request::is('customer-deposit-create/*')  ? ' active pcoded-trigger' : '' }}
            OR {{ Request::is('admin-deposit/*')  ? ' active pcoded-trigger' : '' }} 
            OR {{ Request::is('admin-initial-create')  ? ' active pcoded-trigger' : '' }}
            OR {{ Request::is('admin-customerinitial-create/*')  ? ' active pcoded-trigger' : '' }}
            
           
            OR {{ Request::is('admin-withdraw')  ? ' active pcoded-trigger' : '' }}  
            OR {{ Request::is('admin-withdraw-create')  ? ' active pcoded-trigger' : '' }}
            OR {{ Request::is('admin-withdraw/edit/*')  ? ' active pcoded-trigger' : '' }}

            OR {{ Request::is('manage-payreq')  ? ' active pcoded-trigger' : '' }}
            OR {{ Request::is('manage-payreq-create')  ? ' active pcoded-trigger' : '' }}
            OR {{ Request::is('manage-payreq/edit/*')  ? ' active pcoded-trigger' : '' }}

            OR {{ Request::is('admin-bonus')  ? ' active pcoded-trigger' : '' }}
            OR {{ Request::is('admin-bonus-create')  ? ' active pcoded-trigger' : '' }}
            OR {{ Request::is('admin-bonus/edit/*')  ? ' active pcoded-trigger' : '' }}
            
            
            ">
            <a href="javascript:void(0)" class="waves-effect waves-dark">
                <span class="pcoded-micon"><i class="ti-bar-chart-alt"></i><b>A</b></span>
                <span class="pcoded-mtext">Finance</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">


                <li class="{{ Request::is('admin-deposit')  ? 'active' : '' }}
                    OR {{ Request::is('admin-deposit-create')  ? 'active' : '' }} 
                    OR {{ Request::is('admin-deposit/edit/*')  ? 'active' : '' }}
                    OR {{ Request::is('customer-deposit-create/*')  ? 'active' : '' }} 
                    OR {{ Request::is('admin-deposit/*')  ? 'active' : '' }}
                    OR {{ Request::is('admin-initial-create')  ? 'active' : '' }} 
                    OR {{ Request::is('admin-customerinitial-create/*')  ? 'active' : '' }} ">
                    <a href="{{ url('admin-deposit') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Deposit Payments</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ Request::is('admin-withdraw')  ? 'active' : '' }}
                        OR {{ Request::is('admin-withdraw-create')  ? 'active' : '' }} 
                        OR {{ Request::is('admin-withdraw/edit/*')  ? 'active' : '' }} ">
                    <a href="{{ url('admin-withdraw') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Withdraw Payments</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ Request::is('manage-payreq')  ? 'active' : '' }}  
                        OR {{ Request::is('manage-payreq-create')  ? 'active' : '' }} 
                        OR {{ Request::is('manage-payreq/edit/*')  ? 'active' : '' }} ">
                    <a href="{{ url('manage-payreq') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Manage Requests </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

                <li class="{{ Request::is('admin-bonus')  ? 'active' : '' }}
                    OR {{ Request::is('admin-bonus-create')  ? 'active' : '' }} 
                    OR {{ Request::is('admin-bonus/edit/*')  ? 'active' : '' }} ">
                    <a href="{{ url('admin-bonus') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Bonus Details</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

            </ul>
        </li>
    </ul>

    <div class="pcoded-navigation-label">User Management</div>
    <ul class="pcoded-item pcoded-left-item">
        <li class="pcoded-hasmenu  {{ Request::is('client-user')  ? ' active pcoded-trigger' : '' }}  
            OR {{ Request::is('client-user-create')  ? ' active pcoded-trigger' : '' }} 
            OR {{ Request::is('client-user/edit/*')  ? ' active pcoded-trigger' : '' }} 
            OR {{ Request::is('client-user/view/*')  ? ' active pcoded-trigger' : '' }}
            OR {{ Request::is('client-user/changepwd/*')  ? ' active pcoded-trigger' : '' }}
            
            ">
            <a href="{{ url('client-user') }}" class="waves-effect waves-dark">
                <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                <span class="pcoded-mtext">Customers</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <!-- <ul class="pcoded-submenu">
            <li class="{{ Request::is('client-user')  ? 'active' : '' }}
                    OR {{ Request::is('client-user-create')  ? 'active' : '' }} 
                    OR {{ Request::is('client-user/edit/*')  ? 'active' : '' }}
                    OR {{ Request::is('client-user/view/*')  ? 'active' : '' }}
                    OR {{ Request::is('client-user/changepwd/*')  ? 'active' : '' }}
                    ">
                    <a href="{{ url('client-user') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Customer Accounts</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul> -->
        </li>

        <li class="pcoded-hasmenu  {{ Request::is('admin-user')  ? ' active pcoded-trigger' : '' }}  
            OR {{ Request::is('admin-user-create')  ? ' active pcoded-trigger' : '' }} 
            OR {{ Request::is('admin-user/edit/*')  ? ' active pcoded-trigger' : '' }} 
            ">
            <a href="{{ url('admin-user') }}" class="waves-effect waves-dark">
                <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                <span class="pcoded-mtext">Admin Users</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <!-- <ul class="pcoded-submenu">
            
                <li class="{{ Request::is('admin-user')  ? 'active' : '' }}
                    OR {{ Request::is('admin-user-create')  ? 'active' : '' }} 
                    OR {{ Request::is('admin-user/edit/*')  ? 'active' : '' }}">
                    <a href="{{ url('admin-user') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Admin Users</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul> -->
        </li>
    </ul>


    <div class="pcoded-navigation-label">Report Management</div>
    <ul class="pcoded-item pcoded-left-item">
        <li class="pcoded-hasmenu  {{ Request::is('admin-payment')  ? ' active pcoded-trigger' : '' }}  
            OR {{ Request::is('auditlog')  ? ' active pcoded-trigger' : '' }}  ">
            <a href="javascript:void(0)" class="waves-effect waves-dark">
                <span class="pcoded-micon"><i class="ti-bar-chart-alt"></i><b>A</b></span>
                <span class="pcoded-mtext">Reports</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <!-- <ul class="pcoded-submenu">
                <li class="{{ Request::is('admin-payment')  ? 'active' : '' }} ">
                    <a href="{{ url('admin-payment') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Monthly Reports</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul> -->
            <ul class="pcoded-submenu">
                <li class="{{ Request::is('auditlog')  ? 'active' : '' }} ">
                    <a href="{{ url('auditlog') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext">Audit Log</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>

            </ul>
        </li>
    </ul>




    </div>
<?php
        }
?>
</nav>