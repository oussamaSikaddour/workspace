<?php

namespace App\Livewire\Forms\Hero;

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
    public $title_fr;
    public $title_ar;
    public $sub_title_ar;
    public $sub_title_fr;
    public $images;




        // Livewire rules
        public function rules()
        {

            return [
                'title_fr' => [
                    'required',
                    'string',
                    'min:10',
                    'max:100',
                    Rule::unique('heros','title_fr')->ignore($this->id),
                ],
                'title_ar' => [
                    'required',
                    'string',
                    'min:10',
                    'max:100',
                    Rule::unique('heros','title_ar')->ignore($this->id),
                ],
                'sub_title_fr' => [
                    'required',
                    'string',
                    'min:10',
                    'max:100',
                    Rule::unique('heros','sub_title_fr')->ignore($this->id),
                ],
                'sub_title_ar' => [
                    'required',
                    'string',
                    'min:10',
                    'max:100',
                    Rule::unique('heros','sub_title_ar')->ignore($this->id),
                ],
                'images.*' => 'nullable|file|mimes:jpeg,png,gif,ico,webp|max:10000',
                'images' => 'nullable|array|max:5',

            ];


        }

        public function validationAttributes()
        {
            return [
            'title_ar' =>  __("forms.hero.title-ar"),
            'title_fr' =>  __("forms.hero.title-fr"),
            'sub_title_fr' =>  __("forms.hero.sub-title-fr"),
            'sub_title_ar' =>  __("forms.hero.sub-title-ar"),
            'images' =>  __("forms.hero.images"),
            ];
        }




        public function save($hero)
        {
            $data =$this->validate();
           try {
                return DB::transaction(function () use ($data,$hero ) {

                    $hero->update($data);
                      if ($this->images) {
                          $this->uploadAndUpdateImages($this->images, $hero->id, "App\Models\Hero", "hero");
                      }
                      return $this->response(true,message:__("forms.hero.update.success-txt"));

                });

        } catch (\Exception $e) {
            return $this->response(false,errors:[$e->getMessage()]);
        }
        }
}
