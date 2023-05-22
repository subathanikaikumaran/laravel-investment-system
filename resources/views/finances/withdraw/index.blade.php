@extends('layouts.app')

@section('content')

<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Withdraw Payments</h5>
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
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper" style="padding: 3px;">
                <div class="page-body">

                  
                    <div class="card">
                        <div class="card-header">
                            <h5>Withdraw Payment Details</h5>
                            <span>All<code> Withdraw </code>payment details</span>
                            <div class="card-header-right">
                                <div class="dropdown-primary dropdown open">
                                    <button class="btn btn-floating btn-dark-teal btn-sm" type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa fa-wrench open-card-option"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('admin.withdraw.create') }}">Add New</a>
                                        <!-- <div class="dropdown-divider"></div>
                                        <a class="dropdown-item waves-light waves-effect" onclick="download_csv();">Export</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <br />
                            @include('layouts.notification')

                            {!! Form::open(['action' => 'PaymentController@indexWithdraw','id'=>'search-form','class'=>'md-float-material form-material']) !!}
                            @csrf
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group form-info">
                                        <input type="text" name="search_value" id="search_value" value="{{ $search_value }}" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Search By ID/Name</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group form-info">
                                        <input type="date" name="fdate" id="fdate" class="form-control fill" value="{{ $fdate }}" autocomplete="new-dob">
                                        <span class="form-bar"></span>
                                        <label class="float-label">From Date</label>

                                        <div class="text-danger-error" id='custom-error-from' style="display: none">
                                            <p id='msg-from'></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group form-info">
                                        <input type="date" name="tdate" id="tdate" class="form-control fill" value="{{ $tdate }}" autocomplete="new-dob">
                                        <span class="form-bar"></span>
                                        <label class="float-label">To Date</label>

                                        <div class="text-danger-error" id='custom-error-to' style="display: none">
                                            <p id='msg-to'></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6">
                                    <div class="form-group form-info">
                                        <button class="btn btn-dark-teal waves-effect waves-light">Search <i class="icofont icofont-ui-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            </form>

                            <div class="table-border-style">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tblpayment" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>User ID</th>
                                                <th>Amount</th>
                                                
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
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
    var search_value = '<?php echo $search_value; ?>';
    var fdate = '<?php echo $fdate; ?>';
    var tdate = '<?php echo $tdate; ?>';

    var errorBoxf = document.getElementById('custom-error-from');
    var errorMsgf = document.getElementById('msg-from');
    var errorBoxt = document.getElementById('custom-error-to');
    var errorMsgt = document.getElementById('msg-to');
    $(document).ready(function() {
        getAlldata();
        var oTable = $('#tblpayment').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "iDisplayLength": 10,
            "bSort": false,

            "bFilter": false,
            "bLengthChange": true,
            "lengthMenu": [10, 20, 30],
            ajax: {
                url: "{{ route('allwithdrawpaymentList') }}",
                data: function (d) {
                    d.search_value = search_value;
                    d.fdate = fdate;
                    d.tdate = tdate;
                } 
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'first_name',
                    name: 'first_name',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'last_name',
                    name: 'last_name',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'user_id',
                    name: 'user_id',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'amount',
                    name: 'amount',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'date',
                    name: 'date',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
        $("form").submit(function(e) {
            getAlldata();
            if (validationDate(fdate, tdate)) {
                oTable.draw();
            } else {
                e.preventDefault();
            }

        });
    });

    function validationDate(fdate, tdate) {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        //2021-09-01
        var todayDate = yyyy + '-' + mm + '-' + dd; //mm + '/' + dd + '/' + yyyy;
        if (fdate !== "" && tdate == "") {
            errorBoxt.style.display = 'block';
            errorMsgt.innerHTML = "Please select the To date.";
            return false;
        } else if (fdate == "" && tdate !== "") {
            errorBoxf.style.display = 'block';
            errorMsgf.innerHTML = "Please select the From date.";
            return false;
        } else if (fdate !== "" && tdate !== "") {
            if (Date.parse(fdate) > Date.parse(tdate)) {
                errorBoxt.style.display = 'block';
                errorMsgt.innerHTML = "To date should be greater than From date.";
                return false;
            } else if (Date.parse(fdate) > Date.parse(todayDate)) {
                errorBoxf.style.display = 'block';
                errorMsgf.innerHTML = "From date can't be future date.";
                return false;
            } else if (Date.parse(tdate) > Date.parse(todayDate)) {
                errorBoxt.style.display = 'block';
                errorMsgt.innerHTML = "To date can't be future date.";
                return false;
            }
        } else {
            return true;
        }
        return true;
    }

    function getAlldata() {
        search_value = $('#search_value').val();
        fdate = $('#fdate').val();
        tdate = $('#tdate').val();
    }
</script>

@endpush