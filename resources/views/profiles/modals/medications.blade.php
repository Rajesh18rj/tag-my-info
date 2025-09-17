<x-modal-new
    title="Medication"
    :items="$profile->medications"
    baseUrl="{{ url('profiles/'.$profile->id.'/medications') }}"
    :parentId="$profile->id"
    :fields="[
        ['name' => 'medication_name','label'=>'Medication Name','type'=>'text'],
        ['name' => 'dosage','label'=>'Dosage','type'=>'text'],
        ['name' => 'dosage_unit', 'label' => 'Dosage-Unit', 'type' => 'enum', 'options' => ['pills','cc','ml','gr','mg','units','spray']],
        ['name' => 'frequency', 'label' => 'Frequency', 'type' => 'enum', 'options' => ['daily','weekly','monthly','as needed']],
        ['name' => 'frequency_type','label' => 'Frequency Type','type'=>'enum', 'options' => ['1time','2times','3times','4times']],
        ['name' => 'notes','label'=>'Notes','type'=>'textarea']
    ]"
/>
