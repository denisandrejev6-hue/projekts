{{-- resources/views/telpas/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Telpu saraksts</h1>

    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif

    @if(auth()->user()->loma !== 'Lietotajs')
        <a href="{{ route('telpas.create') }}" class="btn">Pievienot jaunu telpu</a>
    @endif

    <table border="1" cellpadding="12" cellspacing="0" style="margin-top:16px; width:100%; border-collapse:collapse; table-layout:auto;">
        <thead>
            <tr>
                <th style="text-align:center;">Nosaukums</th>
                <th style="text-align:center;">Ietilpība</th>
                @if(auth()->user()->loma !== 'Lietotajs')
                    <th style="text-align:center;">Darbības</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td style="text-align:center;">{{ $item->nosaukums }}</td>
                    <td style="text-align:center;">{{ $item->ietilpiba }}</td>
                    @if(auth()->user()->loma !== 'Lietotajs')
                    <td style="text-align:center;">
                            <div style="display:flex; gap:8px; justify-content:center; align-items:center;">
                                <a href="{{ route('telpas.edit', $item->ID) }}" class="btn edit">Rediģēt</a>
                                <form action="{{ route('telpas.destroy', $item->ID) }}" method="POST" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn delete" onclick="return confirm('Vai tiešām dzēst datus par šo telpu?')">Dzēst</button>
                                </form>
                            </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
