<?php

namespace App\Services\Reports;

use App\Http\Resources\PaymentResource;
use App\Repositories\PaymentRepository;
use App\Repositories\PersonRepository;
use App\Services\CsvService;

class PersonCsvReport
{
    public function __construct(
        private CsvService $csvService,
        private PersonRepository $personRepository
    ) {

    }

    public function generate(array $filters): string
    {
        $persons = $this->personRepository->getPersons($filters);
        $rows = PaymentResource::collection($persons)->resolve();
        return $this->csvService->generate($rows);
    }

}
