<?php

namespace App\Services;

use App\Models\Person;
use App\Notifications\PersonCreated;
use App\Repositories\PersonRepository;

class PersonService
{

    public function __construct(
        private PersonRepository $personRepository
    ) {

    }

    public function create(array $personData): int
    {

        /**
         * @var Person $person
         */
        $person = $this->personRepository->create($personData);
        $person->notify(new PersonCreated($person));

        return $person->id;
    }

    public function update(array $data, int $id)
    {
        $res = $this->personRepository->update($id, $data);
        return $res;
    }

    public function delete(int $id)
    {
        $res = $this->personRepository->delete($id);
        return $res;
    }

    public function find(int $id)
    {
        $person = $this->personRepository->find($id);
        return $person;
    }

}
