{{-- resources/views/jaunumi/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Jaunumi</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(auth()->user()->loma !== 'Lietotajs')
            <a href="{{ route('jaunumi.create') }}" class="btn btn-primary">Pievienot jaunu ziņu</a>
        @endif

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Virsraksts</th>
                    <th>Publicēts</th>
                    @if(auth()->user()->loma !== 'Lietotajs')
                        <th>Darbības</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr>
                        <td>{{ $item->virsraksts }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->publicets_datums)->format('Y-m-d') }}</td>
                        @if(auth()->user()->loma !== 'Lietotajs')
                            <td>
                                <a href="{{ route('jaunumi.edit', $item->id) }}" class="btn btn-sm btn-warning">Rediģēt</a>
                                <form action="{{ route('jaunumi.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Vai tiešām vēlaties dzēst šo ziņu?')">Dzēst</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Nav pievienotu jaunumu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
