<?php

namespace App\Livewire\Forms\AboutUs;

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
public $title_ar;
public $title_fr;
public $description_fr;
public $description_ar;
public $image;



    // Livewire rules
    public function rules()
    {

        return [
            'title_fr' => [
                'required',
                'string',
                'min:5',
                'max:100',
                Rule::unique('about_us','title_fr')->ignore($this->id),
            ],
            'title_ar' => [
                'required',
                'string',
                'min:5',
                'max:100',
                Rule::unique('about_us','title_ar')->ignore($this->id),
            ],
            'description_ar' => [
                'required',
                'string',
            ],
            'description_fr' => [
                'required',
                'string',
            ],

           'image' => 'nullable|file|mimes:jpeg,jpg,png,gif,ico,webp|max:10000',

        ];


    }

    public function validationAttributes()
    {
        return [
        'image'=>__("forms.aboutUs.Image"),
        'title_ar'=>__("forms.aboutUs.titleAr"),
        'title_fr'=>__("forms.aboutUs.titleFr"),
        'description_fr'=>__("forms.aboutUs.descriptionFr"),
        'description_ar'=>__("forms.aboutUs.descriptionAr"),
        'image'=>__("forms.aboutUs.image"),
        ];
    }




    public function save($aUs)
    {
        $data =$this->validate();
       try {
              return DB::transaction(function () use ($data, $aUs) {
            $image = $this->image;
            if ($image) {
                $this->uploadAndUpdateImage($image, $aUs->id, "App\Models\AboutUs", "image");
            }
            $aUs->update($data);
            return $this->response(true,message:__("forms.aboutUs.update.success-txt"));
        });
    } catch (\Exception $e) {
        return $this->response(false,errors:[$e->getMessage()]);
    }
    }
}
