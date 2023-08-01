@extends('layouts.app')
@section('content')
<user-information :users="{{ $users }}" :logged_in_user="{{ Auth::user() }}"></user-information>
@endsection