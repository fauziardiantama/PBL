<?php

namespace App\Console\Commands;

use App\Models\Tahun;
use Illuminate\Console\Command;

class AddNewYear extends Command
{
    protected $signature = 'year:add';

    protected $description = 'Add a new year to the database if it does not exist.';

    public function handle()
    {
        // $currentYear = date('Y');
        // $existingYear = Tahun::where('tahun', $currentYear)->get();

        // if (!$existingYear) {
        //     $year = new Tahun();
        //     $year->tahun = $currentYear;
        //     $year->save();
        //     $this->info('New year added: ' . $currentYear);
        // } else {
        //     $this->info('Year already exists: ' . $currentYear);
        // }
    }
}

