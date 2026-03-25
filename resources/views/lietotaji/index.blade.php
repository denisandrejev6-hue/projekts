@extends('layouts.app')

@section('content')
<div class="page-heading" style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap;">
    <div>
        <h1>Lietotāji</h1>
        <p>Šeit var apskatīt lietotāju sarakstu un, ja nepieciešams, apstiprināt jaunus lietotājus.</p>
    </div>

    @if(auth()->check() && in_array(auth()->user()->loma, ['Admin', 'Darbinieks']))
        <a href="{{ route('lietotaji.create') }}" class="btn">+ Pievienot</a>
    @endif
</div>

@if(session('success'))
    <div class="flash flash-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="flash flash-error">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Vārds</th>
                <th>Uzvārds</th>
                <th>E-pasts</th>
                <th>Loma</th>

                @if(auth()->check() && in_array(auth()->user()->loma, ['Admin', 'Darbinieks']))
                    <th>Aktīvs</th>
                    <th>Darbības</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->ID }}</td>
                    <td>{{ $item->vards }}</td>
                    <td>{{ $item->uzvards }}</td>
                    <td>{{ $item->epasts }}</td>
                    <td>{{ $item->loma }}</td>

                    @if(auth()->check() && in_array(auth()->user()->loma, ['Admin', 'Darbinieks']))
                        <td>{{ (int)$item->aktivs === 1 ? 'Jā' : 'Nē' }}</td>
                        <td>
                            <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">

                                @if((int)$item->aktivs !== 1)
                                    <form action="{{ route('lietotaji.apstiprinat', $item->ID) }}" method="POST" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm">Apstiprināt</button>
                                    </form>
                                @else
                                    <span style="padding:8px 12px; border-radius:10px; background:rgba(109,121,136,.12); color:#4d5b69; font-weight:600;">
                                        Apstiprināts
                                    </span>
                                @endif

                                <a href="{{ route('lietotaji.edit', $item->ID) }}" class="btn btn-sm secondary">
                                    Rediģēt
                                </a>

                                <form action="{{ route('lietotaji.destroy', $item->ID) }}" method="POST" style="margin:0;" onsubmit="return confirm('Vai tiešām vēlaties dzēst šo lietotāju?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm delete">
                                        Dzēst
                                    </button>
                                </form>
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection