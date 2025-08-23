@php
    // pastikan variabel tersedia agar aman
    $siswa = $siswa ?? null;
@endphp

<div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="nama" class="form-control"
           value="{{ old('nama', optional($siswa)->nama) }}" required>
</div>

<div class="mb-3">
    <label class="form-label">NIS</label>
    <input type="text" name="nis" class="form-control"
           value="{{ old('nis', optional($siswa)->nis) }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Jurusan</label>
    <select name="jurusan_id" class="form-control" required>
        <option value="">-- Pilih Jurusan --</option>
        @foreach($jurusan as $j)
            <option value="{{ $j->id }}"
                {{ old('jurusan_id', optional($siswa)->jurusan_id) == $j->id ? 'selected' : '' }}>
                {{ $j->jurusan }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Jenis Kelamin</label>
    <select name="jenis_kelamin" class="form-control" required>
        @php $jk = old('jenis_kelamin', optional($siswa)->jenis_kelamin); @endphp
        <option value="L" {{ $jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
        <option value="P" {{ $jk == 'P' ? 'selected' : '' }}>Perempuan</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">No HP</label>
    <input type="text" name="no_hp" class="form-control"
           value="{{ old('no_hp', optional($siswa)->no_hp) }}">
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control"
           value="{{ old('email', optional(optional($siswa)->user)->email) }}" required>
</div>

<div class="mb-3">
    <label class="form-label">
        Password {!! $siswa ? '<small class="text-muted">(kosongkan jika tidak diganti)</small>' : '' !!}
    </label>
    <input type="password" name="password" class="form-control" {{ $siswa ? '' : 'required' }}>
</div>
