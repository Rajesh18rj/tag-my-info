@props([
    'title',
    'items' => collect(),
    'fields' => [],
    'baseUrl', // REQUIRED: e.g. url('profiles/'.$profile->id.'/allergies')
    'parentId' => null,
])

@php
    use Illuminate\Support\Str;
    $slug = Str::slug($title, '_'); // safe identifier for IDs/classes
    $baseUrl = rtrim($baseUrl ?? '', '/');
@endphp

<fieldset class="ml-1 relative border-2 border-red-400 rounded-lg p-6 shadow-md bg-gray-50 max-w-5xl mx-auto mb-4">
    <legend class="text-red-700 font-semibold mb-2 bg-red-100 px-3 py-1 rounded-md shadow-sm inline-block">
        {{ $title }}
    </legend>

    <button type="button"
            class="absolute -top-10 right-3 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-all shadow"
            onclick="openModal('createModal_{{ $slug }}')">
        + Add {{ $title }}
    </button>

    @if($items->count())
        <div class="hidden sm:flex justify-between font-bold text-black border-b-2 border-red-200 pb-2 mb-3 px-4">
            @foreach($fields as $field)
                <span class="flex-1">{{ $field['label'] }}</span>
            @endforeach
            <span class="w-24 text-center">Actions</span>
        </div>

        <ul class="space-y-3">
            @foreach($items as $item)
                <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-4 rounded-lg border border-red-200 bg-white shadow hover:shadow-md transition">
                    @foreach($fields as $field)
                        <div class="flex-1 mt-2 sm:mt-0">
                            @if($item->{$field['name']})
                                <p class="text-gray-600 text-sm">{{ $item->{$field['name']} }}</p>
                            @else
                                <p class="text-gray-400 text-sm italic">No {{ strtolower($field['label']) }}</p>
                            @endif
                        </div>
                    @endforeach

                    <div class="flex gap-4 w-24 justify-center items-center mt-2 sm:mt-0">
                        <button type="button"
                                class="editBtn-{{ $slug }} text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition"
                                data-item='@json($item)'
                                title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>

                        <form method="POST" action="{{ $baseUrl }}/{{ $item->id }}"
                              onsubmit="return confirm('Are you sure you want to delete this item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition"
                                    title="Delete">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500 italic">No {{ strtolower($title) }} recorded.</p>
    @endif
</fieldset>

<!-- Modals: Create / Edit / View -->
@foreach (['create', 'edit', 'view'] as $modal)
    <div id="{{ $modal }}Modal_{{ $slug }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
        <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg relative">
            <h2 class="text-xl font-bold text-red-700 mb-5">{{ ucfirst($modal) }} {{ $title }}</h2>

            @if($modal === 'view')
                @foreach($fields as $field)
                    <div class="mb-4">
                        <strong class="block text-gray-700">{{ $field['label'] }}:</strong>
                        <div id="view_{{ $slug }}_{{ $field['name'] }}" class="mt-1 text-gray-600"></div>
                    </div>
                @endforeach
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal('{{ $modal }}Modal_{{ $slug }}')" class="px-4 py-2 border rounded-lg hover:bg-red-50 transition">Close</button>
                </div>
            @else
                <form id="{{ $modal==='edit' ? 'editForm_'.$slug : '' }}" method="POST" action="{{ $modal==='edit' ? '' : $baseUrl }}" class="space-y-6">
                    @csrf
                    @if($modal==='edit') @method('PUT') @endif

                    @foreach($fields as $field)
                        <div>
                            <label class="block text-black font-medium mb-1">{{ $field['label'] }}</label>
                            @if(($field['type'] ?? '') === 'textarea')
                                <textarea name="{{ $field['name'] }}" id="{{ $modal }}_{{ $slug }}_{{ $field['name'] }}" class="w-full border-2 border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 transition"></textarea>

                            @elseif(($field['type'] ?? '') === 'enum')
                                <select name="{{ $field['name'] }}" id="{{ $modal }}_{{ $slug }}_{{ $field['name'] }}" class="w-full border-2 border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 transition">
                                    <option value="">Select {{ strtolower($field['label']) }}</option>
                                    @if(!empty($field['options']) && is_array($field['options']))
                                        @foreach($field['options'] as $option)
                                            <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                                        @endforeach
                                    @endif
                                </select>


                            @else
                                <input type="{{ $field['type'] ?? 'text' }}" name="{{ $field['name'] }}" id="{{ $modal }}_{{ $slug }}_{{ $field['name'] }}" class="w-full border-2 border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-400 transition">
                            @endif
                        </div>
                    @endforeach

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('{{ $modal }}Modal_{{ $slug }}')" class="px-4 py-2 border rounded-lg hover:bg-red-50 transition">Cancel</button>
                        <button type="submit" class="px-4 py-2 rounded-lg {{ $modal==='create' ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-blue-600 hover:bg-blue-700 text-white' }} transition shadow">
                            {{ $modal==='create' ? 'Save' : 'Update' }}
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endforeach

<script>
    (function () {
        function openModal(id){ document.getElementById(id)?.classList.remove('hidden'); }
        function closeModal(id){ document.getElementById(id)?.classList.add('hidden'); }
        window.openModal = openModal;
        window.closeModal = closeModal;

        const slug = "{{ $slug }}";
        const baseUrl = "{{ $baseUrl }}";

        document.querySelectorAll('.editBtn-{{ $slug }}').forEach(btn => {
            btn.addEventListener('click', () => {
                const item = JSON.parse(btn.getAttribute('data-item') || '{}');
                @foreach($fields as $field)
                document.getElementById('edit_{{ $slug }}_{{ $field['name'] }}').value = item['{{ $field['name'] }}'] ?? '';
                @endforeach
                const form = document.getElementById('editForm_{{ $slug }}');
                form.action = baseUrl + '/' + item.id;
                openModal('editModal_{{ $slug }}');
            });
        });
    })();
</script>
