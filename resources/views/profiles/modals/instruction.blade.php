<x-modal-new
    title="Instruction"
    :items="$profile->instructions"
    baseUrl="{{ url('profiles/'.$profile->id.'/instructions') }}"
    :parentId="$profile->id"
    :fields="[
        ['name'=>'title','label'=>'Title','type'=>'text'],
        ['name'=>'notes','label'=>'Notes','type'=>'textarea']
    ]"
/>
