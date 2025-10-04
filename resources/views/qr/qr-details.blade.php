<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>View Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-start py-4 px-3">

<div class="w-full max-w-sm bg-white shadow-xl rounded-2xl border-2 border-[#a6705d] overflow-hidden">
    <!-- Header -->
    <div class="bg-[#f7f4f2] px-4 py-3 flex items-center gap-3 border-b border-[#a6705d]/20 shadow-[0_1px_0_0_rgba(0,0,0,0.03)]">
        <img
            class="bg-white h-16 w-auto border border-[#a6705d]/30 rounded-md p-1 object-contain"
            src="{{ asset('images/logo2.png') }}"
            alt="Tag My Info"
        />
        <div class="min-w-0 flex-1">
            <h1 class="text-[20px] font-semibold text-[#a6705d] leading-tight truncate">
                @if(($qrDetails[0]->profile->type ?? '') === 'Human')
                    Personal Information
                @else
                    {{ ucfirst($qrDetails[0]->profile->type ?? 'Profile') }} Information
                @endif
            </h1>
        </div>
    </div>

    <!-- Profile Image -->
    <div class="flex items-center justify-center px-4 pt-4 pb-2 ">
        @if(!empty($qrDetails[0]->profile->profile_image))
            <img src="{{ Storage::url($qrDetails[0]->profile->profile_image) }}" alt="Profile Image"
                 class="h-24 w-24 object-cover rounded-full border-2 border-gray-400 shadow-md">
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

                    <!-- Field -->
                    <div class="bg-white shadow-md rounded-xl p-4 text-sm border border-[#a6705d]/30" >
                        <dl class="grid gap-y-3 gap-x-6">

                            <div class="flex">
                                <dt class="font-semibold text-gray-500 w-32">Name</dt>
                                <dd class="font-semibold text-gray-700">{{ $profile->first_name }} {{ $profile->last_name ?? '' }}</dd>
                            </div>

                            <div class="flex">
                                <dt class="font-semibold text-gray-500 w-32">Gender</dt>
                                <dd class="font-semibold text-gray-700">{{ $profile->gender ?? 'N/A' }}</dd>
                            </div>

                            <div class="flex">
                                <dt class="font-semibold text-gray-500 w-32">Blood Group</dt>
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
                                <dt class="font-semibold text-gray-500 w-32">Age</dt>
                                <dd class="font-semibold text-gray-700">{{ $ageText }}</dd>
                            </div>


                            <div class="flex">
                                <dt class="font-semibold text-gray-500 w-32">Notes</dt>
                                <dd class="font-semibold text-gray-700 whitespace-pre-line leading-snug">{{ $profile->notes ?? 'N/A' }}</dd>
                            </div>


                        </dl>
                    </div>

                    <!-- Emergency Contacts -->
                    <div class="mt-0 rounded-xl overflow-hidden border border-[#a6705d]/30 bg-white">
                        <!-- Header -->
                        <div class="flex items-center gap-2 px-3 py-2 bg-[#f7f4f2] border-b border-[#a6705d]/20">
                            <div class="h-5 w-1.5 rounded-full bg-[#a6705d]"></div>
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
                                                    {{ $contact->mobile_number }}
                                                </div>
                                            </div>

                                            <!-- Call button -->
                                            @php
                                                $num = trim($contact->mobile_number ?? '');
                                                $tel = $num ? 'tel:' . preg_replace('/\s+/', '', $num) : '';
                                            @endphp
                                            @if($tel)
                                                <a href="{{ $tel }}"
                                                   class="shrink-0 inline-flex items-center justify-center rounded-md bg-green-400 text-white px-2.5 py-1.5 text-xs font-medium hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-[#a6705d] focus:ring-offset-2">
                                                    <i class="fa-solid fa-phone mr-1 text-[11px]"></i>
                                                    Call
                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-400 text-sm px-1"><em>No emergency contacts recorded.</em></p>
                            @endif
                        </div>
                    </div>

            <!------------------- Second Container --------------------------->
                <div>
                    <div class="flex items-center gap-2 px-3 py-2 bg-[#f7f4f2] border border-[#a6705d]/30 rounded-t-lg">
                        <div class="h-4 w-1.5 rounded-full bg-[#a6705d]"></div>
                        <i class="fa-solid fa-plus text-[#7a5547] text-sm"></i>
                        <h2 class="text-sm font-semibold text-[#7a5547]">Additional information</h2>
                    </div>


                    <div class="grid grid-cols-1 gap-y-3 text-sm border rounded-b-lg border-[#a6705d]/30">
                        @if($ptype === 'human')

                            <!-- Field -->
                            <div class="bg-white shadow-md rounded-xl p-4 text-sm">
                                <dl class="grid gap-y-3 gap-x-6">

                                    <div class="flex">
                                        <dt class="font-semibold text-gray-500 w-32">D.O.B</dt>
                                        <dd class="font-semibold text-gray-700">
                                            @if(!empty($profile->birth_date))
                                                {{ \Carbon\Carbon::parse($profile->birth_date)->format('d/m/Y') }}
                                            @else
                                                N/A
                                            @endif
                                        </dd>
                                    </div>


                                    <div class="flex">
                                        <dt class="font-semibold text-gray-500 w-32">My Number</dt>
                                        <dd class="font-semibold text-gray-700 break-words">{{ $profile->personal_number ?? 'N/A' }}</dd>
                                    </div>

                                    <div class="flex">
                                        <dt class="font-semibold text-gray-500 w-32">City</dt>
                                        <dd class="font-semibold text-gray-700">{{ $profile->city ?? 'N/A' }}</dd>
                                    </div>

                                    <div class="flex">
                                        <dt class="font-semibold text-gray-500 w-32">State</dt>
                                        <dd class="font-semibold text-gray-700">{{ $profile->state ?? 'N/A' }}</dd>
                                    </div>

                                    <div class="flex">
                                        <dt class="font-semibold text-gray-500 w-32">Country</dt>
                                        <dd class="font-semibold text-gray-700">{{ $profile->country ?? 'N/A' }}</dd>
                                    </div>

                                </dl>
                            </div>
                        @endif
                    </div>
                </div>

                    <!-- Allergies -->
                    <div class="mt-0 rounded-2xl overflow-hidden border border-orange-200 bg-white">
                        <!-- Header -->
                        <div class="flex items-center gap-2 px-3 py-2 bg-orange-50 border-b border-orange-200">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-orange-500/10 text-orange-600">
                              <i class="fas fa-allergies text-xs"></i>
                            </span>
                            <p class="font-semibold text-orange-700 text-sm">Allergies</p>
                        </div>

                        <!-- Body -->
                        <div class="p-3">
                            @if($profile->allergies && $profile->allergies->isNotEmpty())
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
                                                            <div class="text-[11px] font-medium text-gray-600">Notes</div>
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
                            @else
                                <p class="text-gray-400 text-sm"><em>No allergies recorded.</em></p>
                            @endif
                        </div>
                    </div>

                    <!-- Medications -->
                    <div class="mt-0 rounded-2xl overflow-hidden border border-emerald-200 bg-white">
                        <!-- Header -->
                        <div class="flex items-center gap-2 px-3 py-2 bg-emerald-50 border-b border-emerald-200">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-emerald-500/10 text-emerald-600">
                              <i class="fas fa-pills text-xs"></i>
                            </span>
                            <p class="font-semibold text-emerald-700 text-sm">Medications</p>
                        </div>

                        <!-- Body -->
                        <div class="p-3">
                            @if($profile->medications && $profile->medications->isNotEmpty())
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
                                                            <div class="text-[11px] font-medium text-gray-600">Notes</div>
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
                            @else
                                <p class="text-gray-400 text-sm"><em>No medications recorded.</em></p>
                            @endif
                        </div>
                    </div>

                    <!-- Health Insurances -->
                    <div class="mt-0 rounded-2xl overflow-hidden border border-fuchsia-200 bg-white">
                        <!-- Header -->
                        <div class="flex items-center gap-2 px-3 py-2 bg-fuchsia-50 border-b border-fuchsia-200">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-fuchsia-500/10 text-fuchsia-600">
                              <i class="fas fa-file-medical text-xs"></i>
                            </span>
                            <p class="font-semibold text-fuchsia-700 text-sm">Health Insurances</p>
                        </div>

                        <!-- Body -->
                        <div class="p-3">
                            @if($profile->healthInsurances && $profile->healthInsurances->isNotEmpty())
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
                                                            <div class="text-[11px] font-medium text-gray-600">Notes</div>
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
                            @else
                                <p class="text-gray-400 text-sm"><em>No health insurances recorded.</em></p>
                            @endif
                        </div>
                    </div>

                    <!-- Vital Medical Conditions -->
                    <div class="mt-0 rounded-2xl overflow-hidden border border-indigo-200 bg-white">
                        <!-- Header -->
                        <div class="flex items-center gap-2 px-3 py-2 bg-indigo-50 border-b border-indigo-200">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-indigo-500/10 text-indigo-600">
                              <i class="fas fa-heartbeat text-xs"></i>
                            </span>
                            <p class="font-semibold text-indigo-700 text-sm">Vital Medical Conditions</p>
                        </div>

                        <!-- Body -->
                        <div class="p-3">
                            @if($profile->vitalMedicalConditions && $profile->vitalMedicalConditions->isNotEmpty())
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
                                                            <div class="text-[11px] font-medium text-gray-600">Notes</div>
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
                            @else
                                <p class="text-gray-400 text-sm"><em>No vital medical conditions recorded.</em></p>
                            @endif
                        </div>
                    </div>

                @elseif($ptype === 'pet')
                    <div>
                        <div class="font-semibold text-gray-600 text-xs">Pet Name</div>
                        <div class="text-gray-900">{{ $profile->first_name }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600 text-xs">Breed</div>
                        <div class="text-gray-900">{{ $profile->breed_name ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600 text-xs">Gender</div>
                        <div class="text-gray-900">{{ $profile->gender ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600 text-xs">City</div>
                        <div class="text-gray-900">{{ $profile->city ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600 text-xs">State</div>
                        <div class="text-gray-900">{{ $profile->state ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600 text-xs">Country</div>
                        <div class="text-gray-900">{{ $profile->country ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600 text-xs">Identification Mark</div>
                        <div class="text-gray-900">{{ $profile->identification_mark ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600 text-xs">Notes</div>
                        <div class="text-gray-900">{{ $profile->notes ?? 'N/A' }}</div>
                    </div>

                    <div class="mt-3 rounded-lg p-3 bg-yellow-50">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-user-friends text-yellow-600 mr-2 text-sm"></i>
                            <p class="font-semibold text-yellow-700 text-sm">Pet Owners</p>
                        </div>
                        @if($profile->petOwners && $profile->petOwners->isNotEmpty())
                            <ul class="list-disc pl-4 text-gray-800 space-y-1 text-sm">
                                @foreach($profile->petOwners as $owner)
                                    <li>
                                        <span class="font-medium">{{ $owner->name }}</span>
                                        @if($owner->relationship)
                                            <span class="text-gray-500">({{ $owner->relationship }})</span>
                                        @endif
                                        <span class="ml-2 text-gray-700">- {{ $owner->contact_number }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-400 text-sm"><em>No pet owners recorded.</em></p>
                        @endif
                    </div>

                    <div class="mt-3 rounded-lg p-3 bg-orange-50">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-allergies text-red-600 mr-2 text-sm"></i>
                            <p class="font-semibold text-red-700 text-sm">Allergies</p>
                        </div>
                        @if($profile->allergies && $profile->allergies->isNotEmpty())
                            <ul class="list-disc pl-4 text-gray-800 space-y-1 text-sm">
                                @foreach($profile->allergies as $allergy)
                                    <li>
                                        <span class="font-medium">{{ $allergy->allergic_name }}</span>
                                        @if($allergy->notes)
                                            <span class="text-gray-500">({{ $allergy->notes }})</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-400 text-sm"><em>No allergies recorded.</em></p>
                        @endif
                    </div>

                    <div class="mt-3 rounded-lg p-3 bg-green-50">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-pills text-red-400 mr-2 text-sm"></i>
                            <p class="font-semibold text-red-700 text-sm">Medications</p>
                        </div>
                        @if($profile->medications && $profile->medications->isNotEmpty())
                            <ul class="list-disc pl-4 text-gray-800 space-y-1 text-sm">
                                @foreach($profile->medications as $med)
                                    <li>
                                        <span class="font-medium">{{ $med->medication_name }}</span>
                                        @if($med->dosage)
                                            <span class="ml-1 text-gray-700">- {{ $med->dosage }} {{ $med->dosage_unit ?? '' }}</span>
                                        @endif
                                        @if($med->frequency)
                                            <span class="ml-2 text-gray-500">({{ $med->frequency }} {{ $med->frequency_type ?? '' }})</span>
                                        @endif
                                        @if($med->notes)
                                            <span class="ml-2 text-gray-400">- Notes: {{ $med->notes }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-400 text-sm"><em>No medications recorded.</em></p>
                        @endif
                    </div>

                    <div class="mt-3 rounded-lg p-3 bg-blue-50">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-user-md text-blue-600 mr-2 text-sm"></i>
                            <p class="font-semibold text-blue-700 text-sm">Vet Details</p>
                        </div>
                        @if($profile->vetDetails && $profile->vetDetails->isNotEmpty())
                            <ul class="list-disc pl-4 text-gray-800 space-y-1 text-sm">
                                @foreach($profile->vetDetails as $vet)
                                    <li>
                                        <span class="font-medium">{{ $vet->name }}</span>
                                        @if($vet->personal_number)
                                            <span class="text-gray-700">- {{ $vet->personal_number }}</span>
                                        @endif
                                        @if($vet->address)
                                            <span class="text-gray-500">({{ $vet->address }})</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-400 text-sm"><em>No vet details recorded.</em></p>
                        @endif
                    </div>

                    <div class="mt-3 rounded-lg p-3 bg-gray-100">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-clipboard-list text-gray-600 mr-2 text-sm"></i>
                            <p class="font-semibold text-gray-700 text-sm">Instructions</p>
                        </div>
                        @if($profile->instructions && $profile->instructions->isNotEmpty())
                            <ul class="list-disc pl-4 text-gray-800 space-y-1 text-sm">
                                @foreach($profile->instructions as $instruction)
                                    <li>
                                        <strong>{{ $instruction->title }}</strong>
                                        @if($instruction->notes)
                                            <span class="ml-1 text-gray-700">- {{ $instruction->notes }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-400 text-sm"><em>No instructions recorded.</em></p>
                        @endif
                    </div>

                @elseif($ptype === 'valuables')
                    <div>
                        <div class="font-semibold text-gray-600 text-xs">Item Name</div>
                        <div class="text-gray-900">{{ $profile->first_name }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600 text-xs">Personal Number</div>
                        <div class="text-gray-900 break-words">{{ $profile->personal_number ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600 text-xs">Alternate Number</div>
                        <div class="text-gray-900 break-words">{{ $profile->alternate_number ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600 text-xs">Email</div>
                        <div class="text-gray-900 break-words">{{ $profile->email ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600 text-xs">Description</div>
                        <div class="text-gray-900 whitespace-pre-line leading-snug">{{ $profile->notes ?? 'N/A' }}</div>
                    </div>

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

</body>
</html>
