<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Http;

class Login extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:login {login} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Login';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = $this->arguments();
        $response = Http::asForm()->post('localhost/oauth/token', [
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            'username' => $data['login'],
            'password' => $data['password'],
            'scope' => '*',
        ])->object();
        if (isset($response->error)) {
            echo 'Invalid login or password';
        } else {
            echo $response->access_token;
        }

        return Command::SUCCESS;
    }
}