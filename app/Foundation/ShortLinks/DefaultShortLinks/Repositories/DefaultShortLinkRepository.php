<?php

namespace App\Foundation\ShortLinks\DefaultShortLinks\Repositories;

use App\Foundation\AbstractModules\Repositories\AbstractRepository;
use App\Foundation\ShortLinks\DefaultShortLinks\Models\DefaultLinks;

class DefaultShortLinkRepository extends AbstractRepository
{
    /**
     * @var string $classModel
     */
    public $classModel = DefaultLinks::class;
}