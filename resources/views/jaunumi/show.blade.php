{{-- resources/views/jaunumi/show.blade.php --}}
@extends('layouts.app')
@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="container" style="max-width: 850px; margin-top: 20px;">
        <h1>{{ $item->virsraksts }}</h1>
        <p><strong>Publicēts:</strong> {{ \Carbon\Carbon::parse($item->publicets_datums)->format('Y-m-d') }}</p>
        <hr>
        <p style="white-space: pre-line;">{{ $item->apraksts }}</p>

        @if($item->images->count() > 0)
            <div style="margin-top: 20px;">
                <h3>Attēli:</h3>
                <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:10px;">
                    @foreach($item->images as $image)
                        <img src="{{ Storage::url($image->image_path) }}" alt="Attēls" style="width:200px; height:200px; object-fit:cover; border-radius:6px; border:1px solid #ddd;">
                    @endforeach
                </div>
            </div>
        @endif

        <div style="margin-top: 30px; display: flex; gap: 12px;">
            <a href="{{ route('jaunumi.index') }}" class="btn secondary">Atpakaļ uz jaunumiem</a>
        </div>
    </div>
@endsection