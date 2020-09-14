<?php

namespace App;

use App\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileApproval extends Model
{
    use SoftDeletes;

    protected $table = 'file_approvals';

    protected $fillable = [
        'title',
        'overview_short',
        'overview',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($approval) {
            $approval->file->approvals->each->delete();
        });
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
