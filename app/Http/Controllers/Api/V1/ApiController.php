<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class ApiController extends Controller
{
    use ApiResponses;

    protected $policyClass;

    protected string $namespace = 'App\\\\Policies\\\\V1';

    public function __construct()
    {
        Gate::guessPolicyNamesUsing(fn (string $modelClass) =>
            "{$this->namespace}\\\\" . class_basename($modelClass) . "Policy"
        );
    }
    public function include(string $relationship):bool{
        $param = request()->get('include');

        if (!isset($param)) {
        return false;
        }

        $includeValues = explode(',', strtolower($param));

        return in_array(strtolower($relationship), $includeValues);
    }

    public function isAble($ability, $targetModel)
    {
        $modelClass = is_object($targetModel) ? get_class($targetModel) : $targetModel;
        $gate = Gate::policy($modelClass, $this->policyClass);
        return $gate->authorize($ability, [$targetModel]);
    }
}
