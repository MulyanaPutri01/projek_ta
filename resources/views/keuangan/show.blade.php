<!-- resources/views/keuangan/show.blade.php -->
<h2>Detail Keuangan</h2>
<p><strong>ID Keuangan:</strong> {{ $keuangan->id_keuangan }}</p>
<p><strong>Tanggal:</strong> {{ $keuangan->tanggal }}</p>
<p><strong>Sumber Keuangan:</strong> {{ $keuangan->sumber_keuangan }}</p>
<p><strong>Pemasukan:</strong> {{ $keuangan->pemasukan }}</p>
<p><strong>Pengeluaran:</strong> {{ $keuangan->pengeluaran }}</p>
<p><strong>Jumlah:</strong> {{ $keuangan->jumlah }}</p>
<p><strong>Total Saldo:</strong> {{ $keuangan->total_saldo }}</p>
