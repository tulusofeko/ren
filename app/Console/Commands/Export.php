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

use DB;

class Export extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ren:ekspor {nama_file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ekspor data';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = [
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

        $bar = $this->output->createProgressBar(count($data) + 2);
        $bar->setFormat("%current%/%max% [%bar%] %percent:3s%% -- %message%");

        foreach ($data as $key => $class) {
            $bar->setMessage('Memproses ' . $key);
            $bar->advance(); 

            $table = with(new $class)->getTable();
            $proccessed_data[$key] = DB::select('SELECT * FROM ' . $table);
        }
    
        $bar->setMessage('Encoding data');
        $bar->advance(); 
        
        $json_data = json_encode($proccessed_data, JSON_PRETTY_PRINT);
        

        $bar->setMessage('Menyimpan data');
        $bar->setMessage('Selesai   ');
        $bar->advance(); 
        
        file_put_contents($this->argument('nama_file'), $json_data);

        $bar->finish();
    }
}
