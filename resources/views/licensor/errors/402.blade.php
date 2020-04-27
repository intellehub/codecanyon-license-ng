@extends('licensor::licensor.layouts.licensor')
@section('content')
<div class="panel-body">
    <div class="error-page">
        <h2 class="headline text-yellow"> 402: Invalid License</h2><br />
        <div class="error-content">
            <h3><i class="fa fa-warning font-red"></i> Payment Required/Invalid License.</h3>
            <p>
                Sorry, we could not verify your license with the purchase code you entered .<br />
                If you think this was by mistake, please contact the Support team.<br />
                Meanwhile, you may want to retry with a different/correct purchase code using the following link <br />
                <hr />
                <a class="btn btn-success btn-md" href='{{ route('licensor.verify-purchase', $config) }}'>Verify Purchase</a>.
            </p>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->
</div>
@stop
