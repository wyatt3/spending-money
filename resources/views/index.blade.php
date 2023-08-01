@extends('layouts.app')
@section('content')
<user-information :users="{{ $users }}" :loggedInUser="{{ Auth::user() }}"></user-information>
@endsection