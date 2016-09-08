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
                    <select>
                        @foreach ($typeOfInvoices as $typeOfInvoice)
                            <option value="{{ $typeOfInvoice->typeOfInvoice }}">{{ $typeOfInvoice->typeOfInvoice }}</option>
                        @endforeach
                    </select> 
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
