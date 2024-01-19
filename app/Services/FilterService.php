<?php

namespace App\Services;


class FilterService
{
    public function filters($query, $key, $type, $value, $method = 'where', $relation_column = 'id', $operation = null)
    {
        if ($type === 'relation') {
            $query->whereHas($key, function ($q) use ($value, $method, $relation_column, $operation) {
                if ($operation)
                    $q->$method($relation_column, $operation, $value);
                else
                    $q->$method($relation_column, $value);
            });
        } elseif ($type === 'field') {

            if ($operation)
                $query->$method($key, $operation, $value);
            else
                $query->$method($key, $value);
        }

        return $query;
    }
}
