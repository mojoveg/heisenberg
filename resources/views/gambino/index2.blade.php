@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Gambino</div>

                <div class="panel-body">
                    Your Application's Landing Page.
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="/gambino2">
                        {{ csrf_field() }}
                        <div class="form-group">
                        <select name="typeOfInvoices">
                            @foreach ($typeOfInvoices as $typeOfInvoice)
                                <option value="{{ $typeOfInvoice->typeOfInvoice }}">{{ $typeOfInvoice->typeOfInvoice }}</option>
                            @endforeach
                        </select> 
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@if(Session::has('itypeOfInvoices'))
    <div class="row">
        <div class="col-md-4 col-md-offset-4 success">
            {{Session::get('itypeOfInvoices')}}
        </div>
    </div>
@endif

<script type="text/javascript">
    $( "select" )
        .change(function () {
            // body...
        })
</script>

@endsection
