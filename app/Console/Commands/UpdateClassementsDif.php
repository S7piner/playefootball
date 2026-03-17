<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Classement;

class UpdateClassementsDif extends Command
{
    protected $signature = 'classements:update-dif';
    protected $description = 'Mettre à jour la différence de buts dans les classements';

    public function handle()
    {
        $classements = Classement::all();

        foreach ($classements as $classement) {
            $classement->dif = $classement->bp - $classement->bc;
            $classement->save();
        }

        $this->info('Différence de buts mise à jour pour ' . $classements->count() . ' classements.');
        return 0;
    }
}
