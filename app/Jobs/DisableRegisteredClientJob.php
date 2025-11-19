<?php

namespace App\Jobs;

use App\Models\Company;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DisableRegisteredClientJob implements ShouldQueue
{
    use Queueable;

    private Company $company;

    /**
     * Create a new job instance.
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $companyRelatedUsers = $this->company->generalUsers;
            $companyItems = $this->company->itemsInStock;
            foreach($companyRelatedUsers as $user) {
                DB::table('sessions')->where('user_id', $user->id)->delete();
                $user->update([
                    'is_active' => false,
                ]);
            }
            foreach($companyItems as $companyItem) {
                $companyItem->update([
                    'is_active' => false,
                ]);
            }
            $this->company->update([
                'is_active' => false,
            ]);
        } catch (\Exception $exception) {
            Log::critical($exception);
            return;
        }
    }
}
