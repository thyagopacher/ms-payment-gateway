<?php

namespace App\Services;

use App\Dto\PersonDTO;
use App\Models\Person;
use App\Notifications\PersonCreated;
use App\Repositories\PersonRepository;
use Illuminate\Database\Eloquent\Collection;

class PersonService
{

    public function __construct(
        private PersonRepository $personRepository
    ) {

    }

    public function create(PersonDTO $personData): int
    {

        $person = $this->personRepository->findByDocument($personData->person_document);
        if (!empty($person->id)) {
            return $person->id;
        }

        /**
         * @var Person $person
         */
        $person = $this->personRepository->create($personData->toArray());
        $person->notify(new PersonCreated($person));

        return $person->id;
    }

    public function update(PersonDTO $data, int $id)
    {
        return $this->personRepository->update($id, $data->toArray());
    }

    public function delete(int $id)
    {
        $res = $this->personRepository->delete($id);
        return $res;
    }

    public function find(int $id)
    {
        return $this->personRepository->find($id);
    }

    public function findAll(): Collection
    {
        return $this->personRepository->all();
    }

}
