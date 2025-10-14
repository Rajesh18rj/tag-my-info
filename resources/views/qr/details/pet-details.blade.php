<!-- Field -->
<div class="bg-white shadow-md rounded-xl p-4 text-sm border border-[#a6705d]/30" >
    <dl class="grid gap-y-3 gap-x-6">

        <div class="flex">
            <dt class="font-semibold text-gray-400 w-32">Pet Name</dt>
            <dd class="font-semibold text-gray-700">{{ $profile->first_name }}</dd>
        </div>

        <div class="flex">
            <dt class="font-semibold text-gray-400 w-32">Breed</dt>
            <dd class="font-semibold text-gray-700">{{ $profile->breed_name ?? 'N/A' }}</dd>
        </div>

        <div class="flex">
            <dt class="font-semibold text-gray-400 w-32">Gender</dt>
            <dd class="font-semibold text-gray-700">{{ $profile->gender ?? 'N/A' }}</dd>
        </div>

        <div class="flex">
            <dt class="font-semibold text-gray-400 w-32">Hair Color</dt>
            <dd class="font-semibold text-gray-700">{{ $profile->hair_colour ?? 'N/A' }}</dd>
        </div>

        <div class="flex">
            <dt class="font-semibold text-gray-400 w-32">Eye Color</dt>
            <dd class="font-semibold text-gray-700">{{ $profile->eye_color ?? 'N/A' }}</dd>
        </div>

        <div class="flex">
            <dt class="font-semibold text-gray-400 w-32">Identify Mark</dt>
            <dd class="font-semibold text-gray-700">{{ $profile->identification_mark ?? 'N/A' }}</dd>
        </div>

        <div class="flex">
            <dt class="font-semibold text-gray-400 w-32">Note</dt>
            <dd class="font-semibold text-gray-700 whitespace-pre-line leading-snug">{{ $profile->notes ?? 'N/A' }}</dd>
        </div>
    </dl>

</div>

<!-- Pet Owners -->
<div id="pet-owners" class="mt-0 rounded-xl overflow-hidden border border-[#a6705d]/30 bg-white">
    <!-- Header -->
    <div class="flex items-center gap-2 px-3 py-2 bg-[#f7f4f2] border-b border-[#a6705d]/20">
        <i class="fas fa-paw text-[#a6705d] text-sm"></i>
        <p class="font-semibold text-[#7a5547] text-sm">Pet Owners</p>
    </div>

    <!-- Body -->
    <div class="p-3">
        @if($profile->petOwners && $profile->petOwners->isNotEmpty())
            <ul class="space-y-2">
                @foreach($profile->petOwners as $owner)
                    <li class="flex items-start gap-3 p-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                        <div class="flex-1 min-w-0">
                            <div class="text-gray-900 text-sm font-medium">
                                {{ $owner->name }}
                                @if($owner->relationship)
                                    <span class="text-gray-500 font-normal">({{ $owner->relationship }})</span>
                                @endif
                            </div>
                            <div class="text-gray-700 text-sm break-words">
                                @if(isset($profile->country) && strtolower($profile->country) === 'india')
                                    <span class="text-[#a6705d] font-medium tracking-wide mr-1">+91</span>
                                    {{ $owner->contact_number }}
                                @else
                                    {{ $owner->contact_number }}
                                @endif
                            </div>
                        </div>

                        <!-- Call & WhatsApp buttons -->
                        @php
                            $num = trim($owner->contact_number ?? '');
                            $cleanNum = $num ? preg_replace('/\s+/', '', $num) : '';

                            // Phone link
                            if ($cleanNum) {
                                if (isset($profile->country) && strtolower($profile->country) === 'india') {
                                    $tel = 'tel:+91' . $cleanNum;
                                } else {
                                    $tel = 'tel:' . $cleanNum;
                                }
                            } else {
                                $tel = '';
                            }

                            // WhatsApp link
                            if ($cleanNum) {
                                if (isset($profile->country) && strtolower($profile->country) === 'india') {
                                    $waLink = 'https://wa.me/91' . $cleanNum;
                                } else {
                                    $waLink = 'https://wa.me/' . $cleanNum;
                                }
                            } else {
                                $waLink = '';
                            }
                        @endphp

                        <div class="flex gap-2">
                            @if($tel)
                                <a href="{{ $tel }}"
                                   class="shrink-0 inline-flex items-center justify-center rounded-md bg-blue-500 text-white px-2.5 py-1.5 text-xs font-medium hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-[#a6705d] focus:ring-offset-2">
                                    <i class="fa-solid fa-phone mr-2 text-[13px]"></i>
                                    Call
                                </a>
                            @endif

                            @if($waLink)
                                <a href="{{ $waLink }}" target="_blank"
                                   class="shrink-0 flex items-center justify-center w-9 h-9 rounded-full bg-[#25D366] text-white text-xl shadow-md hover:shadow-lg transform hover:scale-110 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-[#a6705d] focus:ring-offset-2">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-400 text-sm px-1"><em>No pet owners recorded.</em></p>
        @endif
    </div>
