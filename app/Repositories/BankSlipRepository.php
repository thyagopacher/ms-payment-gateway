<?php

namespace App\Repositories;

use App\Models\Bank;
use Illuminate\Database\Eloquent\Model;

class BankSlipRepository extends BaseRepository
{

    /**
     * @var BankSlip
     */
    protected Model $model;

    public function __construct()
    {
        parent::__construct(app('App\Models\BankSlip'));
    }

    public function findBankSlipById(int $id): array
    {
        $bankSlip = $this->find($id);

        $data = $bankSlip ? $bankSlip->toArray() : [];
        if (empty($data)) {
            throw new \Exception('Boleto não encontrado.');
        }

        $data['bank'] = $bankSlip->bank()->code;
        return $data;
    }
}
