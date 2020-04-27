@extends('licensor::licensor.layouts.licensor')
@section('content')
<form role="form" method="POST" action="{{ route('licensor.verify-purchase-post') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="content-box wow bounceInDown modal-content">
        <h3 class="content-box-header content-box-header-alt bg-default">
            <span class="icon-separator">
                <i class="glyphicon glyphicon-warning-sign"></i>
            </span>
            <span class="header-wrapper">
                <small>Verify Your Purchase.</small>
            </span>
        </h3>
        <div class="content-box-wrapper">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Purchase Code" name="code">
                    <input type="hidden" name="config" value="{{ $config }}">
                    <span class="input-group-addon bg-blue">
                        <i class="glyphicon glyphicon-cog"></i>
                    </span>
                </div>
            </div>
            
            <button class="btn btn-success btn-block">Verify</button>
        </div>
    </div>
</form>
@stop