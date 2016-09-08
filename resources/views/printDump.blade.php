@extends('layouts.app')

@section('content')
<div class="container">
        <pre>
        {{ $reply or 'Default'}}
        </pre> 
</div>
@endsection