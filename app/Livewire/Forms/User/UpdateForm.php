<?php

namespace App\Livewire\Forms\User;

use App\Models\Image;
use App\Models\Occupation;
use App\Models\PersonnelInfo;
use App\Models\User;
use App\Traits\FileTrait;
use App\Traits\ImageTrait;
use App\Traits\ResponseTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UpdateForm extends Form
{
    use ResponseTrait,ImageTrait,FileTrait;

  public $default= [
    'id'=>null,
  ];
  public $image;
  public $cv;
  public $personnelInfo= [
    "user_id"=>null,
     "lats_name"=>null,
     "first_name"=>null,
      "card_number"=>null,
      "birth_place"=>null,
      "birth_date"=>null,
      "address"=>null,
      "tel"=>null,

  ];

    public function rules()
    {
        if($this->default['id'] !==""){
            try{
        $user =User::findOrFail($this->default['id']);

            }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return $this->response(false,errors:[$e->getMessage()]);
            }
    }
        $rules =[
            'default.id' => 'required|exists:users,id',
            'personnelInfo.user_id' => 'required|exists:users,id',
            'image' => 'nullable|file|mimes:jpeg,png,gif,ico,webp|max:10000',
            'cv' => 'nullable|file|mimes:pdf|max:10000',
        ];



            if($this->personnelInfo["last_name"]!== null){
                $rules = array_merge($rules,
                [
                'personnelInfo.last_name' => 'required|string|min:3|max:100',
                ]);
            }
            if($this->personnelInfo["first_name"]!== null){
                $rules = array_merge($rules,
                [
                'personnelInfo.first_name' => 'required|string|min:3|max:100',
                ]);
            }
            if($this->personnelInfo["card_number"]!== null){
                $rules = array_merge($rules,
                [
                    'personnelInfo.card_number' => [
                        'sometimes',
                        'string',
                        'min:6',
                        'max:255',
                        Rule::unique('personnel_infos', "card_number")->whereNull('deleted_at')->ignore($user->personnelInfo->user_id ?? null, "user_id"),
                    ],
                ]);
            }
            if($this->personnelInfo["birth_place"]!== null){
                $rules = array_merge($rules,
                [
                    'personnelInfo.birth_place' => 'required|string|min:3|max:200',
                ]);
            }
            if($this->personnelInfo["birth_date"]!== null){
                $rules = array_merge($rules,
                [
                    'personnelInfo.birth_date' =>  'required|date|date_format:Y-m-d|after:1920-01-01|before:' . Carbon::now()->subYears(18)->format('Y-m-d'),
                ]);
            }
            if($this->personnelInfo["address"]!== null){
                $rules = array_merge($rules,
                [
                    'personnelInfo.address' =>  'required|string|min:3|max:400',
                ]);
            }
            if($this->personnelInfo["tel"]!== null){
                $rules = array_merge($rules,
                [
                    'personnelInfo.tel' => [
                        'sometimes',
                        'regex:/^(05|06|07)\d{8}$/',
                        Rule::unique('personnel_infos', "tel")->whereNull('deleted_at')->ignore($user->personnelInfo->user_id ?? null, "user_id"),
                    ],
                ]);
            }

            return $rules;
    }

    public function validationAttributes()
    {
        return [
            'default.email' =>  __("modals.user.email"),
            'image'=>__("modals.user.profile-img"),
            'cv'=>__("modals.user.cv"),
            'personnelInfo.last_name' => __("modals.user.l-name"),
            'personnelInfo.first_name' =>__("modals.user.f-name"),
            'personnelInfo.card_number' => __("modals.user.card-number"),
            'personnelInfo.birth_place' => __("modals.user.b-place"),
            'personnelInfo.birth_date' =>__("modals.user.b-date"),
            'personnelInfo.address' => __("modals.user.address"),
            'personnelInfo.tel' =>__("modals.user.tel"),
        ];
    }



    public function messages(): array
    {
        return [
            'personnelInfo.tel.regex' => __("forms.user.tel-match-err"),
        ];
    }
    public function save($user)
    {
        $data =$this->validate();
       try {

        return DB::transaction(function () use ($data, $user) {
            $userId = $user->id;
            $pInfo = PersonnelInfo::where('user_id', $userId)->first();
            if ($pInfo) {
                $pInfo->update($data["personnelInfo"]);
                $user["name"] = $pInfo["last_name"] . " " . $pInfo["first_name"];
            }
            $image = $this->image;
            if ($image) {
                $this->uploadAndUpdateImage($image, $user->id, "App\Models\User", "profile_pic");
            }
            if ($this->cv) {
                $this->uploadAndUpdateFile($this->cv, $user->id, "App\Models\User", "cv");
            }
            $user->update($data["default"]);
            $user->refresh();
            return $this->response(true,message:__("forms.user.add.success-txt"));
        });
    } catch (\Exception $e) {
        return $this->response(false,errors:[$e->getMessage()]);
    }
    }

}
