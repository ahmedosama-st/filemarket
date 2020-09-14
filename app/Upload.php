<?php

namespace App;

use App\File;
use App\Traits\HasApprovals;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload extends Model
{
    use HasApprovals, SoftDeletes;

    protected $fillable = [
        'filename',
        'size',
        'approved',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPathAttribute()
    {
        return storage_path('app/files/' . $this->file->identifier . '/' . $this->filename);
    }
}
