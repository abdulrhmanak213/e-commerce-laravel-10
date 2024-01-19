<?php

namespace App\Http\Controllers\Admin\Term;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Policy\TermRequest;
use App\Models\Term;
use App\Repositories\Contracts\ITerm;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function show(): \Illuminate\Http\Response
    {
        $term = Term::query()->firstOrCreate([]);
        return self::returnData('term', $term);
    }

    public function store(TermRequest $request): \Illuminate\Http\Response
    {
        $data = $request->validated();
        $term = Term::query()->firstOrCreate([]);
        $this->translate($term, $data);
        return self::success('Success!');
    }

    public function translate($record, $data)
    {
        $translatedAttributes = ['message', 'title'];
        foreach ($this->languages as $language) {
            foreach ($translatedAttributes as $field)
                $record->translateOrNew($language)->$field = $data[$field . '_' . $language];
        }
        $record->save();
    }
}
