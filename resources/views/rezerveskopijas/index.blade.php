{{-- resources/views/rezerveskopijas/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Rezerves kopiju saraksts</h1>

    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('rezerveskopijas.create') }}" class="btn">Pievienot jaunu ierakstu</a>

    <table border="1" cellpadding="12" cellspacing="0" style="margin-top:16px; width:100%; border-collapse:collapse; table-layout:auto;">
        <thead>
            <tr>
                <th style="text-align:center;">Fails</th>
                <th style="text-align:center;">Izveides datums</th>
                <th style="text-align:center;">Darbības</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td style="text-align:center;">{{ $item->fails }}</td>
                    <td style="text-align:center;">{{ \Carbon\Carbon::parse($item->izveides_datums)->format('d.m.Y') }}</td>
                    <td style="text-align:center;">
                            <div style="display:flex; gap:8px; justify-content:center; align-items:center;">
                                <a href="{{ route('rezerveskopijas.edit', $item->ID) }}" class="btn edit">Rediģēt</a>
                                <form action="{{ route('rezerveskopijas.destroy', $item->ID) }}" method="POST" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn delete" onclick="return confirm('Vai tiešām dzēst šo pasakumu?')">Dzēst</button>
                                </form>
                            </div>
                        </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
