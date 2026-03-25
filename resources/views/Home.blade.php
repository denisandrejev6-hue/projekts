@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="hero-panel">
    <h1>Sākumlapa</h1>
    <p>Jaunākie bibliotēkas jaunumi un pasākumi.</p>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="page-heading">
            <h2>3 pēdējie jaunumi</h2>
            <p>Aktuāla informācija par bibliotēkas jaunumiem un notikumiem.</p>
        </div>

        @forelse($jaunumi as $item)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->virsraksts }}</h5>
                    <p class="card-text"><small>{{ \Carbon\Carbon::parse($item->publicets_datums)->format('Y-m-d') }}</small></p>
                    <p class="card-text">{{ $item->apraksts }}</p>
                </div>
            </div>
        @empty
            <div class="card"><p>Nav pieejamu jaunumu.</p></div>
        @endforelse
    </div>

    <div class="col-md-6">
        <div class="page-heading">
            <h2>3 pēdējie pasākumi</h2>
            <p>Uzziniet par gaidāmajiem pasākumiem un aktivitātēm bibliotēkā.</p>
        </div>

        @forelse($pasakumi as $item)
            <div class="card mb-3">
                @if($item->images->count() > 0)
                    <img src="{{ Storage::url($item->images->first()->image_path) }}" class="card-img-top" style="max-height:220px; object-fit:cover;" alt="{{ $item->nosaukums }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $item->nosaukums }}</h5>
                    <p class="card-text"><strong>Datums:</strong> {{ $item->datums_no }} - {{ $item->datums_lidz }}</p>
                    <p class="card-text">{{ Str::limit($item->apraksts, 180, '...') }}</p>
                    <a href="{{ route('pasakumi.show', $item->ID) }}" class="btn btn-sm">Skatīt detaļas</a>
                </div>
            </div>
        @empty
            <div class="card"><p>Nav pieejamu pasākumu.</p></div>
        @endforelse
    </div>
</div>
@endsection