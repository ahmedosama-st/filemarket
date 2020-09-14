<?php

namespace App;

use App\FileApproval;
use App\Sale;
use App\Traits\HasApprovals;
use App\Upload;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model 
{
    use HasApprovals, SoftDeletes;

    const APPROVAL_PROPERTIES = [
        'title',
        'overview_short',
        'overview',
    ];

    protected array $fillable = [
        'title',
        'overview_short',
        'overview',
        'price',
        'live',
        'approved',
        'finished',
    ];

    public function needsApproval(array $approvalProperties)
    {
        if ($this->currentPropertiesDifferToLatestUpdates($approvalProperties)) {
            return true;
        }

        return false;
    }

    public function createApprovals(array $approvalProperties)
    {
        if ($this->currentPropertiesDifferToLatestUpdates($approvalProperties)) {
            $this->approvals()->create(array_only($this->approvals()->where('deleted_at', null)->latest()->first()->toArray(), self::APPROVAL_PROPERTIES));
        }
    }

    protected function currentPropertiesDifferToLatestUpdates(array $approvalProperties): array
    {
        return array_only($this->approvals()->where('deleted_at', null)->latest()->firstOrCreate($approvalProperties)->toArray(), self::APPROVAL_PROPERTIES) != $approvalProperties;
    }

    public function approve(): void
    {
        $this->updateToBeVisible();
        $this->approveAllUploads();
    }

    public function calculateCommission()
    {
        return (20 / 100) * $this->price;
    }

    public function approveAllUploads()
    {
        $this->uploads()->update([
            'approved' => true,
        ]);
    }

    public function deleteUnapprovedUploads()
    {
        $this->uploads()->delete();
    }

    public function visible(): bool
    {
        if (auth()->user()->isAdmin()) {
            return true;
        }

        if (auth()->user()->isTheSameAs($this->user)) {
            return true;
        }

        return $this->live && $this->approved;
    }

    public function matchesSale(Sale $sale)
    {
        return $this->sales->contains($sale);
    }

    public function getUploadList()
    {
        return $this->uploads()->approved()->get()->pluck('path')->toArray();
    }

    protected function updateToBeVisible()
    {
        $this->update([
            'live' => true,
            'approved' => true,
        ]);
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

    public function approvals()
    {
        return $this->hasMany(FileApproval::class);
    }

    public function isFree()
    {
        return $this->price == 0;
    }

    public function mergeAndUpdateApprovalProperties()
    {
        $this->update(array_only(
            $this->approvals->first()->toArray(),
            self::APPROVAL_PROPERTIES
        ));
    }

    public function deleteAllApprovals()
    {
        $this->approvals()->delete();
    }

    public function isApproved()
    {
        return $this->approved;
    }

    public function isLive()
    {
        return $this->live;
    }

    public function scopeFinished(Builder $builder)
    {
        return $builder->where('finished', true);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($file) {
            $file->identifier = uniqid(true);
        });
    }

    public function getRouteKeyName()
    {
        return 'identifier';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
