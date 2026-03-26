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
                <select name="darbinieks_id" class="form-control" required>
                    <option value="">-- Izvēlieties darbinieku --</option>
                    @foreach($darbinieki as $d)
                        <option value="{{ $d->ID }}" {{ old('darbinieks_id', $item->darbinieks_id) == $d->ID ? 'selected' : '' }}>
                            {{ $d->vards }} {{ $d->uzvards }}
                        </option>
                    @endforeach
                </select>
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
    const fields = {
        datumsNo: document.querySelector('input[name="datums_no"]'),
        datumsLidz: document.querySelector('input[name="datums_lidz"]'),
        sakumaLaiks: document.querySelector('select[name="sakuma_laiks"]'),
        beiguLaiks: document.querySelector('select[name="beigu_laiks"]'),
    };
    const telpaSelect = document.getElementById('telpa_id');
    const telpaStatuss = document.getElementById('telpa-statuss');
    let activeRequest = 0;

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

    const loadRooms = async () => {
        if (!hasRequiredValues()) {
            setPlaceholder('Vispirms izvēlieties datumu un laiku');
            return;
        }

        const selectedRoom = telpaSelect.value;
        const requestId = ++activeRequest;
        setPlaceholder('Notiek brīvo telpu ielāde...', true);

        const params = new URLSearchParams({
            datums_no: fields.datumsNo.value,
            datums_lidz: fields.datumsLidz.value,
            sakuma_laiks: fields.sakumaLaiks.value,
            beigu_laiks: fields.beiguLaiks.value,
            ignore_id: telpaSelect.dataset.ignoreId,
        });

        try {
            const response = await fetch(`{{ route('pasakumi.availableRooms') }}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error('Neizdevās ielādēt telpas.');
            }

            const data = await response.json();

            if (requestId !== activeRequest) {
                return;
            }

            renderRooms(data.telpas ?? [], selectedRoom);
        } catch (error) {
            if (requestId !== activeRequest) {
                return;
            }

            setPlaceholder('Neizdevās ielādēt telpas. Mēģiniet vēlreiz.');
        }
    };

    Object.values(fields).forEach((field) => {
        field?.addEventListener('change', loadRooms);
    });

    loadRooms();
});
</script>
@endpush