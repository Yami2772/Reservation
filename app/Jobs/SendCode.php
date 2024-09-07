<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $User;
    protected $code;

    /**
     * Create a new job instance.
     */
    public function __construct($User, $code)
    {
        $this->User = $User;
        $this->code = $code;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        require 'autoload.php';

        $apiKey = "CUjKycwbNjCBDDPYQWAdzYb7uR2z3O3rsgBKP4Bdyuc=";

        $client = new \IPPanel\Client($apiKey);

        $patternValues = [
            "code" => $code,
        ];

        $client->sendPattern(
            "x158bky4hxb5e5u",    // pattern code
            "+983000505",         // originator
            $User->phone_number,  // recipient
            $patternValues,       // pattern values
        );
    }
}
