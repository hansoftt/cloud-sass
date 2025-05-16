<?php
namespace Hansoft\CloudSass\Models;

use Carbon\Carbon;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Client extends Model
{
    protected $table = 'cloud_sass_clients_table';

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

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

    protected static function booted(): void
    {
        $table = (new static)->getTable();
        static::deleted(function (Client $user) use ($table) {
            DB::statement(sprintf('ALTER TABLE `%s` AUTO_INCREMENT = 1;', $table));
        });
    }
}
