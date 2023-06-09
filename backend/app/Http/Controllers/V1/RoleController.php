<?php

namespace App\Http\Controllers\V1;

use App\Filters\V1\RoleFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\StoreRoleRequest;
use App\Http\Requests\V1\Admin\ManageRolesRequest;
use App\Http\Requests\V1\Admin\UpdateRoleRequest;
use App\Http\Resources\V1\starter\RoleResource;
use App\Models\Role;
use App\Models\User;
use App\Traits\HttpManagements;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    use HttpManagements;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $filter = new RoleFilter();
            $filterItems = $filter->transform($request);
            $roles = Role::where($filterItems);
            $includeUsers = $request->query("includeUsers");
            if ($includeUsers) {
                $roles = $roles->with('users');
            }
            $roles =  RoleResource::collection($roles->paginate()->appends($request->query()));
            return response()->json([
                'message' => 'Rôles récupérés avec succès',
                'roles' => $roles
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la recuperation des roles",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(StoreRoleRequest $request)
    {
        try {
            $request->validated($request->all());
            $role = Role::create([
                "name" => $request->name,
                "slug" => $request->slug,

            ]);


            return response()->json([
                'message' => 'Rôl ajouter avec succès',
                'role' => new RoleResource($role),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de l ajout du role",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(String $lang, Role $role, Request $request)
    {
        try {
            $includeUsers = $request->query("includeUsers");
            if ($includeUsers) {
                $role = $role->loadMissing('users');
            }

            return response()->json([
                'message' => 'Rôle récupéré avec succès',
                'role' => new RoleResource($role),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la récupération du rôle",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, String $lang, Role $role)
    {
        try {
            $data = $request->validated();
            if ($request->slug) {
                if ($role->slug != 'admin' && $role->slug != 'super-admin') {
                    //don't allow changing the admin slug, because it will make the routes inaccessbile due to faile ability check
                    $role->slug = $request->slug;
                }
            }
            $role->update($data);
            return response()->json([
                'message' => 'Mise à jour du rôle réussie',
                'role' => new RoleResource($role),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la récupération du rôle",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $lang, Role $role)
    {
        try {
            if ($role->slug != 'admin' && $role->slug != 'super-admin') {
                //don't allow changing the admin slug, because it will make the routes inaccessbile due to faile ability check

                $role->delete();
                return response()->json([
                    'message' => 'You have succesfully delted the role'
                ], 201);
            } else {
                throw new \Exception("vous n'avez pas la possibilité de supprimer");
            }
            return $this->error('', 'you cannot delete this role ' . $role->slug, 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la récupération du rôle",
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function manageRoles(ManageRolesRequest $request)
    {
        try {
            $newRoles = $request->validated()['abilities'];
            $user = User::find($request->user_id);
            $oldRoles = $user->roles->pluck('slug')->toArray();
            $rolesToAdd = array_diff($newRoles, $oldRoles);
            $rolesToRemove = array_diff($oldRoles, $newRoles);

            // Attach new roles
            foreach ($rolesToAdd as $slug) {
                $role = Role::where('slug', $slug)->first();
                $user->roles()->attach($role);
            }

            // Detach old roles
            foreach ($rolesToRemove as $slug) {
                $role = Role::where('slug', $slug)->first();
                $user->roles()->detach($role);
            }

            $user->tokens()->delete();
            return response()->json([
                'message' => "l'utilisateur doit se reconnecter pour valider les modifications"
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "une erreur s'est produite lors de la récupération du rôle",
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
