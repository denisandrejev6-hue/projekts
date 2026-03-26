{{-- resources/views/kategorijas/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Rediģēt kategoriju</h1>

    @if ($errors->any())
        <div class="flash flash-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kategorijas.update', $item->ID) }}" method="POST" style="max-width:500px;">
        @csrf
        @method('PUT')

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Nosaukums:</label>
            <input type="text" name="nosaukums" value="{{ old('nosaukums', $item->nosaukums) }}" style="width:90%; padding:10px; border-radius:6px;">
        </div>

        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn">Saglabāt</button>
            <a href="{{ route('kategorijas.index') }}" class="btn secondary btn-cancel">Atcelt</a>
        </div>
    </form>
@endsection
