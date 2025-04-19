<?php

namespace Hansoft\CloudSass\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'cloud_sass_projects_table';

    protected $guarded = [];

    public function clients()
    {
        return $this->hasMany(Client::class, 'project_id', 'id');
    }
}
