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
                <input type="date" name="datums_no" value="{{ old('datums_no') }}" lang="lv-LV"
                    class="form-control @error('datums_no') is-invalid @enderror">
                @error('datums_no')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Datums līdz <span class="required-star">*</span></label>
                <input type="date" name="datums_lidz" value="{{ old('datums_lidz') }}" lang="lv-LV"
                    class="form-control @error('datums_lidz') is-invalid @enderror">
                @error('datums_lidz')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Sākuma laiks <span class="required-star">*</span></label>
                <input type="time" name="sakuma_laiks" value="{{ old('sakuma_laiks') }}" lang="lv-LV"
                    class="form-control @error('sakuma_laiks') is-invalid @enderror">
                @error('sakuma_laiks')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Beigu laiks <span class="required-star">*</span></label>
                <input type="time" name="beigu_laiks" value="{{ old('beigu_laiks') }}" lang="lv-LV"
                    class="form-control @error('beigu_laiks') is-invalid @enderror">
                @error('beigu_laiks')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Reģistrācijas beigu datums</label>
                <input type="date" name="registracijas_beigu_datums" value="{{ old('registracijas_beigu_datums') }}" lang="lv-LV"
                    class="form-control @error('registracijas_beigu_datums') is-invalid @enderror">
                @error('registracijas_beigu_datums')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Reģistrācijas beigu laiks</label>
                <input type="time" name="registracijas_beigu_laiks" value="{{ old('registracijas_beigu_laiks') }}" lang="lv-LV"
                    class="form-control @error('registracijas_beigu_laiks') is-invalid @enderror">
                @error('registracijas_beigu_laiks')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <small style="display:block; margin-top:-14px; margin-bottom:24px; color:var(--clr-text-muted, #666);">
            Reģistrācija jānoslēdz ne vēlāk kā pasākuma sākuma datumā un laikā.
        </small>

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
                <select
                    name="darbinieks_id"
                    id="darbinieks_id"
                    class="form-control @error('darbinieks_id') is-invalid @enderror"
                    data-selected-employee="{{ old('darbinieks_id') }}"
                    disabled
                >
                    <option value="">-- Izvēlieties darbinieku --</option>
                    @foreach($darbinieki as $d)
                        <option value="{{ $d->ID }}" {{ old('darbinieks_id') == $d->ID ? 'selected' : '' }}>
                            {{ $d->vards }} {{ $d->uzvards }}
                        </option>
                    @endforeach
                </select>
                <small id="darbinieks-statuss" style="display:block; margin-top:8px; color:var(--clr-text-muted, #666);">
                    Darbinieki būs pieejami pēc datuma un laika izvēles.
                </small>
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
            <small style="display:block; margin-top:8px; color:var(--clr-text-muted, #666);">
                Vienam pasākumam var pievienot līdz 10 attēliem.
            </small>
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
    // Formā visi nepieciešamie dati ir pieejami uzreiz, tāpēc filtrēšanu var veikt bez papildu pieprasījumiem.
    const darbinieki = @json($darbinieki->values());
    const telpas = @json($telpas->values());
    const aiznemtieLaiki = @json($aiznemtieLaiki->values());
    const fields = {
        datumsNo: document.querySelector('input[name="datums_no"]'),
        datumsLidz: document.querySelector('input[name="datums_lidz"]'),
        sakumaLaiks: document.querySelector('input[name="sakuma_laiks"]'),
        beiguLaiks: document.querySelector('input[name="beigu_laiks"]'),
    };
    const darbinieksSelect = document.getElementById('darbinieks_id');
    const darbinieksStatuss = document.getElementById('darbinieks-statuss');
    const telpaSelect = document.getElementById('telpa_id');
    const telpaStatuss = document.getElementById('telpa-statuss');

    // Ja dati vēl nav izvēlēti vai intervāls nav korekts, izvēlnē rāda paskaidrojošu vietturi.
    const setPlaceholder = (select, statusElement, message, disabled = true) => {
        select.innerHTML = '';
        const option = document.createElement('option');
        option.value = '';
        option.textContent = message;
        select.appendChild(option);
        select.value = '';
        select.disabled = disabled;
        statusElement.textContent = message;
    };

    // Viena un tā pati renderēšanas funkcija tiek izmantota gan telpām, gan darbiniekiem.
    const renderOptions = ({ items, select, selectedValue, emptyMessage, defaultMessage, labelBuilder, statusElement, successMessage }) => {
        select.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = items.length ? defaultMessage : emptyMessage;
        select.appendChild(placeholder);

        items.forEach((item) => {
            const option = document.createElement('option');
            option.value = item.ID;
            option.textContent = labelBuilder(item);

            if (String(item.ID) === String(selectedValue)) {
                option.selected = true;
            }

            select.appendChild(option);
        });

        select.disabled = items.length === 0;
        statusElement.textContent = items.length ? successMessage : emptyMessage;
    };

    const hasDateValues = () => {
        return Boolean(fields.datumsNo?.value && fields.datumsLidz?.value);
    };

    const hasTimeValues = () => {
        return Boolean(fields.sakumaLaiks?.value && fields.beiguLaiks?.value);
    };

    const isValidRange = () => {
        if (!hasDateValues()) {
            return false;
        }

        if (fields.datumsNo.value > fields.datumsLidz.value) {
            return false;
        }

        if (hasTimeValues() && fields.sakumaLaiks.value >= fields.beiguLaiks.value) {
            return false;
        }

        return true;
    };

    // Ja laiki vēl nav izvēlēti, filtrē tikai pēc datumiem.
    const getAvailableRooms = () => {
        return telpas.filter((room) => {
            return !aiznemtieLaiki.some((booking) => {
                const dateOverlap = booking.datums_no <= fields.datumsLidz.value
                    && booking.datums_lidz >= fields.datumsNo.value;

                if (!dateOverlap) {
                    return false;
                }

                if (!hasTimeValues()) {
                    return String(booking.telpa_id) === String(room.ID);
                }

                return String(booking.telpa_id) === String(room.ID)
                    && booking.sakuma_laiks < fields.beiguLaiks.value
                    && booking.beigu_laiks > fields.sakumaLaiks.value;
            });
        });
    };

    // Darbinieku pieejamība tiek noteikta pēc tā paša pārklāšanās principa kā telpām.
    const getAvailableEmployees = () => {
        return darbinieki.filter((employee) => {
            return !aiznemtieLaiki.some((booking) => {
                const dateOverlap = booking.datums_no <= fields.datumsLidz.value
                    && booking.datums_lidz >= fields.datumsNo.value;

                if (!dateOverlap) {
                    return false;
                }

                if (!hasTimeValues()) {
                    return String(booking.darbinieks_id) === String(employee.ID);
                }

                return String(booking.darbinieks_id) === String(employee.ID)
                    && booking.sakuma_laiks < fields.beiguLaiks.value
                    && booking.beigu_laiks > fields.sakumaLaiks.value;
            });
        });
    };

    // Pēc katras datuma vai laika maiņas pārrēķina pieejamās izvēles.
    const loadRooms = () => {
        if (!hasDateValues()) {
            setPlaceholder(darbinieksSelect, darbinieksStatuss, 'Vispirms izvēlieties pasākuma datumus');
            setPlaceholder(telpaSelect, telpaStatuss, 'Vispirms izvēlieties pasākuma datumus');
            return;
        }

        if (!isValidRange()) {
            setPlaceholder(darbinieksSelect, darbinieksStatuss, 'Pārbaudiet, lai beigu datums un laiks būtu pēc sākuma');
            setPlaceholder(telpaSelect, telpaStatuss, 'Pārbaudiet, lai beigu datums un laiks būtu pēc sākuma');
            return;
        }

        const selectedEmployee = darbinieksSelect.value || darbinieksSelect.dataset.selectedEmployee;
        const selectedRoom = telpaSelect.value || telpaSelect.dataset.selectedRoom;
        renderOptions({
            items: getAvailableEmployees(),
            select: darbinieksSelect,
            selectedValue: selectedEmployee,
            emptyMessage: 'Šajā laikā nav neviena brīva darbinieka',
            defaultMessage: '-- Izvēlieties darbinieku --',
            labelBuilder: (employee) => `${employee.vards} ${employee.uzvards}`,
            statusElement: darbinieksStatuss,
            successMessage: 'Redzami tikai brīvie darbinieki izvēlētajā laikā.',
        });
        renderOptions({
            items: getAvailableRooms(),
            select: telpaSelect,
            selectedValue: selectedRoom,
            emptyMessage: 'Šajā laikā nav nevienas brīvas telpas',
            defaultMessage: '-- Izvēlieties telpu --',
            labelBuilder: (room) => `${room.nosaukums} (ietilpība: ${room.ietilpiba ?? 'nav norādīta'})`,
            statusElement: telpaStatuss,
            successMessage: 'Redzamas tikai brīvās telpas izvēlētajā laikā.',
        });

        if (!hasTimeValues()) {
            darbinieksStatuss.textContent = 'Darbinieki atlasīti pēc datuma. Norādiet laikus, lai precizētu pieejamību.';
            telpaStatuss.textContent = 'Telpas atlasītas pēc datuma. Norādiet laikus, lai precizētu pieejamību.';
        }
    };

    Object.values(fields).forEach((field) => {
        field?.addEventListener('change', loadRooms);
    });

    loadRooms();
});
</script>
@endpush