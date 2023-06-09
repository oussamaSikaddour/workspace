<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreGeneralSettingsRequest;
use App\Http\Requests\V1\UpdateGeneralSettingsRequest;
use App\Http\Resources\V1\starter\GeneralSettingsResource;
use App\Models\GeneralSettings;
use App\Traits\HttpManagements;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GeneralSettingsController extends Controller
{
    use HttpManagements;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return GeneralSettingsResource::collection(GeneralSettings::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeneralSettingsRequest $request)
    {
        if ($this->checkTokenAbility(Auth::user(), ["superAdmin"])) {
            $data = $request->validated();

            $gSetting = GeneralSettings::create($data);
            return response([
                "generalSettings" => $gSetting
            ], 200);
        } else {
            return $this->error('', 'you are not authorized to make this action', 403);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $lang, GeneralSettings $gSetting)
    {
        return response([
            "generalSettings" => new GeneralSettingsResource($gSetting),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(String $lang, UpdateGeneralSettingsRequest $request, GeneralSettings $gSetting)
    {
        if ($this->checkTokenAbility(Auth::user(), ["superAdmin"])) {
            $data = $request->validated();
            $gSetting->update($data);
            return response([
                "generalSettings" => $gSetting
            ], 200);
        } else {
            return $this->error('', 'you are not authorized to make this action', 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(String $lang, GeneralSettings $gSetting)
    {

        if ($this->checkTokenAbility(Auth::user(), ["superAdmin"])) {
            $gSetting->delete();
            return $this->success([
                'message' => 'You have successfully deleted this general settings'
            ]);
        } else {
            return $this->error('', 'you are not authorized to make this action', 403);
        }
    }


    // ...



    // ...

    public function createBackup()
    {
        try {
            Artisan::call('backup:run', ['--only-db' => true]);

            $backupFilename = date('Y-m-d') . '-1-database.sql';
            $backupFile = 'laravel-backup/' . $backupFilename;

            // if (Storage::disk('local')->exists($backupFile)) {
                return response()->download(Storage::disk('local')->path($backupFile), $backupFilename);
            // } else {
            //     return response()->json(['status' => 'error', 'message' => 'Backup file not found.'], 404);
            // }
        } catch (\Exception $e) {
            return response()->json([
                'message' => "An error occurred while creating the backup.",
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
