<?php

namespace Modules\Payments\Entities;

use App\Models\BaseModel;

class Payments extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';

    protected $fillable = [
        'name'
    ];
}
