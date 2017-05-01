@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

curl --request GET 'https://na.api.pvp.net/api/lol/na/v1.4/summoner/by-name/RiotSchmick?api_key=<RGAPI-86f304a3-d57c-4b4d-bf99-69ce872ec53c>' --include

            </div>
        </div>
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
