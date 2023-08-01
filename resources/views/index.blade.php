@extends('layouts.app')
@section('content')
<user-information :users="{{ $users }}"></user-information>
@endsection