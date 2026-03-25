@extends('layouts.app')

@section('content')
<div class="auth-card max-w-md">
    <div class="page-heading text-center">
        <h1>Reģistrēties</h1>
        <p>Izveidojiet kontu. Pēc tam profils jāapstiprina administratoram vai darbiniekam.</p>
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
            <label for="vards">Vārds</label>
            <input type="text" name="vards" id="vards" value="{{ old('vards') }}" required>
        </div>

        <div class="mb-4">
            <label for="uzvards">Uzvārds</label>
            <input type="text" name="uzvards" id="uzvards" value="{{ old('uzvards') }}" required>
        </div>

        <div class="mb-4">
            <label for="epasts">E-pasts</label>
            <input type="email" name="epasts" id="epasts" value="{{ old('epasts') }}" required>
        </div>

        <div class="mb-4">
            <label for="password">Parole</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="mb-6">
            <label for="password_confirmation">Apstipriniet paroli</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <button type="submit" class="btn">Reģistrēties</button>
    </form>
</div>
@endsection