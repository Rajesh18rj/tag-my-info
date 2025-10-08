<!-- Profile Summary -->
<div class="bg-white shadow-md rounded-xl p-4 text-sm border border-[#a6705d]/30">
    <dl class="grid gap-y-3 gap-x-6">
        <!-- Item Name -->
        <div class="flex items-start">
            <dt class="font-semibold text-gray-400 w-32 shrink-0">Item Name</dt>
            <dd class="font-semibold text-gray-700">{{ $profile->first_name }}</dd>
        </div>

        <!-- Personal Number with Call -->
        <div class="flex items-start">
            <dt class="font-semibold text-gray-400 w-32 shrink-0">Contact No 1</dt>
            <dd class="flex items-center gap-3">
                <span class="font-semibold text-gray-700">{{ $profile->personal_number }}</span>
                @if($profile->personal_number)
                    <a href="tel:{{ preg_replace('/\\D+/', '', $profile->personal_number) }}"
                       class="shrink-0 inline-flex items-center justify-center rounded-md bg-green-400 text-white px-2.5 py-1.5 text-xs font-medium hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-[#a6705d] focus:ring-offset-2">
                        <i class="fa-solid fa-phone mr-1 text-[11px]"></i>
                        Call
                    </a>
                @endif
            </dd>
        </div>

        <!-- Alternate Number with Call -->
        <div class="flex items-start">
            <dt class="font-semibold text-gray-400 w-32 shrink-0">Contact No 2</dt>
            <dd class="flex items-center gap-3">
                <span class="font-semibold text-gray-700">{{ $profile->alternate_number }}</span>
                @if($profile->alternate_number)
                    <a href="tel:{{ preg_replace('/\\D+/', '', $profile->alternate_number) }}"
                       class="shrink-0 inline-flex items-center justify-center rounded-md bg-green-400 text-white px-2.5 py-1.5 text-xs font-medium hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-[#a6705d] focus:ring-offset-2">
                        <i class="fa-solid fa-phone mr-1 text-[11px]"></i>
                        Call
                    </a>
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
