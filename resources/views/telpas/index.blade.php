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
                    <div style="display:flex; gap:12px; margin-top:24px;">
                    <a href="{{ route('telpas.edit', $data->ID) }}" class="btn">Rediģēt</a>
                        <form action="{{ route('telpas.destroy', $data->ID) }}" method="POST" onsubmit="return confirm('Vai tiešām dzēst?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn secondary">Dzēst</button>
                        </form>
                    @endif
                    </tr>
            @endforeach
        </tbody>
    </table>
@endsection
