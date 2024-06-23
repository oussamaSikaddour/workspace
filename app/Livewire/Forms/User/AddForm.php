<?php

namespace App\Livewire\Forms\User;

use App\Events\Auth\GeneratePasswordEvent;
use App\Models\Occupation;
use App\Models\PersonnelInfo;
use App\Models\Role;
use App\Models\User;
use App\Traits\FileTrait;
use App\Traits\ImageTrait;
use App\Traits\ResponseTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Form;

class AddForm extends Form

{
    use ResponseTrait,ImageTrait,FileTrait;
  public $default= [
    "email"=>null,
  ];
  public $image;
  public $cv;
  public $personnelInfo= [
     "lats_name"=>null,
     "first_name"=>null,
      "card_number"=>null,
      "birth_place"=>null,
      "birth_date"=>null,
      "address"=>null,
      "tel"=>null,
  ];



    // Livewire rules
    public function rules()
    {

        $rules = [
            'default.email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users','email')->whereNull('deleted_at'),
            ],
            'personnelInfo.last_name' => 'required|string|min:3|max:100',
            'personnelInfo.first_name' => 'required|string|min:3|max:100',
            'image' => 'nullable|file|mimes:jpeg,png,gif,ico,webp|max:10000',
            'cv' => 'nullable|file|mimes:pdf|max:10000',
        ];


        if($this->personnelInfo["card_number"]!== null){
            $rules = array_merge($rules,
            [
                'personnelInfo.card_number' => [
                    'nullable',
                    'string',
                    'min:6',
                    Rule::unique('personnel_infos', 'card_number')->whereNull('deleted_at'),
                ],
            ]);
        }
        if($this->personnelInfo["birth_place"]!== null){
            $rules = array_merge($rules,
            [
                'personnelInfo.birth_place' => 'nullable|string|min:3|max:200',
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
                'personnelInfo.address' =>  'nullable|string|min:3|max:400',
            ]);
        }
        if($this->personnelInfo["tel"]!== null){
            $rules = array_merge($rules,
            [
                'personnelInfo.tel' => [
                    'nullable',
                    'regex:/^(05|06|07)\d{8}$/',
                    'unique:personnel_infos,tel'
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
            'cv.mimes' => __("modals.common.pdf-type-err",[__("modals.user.cv")]),
        ];
    }
    public function save()
    {
        $data = $this->validate();
        try {

            return DB::transaction(function () use ($data) {
                // $password = Str::password(8,symbols:false);
                $password="Vide=1342";
                $user = User::create([
                    "name" => $data["personnelInfo"]["last_name"] . " " . $data["personnelInfo"]["first_name"],
                    "email" => $data['default']['email'],
                    "password" => Hash::make($password),
                ]);
                // $images = $request->allFiles('images');

                if ($this->image) {
                    $this->uploadAndCreateImage($this->image, $user->id, "App\Models\User", "profile_pic");
                }
                if ($this->cv) {
                    $this->uploadAndCreateFile($this->cv, $user->id, "App\Models\User", "cv");
                }
                $data['personnelInfo']['user_id'] = $user->id;
                PersonnelInfo::create($data['personnelInfo']);
                // event(new GeneratePasswordEvent($user, $password));
                // $defaultRoleSlugs = ["admin"];
                // $defaultRoleSlugs = [config('defaultRole.default_role_slug', 'user')];


                    $defaultRoleSlugs = ['user', 'formatter'];

                $user->roles()->attach(Role::whereIn('slug', $defaultRoleSlugs)->get());
                $user->refresh();
                return $this->response(true, message:__("forms.user.add.success-txt"));
            });

        } catch (\Exception $e) {
            return $this->response(false,errors:[$e->getMessage()]);
        }
    }
}
