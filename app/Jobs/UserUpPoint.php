<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\point;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserUpPoint implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        //
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
      //  sleep(5);
        $total_point = 0;
            $objs = point::where('user_key', $this->details['phone'])->get();

            foreach($objs as $u){
                if($this->details['type'] == 0){
                    $total_point += $this->details['point'];
                }elseif($this->details['type'] == 2){
                $total_point += $this->details['point'];
                }else{
                    $total_point -= $this->details['point'];
                }
            }

            $package = User::find($this->details['id']);
            $package->point = $total_point;
            $package->save();


    }
}
