@extends('layouts.app')

@section('content')
<div class="auth-card max-w-md">
    <div class="page-heading text-center">
        <h1>Pieslēgties</h1>
        <p>Ievadiet savus datus, lai piekļūtu sistēmai.</p>
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

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="epasts">E-pasts</label>
            <input type="email" name="epasts" id="epasts" value="Sergejs@gmail.com" required>
        </div>

        <div class="mb-6">
            <label for="password">Parole</label>
            <input type="password" name="password" id="password" value="Admin@123" required>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="btn">Pieslēgties</button>
        </div>
    </form>

    <div class="card" style="margin-top:20px;">
        <h3>Demo konti</h3>
        <p><strong>Admins:</strong> Sergejs@gmail.com / Admin@123</p>
        <p><strong>Lietotājs:</strong> martins@gmail.com / Lietotajs123</p>
    </div>
</div>
@endsection