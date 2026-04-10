<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BankSlipRepository extends BaseRepository
{

    /**
     * @var \App\Models\BankSlip
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

        $bank = $bankSlip->bank()->first();
        if (empty($bank->code)) {
            throw new \Exception('Banco do boleto não encontrado.');
        }

        $data['bank'] = $bank->code;
        return $data;
    }
}
