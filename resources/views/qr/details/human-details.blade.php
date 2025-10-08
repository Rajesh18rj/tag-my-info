
<!-- Field -->
<div class="bg-white shadow-md rounded-xl p-4 text-sm border border-[#a6705d]/30" >
    <dl class="grid gap-y-3 gap-x-6">

        <div class="flex">
            <dt class="font-semibold text-gray-400 w-32">Name</dt>
            <dd class="font-semibold text-gray-700">{{ $profile->first_name }} {{ $profile->last_name ?? '' }}</dd>
        </div>

        <div class="flex">
            <dt class="font-semibold text-gray-400 w-32">Gender</dt>
            <dd class="font-semibold text-gray-700">{{ $profile->gender ?? 'N/A' }}</dd>
        </div>

        <div class="flex">
            <dt class="font-semibold text-gray-400 w-32">Blood Group</dt>
            <dd class="font-semibold text-gray-700">{{ $profile->blood_group ?? 'N/A' }}</dd>
        </div>

        @php
            $ageText = 'N/A';

            if (!empty($profile->birth_date)) {
                try {
                    $birth = \Carbon\Carbon::parse($profile->birth_date)->startOfDay();
                    $now   = \Carbon\Carbon::now()->startOfDay();

                    if ($birth->lessThanOrEqualTo($now)) {
                        // Start with raw differences
                        $years  = $now->year  - $birth->year;
                        $months = $now->month - $birth->month;
                        $days   = $now->day   - $birth->day;

                        // If days negative, borrow days from previous month
                        if ($days < 0) {
                            $prevMonth = $now->copy()->subMonthNoOverflow();
                            $daysInPrevMonth = $prevMonth->daysInMonth;
                            $days += $daysInPrevMonth;   // borrow
                            $months -= 1;
                        }

                        // If months negative, borrow from years
                        if ($months < 0) {
                            $months += 12;
                            $years  -= 1;
                        }

                        // Guard against negatives if birth is very close to now
                        $years  = max(0, $years);
                        $months = max(0, $months);
                        $days   = max(0, $days);

                        $ageText = "{$years} yrs {$months} mos {$days} days";
                    }
                } catch (\Throwable $e) {
                    $ageText = 'N/A';
                }
            }
        @endphp

        <div class="flex">
            <dt class="font-semibold text-gray-400 w-32">Age</dt>
            <dd class="font-semibold text-gray-700">{{ $ageText }}</dd>
        </div>


        <div class="flex">
            <dt class="font-semibold text-gray-400 w-32">Note</dt>
            <dd class="font-semibold text-gray-700 whitespace-pre-line leading-snug">{{ $profile->notes ?? 'N/A' }}</dd>
        </div>


    </dl>
</div>

<!-- Emergency Contacts -->
<div id="emergency" class="mt-0 rounded-xl overflow-hidden border border-[#a6705d]/30 bg-white">

    @php
        $num = trim($contact->mobile_number ?? '');
        $cleanNum = $num ? preg_replace('/\s+/', '', $num) : '';

        // Add +91 only if country is India
        if ($cleanNum) {
            if (isset($profile->country) && strtolower($profile->country) === 'india') {
                $tel = 'tel:+91' . $cleanNum;
            } else {
                $tel = 'tel:' . $cleanNum;
            }
        } else {
            $tel = '';
        }
    @endphp

        <!-- Header -->
    <div class="flex items-center gap-2 px-3 py-2 bg-[#f7f4f2] border-b border-[#a6705d]/20">
        <i class="fas fa-phone-volume text-[#a6705d] text-sm"></i>
        <p class="font-semibold text-[#7a5547] text-sm">Emergency Contacts</p>
    </div>

    <!-- Body -->
    <div class="p-3">
        @if($profile->emergencyContacts && $profile->emergencyContacts->isNotEmpty())
            <ul class="space-y-2">
                @foreach($profile->emergencyContacts as $contact)
                    <li class="flex items-start gap-3 p-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                        <div class="flex-1 min-w-0">
                            <div class="text-gray-900 text-sm font-medium">
                                {{ $contact->name }}
                                @if($contact->relationship)
                                    <span class="text-gray-500 font-normal">({{ $contact->relationship }})</span>
                                @endif
                            </div>
                            <div class="text-gray-700 text-sm break-words">
                                @if(isset($profile->country) && strtolower($profile->country) === 'india')
                                    <span class="text-[#a6705d] font-medium tracking-wide mr-1">+91</span>
                                    {{ $contact->mobile_number }}
                                @else
                                    {{ $contact->mobile_number }}
                                @endif
                            </div>

                        </div>

                        <!-- Call & WhatsApp buttons -->
                        @php
                            $num = trim($contact->mobile_number ?? '');
                            $cleanNum = $num ? preg_replace('/\s+/', '', $num) : '';
                            $tel = $cleanNum ? 'tel:' . $cleanNum : '';

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
            <p class="text-gray-400 text-sm px-1"><em>No emergency contacts recorded.</em></p>
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
        @if($ptype === 'human')

            <!-- Field -->
            <div class="bg-white shadow-md rounded-xl p-4 text-sm">
                <dl class="grid gap-y-3 gap-x-6">

                    <div class="flex">
                        <dt class="font-semibold text-gray-400 w-32">D.O.B</dt>
                        <dd class="font-semibold text-gray-700">
                            @if(!empty($profile->birth_date))
                                {{ \Carbon\Carbon::parse($profile->birth_date)->format('d/m/Y') }}
                            @else
                                N/A
                            @endif
                        </dd>
                    </div>


                    <div class="flex">
                        <dt class="font-semibold text-gray-400 w-32">My Number</dt>
                        <dd class="font-semibold text-gray-700 break-words">{{ $profile->personal_number ?? 'N/A' }}</dd>
                    </div>

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

