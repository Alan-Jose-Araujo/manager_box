<?php
namespace Tests\Unit\Jobs;

use App\Jobs\DisableRegisteredClientJob;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DisableRegisteredClientJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_disables_company_and_related_users_and_deletes_sessions(): void
    {
        $company = Company::factory()->create();
        $users = User::factory()->count(2)->create([
            'company_id' => $company->id,
        ]);

        foreach ($users as $index => $user) {
            DB::table('sessions')->insert([
                'id' => $index,
                'user_id' => $user->id,
                'payload' => '',
                'last_activity' => now()->timestamp,
            ]);
        }

        (new DisableRegisteredClientJob($company))->handle();

        $company->refresh();
        $this->assertFalse($company->is_active);

        foreach ($users as $user) {
            $user->refresh();
            $this->assertFalse($user->is_active);
            $this->assertDatabaseMissing('sessions', ['user_id' => $user->id]);
        }
    }
}