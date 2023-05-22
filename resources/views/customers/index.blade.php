@extends('layouts.app')

@section('content')

<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Customers</h5>
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
                            <h5>Customer</h5>
                            <span>All<code> Customer </code>details</span>
                            <div class="card-header-right">
                                <div class="dropdown-primary dropdown open">
                                    <button class="btn btn-floating btn-dark-teal btn-sm" type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa fa-wrench open-card-option"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('client.user.create') }}">Add New</a>                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <br />
                            @include('layouts.notification')

                            {!! Form::open(['action' => 'CustomerController@index','id'=>'search-form','class'=>'md-float-material form-material']) !!}
                            @csrf
                            <div class="row">
                                
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group form-info">
                                        <select name="active_status" id="active_status" class="form-control">
                                            <option value="0">All</option>
                                            <option value="1" <?php echo ($active_status == 1 ? 'selected' : '') ?>>Active</option>
                                            <option value="2" <?php echo ($active_status == 2 ? 'selected' : '') ?>>Inactive</option>
                                        </select>
                                            <span class="form-bar"></span>
                                            <label class="float-label">Search By Status</label>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group form-info">
                                        <select name="pay_status" id="pay_status" class="form-control">
                                            <option value="0">All</option>
                                            <option value="1" <?php echo ($pay_status == 1 ? 'selected' : '') ?>>Active</option>
                                            <option value="2" <?php echo ($pay_status == 2 ? 'selected' : '') ?>>Inactive</option>
                                        </select>
                                            <span class="form-bar"></span>
                                            <label class="float-label">Search By Payment Status</label>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group form-info">
                                        <input type="text" name="search_value" id="search_value" value="{{ $search_value }}" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Search By ID/Name</label>
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
                                                <!-- <th>Email</th> -->
                                                <th>Status</th>
                                                <!-- <th>Currency</th> -->
                                                <th>Payment Status</th>
                                                <th>No.Member</th>
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
    var active_status = '<?php echo $active_status; ?>';
    var pay_status = '<?php echo $pay_status; ?>';
    

    $(document).ready(function() {

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
                url: "{{ route('allClientUserList') }}",
                data: function(d) {
                    d.search_value = search_value;
                    d.active_status = active_status;
                    d.pay_status = pay_status;
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
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false
                },
                // {
                //     data: 'email',
                //     name: 'email',
                //     orderable: false,
                //     searchable: false
                // },
                {
                    data: 'active_status',
                    name: 'active_status',
                    orderable: false,
                    searchable: false
                },
                // {
                //     data: 'currency',
                //     name: 'currency',
                //     orderable: false,
                //     searchable: false
                // },
                {
                    data: 'pay_status',
                    name: 'pay_status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'team',
                    name: 'team',
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

    });
</script>

@endpush