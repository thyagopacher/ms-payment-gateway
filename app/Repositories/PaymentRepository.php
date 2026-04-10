<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class PaymentRepository extends BaseRepository
{

    /**
     * @var \App\Models\Payment
     */
    protected Model $model;

    public function __construct()
    {
        parent::__construct(app('App\Models\Payment'));
    }

    public function findPaymentById(int $id): array
    {
        $payment = $this->find($id);

        $data = $payment ? $payment->toArray() : [];
        if (empty($data)) {
            throw new \Exception('Pagamento não encontrado.');
        }

        $data['person_name'] = $payment->person()->name;
        return $data;
    }

    public function getPayments(array $filters = []): array
    {
        $query = $this->model->newQuery();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['person_id'])) {
            $query->where('person_id', $filters['person_id']);
        }

        if (isset($filters['limit'])) {
            $query->limit($filters['limit']);
        }

        return $query->get()->toArray();
    }
}