<!-- Allergies -->
@if($profile->allergies && $profile->allergies->isNotEmpty())
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

<!-- Medications -->
@if($profile->medications && $profile->medications->isNotEmpty())
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

<!-- Health Insurances -->
@if($profile->healthInsurances && $profile->healthInsurances->isNotEmpty())
<div id="insurance" class="mt-0 rounded-2xl overflow-hidden border border-fuchsia-200 bg-white">
    <!-- Header -->
    <div class="flex items-center gap-2 px-3 py-2 bg-fuchsia-50 border-b border-fuchsia-200">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-fuchsia-500/10 text-fuchsia-600">
                              <i class="fas fa-hospital-user text-xs"></i>
                            </span>
        <p class="font-semibold text-fuchsia-700 text-sm">Health Insurances</p>
    </div>

    <!-- Body -->
    <div class="p-3">
            <ul class="space-y-2.5">
                @foreach($profile->healthInsurances as $insurance)
                    <li class="rounded-lg border border-fuchsia-200/70 bg-fuchsia-50/40 p-3">
                        <div class="flex gap-3">
                            <!-- Left accent -->
                            <span class="mt-0.5 h-auto w-1 rounded bg-fuchsia-400/70"></span>

                            <div class="min-w-0 flex-1">
                                <!-- Company -->
                                <div class="text-[11px] font-medium text-gray-600">Company</div>
                                <div class="text-sm text-gray-900 font-medium break-words">
                                    {{ $insurance->insurance_company_name }}
                                </div>

                                <!-- Notes -->
                                @if($insurance->insurance_notes)
                                    <div class="mt-2">
                                        <div class="text-[11px] font-medium text-gray-600">Note</div>
                                        <div class="text-sm text-gray-700 leading-snug">
                                            {{ $insurance->insurance_notes }}
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


<!-- Vital Medical Conditions -->
@if($profile->vitalMedicalConditions && $profile->vitalMedicalConditions->isNotEmpty())
<div id="conditions"  class="mt-0 rounded-2xl overflow-hidden border border-indigo-200 bg-white mb-16">
    <!-- Header -->
    <div class="flex items-center gap-2 px-3 py-2 bg-indigo-50 border-b border-indigo-200">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-indigo-500/10 text-indigo-600">
                              <i class="fas fa-heartbeat text-xs"></i>
                            </span>
        <p class="font-semibold text-indigo-700 text-sm">Vital Medical Conditions</p>
    </div>

    <!-- Body -->
    <div class="p-3">
            <ul class="space-y-2.5">
                @foreach($profile->vitalMedicalConditions as $condition)
                    <li class="rounded-lg border border-indigo-200/70 bg-indigo-50/40 p-3">
                        <div class="flex gap-3">
                            <!-- Left accent -->
                            <span class="mt-0.5 h-auto w-1 rounded bg-indigo-400/70"></span>

                            <div class="min-w-0 flex-1">
                                <!-- Condition -->
                                <div class="text-[11px] font-medium text-gray-600">Condition</div>
                                <div class="text-sm text-gray-900 font-medium break-words">
                                    {{ $condition->condition_name }}
                                </div>

                                <!-- Notes -->
                                @if($condition->notes)
                                    <div class="mt-2">
                                        <div class="text-[11px] font-medium text-gray-600">Note</div>
                                        <div class="text-sm text-gray-700 leading-snug">
                                            {{ $condition->notes }}
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
    (!$profile->vitalMedicalConditions || $profile->vitalMedicalConditions->isEmpty())
)
    <div class="mt-12"></div>
@endif



