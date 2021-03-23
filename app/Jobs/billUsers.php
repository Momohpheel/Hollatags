<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class billUsers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $token = env('PAYSTACK-AUTH-TOKEN');
        Redis::throttle('key')->allow(500)->every(120)->then(function () {
                // $response = Http::withToken($token)->post('https://api.paystack.co/transaction/charge_authorization', [
                //     'authorization_code' => $this->user->auth_code,
                //     'email' => $this->user->email,
                //     'amount' => $this->user->amount_to_bill,
                // ]);
                Log::info('message dispatched');
            
        }, function(){
            return $this->release(120);
        });
        

    }
}
