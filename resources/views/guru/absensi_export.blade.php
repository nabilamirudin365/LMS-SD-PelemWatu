<table>
    <thead>
        {{-- Baris Judul Utama --}}
        <tr>
            <th colspan="{{ 5 + $daysInMonth }}" style="font-weight: bold; text-align: center; font-size: 14px;">
                DAFTAR HADIR SISWA
            </th>
        </tr>
        <tr>
            <th colspan="{{ 5 + $daysInMonth }}" style="font-weight: bold; text-align: center; font-size: 12px;">
                KELAS: {{ $kelas->nama_kelas }}
            </th>
        </tr>
        <tr>
            <th colspan="{{ 5 + $daysInMonth }}" style="font-weight: bold; text-align: center; font-size: 12px;">
                BULAN: {{ strtoupper($bulan) }} {{ $tahun }}
            </th>
        </tr>
        <tr></tr>

        {{-- Baris Header Tabel --}}
        <tr>
            <th rowspan="2" style="font-weight: bold; border: 1px solid #000; text-align: center;">No</th>
            <th rowspan="2" style="font-weight: bold; border: 1px solid #000; text-align: center;">Nama Siswa</th>
            <th colspan="{{ $daysInMonth }}" style="font-weight: bold; border: 1px solid #000; text-align: center;">Tanggal</th>
            <th colspan="4" style="font-weight: bold; border: 1px solid #000; text-align: center;">Jumlah</th>
        </tr>
        <tr>
            @for ($i = 1; $i <= $daysInMonth; $i++)
            <th style="font-weight: bold; border: 1px solid #000; text-align: center;">{{ $i }}</th>
            @endfor
            <th style="font-weight: bold; border: 1px solid #000; text-align: center;">H</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center;">S</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center;">I</th>
            <th style="font-weight: bold; border: 1px solid #000; text-align: center;">A</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($rekapData as $data)
        <tr>
            <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
            <td style="border: 1px solid #000; text-align: left;">{{ $data['nama'] }}</td>
            @foreach($data['kehadiran'] as $status)
            <td style="border: 1px solid #000; text-align: center;">{{ $status }}</td>
            @endforeach
            <td style="border: 1px solid #000; text-align: center;">{{ $data['rekapSiswa']['H'] }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $data['rekapSiswa']['S'] }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $data['rekapSiswa']['I'] }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $data['rekapSiswa']['A'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>