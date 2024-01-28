<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Backup;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class DataController extends Controller
{
    public function database(): string
    {
        $path = storage_path('app/' . config('backup.backup.name') . '/*');
        $latest_ctime = 0;
        $latest_filename = '';
        $files = glob($path);
        foreach ($files as $file) {
            if (is_file($file) && filectime($file) > $latest_ctime) {
                $latest_ctime = filectime($file);
                $latest_filename = $file;
            }
        }

        return $latest_filename;
    }

    public function download()
    {
        return response()->download($this->database());
    }

    public function backup()
    {
        Artisan::call('backup:run');

        return back()->with('success', 'Data successfully saved.');
    }

    public function email()
    {
        Mail::to(config('settings.company.email'))->send(new Backup($this->database()));

        return back()->with('success', 'Data successfully sent.');
    }
}
