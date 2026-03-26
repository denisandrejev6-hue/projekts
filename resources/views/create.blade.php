@extends('layouts.app')

@section('content')
<div class="pasakumi-container">
    <div class="page-heading">
        <h1>Jauns pasākums</h1>
        <p>Aizpildiet formu zemāk, lai izveidotu jaunu bibliotēkas pasākumu.</p>
    </div>

    @if ($errors->any())
        <div class="error-block">
            <strong>Lūdzu, izlabojiet šādas kļūdas:</strong>
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
                <label>Nosaukums <span class="required-star">*</span></label>
                <input type="text" name="nosaukums" value="{{ old('nosaukums') }}" placeholder="Ievadiet pasākuma nosaukumu"
                    class="form-control @error('nosaukums') is-invalid @enderror">
                @error('nosaukums')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Kategorija <span class="required-star">*</span></label>
                <input type="text" name="kategorija" value="{{ old('kategorija') }}" placeholder="Ievadiet kategoriju"
                    class="form-control @error('kategorija') is-invalid @enderror">
                @error('kategorija')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Datums no <span class="required-star">*</span></label>
                <input type="date" name="datums_no" value="{{ old('datums_no') }}"
                    class="form-control @error('datums_no') is-invalid @enderror">
                @error('datums_no')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Datums līdz <span class="required-star">*</span></label>
                <input type="date" name="datums_lidz" value="{{ old('datums_lidz') }}"
                    class="form-control @error('datums_lidz') is-invalid @enderror">
                @error('datums_lidz')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Sākuma laiks <span class="required-star">*</span></label>
                <input type="time" name="sakuma_laiks" value="{{ old('sakuma_laiks') }}"
                    class="form-control @error('sakuma_laiks') is-invalid @enderror">
                @error('sakuma_laiks')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Beigu laiks <span class="required-star">*</span></label>
                <input type="time" name="beigu_laiks" value="{{ old('beigu_laiks') }}"
                    class="form-control @error('beigu_laiks') is-invalid @enderror">
                @error('beigu_laiks')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Reģistrācijas beigu datums</label>
                <input type="date" name="registracijas_beigu_datums" value="{{ old('registracijas_beigu_datums') }}"
                    class="form-control @error('registracijas_beigu_datums') is-invalid @enderror">
                @error('registracijas_beigu_datums')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Reģistrācijas beigu laiks</label>
                <input type="time" name="registracijas_beigu_laiks" value="{{ old('registracijas_beigu_laiks') }}"
                    class="form-control @error('registracijas_beigu_laiks') is-invalid @enderror">
                @error('registracijas_beigu_laiks')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group" style="margin-bottom:24px;">
            <label>Apraksts</label>
            <textarea name="apraksts" placeholder="Ievadiet pasākuma aprakstu..."
                class="form-control @error('apraksts') is-invalid @enderror">{{ old('apraksts') }}</textarea>
            @error('apraksts')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-row" style="margin-bottom:32px;">
            <div class="form-group">
                <label>Darbinieks <span class="required-star">*</span></label>
                <select name="darbinieks_id" class="form-control @error('darbinieks_id') is-invalid @enderror">
                    <option value="">-- Izvēlieties darbinieku --</option>
                    @foreach($darbinieki as $d)
                        <option value="{{ $d->ID }}" {{ old('darbinieks_id') == $d->ID ? 'selected' : '' }}>
                            {{ $d->vards }} {{ $d->uzvards }}
                        </option>
                    @endforeach
                </select>
                @error('darbinieks_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Telpa <span class="required-star">*</span></label>
                <select
                    name="telpa_id"
                    id="telpa_id"
                    class="form-control @error('telpa_id') is-invalid @enderror"
                    data-selected-room="{{ old('telpa_id') }}"
                    disabled
                >
                    <option value="">Vispirms izvēlieties datumu un laiku</option>
                    @foreach($telpas as $t)
                        <option value="{{ $t->ID }}" {{ old('telpa_id') == $t->ID ? 'selected' : '' }}>
                            {{ $t->nosaukums }} (ietilpība: {{ $t->ietilpiba ?? 'nav norādīta' }})
                        </option>
                    @endforeach
                </select>
                <small id="telpa-statuss" style="display:block; margin-top:8px; color:var(--clr-text-muted, #666);">
                    Telpas būs pieejamas pēc datuma un laika izvēles.
                </small>
                @error('telpa_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group" style="margin-bottom:24px;">
            <label>Attēli (maksimums 10, katrs līdz 2MB)</label>
            <input type="file" name="images[]" multiple accept="image/*"
                class="form-control @error('images') is-invalid @enderror">
            @error('images')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            @error('images.*')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Atcelt</a>
            <button type="submit" class="btn">Saglabāt pasākumu</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const telpas = @json($telpas->values());
    const aiznemtieLaiki = @json($aiznemtieLaiki->values());
    const fields = {
        datumsNo: document.querySelector('input[name="datums_no"]'),
        datumsLidz: document.querySelector('input[name="datums_lidz"]'),
        sakumaLaiks: document.querySelector('input[name="sakuma_laiks"]'),
        beiguLaiks: document.querySelector('input[name="beigu_laiks"]'),
    };
    const telpaSelect = document.getElementById('telpa_id');
    const telpaStatuss = document.getElementById('telpa-statuss');

    const setPlaceholder = (message, disabled = true) => {
        telpaSelect.innerHTML = '';
        const option = document.createElement('option');
        option.value = '';
        option.textContent = message;
        telpaSelect.appendChild(option);
        telpaSelect.value = '';
        telpaSelect.disabled = disabled;
        telpaStatuss.textContent = message;
    };

    const renderRooms = (rooms, selectedRoom) => {
        telpaSelect.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = rooms.length
            ? '-- Izvēlieties telpu --'
            : 'Šajā laikā nav nevienas brīvas telpas';
        telpaSelect.appendChild(placeholder);

        rooms.forEach((room) => {
            const option = document.createElement('option');
            option.value = room.ID;
            option.textContent = `${room.nosaukums} (ietilpība: ${room.ietilpiba ?? 'nav norādīta'})`;

            if (String(room.ID) === String(selectedRoom)) {
                option.selected = true;
            }

            telpaSelect.appendChild(option);
        });

        telpaSelect.disabled = rooms.length === 0;
        telpaStatuss.textContent = rooms.length
            ? 'Redzamas tikai brīvās telpas izvēlētajā laikā.'
            : 'Šajā laikā nav nevienas brīvas telpas.';
    };

    const hasRequiredValues = () => {
        return Object.values(fields).every((field) => field && field.value);
    };

    const isValidRange = () => {
        if (!hasRequiredValues()) {
            return false;
        }

        if (fields.datumsNo.value > fields.datumsLidz.value) {
            return false;
        }

        if (fields.sakumaLaiks.value >= fields.beiguLaiks.value) {
            return false;
        }

        return true;
    };

    const getAvailableRooms = () => {
        return telpas.filter((room) => {
            return !aiznemtieLaiki.some((booking) => {
                return String(booking.telpa_id) === String(room.ID)
                    && booking.datums_no <= fields.datumsLidz.value
                    && booking.datums_lidz >= fields.datumsNo.value
                    && booking.sakuma_laiks < fields.beiguLaiks.value
                    && booking.beigu_laiks > fields.sakumaLaiks.value;
            });
        });
    };

    const loadRooms = () => {
        if (!hasRequiredValues()) {
            setPlaceholder('Vispirms izvēlieties datumu un laiku');
            return;
        }

        if (!isValidRange()) {
            setPlaceholder('Pārbaudiet, lai beigu datums un laiks būtu pēc sākuma');
            return;
        }

        const selectedRoom = telpaSelect.value || telpaSelect.dataset.selectedRoom;
        renderRooms(getAvailableRooms(), selectedRoom);
    };

    Object.values(fields).forEach((field) => {
        field?.addEventListener('change', loadRooms);
    });

    loadRooms();
});
</script>
@endpush