</div>



<!-- Additional Information -->
<div>
    <div id="additional" class="flex items-center gap-2 px-3 py-2 bg-[#f7f4f2] border border-[#a6705d]/30 rounded-t-lg">
        <i class="fa-solid fa-plus text-[#7a5547] text-sm"></i>
        <h2 class="text-sm font-semibold text-[#7a5547]">Additional information</h2>
    </div>


    <div class="grid grid-cols-1 gap-y-3 text-sm border rounded-b-lg border-[#a6705d]/30">
        @if($ptype === 'pet')

            <!-- Field -->
            <div class="bg-white shadow-md rounded-xl p-4 text-sm">
                <dl class="grid gap-y-3 gap-x-6">

                    <div class="flex">
                        <dt class="font-semibold text-gray-400 w-32">City</dt>
                        <dd class="font-semibold text-gray-700">{{ $profile->city ?? 'N/A' }}</dd>
                    </div>

                    <div class="flex">
                        <dt class="font-semibold text-gray-400 w-32">State</dt>
                        <dd class="font-semibold text-gray-700">{{ $profile->state ?? 'N/A' }}</dd>
                    </div>

                    <div class="flex">
                        <dt class="font-semibold text-gray-400 w-32">Country</dt>
                        <dd class="font-semibold text-gray-700">{{ $profile->country ?? 'N/A' }}</dd>
                    </div>

                </dl>
            </div>
        @endif
    </div>
</div>

@if($profile->allergies && $profile->allergies->isNotEmpty())
    <!-- Allergies -->
