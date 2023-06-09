<?php

namespace App\Http\Controllers\V1;

use App\Events\V1\Auth\EmailVerificationEvent;
use App\Events\V1\NewUserPasswordEvent;
use App\Filters\V1\UserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreUserRequest;
use App\Http\Requests\V1\Admin\UpdateUserRequest;
use App\Http\Resources\V1\starter\UserResource;
use App\Models\Education;
use App\Models\Notification;
use App\Models\Occupation;
use App\Models\PersonnelInfo;
use App\Models\Role;
use App\Models\User;
use App\Traits\HttpManagements;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use HttpManagements;
    use Utilities;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            // Define the base query with eager loading of related models
            $query = User::query()
                ->with([
                    'personnelInfo',
                     "roles"
                ]);
            if ($request->query('name')) {
                $name = $request->input("name");
                $query->where('name','like','%'.$name .'%');
            }
            if ($request->query('email')) {
                $email = $request->input("email");
                $query->where('email','like','%'.$email.'%');
            }

            if ($request->has('ability')) {
                $query->whereHas('roles', function ($query) use ($request) {
                    $ability = $request->input("ability");
                    $query->where('slug', $ability);
                });
            }



            if ($request->query("simple")) {
                $users = $query->get();
                $users = UserResource::collection($users);
            } else {

                $users = $query->get()->map(function ($user) {
                    $abilities = $user->roles->pluck('slug')->toArray();
                    $personnelInfo = $user->personnelInfo;
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'tel' => $personnelInfo ? $personnelInfo->tel : null,
                        "abilities" => implode(',', $abilities),
                    ];
                });

            }




            // Get the results and format them as an array of rendezvous data


            // Return the formatted data as a JSON response
            return response()->json([
                'status' => 'success',
                'users' => $users
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération de rendez vous",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(String $lang, StoreUserRequest $request)
    {
        return $this->createUser($request, false);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(String $lang, StoreUserRequest $request)
    {
        return $this->createUser($request);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(String $lang, User $user, Request $request)
    {
        try {


            $user->loadMissing('personnelInfo');
            $user->loadMissing('occupation');
            $user->loadMissing('education');
            $user->loadMissing('messages');
            $user->loadMissing('bookings');
            return response()->json([
                'message' => 'Service retrieved successfully',
                'user' => new UserResource($user)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la récupération du service",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(String $lang, UpdateUserRequest $request, User $user)
    {


        try {
            $userId = $user->id;
            $data = $request->validated();
            $pInfo = PersonnelInfo::where('user_id', $userId)->first();
            if ($pInfo) {
                $pInfo->update($data["personalInfo"]);
                $user["name"] = $pInfo["last_name"] . " " . $pInfo["first_name"];
            }
            $occupation = Occupation::where('user_id', $userId)->first();
            if ($occupation) {
                $occupation->update($data["occupation"]);
            }
            $education = Education::where('user_id', $userId)->first();
            if ($education) {
                $education->update($data["education"]);
            }

            // turnOffNotifications

            $user->update($data["default"]);
            $user->loadMissing('occupation');
            $user->loadMissing('education');
            $user->loadMissing('personnelInfo');
            $user->refresh();
            return response()->json([
                "user" => new UserResource($user)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la modification",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $lang, User $user)
    {
        $adminRole = Role::where('slug', 'super_admin')->first();
        $userRoles = $user->roles;
        if ($userRoles->contains($adminRole)) {
            //the current user is admin, then if there is only one admin - don't delete
            $numberOfAdmins = Role::where('slug', 'super_admin')->first()->users()->count();
            if (1 == $numberOfAdmins) {
                return $this->error('', 'Create another admin before deleting this only admin user', 409);
            }
        }
        $user->delete();

        return $this->success([
            'message' => 'You have succesfully delted your account'
        ]);
    }

    private function isNotAuthorized($user)
    {
        if (Auth::user()->id !== $user->id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }
    }

    private function createUser($request, $isRegister = true)
    {

        try {
            $data = $request->validated();
            if ($isRegister) {
                if ($request->password) {
                    $password = $request->password;
                } else {
                    throw new \Exception("Le mot de passe doit comporter au moins 8 caractères.");
                }
            } else {
                $randomNumber = rand(1000, 9999);
                $password = "admin" . strval($randomNumber);
            }
            $user = User::create([
                "name" => $request->personalInfo["last_name"] . " " . $request->personalInfo["first_name"],
                "email" => $request->email,
                "password" => Hash::make($password),
            ]);

            $data['personalInfo']['user_id'] = $user->id;
            PersonnelInfo::create($data['personalInfo']);
            if ($isRegister) {
                event(new EmailVerificationEvent($user));
                $defaultRoleSlugs = [config('defaultUserRole.default_user_role_slug', 'guest')];
                $data['occupation']['user_id'] = $user->id;
                Occupation::create($data['occupation']);
                $data['education']['user_id'] = $user->id;
                Education::create($data['education']);
            } else {
                event(new NewUserPasswordEvent($user, $password));
                $defaultRoleSlugs = ["admin"];
            }
            $plainTextToken = $user->createToken("Api Token", $defaultRoleSlugs)->plainTextToken;
            $user->roles()->attach(Role::whereIn('slug', $defaultRoleSlugs)->get());
            $user->loadMissing('occupation');
            $user->loadMissing('education');
            $user->loadMissing('personnelInfo');
            return response()->json([
                "user" => new UserResource($user),
                "token" => $plainTextToken
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur s'est produite lors de la creation de la personne",
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
