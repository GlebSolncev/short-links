<?php

namespace App\Foundation\ShortLinks\DefaultShortLinks\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DefaultLinks
 *
 * @package App\Foundation\ShortLinks\DefaultShortLinks\Models
 */
class DefaultLinks extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'links';

    /**
     * @var string $primaryKey
     */
    protected $primaryKey = 'endpoint';
    /**
     * @var bool $incrementing
     */
    public $incrementing = false;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'endpoint',
        'url',
        'count',
        'active'
    ];
}