<?php

namespace App\Services\HistorieManager;

use Closure;
use App\Models\Historie;

class HistorieManager
{
    public function logAdd($model_id, $model_name, $before, $after, $action = 'on'){
        if(empty($model_id) || empty($model_name) || empty($before) || empty($after)){return false;}
        Historie::create(
            $log = [
                    'model_id'   => $model_id,
                    'model_name' => $model_name,
                    'before'     => $before,
                    'after'      => $after,
                    'action'     => $action,
            ]);
        return $log;
    }
}
