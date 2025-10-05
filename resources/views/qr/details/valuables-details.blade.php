<div>
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
</div>
