@extends('layouts.app')

@section('content')
<div class="auth-card max-w-md">
    <div class="page-heading text-center">
        <h1>Reģistrēties</h1>
        <p>Izveidojiet jaunu lietotāja kontu sistēmā.</p>
    </div>

    @if ($errors->any())
        <div class="flash flash-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="name">Vārds</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-4">
            <label for="epasts">E-pasts</label>
            <input type="email" name="epasts" id="epasts" value="{{ old('epasts') }}" required>
        </div>

        <div class="mb-6">
            <label for="password">Parole</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="mb-6">
            <label for="password_confirmation">Apstipriniet paroli</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="btn">Reģistrēties</button>
        </div>
    </form>
</div>
@endsection