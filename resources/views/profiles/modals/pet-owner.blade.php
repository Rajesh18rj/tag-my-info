<x-modal-new
    title="Pet Owner"
    :items="$profile->petOwners"
    baseUrl="{{ url('profiles/'.$profile->id.'/pet-owners') }}"
    :parentId="$profile->id"
    :fields="[
        ['name'=>'name','label'=>'Name','type'=>'text'],
        ['name'=>'relationship','label'=>'Relationship','type'=>'text'],
        ['name'=>'contact_number','label'=>'Contact Number','type'=>'text'],
    ]"
/>
