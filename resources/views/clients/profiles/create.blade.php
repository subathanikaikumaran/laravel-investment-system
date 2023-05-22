@extends('layouts.app')

@section('content')
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Corporates</h5>
                        <p class="m-b-0">Welcome to Investment System</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Corporates</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Create Corporate</a>
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
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Colored Input</h5>
                                </div>
                                <div class="card-block">
                                    <form class="form-material">

                                        <div class="form-group form-primary">
                                            <input type="text" name="footer-email" class="form-control">
                                            <span class="form-bar"></span>
                                            <label class="float-label">form-primary</label>
                                        </div>

                                    </form>
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