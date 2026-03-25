@extends('layouts.app')

@section('content')
<div class="pasakumi-container">
    <div class="page-heading">
        <h1>Izveidot jaunu pasākumu</h1>
        <p>Telpu var izvēlēties tikai tad, ja tā šajā laikā ir brīva. Pie telpas tiek rādīta ietilpība.</p>
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

    <form action="{{ route('pasakumi.store') }}" method="POST" class="pasakumi-form" enctype="multipart/form-data">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label>Nosaukums</label>
                <input type="text" name="nosaukums" value="{{ old('nosaukums') }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Kategorija</label>
                <input type="text" name="kategorija" value="{{ old('kategorija') }}" class="form-control" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Datums no</label>
                <input type="date" name="datums_no" value="{{ old('datums_no') }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Datums līdz</label>
                <input type="date" name="datums_lidz" value="{{ old('datums_lidz') }}" class="form-control" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Sākuma laiks</label>
                <select name="sakuma_laiks" class="form-control" required>
                    @for($h = 0; $h < 24; $h++)
                        @for($m = 0; $m < 60; $m += 15)
                            @php $time = sprintf('%02d:%02d', $h, $m); @endphp
                            <option value="{{ $time }}" {{ old('sakuma_laiks') == $time ? 'selected' : '' }}>
                                {{ $time }}
                            </option>
                        @endfor
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <label>Beigu laiks</label>
                <select name="beigu_laiks" class="form-control" required>
                    @for($h = 0; $h < 24; $h++)
                        @for($m = 0; $m < 60; $m += 15)
                            @php $time = sprintf('%02d:%02d', $h, $m); @endphp
                            <option value="{{ $time }}" {{ old('beigu_laiks') == $time ? 'selected' : '' }}>
                                {{ $time }}
                            </option>
                        @endfor
                    @endfor
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Reģistrācijas beigu datums</label>
                <input type="date" name="registracijas_beigu_datums" value="{{ old('registracijas_beigu_datums') }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Reģistrācijas beigu laiks</label>
                <select name="registracijas_beigu_laiks" class="form-control">
                    <option value="">-- Izvēlieties --</option>
                    @for($h = 0; $h < 24; $h++)
                        @for($m = 0; $m < 60; $m += 15)
                            @php $time = sprintf('%02d:%02d', $h, $m); @endphp
                            <option value="{{ $time }}" {{ old('registracijas_beigu_laiks') == $time ? 'selected' : '' }}>
                                {{ $time }}
                            </option>
                        @endfor
                    @endfor
                </select>
            </div>
        </div>

        <div class="form-group" style="margin-bottom:20px;">
            <label>Apraksts</label>
            <textarea name="apraksts" class="form-control">{{ old('apraksts') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Atbildīgais darbinieks</label>
                <select name="darbinieks_id" class="form-control" required>
                    <option value="">-- Izvēlieties darbinieku --</option>
                    @foreach($darbinieki as $d)
                        <option value="{{ $d->ID }}" {{ old('darbinieks_id') == $d->ID ? 'selected' : '' }}>
                            {{ $d->vards }} {{ $d->uzvards }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Telpa</label>
                <select name="telpa_id" class="form-control" required>
                    <option value="">-- Izvēlieties telpu --</option>
                    @foreach($telpas as $t)
                        <option value="{{ $t->ID }}" {{ old('telpa_id') == $t->ID ? 'selected' : '' }}>
                            {{ $t->nosaukums }} (ietilpība: {{ $t->ietilpiba }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group" style="margin-bottom:24px;">
            <label>Attēli</label>
            <input type="file" name="images[]" multiple accept="image/*" class="form-control">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Saglabāt pasākumu</button>
        </div>
    </form>
</div>
@endsection