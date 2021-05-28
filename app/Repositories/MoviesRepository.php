<?php

namespace App\Repositories;

use App\Http\Resources\MovieCollection;
use App\Models\Movie;

class MoviesRepository
{

    public $fillable = ['title','thumbnail','release_date','on_billboard'];

    /**
     * Recommended movies
     *
     * @return collection
     */
    public function recommended()
    {
        return Movie::select(['id','title','thumbnail','release_date','on_billboard'])
            ->inRandomOrder()
            ->take(15)
            ->get();
    }

    /**
     * Paginated list
     *
     * @return collection
     */
    public function list(string $sortBy = 'id', string $sortType = 'asc', int $perPage = 10)
    {
        $movies = Movie::select(['id','title','thumbnail','release_date','on_billboard'])
            ->with('schedules:id')
            ->orderBy($sortBy, $sortType)
            ->paginate($perPage);

        $data = $movies->getCollection();

        $data->each(function ($movie) {
            $schedules = $movie->schedules()->pluck('id');
            $movie->setRelation('schedules', $schedules);
        });

        $movies->setCollection($data);

        return $movies;
    }

    /**
     * Store new movie
     *
     * @return Movie
     */
    public function store(array $movie)
    {
        return Movie::create($movie)
            ->makeHidden('created_at','updated_at');
    }

    /**
     * Update movie
     *
     * @return Movie
     */
    public function update(int $id, array $movie)
    {
        $orginalMovie = Movie::select(['id','title','thumbnail','release_date','on_billboard'])
            ->findOrFail($id);

        $orginalMovie->title = !array_key_exists('title', $movie) ? $orginalMovie->title : $movie['title'];
        $orginalMovie->thumbnail = !array_key_exists('thumbnail', $movie) ? $orginalMovie->thumbnail : $movie['thumbnail'];
        $orginalMovie->release_date = !array_key_exists('release_date',$movie) ? $orginalMovie->release_date : $movie['release_date'];
        $orginalMovie->on_billboard = !array_key_exists('on_billboard',$movie) ? $orginalMovie->on_billboard : $movie['on_billboard'];

        if ($orginalMovie->isDirty()) {
            $orginalMovie->save();
        }

        return $orginalMovie;
    }

    /**
     * Delete movie
     *
     * @return object
     */
    public function delete(int $id)
    {
        $message = 'The movie was deleted';
        $statusCode = 200;

        if (Movie::destroy($id) == 0) {
            $statusCode = 500;
            $message = 'An error occurred while deleting the movie';
        }

        return response()->json([
            'message' => $message
        ], $statusCode);
    }

    /**
     * Sync schedules
     *
     * @return array
     */
    public function syncSchedules(int $id, array $schedules)
    {
        $movie = Movie::select('id')->findOrFail($id);
        $movie->schedules()->sync($schedules ?? []);

        return response()->json($schedules);
    }

}
