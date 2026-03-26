{{-- resources/views/jaunumi/edit.blade.php --}}
@extends('layouts.app')
@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <h1>Rediģēt ziņu</h1>

    @if ($errors->any())
        <div class="flash flash-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jaunumi.update', $item->id) }}" method="POST" enctype="multipart/form-data" style="max-width:600px;">
        @csrf
        @method('PUT')

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Virsraksts:</label>
            <input type="text" name="virsraksts" value="{{ old('virsraksts', $item->virsraksts) }}" style="width:100%; padding:10px; border-radius:6px;">
        </div>

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Saturs:</label>
            <textarea name="apraksts" style="width:100%; padding:10px; border-radius:6px; min-height:200px;">{{ old('apraksts', $item->apraksts) }}</textarea>
        </div>

        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Publicēšanas datums:</label>
            <input type="date" name="publicets_datums" value="{{ old('publicets_datums', $item->publicets_datums) }}" lang="lv-LV" style="width:100%; padding:10px; border-radius:6px;">
        </div>

        <!-- Esošie attēli -->
        @if($item->images->count() > 0)
            <div style="margin-bottom:16px;">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Esošie attēli:</label>
                <div style="display:flex; flex-wrap:wrap; gap:8px;">
                    @foreach($item->images as $image)
                        <div style="position:relative;">
                            <img src="{{ Storage::url($image->image_path) }}" alt="Attēls" style="width:100px; height:100px; object-fit:cover; border-radius:6px;">
                            <form action="{{ route('jaunumi.deleteImage', [$item->id, $image->id]) }}" method="POST" style="position:absolute; top:0; right:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:red; color:white; border:none; border-radius:50%; width:20px; height:20px; cursor:pointer;" onclick="return confirm('Vai tiešām vēlaties dzēst šo attēlu?')">×</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Jauni attēli -->
        <div class="form-control" style="margin-bottom:16px;">
            <label style="font-weight:700; display:block; margin-bottom:8px;">Pievienot jaunus attēlus (maksimums {{ 10 - $item->images->count() }}):</label>
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
