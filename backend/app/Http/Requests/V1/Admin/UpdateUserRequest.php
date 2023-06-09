<?php

namespace App\Http\Requests\V1\Admin;

use App\Models\PersonnelInfo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */

    public function rules()
    {

        $method = $this->method();
        if ($method == "PUT") {
            return [
                'default.email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users', "email")->whereNull('deleted_at')->ignore($this->user->id),
                ],
                'personalInfo.last_name' => 'required|string|min:3|max:100',
                'personalInfo.first_name' => 'required|string|min:3|max:100',
                'personalInfo.card_number' => [
                    'required',
                    'string',
                    'min:6',
                    'max:255',
                    Rule::unique('personnel_infos', "card_number")->whereNull('deleted_at')->ignore($this->user->personnelInfo->user_id ?? null, "user_id"),
                ],
                'personalInfo.birth_place' => 'nullable|string|min:3|max:200',
                'personalInfo.birth_date' => 'nullable|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
                'personalInfo.addresses' =>  'nullable|string|min:3|max:400',
                'personalInfo.tel' => [
                    'nullable',
                    'regex:/^(05|06|07)\d{8}$/',
                    Rule::unique('personnel_infos', "tel")->whereNull('deleted_at')->ignore($this->user->personnelInfo->user_id ?? null, "user_id"),
                ],

                'occupation.entitled' => [
                    'nullable',
                    'string',
                    'min:4',
                    'max:100'
                ],
                'occupation.field' => 'nullable|string|min:10|max:200',
                'occupation.experience' => 'nullable|numeric|max:10',
                'occupation.specialty' => 'nullable|string|min:5|max:200',
                'occupation.grade' => 'nullable|string|min:5|max:200',

                'education.institution' => 'nullable|string|min:10|max:200',
                'education.field_of_study' => 'nullable|string|min:5|max:200',
                'education.graduation_date' => 'nullable|date',
                'education.place_of_graduation' => 'nullable|string|min:5|max:200',


            ];
        } else {
            return [
                'default.email' => [
                    'sometimes',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users', "email")->whereNull('deleted_at')->ignore($this->user->id),
                ],
                'personalInfo.last_name' => 'sometimes|string|min:3|max:100',
                'personalInfo.first_name' => 'sometimes|string|min:3|max:100',
                'personalInfo.card_number' => [
                    'sometimes',
                    'string',
                    'min:6',
                    'max:255',
                    Rule::unique('personnel_infos', "card_number")->whereNull('deleted_at')->ignore($this->user->personnelInfo->user_id ?? null, "user_id"),
                ],
                'personalInfo.birth_place' => 'sometimes|string|min:3|max:200',
                'personalInfo.birth_date' => 'sometimes|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
                'personalInfo.addresses' =>  'sometimes|string|min:3|max:400',
                'personalInfo.tel' => [
                    'sometimes',
                    'regex:/^(05|06|07)\d{8}$/',
                    Rule::unique('personnel_infos', "tel")->whereNull('deleted_at')->ignore($this->user->personnelInfo->user_id ?? null, "user_id"),
                ],

                'occupation.entitled' => [
                    'sometimes',
                    'string',
                    'min:4',
                    'max:100'
                ],
                'occupation.field' => 'sometimes|string|min:10|max:200',
                'occupation.experience' => 'sometimes|numeric|max:10',
                'occupation.specialty' => 'sometimes|string|min:5|max:200',
                'occupation.grade' => 'sometimes|string|min:5|max:200',

                'education.institution' => 'sometimes|string|min:10|max:200',
                'education.field_of_study' => 'sometimes|string|min:5|max:200',
                'education.graduation_date' => 'sometimes|date',
                'education.place_of_graduation' => 'sometimes|string|min:5|max:200',


            ];
        }
    }

    protected function prepareForValidation()
    {

        $personalInfo = [];
        $occupation = [];
        $education = [];
        $default= [];
        if(isset($this->email)){
          $default['email'] = $this->input('email');
        }

            if (isset($this->lastName)) {
                $personalInfo['last_name'] = $this->input('lastName');
            }
            if (isset($this->firstName)) {
                $personalInfo['first_name'] = $this->input('firstName');
            }
            if (isset($this->cardNumber)) {
                $personalInfo['card_number'] = $this->input('cardNumber');
            }
            if (isset($this->birthDate)) {
                $personalInfo['birth_date'] = $this->input('birthDate');
            }
            if (isset($this->birthPlace)) {
                $personalInfo['birth_place'] = $this->input('birthPlace');
            }
            if (isset($this->addresses)) {
                $personalInfo['addresses'] = $this->input('addresses');
            }
            if (isset($this->tel)) {
                $personalInfo['tel'] = $this->input('tel');
            }

            if (isset($this->entitled)) {
                $occupation['entitled'] = $this->input('entitled');
            }
            if (isset($this->field)) {
                $occupation['field'] = $this->input('field');
            }
            if (isset($this->experience)) {
                $occupation['experience'] = $this->input('experience');
            }
            if (isset($this->specialty)) {
                $occupation['specialty'] = $this->input('specialty');
            }
            if (isset($this->grade)) {
                $occupation['grade'] = $this->input('grade');
            }
            $this->merge(['occupation' => $occupation]);



            if (isset($this->institution)) {
                $education['institution'] = $this->input('institution');
            }

            if (isset($this->fieldOfStudy)) {
                $education['field_of_study'] = $this->input('fieldOfStudy');
            }

            if (isset($this->graduationDate)) {
                $education['graduation_date'] = $this->input('graduationDate');
            }

            if (isset($this->placeOfGraduation)) {
                $education['place_of_graduation'] = $this->input('placeOfGraduation');
            }

            $this->merge(['education' => $education]);

        if(count($default) > 0){
            $this->merge(['default' => $default]);}
        if(count($personalInfo) > 0){
            $this->merge(['personalInfo' => $personalInfo]);}
        if(count($occupation) > 0){
            $this->merge(['occupation' => $occupation]);}
        if(count($education) > 0){
            $this->merge(['education' => $education]);}


    }

    public function messages()
    {
        return [
            'default.email.required' => 'Le champ email est obligatoire.',
            'default.email.string' => 'Le champ email doit être une chaîne.',
            'default.email.email' => 'Le champ email doit être une adresse email valide.',
            'default.email.max' => "Le champ de l'e-mail ne doit pas dépasser : max caractères.",
            'default.email.unique' => "L'adresse e-mail saisie est déjà utilisée.",
            'personalInfo.last_name.required' => 'Le champ du nom de famille est obligatoire.',
            'personalInfo.last_name.string' => 'Le champ du nom de famille doit être une chaîne.',
            'personalInfo.last_name.min' => 'Le champ du nom de famille doit contenir au moins :min caractères.',
            'personalInfo.last_name.max' => 'Le champ du nom de famille ne doit pas dépasser :max caractères.',
            'personalInfo.first_name.required' => 'Le champ prénom est obligatoire.',
            'personalInfo.first_name.string' => 'Le champ prénom doit être une chaîne.',
            'personalInfo.first_name.min' => 'Le champ du prénom doit contenir au moins :min caractères.',
            'personalInfo.first_name.max' => 'Le champ du prénom ne doit pas être supérieur à :max caractères.',
            'personalInfo.card_number.required' => 'Veuillez fournir un numéro de carte.',
            'personalInfo.card_number.unique' => 'Ce numéro de carte est déjà utilisé.',
            'personalInfo.card_number.string' => 'Le numéro de carte doit être une chaîne.',
            'personalInfo.birth_place.string' => 'Le champ lieu de naissance doit être une chaîne.',
            'personalInfo.birth_place.min' => 'Le champ lieu de naissance doit contenir au moins :min caractères.',
            'personalInfo.birth_place.max' => 'Le champ lieu de naissance ne doit pas dépasser : max caractères.',
            'personalInfo.birth_date.date' => 'Le champ de la date de naissance doit être une date valide.',
            'personalInfo.birth_date.before_or_equal' => 'Le champ date de naissance doit être avant ou égal à :date.',
            'personalInfo.addresses.string' => 'Le champ des adresses doit être une chaîne.',
            'personalInfo.addresses.min' => 'Le champ des adresses doit contenir au moins :min caractères.',
            'personalInfo.addresses.max' => 'Le champ des adresses ne doit pas être supérieur à :max caractères.',
            'personalInfo.tel.regex' => 'Le champ du numéro de téléphone doit être un numéro de téléphone mobile valide.',
            'personalInfo.tel.unique' => 'Le numéro de téléphone saisi est déjà utilisé.',
            'occupation.entitled.string' => 'Le champ intitulé doit être une chaîne.',
            'occupation.entitled.min' => 'Le champ intitulé doit contenir au moins :min caractères.',
            'occupation.entitled.max' => 'Le champ intitulé ne doit pas être supérieur à :max caractères.',
            'occupation.field.string' => 'Le champ domain de travail doit être une chaîne.',
            'occupation.field.min' => 'Le champ domain de travail doit contenir au moins :min caractères.',
            'occupation.field.max' => 'Le domaine de travail  ne doit pas dépasser :max caractères.',
            'occupation.experience.numeric' => "L'expérience professionnelle doit être un nombre.",
            'occupation.experience.max' => "L'expérience professionnelle ne doit pas être supérieure à :max.",
            'occupation.specialty.string' => 'La spécialité professionnelle doit être une chaîne.',
            'occupation.specialty.min' => 'La spécialité professionnelle doit comporter au moins :min caractères.',
            'occupation.specialty.max' => 'La spécialité professionnelle ne peut pas être supérieure à :max caractères.',
            'occupation.grade.string' => 'Le grade doit être une chaîne.',
            'occupation.grade.min' => 'Le grade doit comporter au moins :min caractères.',
            'occupation.grade.max' => 'Le grade ne peut pas être supérieure à :max caractères.',
        ];
    }
}
