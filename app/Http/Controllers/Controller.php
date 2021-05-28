<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Validate sort by param
     *
     * @return string
     */
    protected function validateSortBy(string $sortBy = null, array $validKeys = ['id'], string $default = 'id')
    {
        $sortBy = substr($sortBy, 0,1) == '-' ? substr($sortBy, 1, strlen($sortBy)) : $sortBy;

        if (empty($sortBy) || !in_array($sortBy, $validKeys)) {
            return $default;
        }

        return $sortBy;
    }

    /**
     * Validate sort type param
     *
     * @return string
     */
    protected function vlidateSortType(string $sortBy = null)
    {

        if (empty($sortBy)) {
            return 'asc';
        }

        return substr($sortBy, 0,1) == '-' ? 'desc' : 'asc';
    }

    /**
     * Validate per page param
     *
     * @return int
     */
    protected function validatePerPage(int $perPage = null)
    {
        if ($perPage == null || $perPage < 10 || $perPage > 100) {
            return 10;
        }

        return $perPage;
    }

}
