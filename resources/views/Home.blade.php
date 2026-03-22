@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container mt-5">
    <div class="jumbotron bg-light p-5 rounded">
        <h1 class="display-4">Sākumlapa</h1>
        <p class="lead">Jaunākie jaunumi un pasākumi – viss vienuviet.</p>
        <hr class="my-4">
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2>3 pēdējie jaunumi</h2>
            @forelse($jaunumi as $item)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->virsraksts }}</h5>
                        <p class="card-text"><small>{{ \Carbon\Carbon::parse($item->publicets_datums)->format('Y-m-d') }}</small></p>
                        <p class="card-text">{{ $item->apraksts }}</p>
                    </div>
                </div>
            @empty
                <p>Nav pieejamu jaunumu.</p>
            @endforelse
        </div>

        <div class="col-md-6">
            <h2>3 pēdējie pasākumi</h2>
            @forelse($pasakumi as $item)
                <div class="card mb-3">
                    @if($item->images->count() > 0)
                        <img src="{{ Storage::url($item->images->first()->image_path) }}" class="card-img-top" style="max-height:220px; object-fit:cover;" alt="{{ $item->nosaukums }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->nosaukums }}</h5>
                        <p class="card-text"><strong>Datums:</strong> {{ $item->datums_no }} - {{ $item->datums_lidz }}</p>
                        <p class="card-text">{{ Str::limit($item->apraksts, 180, '...') }}</p>
                        <a href="{{ route('pasakumi.show', $item->ID) }}" class="btn btn-sm btn-primary">Skatīt detaļas</a>
                    </div>
                </div>
            @empty
                <p>Nav pieejamu pasākumu.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
