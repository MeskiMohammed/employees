@extends('layout.app')
@section('title','admins')
@section('content')
    @forelse(\App\Models\User::all() as $user)
        {{ $user->name }}
    @empty
        no user found
    @endforelse
@endsection