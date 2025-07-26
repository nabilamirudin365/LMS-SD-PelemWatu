<table>
    <thead>
        <tr>
            <th>Nama Murid</th>
            @foreach($kuisList as $kuis)
                <th>Kuis {{ $loop->iteration }}</th>
            @endforeach
            <th>Rata-rata</th>
        </tr>
    </thead>
    <tbody>
        @foreach($muridList as $murid)
            @php $total = 0; $count = 0; @endphp
            <tr>
                <td>{{ $murid->name }}</td>
                @foreach($kuisList as $kuis)
                    @php
                        $nilaiObj = $murid->nilaiKuis->firstWhere('kuis_id', $kuis->id);
                        $skor = $nilaiObj?->skor;
                        if(!is_null($skor)) { $total += $skor; $count++; }
                    @endphp
                    <td>{{ $skor ?? '-' }}</td>
                @endforeach
                <td>{{ $count ? round($total / $count, 1) : '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
