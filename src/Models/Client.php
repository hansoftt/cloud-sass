<?php
namespace Hansoft\CloudSass\Models;

use Carbon\Carbon;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Client extends Model
{
    protected $table = 'cloud_sass_clients_table';

    protected $guarded = [];

    protected $appends = [
        'database_name',
        'is_expired',
    ];

    protected function getDatabaseNameAttribute()
    {
        $prefix = config('cloud-sass.database_prefix');
        $name = Str::slug($this->name, '_');
        return sprintf('%s_%s_%s', $prefix, $name, $this->id);
    }

    protected function getIsExpiredAttribute()
    {
        $subscription = $this->subscription;
        if ($subscription) {
            return Carbon::parse($this->created_at)->addDays($subscription->validity) < Carbon::now();
        }

        return false;
    }

    protected function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'id');
    }
}
