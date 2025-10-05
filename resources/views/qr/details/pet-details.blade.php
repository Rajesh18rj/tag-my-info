<div>
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
</div>
