<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleStore;
use App\Http\Requests\ScheduleUpdate;
use Illuminate\Http\Request;
use App\Repositories\SchedulesRepository;

class SchedulesController extends Controller
{

    private $repository;

    public function __construct(SchedulesRepository $repository)
    {
        $this->middleware('auth:sanctum');
        $this->repository = $repository;
    }

    /**
     * List schedules
     *
     * @return collection
     */
    public function list()
    {
        return $this->repository->list();
    }

    /**
     * Store schedule
     *
     * @return Schedule
     */
    public function store(ScheduleStore $request)
    {
        $schedule = $request->all();

        return $this->repository->store($schedule);
    }

    /**
     * Update schedule
     *
     * @return Schedule
     */
    public function update(ScheduleUpdate $request, int $id)
    {
        $schedule = [];
        $data = $request->all();

        foreach ($this->repository->fillable as $field) {
            if (array_key_exists($field, $data)) {
                $schedule[$field] = $data[$field];
            }
        }

        return $this->repository->update($id, $schedule);
    }

    /**
     * Delete schedule
     *
     * @return message
     */
    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }

}
