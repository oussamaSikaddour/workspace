<?php

namespace App\Livewire\Forms\SiteParameters;

use App\Traits\ResponseTrait;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SecondForm extends Form
{
    use ResponseTrait;
    public $maintenance;
    public function rules()
    {
        return [
            'maintenance' => [
                'required',
                'boolean',
            ],
            // Add more attribute names as needed
        ];
    }

    public function validationAttributes()
    {
        return [
            'maintenance' => __('forms.site-params.second-f.state'),
            // Add more attribute names as needed
        ];
    }



    public function save($generalSettings)
    {
        $validatedData = $this->validate();
        try {
            $generalSettings->update($validatedData);
            return $this->response(true,message:__('forms.site-params.second-f.success-txt'));
        } catch (\Exception $e) {

            return $this->response(false,errors:[$e->getMessage()]);
        }
    }
}
