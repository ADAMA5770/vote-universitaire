<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivite extends Model
{
    public $timestamps = false;

    protected $table = 'logs_activite';

    protected $fillable = ['user_id', 'action', 'details', 'ip'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log(string $action, string $details = null): void
    {
        static::create([
            'user_id' => auth()->id(),
            'action'  => $action,
            'details' => $details,
            'ip'      => request()->ip(),
        ]);
    }
}
