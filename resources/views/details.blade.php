{{-- resources/views/details.blade.php --}}
@extends('layouts.app')
@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="event-details-card" style="max-width: 420px; margin: 0 auto; background: rgba(0,0,40,0.7); border-radius: 18px; box-shadow: 0 4px 24px #0004; padding: 32px 28px 24px 28px; color: var(--clr-text-light);">
        <h2 style="text-align:center; color: var(--clr-french-violet); margin-bottom: 18px; letter-spacing: 0.04em; font-size: 2rem;">
            <span style="vertical-align: middle;">📚</span> {{ $data->nosaukums }}
        </h2>
        <div style="margin-bottom: 12px;">
            <span style="font-weight:600; color:var(--clr-text-muted);">Kategorija:</span> {{ $data->kategorija }}
        </div>
        <div style="margin-bottom: 12px;">
            <span style="font-weight:600; color:var(--clr-text-muted);">Datums:</span> <span style="color:var(--clr-bright-pink);">{{ $data->datums_no }} – {{ $data->datums_lidz }}</span>
        </div>
        <div style="margin-bottom: 12px;">
            <span style="font-weight:600; color:var(--clr-text-muted);">Laiks:</span> {{ $data->sakuma_laiks }} – {{ $data->beigu_laiks }}
        </div>
        <div style="margin-bottom: 18px;">
            <span style="font-weight:600; color:var(--clr-text-muted);">Apraksts:</span> {{ $data->apraksts }}
        </div>
        <div style="margin-bottom: 12px;">
            <span style="font-weight:600; color:var(--clr-text-muted);">Atbildīgais darbinieks:</span> {{ $data->darbinieks->vards ?? 'Nav norādīts' }}
        </div>
        <div style="margin-bottom: 24px;">
            <span style="font-weight:600; color:var(--clr-text-muted);">Telpa:</span> {{ $data->telpa->nosaukums ?? 'Nav norādīta' }}
        </div>
        <div style="margin-bottom: 24px; padding: 16px; border-radius: 12px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);">
            <div style="margin-bottom: 10px;">
                <span style="font-weight:600; color:var(--clr-text-muted);">Vietas:</span>
                @if(!is_null($pieteiksanasInfo['brivasVietas']))
                    {{ $pieteiksanasInfo['brivasVietas'] }} brīvas no {{ $pieteiksanasInfo['ietilpiba'] }}
                @else
                    Nav norādīta telpas ietilpība
                @endif
            </div>
            @if($pieteiksanasInfo['registracijasBeigas'])
                <div style="margin-bottom: 10px;">
                    <span style="font-weight:600; color:var(--clr-text-muted);">Pieteikšanās līdz:</span>
                    {{ $pieteiksanasInfo['registracijasBeigas']->format('d.m.Y H:i') }}
                </div>
            @endif

            @if($errors->has('pieteiksanas'))
                <div style="margin-bottom: 12px; color: #ffb4b4;">{{ $errors->first('pieteiksanas') }}</div>
            @elseif(!$varPieteikties && auth()->check() && $pieteiksanasInfo['iemesls'])
                <div style="margin-bottom: 12px; color: var(--clr-text-muted);">{{ $pieteiksanasInfo['iemesls'] }}</div>
            @elseif(!auth()->check())
                <div style="margin-bottom: 12px; color: var(--clr-text-muted);">Pieslēdzieties, lai pieteiktos pasākumam.</div>
            @endif

            @if(session('success'))
                <div style="margin-bottom: 12px; color: #9ff2b0;">{{ session('success') }}</div>
            @endif

            @if($lietotajaPieteikums)
                <div style="color: #9ff2b0; font-weight: 600;">Jūsu pieteikuma statuss: {{ $lietotajaPieteikums->statuss }}</div>
            @elseif($varPieteikties)
                <form method="POST" action="{{ route('pasakumi.pieteikties', $data->ID) }}">
                    @csrf
                    <button type="submit" class="btn" style="width: 100%; padding: 12px 18px; border-radius: 10px; font-weight: 700;">
                        Pieteikties pasākumam
                    </button>
                </form>
            @else
                <button type="button" class="btn secondary" style="width: 100%; padding: 12px 18px; border-radius: 10px; opacity: 0.7; cursor: not-allowed;" disabled>
                    Pieteikšanās nav pieejama
                </button>
            @endif
        </div>
        @if($data->images->count() > 0)
            <div style="margin-bottom: 24px;">
                <span style="font-weight:600; color:var(--clr-text-muted);">Attēli:</span>
                <div style="display:flex; flex-wrap:wrap; gap:8px; margin-top:8px;">
                    @foreach($data->images as $image)
                        <img src="{{ Storage::url($image->image_path) }}" alt="Attēls" style="width:100px; height:100px; object-fit:cover; border-radius:6px; border:1px solid var(--clr-bright-pink);">
                    @endforeach
                </div>
            </div>
        @endif
        <div style="text-align:center; margin-top: 18px;">
            <a href="{{ route('pasakumi.index') }}" class="btn secondary" style="font-size:1.1rem; padding: 10px 32px; border-radius: 8px;">Atpakaļ uz sarakstu</a>
        </div>
    </div>
@endsection
