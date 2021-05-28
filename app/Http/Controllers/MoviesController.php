<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MovieStore;
use App\Http\Requests\MovieUpdate;
use App\Repositories\MoviesRepository;
use Illuminate\Support\Facades\Validator;

class MoviesController extends Controller
{

    private $repository;

    public function __construct(MoviesRepository $repository)
    {
        $this->middleware('auth:sanctum')->except('recommended');
        $this->repository = $repository;
    }

    /**
     * Recommended movies
     *
     * @return collection
     */
    public function recommended()
    {
        return $this->repository->recommended();
    }

    /**
     * Movies list
     *
     * @return collection
     */
    public function list(Request $request)
    {
        $validSort      = ['id','title','release_date','on_billboard'];
        $sortBy         = $this->validateSortBy($request->query('sortBy'), $validSort);
        $sortType       = $this->vlidateSortType($request->query('sortBy'));
        $perPage        = $this->validatePerPage($request->query('perPage'));

        return $this->repository->list($sortBy, $sortType, $perPage);
    }

    /**
     * Store movie
     *
     * @return Movie
     */
    public function store(MovieStore $request)
    {
        $imagePath = $request->file('thumbnail')->store('public/movies/thumbnails');

        $movie = [];
        $movie['title'] = $request->title;
        $movie['thumbnail'] = config('app.url') . str_replace('public', '/storage', $imagePath);
        $movie['release_date'] = $request->release_date;
        $movie['on_billboard'] = $request->on_billboard;

        return $this->repository->store($movie);
    }

    /**
     * Update movie
     *
     * @return Movie
     */
    public function update(MovieUpdate $request, $id)
    {
        $movie = [];
        $data = $request->all();

        if ($request->hasFile('thumbnail')) {
            $imagePath = $request->file('thumbnail')->store('public/movies/thumbnails');
            $data['thumbnail'] = config('app.url') . str_replace('public', '/storage', $imagePath);
        }

        foreach ($this->repository->fillable as $field) {
            if (array_key_exists($field, $data)) {
                $movie[$field] = $data[$field];
            }
        }

        return $this->repository->update($id, $movie);
    }

    /**
     * Delete movie
     *
     * @return message
     */
    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Sync schedules
     *
     * @return array
     */
    public function syncSchedules(Request $request, int $id)
    {
        $rules = ['nullable','numeric','min:1'];
        $data = $request->schedules;

        if (!Validator::make($data, $rules)->passes()) {
            abort(401, 'Bad request');
        }

        return $this->repository->syncSchedules($id, $data);
    }

}
