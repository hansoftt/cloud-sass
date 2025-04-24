<?php
namespace Hansoft\CloudSass\Models;

use \Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscription extends Model
{
    protected $table = 'cloud_sass_subscriptions_table';

    protected $guarded = [];

    protected function clients()
    {
        return $this->hasMany(Client::class, 'subscription_id', 'id');
    }
}
