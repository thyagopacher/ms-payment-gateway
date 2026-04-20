<?php

namespace App\Services\Banks\Itau;

use App\Clients\Banks\Itau\ItauPixClient;
use App\Contracts\PixInterface;

class ItauPixService implements PixInterface
{

    private ItauPixClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new ItauPixClient();
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