<div id="allergies" class="mt-0 rounded-2xl overflow-hidden border border-orange-200 bg-white">
    <!-- Header -->
    <div class="flex items-center gap-2 px-3 py-2 bg-orange-50 border-b border-orange-200">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-orange-500/10 text-orange-600">
                              <i class="fas fa-allergies text-xs"></i>
                            </span>
        <p class="font-semibold text-orange-700 text-sm">Allergies</p>
    </div>

    <!-- Body -->
    <div class="p-3">
            <ul class="space-y-2.5">
                @foreach($profile->allergies as $allergy)
                    <li class="rounded-lg border border-orange-200/70 bg-orange-50/40 p-3">
                        <div class="flex gap-3">
                            <!-- Left accent -->
                            <span class="mt-0.5 h-auto w-1 rounded bg-orange-400/70"></span>

                            <div class="min-w-0 flex-1">
                                <!-- Name -->
                                <div class="text-[11px] font-medium text-gray-600">Allergy Name</div>
                                <div class="text-sm text-gray-900 font-medium">
                                    {{ $allergy->allergic_name }}
                                </div>

                                <!-- Notes -->
                                @if($allergy->notes)
                                    <div class="mt-2">
                                        <div class="text-[11px] font-medium text-gray-600">Note</div>
                                        <div class="text-sm text-gray-700 leading-snug">
                                            {{ $allergy->notes }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
    </div>
</div>
@endif

@if($profile->medications && $profile->medications->isNotEmpty())
<!-- Medications -->
<div id="medications"  class="mt-0 rounded-2xl overflow-hidden border border-emerald-200 bg-white">
    <!-- Header -->
    <div class="flex items-center gap-2 px-3 py-2 bg-emerald-50 border-b border-emerald-200">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-emerald-500/10 text-emerald-600">
                              <i class="fas fa-pills text-xs"></i>
                            </span>
        <p class="font-semibold text-emerald-700 text-sm">Medications</p>
    </div>

    <!-- Body -->
    <div class="p-3">
            <ul class="space-y-2.5">
                @foreach($profile->medications as $med)
                    <li class="rounded-lg border border-emerald-200/70 bg-emerald-50/40 p-3">
                        <div class="flex gap-3">
                            <!-- Left accent -->
                            <span class="mt-0.5 h-auto w-1 rounded bg-emerald-400/70"></span>

                            <div class="min-w-0 flex-1">
                                <!-- Name -->
                                <div class="text-[11px] font-medium text-gray-600">Medication Name</div>
                                <div class="text-sm text-gray-900 font-medium">
                                    {{ $med->medication_name }}
                                </div>

                                <!-- Dosage -->
                                @if($med->dosage)
                                    <div class="mt-2">
                                        <div class="text-[11px] font-medium text-gray-600">Dosage</div>
                                        <div class="text-sm text-gray-700">
                                            {{ $med->dosage }} {{ $med->dosage_unit ?? '' }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Frequency -->
                                @if($med->frequency)
                                    <div class="mt-2">
                                        <div class="text-[11px] font-medium text-gray-600">Frequency</div>
                                        <div class="text-sm text-gray-700">
                                            {{ $med->frequency }} {{ $med->frequency_type ?? '' }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Notes -->
                                @if($med->notes)
                                    <div class="mt-2">
                                        <div class="text-[11px] font-medium text-gray-600">Note</div>
                                        <div class="text-sm text-gray-700 leading-snug">
                                            {{ $med->notes }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
    </div>
</div>
@endif

@if($profile->vetDetails && $profile->vetDetails->isNotEmpty())
<!-- Vet Details -->
<div id="vet-details" class="mt-0 rounded-2xl overflow-hidden border border-blue-200 bg-white">
    <!-- Header -->
    <div class="flex items-center gap-2 px-3 py-2 bg-blue-50 border-b border-blue-200">
    <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-blue-500/10 text-blue-600">
      <i class="fas fa-user-md text-[11px] leading-none"></i>
    </span>
        <p class="font-semibold text-blue-700 text-sm">Vet Details</p>
    </div>

    <!-- Body -->
    <div class="p-3">
            <ul class="space-y-2">
                @foreach($profile->vetDetails as $vet)
                    <li class="rounded-lg border border-blue-200/70 bg-blue-50/40 p-3">
                        <div class="flex gap-3">
                            <!-- Left accent -->
                            <span class="mt-0.5 w-1 rounded bg-blue-500/70"></span>

                            <div class="min-w-0 flex-1">
                                <!-- Name -->
                                <div class="text-[11px] font-medium text-gray-700 tracking-wide">Vet Name</div>
                                <div class="text-sm text-gray-900 font-medium line-clamp-1">
                                    {{ $vet->name }}
                                </div>

                                <!-- Personal Number -->
                                @if($vet->personal_number)
                                    <div class="mt-2">
                                        <div class="text-[11px] font-medium text-gray-700 tracking-wide">Personal Number</div>
                                        <div class="text-sm text-gray-700 leading-snug">
                                            {{ $vet->personal_number }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Address -->
                                @if($vet->address)
                                    <div class="mt-2">
                                        <div class="text-[11px] font-medium text-gray-700 tracking-wide">Address</div>
                                        <div class="text-sm text-gray-700 leading-snug">
                                            {{ $vet->address }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
    </div>
</div>
@endif

@if($profile->instructions && $profile->instructions->isNotEmpty())
<!-- Instructions -->
<div id="instructions" class="mt-0 rounded-2xl overflow-hidden border border-gray-200 bg-white mb-14">
    <!-- Header -->
    <div class="flex items-center gap-2 px-3 py-2 bg-gray-50 border-b border-gray-200">
    <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-gray-500/10 text-gray-600">
      <i class="fas fa-clipboard-list text-[11px] leading-none"></i>
    </span>
        <p class="font-semibold text-gray-700 text-sm">Instructions</p>
    </div>

    <!-- Body -->
    <div class="p-3">
            <ul class="space-y-2">
                @foreach($profile->instructions as $instruction)
                    <li class="rounded-lg border border-gray-200/70 bg-gray-50/40 p-3">
                        <div class="flex gap-3">
                            <!-- Left accent -->
                            <span class="mt-0.5 w-1 rounded bg-gray-500/70"></span>

                            <div class="min-w-0 flex-1">
                                <!-- Title -->
                                <div class="text-[11px] font-medium text-gray-700 tracking-wide">Title</div>
                                <div class="text-sm text-gray-900 font-medium line-clamp-1">
                                    {{ $instruction->title }}
                                </div>

                                <!-- Notes -->
                                @if($instruction->notes)
                                    <div class="mt-2">
                                        <div class="text-[11px] font-medium text-gray-700 tracking-wide">Notes</div>
                                        <div class="text-sm text-gray-700 leading-snug">
                                            {{ $instruction->notes }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
    </div>
</div>
@endif

@if(
    (!$profile->instructions || $profile->instructions->isEmpty())
)
    <div class="mt-12"></div>
@endif
