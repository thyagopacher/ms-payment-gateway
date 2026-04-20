<?php

namespace App\Services\Banks\Santander;

use App\Clients\Banks\Santander\SantanderPixClient;
use App\Contracts\PixInterface;

class SantanderPixService implements PixInterface
{

    private SantanderPixClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new SantanderPixClient();
    }

    public function generateBilling(array $data): array
    {
        return $this->apiBanco->generateBilling($data);
    }

    public function recurrenceBilling(array $data): array
    {
        return $this->apiBanco->recurrenceBilling($data);
    }

    public function cancelRecurrenceBilling(array $data): array
    {
        return $this->apiBanco->cancelRecurrenceBilling($data);
    }

}
