<?php

namespace App\Repositories;

use App\Models\Schedule;

class SchedulesRepository
{

    public $fillable = ['hour','status'];

    /**
     * List of schedules
     *
     * @return collection
     */
    public function list()
    {
        return Schedule::select(['id','hour','status'])
            ->get();
    }

    /**
     * Store new schedule
     *
     * @return Schedule
     */
    public function store(array $schedule)
    {
        return Schedule::create($schedule)
            ->makeHidden('created_at','updated_at');
    }

    /**
     * Update schedule
     *
     * @return Schedule
     */
    public function update(int $id, array $schedule)
    {
        $originalSch = Schedule::select(['id','hour','status'])
            ->findOrFail($id);

        $originalSch->hour = !array_key_exists('hour',$schedule) ? $originalSch->hour : $schedule['hour'];
        $originalSch->status = !array_key_exists('status',$schedule) ? $originalSch->status : $schedule['status'];

        if ($originalSch->isDirty()) {
            $originalSch->save();
        }

        return $originalSch;
    }

    /**
     * Delete schedule
     *
     * @return object
     */
    public function delete(int $id)
    {
        $message = 'The schedule was deleted';
        $statusCode = 200;

        if (schedule::destroy($id) == 0) {
            $statusCode = 500;
            $message = 'An error occurred while deleting the schedule';
        }

        return response()->json([
            'message' => $message
        ], $statusCode);
    }

}
