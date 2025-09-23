<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfilesController extends Controller
{
    public function index()
    {
        $profiles = Profile::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('profiles.index', compact('profiles'));
    }

    public function create()
    {
        return view('profiles.form', ['profile' => new Profile()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateProfile($request);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Map unique input names to common model fields based on profile type
        switch ($data['type']) {
            case 'Human':
                $data['first_name'] = $data['human_first_name'] ?? null;
                $data['last_name'] = $data['human_last_name'] ?? null;
                $data['personal_number'] = $data['human_personal_number'] ?? null;
                $data['hair_colour'] = $data['human_hair_colour'] ?? null;
                $data['eye_color'] = $data['human_eye_color'] ?? null;
                $data['height'] = $data['human_height'] ?? null;
                $data['weight'] = $data['human_weight'] ?? null;
                $data['identification_mark'] = $data['human_identification_mark'] ?? null;
                $data['blood_group'] = $data['human_blood_group'] ?? null;
                $data['city'] = $data['human_city'] ?? null;
                $data['state'] = $data['human_state'] ?? null;
                $data['zip_code'] = $data['human_zip_code'] ?? null;
                $data['country'] = $data['human_country'] ?? null;
                $data['birth_date'] = $data['human_birth_date'] ?? null;
                $data['gender'] = $data['human_gender'] ?? null;
                $data['notes'] = $data['human_notes'] ?? null;


                // Remove unique keys so only model attributes remain
                foreach ([
                             'human_first_name', 'human_last_name', 'human_personal_number', 'human_hair_colour', 'human_eye_color',
                             'human_height', 'human_weight', 'human_identification_mark', 'human_blood_group',
                             'human_city', 'human_state', 'human_zip_code', 'human_country', 'human_birth_date', 'human_gender', 'human_notes',
                         ] as $key) {
                    unset($data[$key]);
                }
                break;

            case 'Pet':
                $data['first_name'] = $data['pet_first_name'] ?? null;
                $data['breed_name'] = $data['pet_breed_name'] ?? null;
                $data['hair_colour'] = $data['pet_hair_colour'] ?? null;
                $data['eye_color'] = $data['pet_eye_color'] ?? null;
                $data['height'] = $data['pet_height'] ?? null;
                $data['weight'] = $data['pet_weight'] ?? null;
                $data['identification_mark'] = $data['pet_identification_mark'] ?? null;
                $data['city'] = $data['pet_city'] ?? null;
                $data['state'] = $data['pet_state'] ?? null;
                $data['zip_code'] = $data['pet_zip_code'] ?? null;
                $data['country'] = $data['pet_country'] ?? null;
                $data['birth_date'] = $data['pet_birth_date'] ?? null;
                $data['gender'] = $data['pet_gender'] ?? null;
                $data['notes'] = $data['pet_notes'] ?? null;


                foreach ([
                             'pet_first_name', 'pet_breed_name', 'pet_hair_colour', 'pet_eye_color',
                             'pet_height', 'pet_weight', 'pet_identification_mark', 'pet_city',
                             'pet_state', 'pet_zip_code', 'pet_country', 'pet_birth_date', 'pet_gender', 'pet_notes',
                         ] as $key) {
                    unset($data[$key]);
                }
                break;

            case 'Valuables':
                $data['first_name'] = $data['valuables_first_name'] ?? null;
                $data['personal_number'] = $data['valuables_personal_number'] ?? null;
                $data['email'] = $data['valuables_email'] ?? null;
                $data['notes'] = $data['valuables_notes'] ?? null;
                $data['alternate_number'] = $data['valuables_alternate_number'] ?? null;

                foreach ([
                             'valuables_first_name', 'valuables_personal_number', 'valuables_email', 'valuables_notes', 'valuables_alternate_number'
                         ] as $key) {
                    unset($data[$key]);
                }
                break;
        }

        $data['user_id'] = auth()->id();

        $profile = Profile::create($data);

        return redirect()->route('profiles.edit', $profile)->with('success', 'Profile created successfully.');
    }

    public function edit(Profile $profile)
    {
        return view('profiles.form', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $data = $this->validateProfile($request);

        // Handle profile image update
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        switch ($data['type']) {
            case 'Human':
                $data['first_name'] = $data['human_first_name'] ?? null;
                $data['last_name'] = $data['human_last_name'] ?? null;
                $data['personal_number'] = $data['human_personal_number'] ?? null;
                $data['hair_colour'] = $data['human_hair_colour'] ?? null;
                $data['eye_color'] = $data['human_eye_color'] ?? null;
                $data['height'] = $data['human_height'] ?? null;
                $data['weight'] = $data['human_weight'] ?? null;
                $data['identification_mark'] = $data['human_identification_mark'] ?? null;
                $data['blood_group'] = $data['human_blood_group'] ?? null;
                $data['city'] = $data['human_city'] ?? null;
                $data['state'] = $data['human_state'] ?? null;
                $data['zip_code'] = $data['human_zip_code'] ?? null;
                $data['country'] = $data['human_country'] ?? null;
                $data['birth_date'] = $data['human_birth_date'] ?? null;
                $data['gender'] = $data['human_gender'] ?? null;
                $data['notes'] = $data['human_notes'] ?? null;


                foreach ([
                             'human_first_name', 'human_last_name', 'human_personal_number', 'human_hair_colour', 'human_eye_color',
                             'human_height', 'human_weight', 'human_identification_mark', 'human_blood_group',
                             'human_city', 'human_state', 'human_zip_code', 'human_country', 'human_birth_date', 'human_gender', 'human_notes',
                         ] as $key) {
                    unset($data[$key]);
                }
                break;

            case 'Pet':
                $data['first_name'] = $data['pet_first_name'] ?? null;
                $data['breed_name'] = $data['pet_breed_name'] ?? null;
                $data['hair_colour'] = $data['pet_hair_colour'] ?? null;
                $data['eye_color'] = $data['pet_eye_color'] ?? null;
                $data['height'] = $data['pet_height'] ?? null;
                $data['weight'] = $data['pet_weight'] ?? null;
                $data['identification_mark'] = $data['pet_identification_mark'] ?? null;
                $data['city'] = $data['pet_city'] ?? null;
                $data['state'] = $data['pet_state'] ?? null;
                $data['zip_code'] = $data['pet_zip_code'] ?? null;
                $data['country'] = $data['pet_country'] ?? null;
                $data['birth_date'] = $data['pet_birth_date'] ?? null;
                $data['gender'] = $data['pet_gender'] ?? null;
                $data['notes'] = $data['pet_notes'] ?? null;


                foreach ([
                             'pet_first_name', 'pet_breed_name', 'pet_hair_colour', 'pet_eye_color',
                             'pet_height', 'pet_weight', 'pet_identification_mark', 'pet_city',
                             'pet_state', 'pet_zip_code', 'pet_country', 'pet_birth_date', 'pet_gender', 'pet_notes',
                         ] as $key) {
                    unset($data[$key]);
                }
                break;

            case 'Valuables':
                $data['first_name'] = $data['valuables_first_name'] ?? null;
                $data['personal_number'] = $data['valuables_personal_number'] ?? null;
                $data['email'] = $data['valuables_email'] ?? null;
                $data['notes'] = $data['valuables_notes'] ?? null;
                $data['alternate_number'] = $data['valuables_alternate_number'] ?? null;
                foreach ([
                             'valuables_first_name', 'valuables_personal_number', 'valuables_email', 'valuables_notes', 'valuables_alternate_number',
                         ] as $key) {
                    unset($data[$key]);
                }
                break;
        }

        $profile->update($data);

        return redirect()->route('profiles.index')->with('success', 'Profile updated successfully.');
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();
        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully.');
    }

    protected function validateProfile(Request $request)
    {
        $rules = [
            'type' => ['required', Rule::in(['Human', 'Pet', 'Valuables'])],
            'profile_image' => ['nullable', 'image', 'max:2048'], // <--- validate profile image

        ];

        switch ($request->type) {
            case 'Human':
                $rules = array_merge($rules, [
                    'human_first_name' => ['nullable', 'string', 'max:255'],
                    'human_last_name' => ['nullable', 'string', 'max:255'],
                    'human_personal_number' => ['nullable', 'string', 'max:255'],
                    'human_hair_colour' => ['nullable', 'string', 'max:255'],
                    'human_eye_color' => ['nullable', 'string', 'max:255'],
                    'human_height' => ['nullable', 'string', 'max:50'],
                    'human_weight' => ['nullable', 'string', 'max:50'],
                    'human_identification_mark' => ['nullable', 'string', 'max:255'],
                    'human_blood_group' => ['nullable', 'string', 'max:10'],
                    'human_city' => ['nullable', 'string', 'max:255'],
                    'human_state' => ['nullable', 'string', 'max:255'],
                    'human_zip_code' => ['nullable', 'string', 'max:20'],
                    'human_country' => ['nullable', 'string', 'max:255'],
                    'human_birth_date' => ['nullable', 'date'],  // <-- Added here
                    'human_gender' => ['nullable', Rule::in(['Male', 'Female', 'Others'])],  // Added prefix gender validation
                    'human_notes' => ['nullable', 'string'],
                ]);
                break;

            case 'Pet':
                $rules = array_merge($rules, [
                    'pet_first_name' => ['nullable', 'string', 'max:255'],
                    'pet_breed_name' => ['nullable', 'string', 'max:255'],
                    'pet_hair_colour' => ['nullable', 'string', 'max:255'],
                    'pet_eye_color' => ['nullable', 'string', 'max:255'],
                    'pet_height' => ['nullable', 'string', 'max:50'],
                    'pet_weight' => ['nullable', 'string', 'max:50'],
                    'pet_identification_mark' => ['nullable', 'string', 'max:255'],
                    'pet_city' => ['nullable', 'string', 'max:255'],
                    'pet_state' => ['nullable', 'string', 'max:255'],
                    'pet_zip_code' => ['nullable', 'string', 'max:20'],
                    'pet_country' => ['nullable', 'string', 'max:255'],
                    'pet_birth_date' => ['nullable', 'date'],
                    'pet_gender' => ['nullable', Rule::in(['Male', 'Female', 'Others'])],
                    'pet_notes' => ['nullable', 'string']

                ]);
                break;

            case 'Valuables':
                $rules = array_merge($rules, [
                    'valuables_first_name' => ['nullable', 'string', 'max:255'],
                    'valuables_personal_number' => ['nullable', 'string', 'max:255'],
                    'valuables_email' => ['nullable', 'email'],
                    'valuables_notes' => ['nullable', 'string'],
                    'valuables_alternate_number' => ['nullable', 'string', 'max:15'],

                ]);
                break;
        }

        return $request->validate($rules);
    }

    // Toggle for Profile Availability
    public function togglePublic(Profile $profile)
    {
        $profile->is_public = !$profile->is_public;
        $profile->save();

        return response()->json([
            'success' => true,
            'is_public' => $profile->is_public,
        ]);
    }


}
