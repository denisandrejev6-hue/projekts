@extends('layouts.app')

@section('content')
<div class="page-heading">
    <h1>Lietotāji</h1>
    <p>Šeit var apstiprināt jaunus lietotājus.</p>
</div>

@if(session('success'))
    <div class="flash flash-success">{{ session('success') }}</div>
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
                <th>Aktīvs</th>
                <th>Darbības</th>
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
                    <td>{{ (int)$item->aktivs === 1 ? 'Jā' : 'Nē' }}</td>
                    <td>
                        @if((int)$item->aktivs !== 1)
                            <form action="{{ route('lietotaji.apstiprinat', $item->ID) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" class="btn btn-sm">Apstiprināt</button>
                            </form>
                        @else
                            <span>Apstiprināts</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection