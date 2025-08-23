@extends('layouts.app')

@section('title', 'Tambah Kuota DUDI')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card shadow-sm rounded-3 mx-auto" style="max-width: 600px;">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Kuota DUDI</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('backend.kuota_dudi.store') }}" method="POST">
                @csrf

                <div class="form-floating mb-3">
                    <select name="id_dudi" id="dudiSelect" class="form-select" required>
                        <option value="">-- Pilih DUDI --</option>
                        @foreach($dudi as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <label for="dudiSelect">DUDI</label>
                </div>

                <div class="form-floating mb-3">
                    <select name="tahun_id" id="tahunSelect" class="form-select" required>
                        <option value="">-- Pilih Tahun --</option>
                        @foreach($tahun as $t)
                            <option value="{{ $t->id }}">{{ $t->tahun_pelaksanaan }}</option>
                        @endforeach
                    </select>
                    <label for="tahunSelect">Tahun Pelaksanaan</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="number" name="kuota" class="form-control" id="kuotaInput" min="0" value="{{ old('kuota') }}" required>
                    <label for="kuotaInput">Kuota</label>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('backend.kuota_dudi.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    // Data kombinasi DUDI => Tahun yang sudah ada
    const existing = @json($existing);

    const dudiSelect = document.getElementById('dudiSelect');
    const tahunSelect = document.getElementById('tahunSelect');

    dudiSelect.addEventListener('change', function() {
        const dudiId = this.value;

        // Reset semua options
        for (let i = 0; i < tahunSelect.options.length; i++) {
            tahunSelect.options[i].disabled = false;
            tahunSelect.options[i].text = tahunSelect.options[i].text.replace(' (sudah ada)','');
        }

        if(dudiId && existing[dudiId]) {
            const tahunSudahAda = existing[dudiId];

            for (let i = 0; i < tahunSelect.options.length; i++) {
                const opt = tahunSelect.options[i];
                if(tahunSudahAda.includes(parseInt(opt.value))) {
                    opt.disabled = true;
                    opt.text += ' (sudah ada)';
                }
            }
        }

        // Reset selected
        tahunSelect.value = '';
    });
</script>
@endsection
