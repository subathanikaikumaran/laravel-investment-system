@extends('layouts.app')

@section('content')
<?php
$ques1=0;
if(old('ques1')){
    $ques1=old('ques1');
  }

  $ques2=0;
if(old('ques2')){
    $ques2=old('ques2');
  }
?>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Account Verification</h5>
                        <p class="m-b-0">Welcome to Investment System</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper" style="padding: 3px;">

                <div class="page-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Account Verification - Question & Answers</h5>
                                </div>
                                <div class="card-block">

                                    @if ($cerror = Session::get('error'))
                                    <div class="text-danger">
                                        Error! - {{ $cerror }}
                                    </div>
                                    <br />
                                    @endif
                                    {!! Form::open(array('route' => 'user.accountverify','id'=>'frmprofile','method'=>'POST','class'=>'md-float-material form-material','enctype' => 'multipart/form-data')) !!}
                                    @csrf
                                    <br />
                                    <input type="hidden" name="id" id="id" value="{{ isset($id)?$id:'' }}" />
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-primary">
                                                <select name="ques1" class="form-control" required>
                                                    <option value="0"></option>
                                                    <?php foreach ($quesArr as  $corp) { ?>
                                                        <option value="<?php echo $corp['id']; ?>" 
                                                        <?php if ($ques1 == $corp['id']) { echo "selected";} ?>><?php echo $corp['description']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <span class="form-bar"></span>
                                                <label class="float-label">Question 1 <span class="required-field">*</span></label>
                                                <div class="text-danger-error">
                                                    {!! $errors->first('ques1', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <input maxlength="30" required value="{{old('answer1')}}" type="text" name="answer1" class="form-control" autocomplete="new-answer1">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Answer <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('answer1', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-primary">
                                                <select name="ques2" class="form-control" required>
                                                    <option value="0"></option>
                                                    <?php foreach ($quesArr as  $corp) { ?>
                                                        <option value="<?php echo $corp['id']; ?>" 
                                                        <?php if ($ques2 == $corp['id']) { echo "selected";} ?>><?php echo $corp['description']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <span class="form-bar"></span>
                                                <label class="float-label">Question 2 <span class="required-field">*</span></label>
                                                <div class="text-danger-error">
                                                    {!! $errors->first('ques2', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group form-info">
                                                <input maxlength="30" required value="{{old('answer2')}}" type="text" name="answer2" class="form-control" autocomplete="new-answer2">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Answer <span class="required-field">*</span></label>

                                                <div class="text-danger-error">
                                                    {!! $errors->first('answer2', ':message') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group form-info">
                                        <button type="submit" class="btn btn-dark-teal waves-effect waves-light">Save<i class="icofont icofont-diskette"></i></button>
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