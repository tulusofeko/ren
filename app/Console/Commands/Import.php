<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Storage;
use App\Http\Requests;
use App\EselonSatu;
use App\EselonDua;
use App\EselonTiga;
use App\Program;
use App\Kegiatan;
use App\Output;
use App\SubOutput;
use App\Komponen;
use App\SubKomponen;
use App\Aktivitas;
use App\Datduk;
use App\User;
use Exception;
use Illuminate\Database\QueryException;
use DB, Log;

class Import extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ren:impor {nama_file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Impor data';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::enableQueryLog();

        $data_map = [
            'eselon_satu'  => EselonSatu::class,
            'eselon_dua'   => EselonDua::class,
            'eselon_tiga'  => EselonTiga::class,
            'program'      => Program::class,
            'kegiatan'     => Kegiatan::class,
            'output'       => Output::class,
            'sub_output'   => SubOutput::class,
            'komponen'     => Komponen::class,
            'sub_komponen' => SubKomponen::class,
            'datduks'      => Datduk::class,
            'aktivitas'    => Aktivitas::class,
            'user'         => User::class
        ];

        $this->info("Reading file");

        $json = file_get_contents($this->argument('nama_file'));
        
        $data = json_decode($json);

        $bar = $this->output->createProgressBar(count($data));
        
        $bar->setFormat("%current%/%max% [%bar%] %percent:3s%% -- %message%");

        foreach ($data as $key => $table_data) {
            $class = $data_map[$key];
            
            $bar->setMessage('Memproses ' . $key);

            foreach ($table_data as $item) {
                try {
                    call_user_func([$class, 'create'], (array) $item);
                } catch (QueryException $e) {
                    $this->error($e->getMessage());
                    exit();
                }
            }

            $bar->advance(); 
        }

        $bar->finish();
    }
}
