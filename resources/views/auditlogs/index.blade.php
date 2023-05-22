@extends('layouts.app')

@section('content')
<style>
        table thead .sorting:after,
        table thead .sorting:before,
        table thead .sorting_asc:after,
        table thead .sorting_asc:before,
        table thead .sorting_asc_disabled:after,
        table thead .sorting_asc_disabled:before,
        table thead .sorting_desc:after,
        table thead .sorting_desc:before,
        table thead .sorting_desc_disabled:after,
        table thead .sorting_desc_disabled:before {
        bottom: .5em;
        }
        
    </style>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Audit Log</h5>
                        <p class="m-b-0">Welcome to Investment System</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('home') }}"> <i class="fa fa-home" style="font-size: large;"></i> </a>
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
                    <!-- <div class="row"> -->


                    <div class="card">
                        <div class="card-header">
                            <h5>Auditlog Table</h5>
                           
                        </div>

                        <div class="card-block table-border-style">
                            <br />
                            @if(!empty($err))
                                <div class="text-danger">
                                    <strong>Error!</strong> There were some errors with your input.<br><br>
                                    <ul>
                                        @foreach($err as $p)
                                            <li>{{ $p }}</li>
                                        @endforeach
                                    </ul>                                
                                </div>
                            @endif
                            
                            {!! Form::open(['action' => 'AuditlogController@index','id'=>'search-form','class'=>'md-float-material form-material']) !!}
                            @csrf
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group form-info">
                                        <input type="text" name="search_value" id="search_value" value="{{ $search_value }}" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Search By Activity/ID/User</label>
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
                            

                            <div class="table-responsive">
                                <table class="table table-hover" id="tbl-txn" style="width: 100%;">
                                <thead>
                                        <tr>
                                            <th>Activity</th>
                                            <!-- <th>ID</th> -->
                                            <th>User</th>
                                            <th>User ID</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <!-- <th>IP</th>
                                            <th>Info</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
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
        var oTable = $('#tbl-txn').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "iDisplayLength": 10,
            "bSort": false,              
               
            "bFilter": false,
            "bLengthChange": true,
            "lengthMenu": [10, 20, 30],
            "ajax": {
                data: {
                    "search_value" : search_value,                   
                    "fdate" : fdate,
                    "tdate" : tdate,
                    _token: '{{csrf_token()}}'
                },
                "type": "post",
                "url": "{{ route('auditlogList') }}",
                "jsonpCallback": 'jsonCallback',
                "dataType": "jsonp",
                error: function (jqXHR, textStatus, errorThrown) {
                    if(textStatus ==='parsererror'){
                       console.log('error')
                    }
                }
            }
        });
        $("form").submit(function(e){
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
        var todayDate = yyyy+'-' + mm + '-'+ dd; //mm + '/' + dd + '/' + yyyy;

        if (fdate !== "" && tdate !== "") { 
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

    function getAlldata(){
        search_value=$('#search_value').val();       
        fdate=$('#fdate').val();
        tdate=$('#tdate').val();
    }
</script>

@endpush