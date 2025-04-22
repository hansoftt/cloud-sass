<?php
namespace Hansoft\CloudSass\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Client extends Model
{
    protected $table = 'cloud_sass_clients_table';

    protected $guarded = [];

    protected $appends = [
        'database_name',
    ];

    protected function getDatabaseNameAttribute()
    {
        $name = Str::slug($this->name, '_');
        return sprintf('%s_%s', $name, $this->id);
    }
}
