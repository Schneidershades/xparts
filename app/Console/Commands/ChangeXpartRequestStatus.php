<?php

namespace App\Console\Commands;

use App\Models\Quote;
use App\Jobs\SendEmail;
use App\Models\XpartRequest;
use Illuminate\Console\Command;
use App\Mail\Vendor\XpartQuoteMail;
use App\Models\XpartRequestVendorWatch;
use App\Mail\User\XpartRequestExpiredMail;

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

        $requests = XpartRequest::where('status', '!=', 'ordered')
            ->where('status', '!=', 'paid')
            ->where('status', '!=', 'delivered')
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


        $allRequestsSent = $requests->pluck('id')->toArray();

        $notPaidQuotesButStillActive = Quote::whereIn('xpart_request_id', $allRequestsSent)->where('status', 'active')->get();

        foreach ($notPaidQuotesButStillActive as $quote) {
            $quote->status = 'expired';
            $quote->save();

            SendEmail::dispatch($quote->vendor->email, new XpartQuoteMail($quote, $quote->vendor))->onQueue('emails')->delay(5);
        }

        $sentRequest = XpartRequestVendorWatch::whereIn('xpart_request_id', $allRequestsSent)->get();

        foreach ($sentRequest as $sent) {
            $sent->status = 'expired';
            $sent->save();
        }

        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start) / 60;

        $this->info("Updated {$this->total} xp_requests, Completed after {$execution_time} minutes");
        
        return 0;
    }
}
