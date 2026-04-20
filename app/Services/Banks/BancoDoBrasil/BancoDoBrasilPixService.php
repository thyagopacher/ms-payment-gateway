<?php

namespace App\Services\Banks\BancoDoBrasil;

use App\Clients\Banks\BancoDoBrasil\BancoDoBrasilPixClient;
use App\Contracts\PixInterface;

class BancoDoBrasilPixService implements PixInterface
{

    private BancoDoBrasilPixClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new BancoDoBrasilPixClient();
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
