@extends('layouts.app')

@section('content')

<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Bonus Details</h5>
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
                            <h5>Bonus Details</h5>
                            <span>All<code> Bonus </code>details</span>
                            <div class="card-header-right">
                                <div class="dropdown-primary dropdown open">
                                    <button class="btn btn-floating btn-dark-teal btn-sm" type="button" id="dropdown-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa fa-wrench open-card-option"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdown-2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <a class="dropdown-item waves-light waves-effect" href="{{ route('admin.bonus.create') }}">Add New</a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <br />
                            @include('layouts.notification')

                            {!! Form::open(['action' => 'BonusController@index','id'=>'search-form','class'=>'md-float-material form-material']) !!}
                            @csrf
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group form-info">
                                        <select name="type" id="type" class="form-control">
                                            <option value="0">All</option>
                                            <option value="1" <?php echo ($type == 1 ? 'selected' : '') ?>>Ring 1</option>
                                            <option value="2" <?php echo ($type == 2 ? 'selected' : '') ?>>Ring 2</option>
                                            <option value="3" <?php echo ($type == 3 ? 'selected' : '') ?>>Ring 3</option>
                                            <option value="4" <?php echo ($type == 4 ? 'selected' : '') ?>>Ring 4</option>
                                        </select>
                                        <span class="form-bar"></span>
                                        <label class="float-label">Search By Ring Level</label>

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
                                                <th>Name</th>	
                                                <th>Level</th>	
                                                <th>Initial Amount</th>
                                                <th>Basic Bonus</th>
                                                <th>Is Monthly/Yearly</th>
                                                
                                                <th>Monthly/Yearly Bonus</th>
                                                <th>Date</th>
                                                <th>Added By</th>
                                                <th>Description</th>
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
    var type = '<?php echo $type; ?>';

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
                url: "{{ route('getBonusList') }}",
                data: function(d) {
                    d.type = type;
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'type',
                    name: 'type',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'level',
                    name: 'level',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'ini_amount',
                    name: 'ini_amount',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'basic_bonus',
                    name: 'basic_bonus',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'isMonthly',
                    name: 'isMonthly',
                    orderable: false,
                    searchable: false
                },
               
                {
                    data: 'monthly_bonus',
                    name: 'monthly_bonus',
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
                    data: 'addedBy',
                    name: 'addedBy',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'description',
                    name: 'description',
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