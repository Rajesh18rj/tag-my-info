<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code ID Card</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

<div class="max-w-md w-full bg-white shadow-xl rounded-2xl p-0 border-2 border-red-400 overflow-hidden">
    <!-- Header: Profile Type & Name -->
    <div class="bg-gradient-to-r from-red-600 via-gray-700 to-gray-800 px-6 py-4 flex items-center">
        <div class="mr-4">
            <img class="bg-white h-15 w-20 mr-4 border" src="{{ asset('images/logo2.png') }}"
                 alt="Tag My Info">
        </div>
        <div>
            <h1 class="text-xl font-bold text-white">
                {{ $qrDetails[0]->profile->type ?? 'Profile' }} Information
            </h1>
        </div>
    </div>

    <!-- Profile Image (optional) -->
    <div class="flex items-center justify-center pt-4 pb-2">
        @isset($qrDetails[0]->profile->image)
            <img src="{{ asset($qrDetails[0]->profile->image) }}" alt="Profile Image"
                 class="h-24 w-24 object-cover rounded-full border-4 border-red-300 shadow-md">
        @else
            <div class="h-24 w-24 flex items-center justify-center rounded-full bg-gray-200 border-4 border-gray-300 text-gray-400 font-bold">IMG</div>
        @endisset
    </div>

    <!-- Profile Details as clean fields -->
    <div class="px-8 py-4">
        @foreach($qrDetails as $detail)
            @php
                $profile = $detail->profile ?? null;
                $ptype = strtolower(trim($profile->type ?? ''));
            @endphp

            @if(!$profile)
                <div class="border border-red-200 rounded-xl p-4 mb-5 bg-red-50 text-center">
                    <p class="text-red-600 font-medium">No profile linked for detail id {{ $detail->id }}</p>
                </div>
                @continue
            @endif

            <!-- The ID Card details area -->
            <div>
                <div class="grid grid-cols-2 gap-x-6 gap-y-3 text-sm">
                    @if($ptype === 'human')
                        <div class="font-bold text-gray-600">Full Name</div>
                        <div>{{ $profile->first_name }} {{ $profile->last_name ?? '' }}</div>
                        <div class="font-bold text-gray-600">Birth Date</div>
                        <div>
                            @if($profile->birth_date)
                                {{ $profile->birth_date }}
                                ({{ \Carbon\Carbon::parse($profile->birth_date)->age }} years old)
                            @else
                                N/A
                            @endif
                        </div>
                        <div class="font-bold text-gray-600">Gender</div>
                        <div>{{ $profile->gender ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">Blood Group</div>
                        <div>{{ $profile->blood_group ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">Personal Number</div>
                        <div>{{ $profile->personal_number ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">City</div>
                        <div>{{ $profile->city ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">State</div>
                        <div>{{ $profile->state ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">Country</div>
                        <div>{{ $profile->country ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">Notes</div>
                        <div>{{ $profile->notes ?? 'N/A' }}</div>


                        {{-- Allergies inside Human --}}
                        <div class="mt-4 col-span-2 bg-orange-50 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-allergies text-red-600 mr-2"></i>
                                <p class="font-semibold text-red-700 text-base">Allergies</p>
                            </div>
                            @if($profile->allergies && $profile->allergies->isNotEmpty())
                                <ul class="list-disc pl-5 text-gray-800 space-y-1">
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
                                <p class="text-gray-400"><em>No allergies recorded.</em></p>
                            @endif
                        </div>

                        {{-- Emergency Contacts --}}
                        <div class="mt-2 col-span-2 bg-red-50 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-phone-volume text-red-500 mr-2"></i>
                                <p class="font-semibold text-red-700 text-base">Emergency Contacts</p>
                            </div>
                            @if($profile->emergencyContacts && $profile->emergencyContacts->isNotEmpty())
                                <ul class="list-disc pl-5 text-gray-800 space-y-1">
                                    @foreach($profile->emergencyContacts as $contact)
                                        <li>
                                            <span class="font-medium">{{ $contact->name }}</span>
                                            @if($contact->relationship)
                                                <span class="text-gray-500">({{ $contact->relationship }})</span>
                                            @endif
                                            <span class="ml-2 text-gray-700">- {{ $contact->mobile_number }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-400"><em>No emergency contacts recorded.</em></p>
                            @endif
                        </div>

                        {{-- Medications --}}
                        <div class="mt-2 col-span-2 bg-green-50 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-pills text-red-400 mr-2"></i>
                                <p class="font-semibold text-red-700 text-base">Medications</p>
                            </div>
                            @if($profile->medications && $profile->medications->isNotEmpty())
                                <ul class="list-disc pl-5 text-gray-800 space-y-1">
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
                                <p class="text-gray-400"><em>No medications recorded.</em></p>
                            @endif
                        </div>

                        {{-- Health Insurances --}}
                        <div class="mt-2 col-span-2 bg-fuchsia-50 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-file-medical text-fuchsia-600 mr-2"></i>
                                <p class="font-semibold text-fuchsia-700 text-base">Health Insurances</p>
                            </div>
                            @if($profile->healthInsurances && $profile->healthInsurances->isNotEmpty())
                                <ul class="list-disc pl-5 text-gray-800 space-y-1">
                                    @foreach($profile->healthInsurances as $insurance)
                                        <li>
                                            <span class="font-medium">{{ $insurance->insurance_company_name }}</span>
                                            @if($insurance->insurance_notes)
                                                <span class="text-gray-500">- Notes: {{ $insurance->insurance_notes }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-400"><em>No health insurances recorded.</em></p>
                            @endif
                        </div>


                        {{-- Vital Medical Conditions --}}
                        <div class="mt-2 col-span-2 bg-indigo-50 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-heartbeat text-indigo-600 mr-2"></i>
                                <p class="font-semibold text-indigo-700 text-base">Vital Medical Conditions</p>
                            </div>
                            @if($profile->vitalMedicalConditions && $profile->vitalMedicalConditions->isNotEmpty())
                                <ul class="list-disc pl-5 text-gray-800 space-y-1">
                                    @foreach($profile->vitalMedicalConditions as $condition)
                                        <li>
                                            <span class="font-medium">{{ $condition->condition_name }}</span>
                                            @if($condition->notes)
                                                <span class="text-gray-500">- Notes: {{ $condition->notes }}</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-400"><em>No vital medical conditions recorded.</em></p>
                            @endif
                        </div>



                    @elseif($ptype === 'pet')
                        <div class="font-bold text-gray-600">Pet Name</div>
                        <div>{{ $profile->first_name }}</div>
                        <div class="font-bold text-gray-600">Breed</div>
                        <div>{{ $profile->breed_name ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">Gender</div>
                        <div>{{ $profile->gender ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">City</div>
                        <div>{{ $profile->city ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">State</div>
                        <div>{{ $profile->state ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">Country</div>
                        <div>{{ $profile->country ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">Identification Mark</div>
                        <div>{{ $profile->identification_mark ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">Notes</div>
                        <div>{{ $profile->notes ?? 'N/A' }}</div>

                        {{-- Pet Owners --}}
                        <div class="mt-4 col-span-2 bg-yellow-50 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-user-friends text-yellow-600 mr-2"></i>
                                <p class="font-semibold text-yellow-700 text-base">Pet Owners</p>
                            </div>
                            @if($profile->petOwners && $profile->petOwners->isNotEmpty())
                                <ul class="list-disc pl-5 text-gray-800 space-y-1">
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
                                <p class="text-gray-400"><em>No pet owners recorded.</em></p>
                            @endif
                        </div>


                        {{-- Allergies inside Pet --}}
                        <div class="mt-2 col-span-2 bg-orange-50 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-allergies text-red-600 mr-2"></i>
                                <p class="font-semibold text-red-700 text-base">Allergies</p>
                            </div>
                            @if($profile->allergies && $profile->allergies->isNotEmpty())
                                <ul class="list-disc pl-5 text-gray-800 space-y-1">
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
                                <p class="text-gray-400"><em>No allergies recorded.</em></p>
                            @endif
                        </div>

                        {{-- Medications for pet --}}
                        <div class="mt-2 col-span-2 bg-green-50 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-pills text-red-400 mr-2"></i>
                                <p class="font-semibold text-red-700 text-base">Medications</p>
                            </div>
                            @if($profile->medications && $profile->medications->isNotEmpty())
                                <ul class="list-disc pl-5 text-gray-800 space-y-1">
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
                                <p class="text-gray-400"><em>No medications recorded.</em></p>
                            @endif
                        </div>

                        {{-- Vet Details --}}
                        <div class="mt-2 col-span-2 bg-blue-50 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-user-md text-blue-600 mr-2"></i>
                                <p class="font-semibold text-blue-700 text-base">Vet Details</p>
                            </div>
                            @if($profile->vetDetails && $profile->vetDetails->isNotEmpty())
                                <ul class="list-disc pl-5 text-gray-800 space-y-1">
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
                                <p class="text-gray-400"><em>No vet details recorded.</em></p>
                            @endif
                        </div>


                        {{-- Instructions for pet --}}
                        <div class="mt-2 col-span-2 bg-gray-100 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-clipboard-list text-gray-600 mr-2"></i>
                                <p class="font-semibold text-gray-700 text-base">Instructions</p>
                            </div>
                            @if($profile->instructions && $profile->instructions->isNotEmpty())
                                <ul class="list-disc pl-5 text-gray-800 space-y-1">
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
                                <p class="text-gray-400"><em>No instructions recorded.</em></p>
                            @endif
                        </div>



                    @elseif($ptype === 'valuables')
                        <div class="font-bold text-gray-600">Item Name</div>
                        <div>{{ $profile->first_name }}</div>
                        <div class="font-bold text-gray-600">Personal Number</div>
                        <div>{{ $profile->personal_number ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">Alternate Number</div>
                        <div>{{ $profile->alternate_number ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">Email</div>
                        <div>{{ $profile->email ?? 'N/A' }}</div>
                        <div class="font-bold text-gray-600">Description</div>
                        <div>{{ $profile->notes ?? 'N/A' }}</div>

                    @else
                        <div class="col-span-2 text-gray-600">
                            Unknown profile type ({{ $profile->type ?? 'NULL' }})
                        </div>
                        <div class="col-span-2 bg-white p-3 rounded mt-2 text-xs overflow-auto">
                            {{ json_encode($profile->toArray(), JSON_PRETTY_PRINT) }}
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
