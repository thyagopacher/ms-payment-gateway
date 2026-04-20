<?php

namespace App\Services\Banks\Bradesco;

use App\Clients\Banks\Bradesco\BradescoPixClient;
use App\Contracts\PixInterface;

class BradescoPixService implements PixInterface
{

    private BradescoPixClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new BradescoPixClient();
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
