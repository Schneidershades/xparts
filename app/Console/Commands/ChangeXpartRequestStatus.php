<?php

namespace App\Console\Commands;

use App\Jobs\SendEmail;
use App\Mail\User\XpartRequestExpiredMail;
use App\Models\XpartRequest;
use Illuminate\Console\Command;

class ChangeXpartRequestStatus extends Command
{
    public $total;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:request-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates xpart request statuses';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->total = 0;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $time_start = microtime(true);

        $requests = XpartRequest::where('status', '!=', 'fulfilled')
            ->whereDate('created_at', '<', now()->subDays(3)->setTime(0, 0, 0)->toDateTimeString())
            ->get();

        foreach ($requests as $xpartRequest) {
            $user = $xpartRequest->user;
            $xpartRequest->update([
                'status' => 'expired',
            ]);

            SendEmail::dispatch($user['email'], new XpartRequestExpiredMail($xpartRequest, $user))->onQueue('emails');
            $this->total += 1;
        }

        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start) / 60;

        $this->info("Updated {$this->total} locations, Completed after {$execution_time} minutes");
        return 0;
    }
}
