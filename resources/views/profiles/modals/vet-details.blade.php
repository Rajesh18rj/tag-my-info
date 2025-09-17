<x-modal-new
    title="Vet Detail"
    :items="$profile->vetDetails"
    baseUrl="{{ url('profiles/'.$profile->id.'/vet-details') }}"
    :parentId="$profile->id"
    :fields="[
        ['name'=>'name','label'=>'Name','type'=>'text'],
        ['name'=>'personal_number','label'=>'Personal Number','type'=>'text'],
        ['name'=>'address','label'=>'Address','type'=>'textarea']
    ]"
/>
