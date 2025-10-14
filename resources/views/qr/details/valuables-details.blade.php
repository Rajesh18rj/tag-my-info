<!-- Profile Summary -->
<div class="bg-white shadow-md rounded-xl p-4 text-sm border border-[#a6705d]/30">
    <dl class="grid gap-y-3 gap-x-6">
        <!-- Item Name -->
        <div class="flex items-start">
            <dt class="font-semibold text-gray-400 w-32 shrink-0">Item Name</dt>
            <dd class="font-semibold text-gray-700">{{ $profile->first_name }}</dd>
        </div>

        <!-- Personal Number with Call & WhatsApp -->
        <div class="flex items-start">
            <dt class="font-semibold text-gray-400 w-32 shrink-0">Contact No 1</dt>
            <dd class="flex items-center gap-3">
                <span class="font-semibold text-gray-700">{{ $profile->personal_number }}</span>
                @if($profile->personal_number)
                    @php
                        $num1 = trim($profile->personal_number);
                        $cleanNum1 = preg_replace('/\s+/', '', $num1);
                        $tel1 = 'tel:' . $cleanNum1;

                        // WhatsApp link for Contact No 1
                        if (isset($profile->country) && strtolower($profile->country) === 'india') {
                            $wa1 = 'https://wa.me/91' . $cleanNum1;
                        } else {
                            $wa1 = 'https://wa.me/' . $cleanNum1;
                        }
                    @endphp

                    <div class="flex gap-2">
                        <a href="{{ $tel1 }}"
                           class="shrink-0 inline-flex items-center justify-center rounded-md bg-blue-500 text-white px-2.5 py-1.5 text-xs font-medium hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-[#a6705d] focus:ring-offset-2">
                            <i class="fa-solid fa-phone mr-2 text-[13px]"></i>
                            Call
                        </a>

                        <a href="{{ $wa1 }}" target="_blank"
                           class="shrink-0 flex items-center justify-center w-9 h-9 rounded-full bg-[#25D366] text-white text-xl shadow-md hover:shadow-lg transform hover:scale-110 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#a6705d] focus:ring-offset-2">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                @endif
            </dd>
        </div>

        <!-- Alternate Number with Call & WhatsApp -->
        <div class="flex items-start">
            <dt class="font-semibold text-gray-400 w-32 shrink-0">Contact No 2</dt>
            <dd class="flex items-center gap-3">
                <span class="font-semibold text-gray-700">{{ $profile->alternate_number }}</span>
                @if($profile->alternate_number)
                    @php
                        $num2 = trim($profile->alternate_number);
                        $cleanNum2 = preg_replace('/\s+/', '', $num2);
                        $tel2 = 'tel:' . $cleanNum2;

                        // WhatsApp link for Contact No 2
                        if (isset($profile->country) && strtolower($profile->country) === 'india') {
                            $wa2 = 'https://wa.me/91' . $cleanNum2;
                        } else {
                            $wa2 = 'https://wa.me/' . $cleanNum2;
                        }
                    @endphp

                    <div class="flex gap-2">
                        <a href="{{ $tel2 }}"
                           class="shrink-0 inline-flex items-center justify-center rounded-md bg-blue-500 text-white px-2.5 py-1.5 text-xs font-medium hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-[#a6705d] focus:ring-offset-2">
                            <i class="fa-solid fa-phone mr-2 text-[13px]"></i>
                            Call
                        </a>

                        <a href="{{ $wa2 }}" target="_blank"
                           class="shrink-0 flex items-center justify-center w-9 h-9 rounded-full bg-[#25D366] text-white text-xl shadow-md hover:shadow-lg transform hover:scale-110 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#a6705d] focus:ring-offset-2">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                @endif
            </dd>
        </div>

        <!-- Email -->
        <div class="flex items-start">
            <dt class="font-semibold text-gray-400 w-32 shrink-0">Email</dt>
            <dd class="font-semibold text-gray-700 break-all">{{ $profile->email }}</dd>
        </div>

        <!-- Note -->
        <div class="flex items-start">
            <dt class="font-semibold text-gray-400 w-28 shrink-0">Note</dt>
            <dd class="w-full">
                <div class="rounded-xl border border-[#a6705d]/30 overflow-hidden">
                    <div class="p-4 bg-[#f7f4f2] shadow-lg">
                        <div class="text-gray-700 leading-relaxed">
                            {{ $profile->notes }}
                        </div>
                    </div>
                </div>
            </dd>
        </div>
    </dl>
</div>
