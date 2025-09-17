<x-modal-new
    title="Vital Medical Condition"
    :items="$profile->vitalMedicalConditions"
    baseUrl="{{ url('profiles/'.$profile->id.'/vital-medical-conditions') }}"
    :parentId="$profile->id"
    :fields="[
        ['name'=>'condition_name','label'=>'Condition Name','type'=>'text'],
        ['name'=>'notes','label'=>'Notes','type'=>'textarea']
    ]"
/>
