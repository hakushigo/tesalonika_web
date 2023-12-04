<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\api_access;
use Illuminate\Support\Str;

class create_api_key extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:create {name} {ndays?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $length = $this->argument('ndays') == null ? 30 : $this->argument('ndays');
        $end = strtotime('+'.$length.' days', time());

        $generated_data = [
            'api_name' => $this->argument('name'),
            'api_key' => Str::random(30),
            'valid_until' => date('Y-m-d H:i:s', $end)
        ];

        api_access::create($generated_data);

        $this->info('successfully create an api key
        ');
        $this->info('name : '.$generated_data['api_name']);
        $this->info('key : '.$generated_data['api_key']);
        $this->info('Valid Until : '.$generated_data['valid_until']);
    }
}
