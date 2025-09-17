<x-modal-new
    title="Allergy"
    :items="$profile->allergies"
    baseUrl="{{ url('profiles/'.$profile->id.'/allergies') }}"
    :parentId="$profile->id"
    :fields="[
        ['name'=>'allergic_name','label'=>'Allergy Name','type'=>'text'],
        ['name'=>'notes','label'=>'Notes','type'=>'textarea']
    ]"
/>
