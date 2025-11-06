<?php

namespace App\Jobs;

use App\Dtos\Composite\RegisteredClientCompositeDto;
use App\Repositories\WarehouseRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CreateCompanyDefaultWarehouseJob implements ShouldQueue
{
    use Queueable;

    private RegisteredClientCompositeDto $registeredClientCompositeDto;

    private WarehouseRepository $warehouseRepository;

    /**
     * Create a new job instance.
     */
    public function __construct(RegisteredClientCompositeDto $registeredClientCompositeDto)
    {
        $this->registeredClientCompositeDto = $registeredClientCompositeDto;
        $this->warehouseRepository = new WarehouseRepository();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $defaultCompanyWarehouseData = [
                'company_id' => $this->registeredClientCompositeDto->company->id,
                'name' => 'Padrão',
                'description' => 'Armazém padrão da empresa',
                'is_default' => true,
            ];
            $this->warehouseRepository->createWarehouse($defaultCompanyWarehouseData);
        } catch (\Exception $exception) {
            Log::critical($exception);
            return;
        }
    }
}
