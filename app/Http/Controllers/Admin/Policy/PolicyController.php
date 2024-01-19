<?php

namespace App\Http\Controllers\Admin\Policy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Policy\PolicyRequest;
use App\Models\Policy;
use App\Repositories\Contracts\IPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use phpseclib3\File\ASN1\Maps\netscape_ca_policy_url;

class PolicyController extends Controller
{
    public function show(): \Illuminate\Http\Response
    {
        $policy = Policy::query()->firstOrCreate([]);
        return self::returnData('policy', $policy);
    }

    public function store(PolicyRequest $request): \Illuminate\Http\Response
    {
        $data = $request->validated();
        $policy = Policy::query()->firstOrCreate([]);
        $this->translate($policy, $data);
        return self::success('Success!');
    }

    public function translate($record, $data)
    {
        foreach ($this->languages as $language) {
            foreach (App::make(Policy::class)->translatedName as $field)
                $record->translateOrNew($language)->$field = $data[$field . '_' . $language];
        }
        $record->save();
    }

}
