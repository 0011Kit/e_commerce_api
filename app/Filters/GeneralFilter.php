<?php 

namespace App\Filters;

use Illuminate\Http\Request;

class GeneralFilter{
    protected $safeParams = [];

    protected $columnMap = [];

    protected $operatorMap = [
        'eq'    =>  '=',
        'lt'    =>  '<',
        'mt'    =>  '>',
        'lte'   =>  '<=',
        'mte'   =>  '>=',
        'ne'    =>  '!=',
        'like'  =>  'like'
    ];

    public function transform(Request $request): array{
        $queryItems = [];
        foreach ($this->safeParams as $param) {
            $value = $request->query($param);

            if (!$value) {
                continue;
            }

            $column = $this->columnMap[$param] ?? $param;

            if (is_array($value)) {
                foreach ($value as $operator => $val) {
                    $sqlOperator = $this->operatorMap[$operator] ?? null;

                    if ($sqlOperator) {
                        $queryItems[] = [$column, $sqlOperator, $sqlOperator === 'like' ? "%$val%" : $val];
                    }
                }
            } else {
                $queryItems[] = [$column, 'like', "%$value%"];
            }
        }

        return $queryItems;
    }

    public function getSort(Request $request): array
    {
        $sortParam = $request->query('sort');

        if (!$sortParam) {
            return [];
        }

        $sorts = explode(',', $sortParam);
        $sortInstructions = [];

        foreach ($sorts as $sort) {
            $direction = 'asc';
            if (str_starts_with($sort, '-')) {
                $direction = 'desc';
                $sort = ltrim($sort, '-');
            }

            if (!in_array($sort, $this->safeParams)) {
                continue; 
            }

            $column = $this->columnMap[$sort] ?? $sort;
            $sortInstructions[] = [$column, $direction];
        }

        return $sortInstructions;
    }
    
}

