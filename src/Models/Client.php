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

    protected function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    protected function getDatabaseNameAttribute()
    {
        $project_name = Str::slug($this->project->name, '_');
        return sprintf('%s_%s', $project_name, $this->id);
    }
}
