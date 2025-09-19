@foreach($qrcodes as $qr)
    <tr class="border-b hover:bg-red-50 transition">
        <td class="py-2 px-4">{{ $qr->id }}</td>
        <td class="py-2 px-4 font-mono text-sm">
        <span @class([
            'px-2 py-1 rounded text-black',
            'bg-green-100' => $qr->profile_type === 'Human',
            'bg-orange-100' => $qr->profile_type === 'Pet',
            'bg-blue-100' => $qr->profile_type === 'Valuables',
        ])>
            {{ $qr->profile_type }}
        </span>
        </td>
        <td class="py-2 px-4 font-mono text-sm">{{ $qr->uid }}</td>
        <td class="py-2 px-4 font-mono text-sm">{{ $qr->pin }}</td>
        <td class="py-2 px-4">{{ $qr->code }}</td>
        <td class="py-2 px-4 flex justify-center items-center">
            {!! QrCode::size(90)->generate(url('/qr-details/' . $qr->id)) !!}
        </td>
        <td class="py-2 px-4">
            @if($qr->status)
                <span class="inline-block px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Used</span>
            @else
                <span class="inline-block px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold">Free</span>
            @endif
        </td>
        <td class="py-2 px-4">
            @if($qr->detail)
                <span title="{{ $qr->detail->email }}">
                {{ $qr->detail->name }} <span class="text-gray-400">({{ $qr->detail->email }})</span>
            </span>
            @else
                <span class="text-gray-400">-</span>
            @endif
        </td>
        <td class="py-2 px-4">
            <a href="{{ route('qr.download', $qr->id) }}"
               class="text-red-600 hover:underline hover:text-red-800 font-medium">
                Download
            </a>
        </td>
    </tr>
@endforeach
