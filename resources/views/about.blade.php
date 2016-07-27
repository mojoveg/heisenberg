@extends('layouts.master')

@section('content')
    <h1>The About page goes here</h1>

<?php 
// Makeing an object of second DB.             
$users2 = DB::connection('mysql_dinersClubData');
// Getting data with second DB object.
$u = $users2->table('accounts_copy_mts')->get();
print_r($u);
?>

@stop