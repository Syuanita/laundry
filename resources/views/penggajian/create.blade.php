@extends('layout.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Input Penggajian Harian (Otomatis)</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('penggajian.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Pilih Karyawan</label>
                <select name="karyawan_id" id="karyawan_id" class="form-control" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($karyawan as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_karyawan }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Total Berat Dikerjakan (Kg) - <span class="text-primary font-weight-bold">Hari Ini</span></label>
                    <input type="number" step="0.01" name="total_kg_dikerjakan" id="total_kg_dikerjakan" class="form-control" readonly required>
                    <small class="text-info">*Angka ini muncul otomatis berdasarkan transaksi hari ini.</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Upah Per Kg (Rp)</label>
                    <input type="number" name="tarif_per_kg" class="form-control" placeholder="Contoh: 1000" required>
                    <small class="text-muted">Gaji akan dihitung: Berat x Upah</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-calculator"></i> Hitung & Simpan Gaji
            </button>
            <a href="{{ route('penggajian.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
    document.getElementById('karyawan_id').addEventListener('change', function() {
        const karyawanId = this.value;
        const inputKg = document.getElementById('total_kg_dikerjakan');

        if (karyawanId) {

            inputKg.value = "Sedang menghitung...";

            fetch("{{ url('penggajian/get-total-kg') }}/" + karyawanId)
                .then(response => response.json())
                .then(data => {
                    inputKg.value = data.total_kg;
                })
                .catch(error => {
                    console.error('Error:', error);
                    inputKg.value = 0;
                });
        } else {
            inputKg.value = "";
        }
    });
</script>
@endsection