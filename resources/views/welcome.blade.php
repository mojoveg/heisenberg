@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Your Application's Landing Page.
                </div>
                <div class="panel-body">
                    <a href="{{ url('/testCC') }}">Test CC php</a>
                </div>
                <div class="panel-body">
                    <a href="{{ url('/testCCcv') }}">Test CC controller/view</a>
                </div>
                <div class="panel-body">
                    <a href="{{ url('/chargeFuel') }}">Charge Fuel</a>
                </div>
                <div class="panel-body">
                    <a href="{{ url('/gambino3') }}">Gambino</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
