<?php

namespace App\Livewire\Forms\Landing;

use App\Traits\ImageTrait;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ManageForm extends Form
{
    use ResponseTrait,ImageTrait;

public $id;
public $phone;
public $landline;
public $fax;
public $email;
public $map;
public $logo;



    // Livewire rules
    public function rules()
    {

        return [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('general_settings','email')->whereNull('deleted_at')->ignore($this->id),
            ],
            'map' => 'nullable|string',
            'phone' => [
                'nullable',
                'regex:/^(05|06|07)\d{8}$/',
                  Rule::unique('general_settings','phone')->whereNull('deleted_at')->ignore($this->id)
            ],
            'landline' => [
                'nullable',
                'regex:/^(0)\d{8}$/',
                  Rule::unique('general_settings','landline')->whereNull('deleted_at')->ignore($this->id)
            ],
            'fax' => [
                'nullable',
                'regex:/^(0)\d{8}$/',
                  Rule::unique('general_settings','landline')->whereNull('deleted_at')->ignore($this->id)
            ],

           'logo' => 'nullable|file|mimes:jpeg,jpg,png,gif,ico,webp|max:10000',

        ];


    }

    public function validationAttributes()
    {
        return [
        'email' =>  __("forms.landing.email"),
        'logo'=>__("forms.landing.logo"),
        'phone'=>__("forms.landing.phone"),
        'landline'=>__("forms.landing.landline"),
        'fax'=>__("forms.landing.fax"),
        'map'=>__("forms.landing.map"),
        ];
    }


    public function messages(): array
    {

        $validationAttributes = $this->validationAttributes();
        return [
            'phone.regex' => __("forms.common.tel-match-err", [
                'attribute' => $validationAttributes['phone']]),
            'landline.regex' => __('forms.common.fix-match-error',             ['attribute'=>$validationAttributes['landline']]),
            'fax.regex' => __('forms.common.fix-match-error',['attribute'=>$validationAttributes['fax']]),
        ];
    }

    public function save($gSetting)
    {
        $data =$this->validate();
       try {
              return DB::transaction(function () use ($data, $gSetting) {
            $logo = $this->logo;
            if ($logo) {
                $this->uploadAndUpdateImage($logo, $gSetting->id, "App\Models\GeneralSetting", "logo");
            }
            $gSetting->update($data);
            return $this->response(true,message:__("forms.landing.update.success-txt"));
        });
    } catch (\Exception $e) {
        return $this->response(false,errors:[$e->getMessage()]);
    }
    }
}
