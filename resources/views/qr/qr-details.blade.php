<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>View Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-start py-0 px-3">

<div class="w-full max-w-sm bg-white shadow-2xl border-1 border-[#a6705d] overflow-hidden">
    <!-- Header -->
    <div class="bg-[#f7f4f2] px-4 py-3 flex items-center gap-3 border-b border-[#a6705d]/20 shadow-[0_1px_0_0_rgba(0,0,0,0.03)]">
        <img
            class="bg-white h-16 w-auto border border-[#a6705d]/30 rounded-md p-1 object-contain"
            src="{{ asset('images/logo2.png') }}"
            alt="Tag My Info"
        />
        <div class="min-w-0 flex-1">
            <h1 class="text-[20px] font-semibold text-[#a6705d] leading-tight truncate px-8">
                @if(($qrDetails[0]->profile->type ?? '') === 'Human')
                    My Info
                @else
{{--                    {{ ucfirst($qrDetails[0]->profile->type ?? 'Profile') }} Information--}}
                    My Info
                @endif
            </h1>
        </div>
    </div>

    <!-- Profile Image -->
    <div class="flex items-center justify-center px-4 pt-4 pb-0 ">
        @if(!empty($qrDetails[0]->profile->profile_image))
            <img src="{{ Storage::url($qrDetails[0]->profile->profile_image) }}" alt="Profile Image"
                 class="h-32 w-32 object-cover rounded-full border-2 border-gray-400 shadow-md">
        @else
            <img src="{{ asset('images/empty.jpg') }}" alt="Default Profile Image"
                 class="h-20 w-20 object-cover rounded-full border-2 border-gray-300 shadow-md">
        @endif
    </div>

    <!-- Details -->
    <div class="px-4 py-3 text-left">
        @foreach($qrDetails as $detail)
            @php
                $profile = $detail->profile ?? null;
                $ptype = strtolower(trim($profile->type ?? ''));
            @endphp

            @if(!$profile)
                <div class="border border-red-200 rounded-xl p-3 mb-4 bg-red-50 text-center">
                    <p class="text-red-600 font-medium text-sm">No profile linked for detail id {{ $detail->id }}</p>
                </div>
                @continue
            @endif

            <div class="grid grid-cols-1 gap-y-3 text-sm">
                @if($ptype === 'human')
                    @include('qr.details.human-details')

                @elseif($ptype === 'pet')
                    @include('qr.details.pet-details')

                @elseif($ptype === 'valuables')
                    @include('qr.details.valuables-details')

                @else
                    <div class="text-gray-600 text-sm">
                        Unknown profile type ({{ $profile->type ?? 'NULL' }})
                    </div>
                    <div class="bg-white p-3 rounded mt-2 text-xs overflow-auto">
                        {{ json_encode($profile->toArray(), JSON_PRETTY_PRINT) }}
                    </div>
                @endif
            </div>


        @endforeach
    </div>

</div>

    <!-- Sticky Bottom Navbar (Inside Card Width) -->
    @if($ptype == 'human' || $ptype == 'pet')
        @include('qr.details.nav-bar')
    @endif

</body>
</html>
