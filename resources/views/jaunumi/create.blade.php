{{-- resources/views/jaunumi/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Pievienot jaunu ziņu</h1>

    @if ($errors->any())
        <div class="flash flash-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jaunumi.store') }}" method="POST" enctype="multipart/form-data" style="max-width:600px;">
        @csrf

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Virsraksts:</label>
            <input type="text" name="virsraksts" value="{{ old('virsraksts') }}" style="width:100%; padding:10px; border-radius:6px;">
        </div>

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Saturs:</label>
            <textarea name="apraksts" style="width:100%; padding:10px; border-radius:6px; min-height:200px;">{{ old('apraksts') }}</textarea>
        </div>

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Publicēšanas datums:</label>
            <input type="date" name="publicets_datums" value="{{ old('publicets_datums') }}" lang="lv-LV" style="width:100%; padding:10px; border-radius:6px;">
        </div>

        <!-- Attēli -->
        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Attēli (maksimums 10, katrs līdz 2MB):</label>
            <input type="file" name="images[]" multiple accept="image/*" style="width:100%; padding:10px; border-radius:6px;">
            @error('images')
                <span style="color: red;">{{ $message }}</span>
            @enderror
            @error('images.*')
                <span style="color: red;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display:flex; gap:12px;">
            <button type="submit" class="btn">Saglabāt</button>
            <a href="{{ route('jaunumi.index') }}" class="btn secondary">Atcelt</a>
        </div>
    </form>
@endsection
