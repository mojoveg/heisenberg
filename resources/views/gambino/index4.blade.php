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
                    <form class="form-horizontal" role="form" method="POST" action="/gambino4/test">
                        {{ csrf_field() }}
                        <div class="form-group">
                        <select name="invoices" size=10>
                            @foreach ($invoices as $invoice)
                                <option value="{{ $invoice->descriptor }}">{{ $invoice->descriptor }}</option>
                            @endforeach
                        </select> 
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Test</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@if(Session::has('typeOfInvoices'))
    <div class="row">
        <div class="col-md-4 col-md-offset-4 success">
            {{Session::get('typeOfInvoices')}}
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
