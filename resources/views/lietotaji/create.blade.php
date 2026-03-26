@extends('layouts.app')

@section('content')
    <div class="pasakumi-container">
        <div class="page-heading">
            <h1>Pievienot lietotāju</h1>
            <p>Aizpildiet formu, lai izveidotu jaunu lietotāja kontu.</p>
        </div>

        @if ($errors->any())
            <div class="flash flash-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lietotaji.store') }}" method="POST" style="max-width: 560px;">
            @csrf

            <div class="form-control" style="margin-bottom:16px;">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Vārds:</label>
                <input type="text" name="vards" value="{{ old('vards') }}" style="width:90%; padding:10px; border-radius:6px;">
            </div>

            <div class="form-control" style="margin-bottom:16px;">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Uzvārds:</label>
                <input type="text" name="uzvards" value="{{ old('uzvards') }}" style="width:90%; padding:10px; border-radius:6px;">
            </div>

            <div class="form-control" style="margin-bottom:16px;">
                <label style="font-weight:700; display:block; margin-bottom:8px;">E-pasts:</label>
                <input type="email" name="epasts" value="{{ old('epasts') }}" style="width:90%; padding:10px; border-radius:6px;">
            </div>

            <div class="form-control" style="margin-bottom:16px;">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Parole:</label>
                <input type="password" name="password" style="width:90%; padding:10px; border-radius:6px;">
            </div>

            <div class="form-control" style="margin-bottom:16px;">
                <label style="font-weight:700; display:block; margin-bottom:8px;">Apstiprināt paroli:</label>
                <input type="password" name="password_confirmation" style="width:90%; padding:10px; border-radius:6px;">
            </div>

            @if(auth()->user()->loma === 'Admin')
                <div class="form-control" style="margin-bottom:16px;">
                    <label style="font-weight:700; display:block; margin-bottom:8px;">Loma:</label>
                    <select name="loma" style="width:90%; padding:10px; border-radius:6px;">
                        <option value="">-- izvēlēties --</option>
                        <option value="Admin" {{ old('loma') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Darbinieks" {{ old('loma') == 'Darbinieks' ? 'selected' : '' }}>Darbinieks</option>
                        <option value="Lietotajs" {{ old('loma') == 'Lietotajs' ? 'selected' : '' }}>Lietotājs</option>
                    </select>
                </div>
            @else
                <input type="hidden" name="loma" value="Lietotajs">
                <div class="form-control" style="margin-bottom:16px;">
                    <label style="font-weight:700; display:block; margin-bottom:8px;">Loma:</label>
                    <div style="width:90%; padding:10px; border-radius:6px; background:rgba(255,255,255,0.05); color:var(--clr-text-muted, #666);">
                        Lietotājs
                    </div>
                    <small style="display:block; margin-top:8px; color:var(--clr-text-muted, #666);">
                        Darbinieks var pievienot tikai lietotāja lomas kontu.
                    </small>
                </div>
            @endif

            <div style="display:flex; gap:12px;">
                <button type="submit" class="btn">Saglabāt</button>
                <a href="{{ route('lietotaji.index') }}" class="btn secondary">Atcelt</a>
            </div>
        </form>
    </div>
@endsection