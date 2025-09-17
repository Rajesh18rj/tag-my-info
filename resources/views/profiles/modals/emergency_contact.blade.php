<x-modal-new
    title="Emergency Contact"
    :items="$profile->emergencyContacts"
    baseUrl="{{ url('profiles/'.$profile->id.'/emergency-contacts') }}"
    :parentId="$profile->id"
    :fields="[
        ['name'=>'name','label'=>'Name','type'=>'text'],
        ['name'=>'relationship','label'=>'Relationship','type'=>'text'],
        ['name'=>'mobile_number','label'=>'Mobile Number','type'=>'text'],
    ]"
/>
