<x-modal-new
    title="Health Insurance"
    :items="$profile->healthInsurances"
    baseUrl="{{ url('profiles/'.$profile->id.'/health-insurances') }}"
    :parentId="$profile->id"
    :fields="[
        ['name'=>'insurance_company_name','label'=>'Insurance Company Name','type'=>'text'],
        ['name'=>'insurance_notes','label'=>'Insurance Notes','type'=>'textarea']
    ]"
/>
