@extends('layouts.app')
@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')
<div class="pasakumi-container">
    <div class="page-heading">
        <h1>Labot pasākumu</h1>
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

    <form action="{{ route('pasakumi.update', $item->ID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label>Nosaukums</label>
                <input type="text" name="nosaukums" value="{{ old('nosaukums', $item->nosaukums) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Kategorija</label>
                <input type="text" name="kategorija" value="{{ old('kategorija', $item->kategorija) }}" class="form-control" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Datums no</label>
                <input type="date" name="datums_no" value="{{ old('datums_no', $item->datums_no) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Datums līdz</label>
                <input type="date" name="datums_lidz" value="{{ old('datums_lidz', $item->datums_lidz) }}" class="form-control" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Sākuma laiks</label>
                <select name="sakuma_laiks" class="form-control" required>
                    @for($h = 0; $h < 24; $h++)
                        @for($m = 0; $m < 60; $m += 15)
                            @php $time = sprintf('%02d:%02d', $h, $m); @endphp
                            <option value="{{ $time }}" {{ old('sakuma_laiks', \Carbon\Carbon::parse($item->sakuma_laiks)->format('H:i')) == $time ? 'selected' : '' }}>
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
                            <option value="{{ $time }}" {{ old('beigu_laiks', \Carbon\Carbon::parse($item->beigu_laiks)->format('H:i')) == $time ? 'selected' : '' }}>
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
                <input type="date" name="registracijas_beigu_datums" value="{{ old('registracijas_beigu_datums', $item->registracijas_beigu_datums) }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Reģistrācijas beigu laiks</label>
                <select name="registracijas_beigu_laiks" class="form-control">
                    <option value="">-- Izvēlieties --</option>
                    @for($h = 0; $h < 24; $h++)
                        @for($m = 0; $m < 60; $m += 15)
                            @php $time = sprintf('%02d:%02d', $h, $m); @endphp
                            <option value="{{ $time }}"
                                {{ old('registracijas_beigu_laiks', $item->registracijas_beigu_laiks ? \Carbon\Carbon::parse($item->registracijas_beigu_laiks)->format('H:i') : '') == $time ? 'selected' : '' }}>
                                {{ $time }}
                            </option>
                        @endfor
                    @endfor
                </select>
            </div>
        </div>

        <div class="form-group" style="margin-bottom:20px;">
            <label>Apraksts</label>
            <textarea name="apraksts" class="form-control">{{ old('apraksts', $item->apraksts) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Atbildīgais darbinieks</label>
                <select name="darbinieks_id" id="darbinieks_id" class="form-control" data-selected-employee="{{ old('darbinieks_id', $item->darbinieks_id) }}" required>
                    <option value="">-- Izvēlieties darbinieku --</option>
                    @foreach($darbinieki as $d)
                        <option value="{{ $d->ID }}" {{ old('darbinieks_id', $item->darbinieks_id) == $d->ID ? 'selected' : '' }}>
                            {{ $d->vards }} {{ $d->uzvards }}
                        </option>
                    @endforeach
                </select>
                <small id="darbinieks-statuss" style="display:block; margin-top:8px; color:var(--clr-text-muted, #666);">
                    Redzami tikai brīvie darbinieki izvēlētajā laikā.
                </small>
            </div>

            <div class="form-group">
                <label>Telpa</label>
                <select name="telpa_id" id="telpa_id" class="form-control" data-ignore-id="{{ $item->ID }}" required>
                    <option value="">Notiek telpu ielāde...</option>
                    @foreach($telpas as $t)
                        <option value="{{ $t->ID }}" {{ old('telpa_id', $item->telpa_id) == $t->ID ? 'selected' : '' }}>
                            {{ $t->nosaukums }} (ietilpība: {{ $t->ietilpiba }})
                        </option>
                    @endforeach
                </select>
                <small id="telpa-statuss" style="display:block; margin-top:8px; color:var(--clr-text-muted, #666);">
                    Redzamas tikai brīvās telpas izvēlētajā laikā.
                </small>
            </div>
        </div>

        @if($item->images->count() > 0)
            <div class="form-group" style="margin-bottom:20px;">
                <label>Esošie attēli</label>
                <div style="display:flex; flex-wrap:wrap; gap:12px;">
                    @foreach($item->images as $image)
                        <div style="position:relative;">
                            <img src="{{ Storage::url($image->image_path) }}" alt="Attēls"
                                 style="width:100px;height:100px;object-fit:cover;border-radius:10px;">
                            <form action="{{ route('pasakumi.deleteImage', [$item->ID, $image->id]) }}" method="POST" style="position:absolute;top:0;right:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:red;color:white;border:none;border-radius:50%;width:24px;height:24px;">×</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="form-group" style="margin-bottom:24px;">
            <label>Pievienot jaunus attēlus</label>
            <input type="file" name="images[]" multiple accept="image/*" class="form-control">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Saglabāt izmaiņas</button>
        </div>
        <div class="form-actions" style="margin-top:12px;">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Atcelt</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const darbinieki = @json($darbinieki->values());
    const telpas = @json($telpas->values());
    const aiznemtieLaiki = @json($aiznemtieLaiki->values());
    const fields = {
        datumsNo: document.querySelector('input[name="datums_no"]'),
        datumsLidz: document.querySelector('input[name="datums_lidz"]'),
        sakumaLaiks: document.querySelector('select[name="sakuma_laiks"]'),
        beiguLaiks: document.querySelector('select[name="beigu_laiks"]'),
    };
    const darbinieksSelect = document.getElementById('darbinieks_id');
    const darbinieksStatuss = document.getElementById('darbinieks-statuss');
    const telpaSelect = document.getElementById('telpa_id');
    const telpaStatuss = document.getElementById('telpa-statuss');

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
        const selectedRoom = telpaSelect.value;
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