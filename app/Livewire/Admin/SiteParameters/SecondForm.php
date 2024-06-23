<?php

namespace App\Livewire\Admin\SiteParameters;

use App\Livewire\Forms\SiteParameters\SecondForm as SiteParametersSecondForm;
use Livewire\Component;
use Symfony\Component\Process\Process;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Storage;

class SecondForm extends Component
{


    public GeneralSetting $generalSettings;
    public SiteParametersSecondForm $form;

    public function downloadDatabase()
    {
        try{

            if (Storage::disk('local')->exists('Starter')) {
                Storage::deleteDirectory('Starter');
            }

        $projectPath = base_path(); // This fetches the root path of your Laravel application
        // Construct the command
        $command = "php {$projectPath}/artisan backup:run";

        // Execute the command to perform the backup
        $process = Process::fromShellCommandline($command);
        $process->mustRun();

        // Retrieve the latest backup file
        $backupFiles = Storage::disk('local')->files('Starter');
        $latestBackup = end($backupFiles); // Assuming the latest backup is the last file

        // Provide a download link for the latest backup and delete after download
        return Storage::download($latestBackup);

    } catch (\Exception $e) {
        // Handle exceptions
        $this->dispatch('open-errors', [$e->getMessage()]);
    }
    }


    public function updateMaintenanceOnKeydownEvent($state){
      $this->form->maintenance=$state;
    }
    public function mount()
    {
            try {
                $this->generalSettings = GeneralSetting::firstOrFail();
                $this->form->fill([
                    'maintenance' => $this->generalSettings->maintenance,
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                $this->dispatch('open-errors', [$e->getMessage()]);
            }

    }

    public function handleSubmit()
    {

        $this->dispatch('form-submitted');
        $response =  $this->form->save($this->generalSettings);
       if ($response['status']) {
        $this->dispatch('open-toast', $response['message']);
       }else{
         $this->dispatch('open-errors', $response['errors']);
         }
    }



    public function render()
    {
        return view('livewire.admin.site-parameters.second-form');
    }
}
