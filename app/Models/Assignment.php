<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'deadline',
        'file',
        'status',
        'lecturer_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'deadline' => 'datetime',
    ];    

    protected $appends = [
        'status_dynamic'
    ];

    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function getStatusDynamicAttribute()
    {
        $now = now();
        $status = null;
    
        // Dosen
        if (Auth::check() && Auth::user()->role === 'dosen') {
            if ($now->lessThan($this->start_date)) {
                $status = 'scheduled';
            } elseif ($now->between($this->start_date, $this->deadline)) {
                $status = 'in progress';
            } elseif ($now->greaterThanOrEqualTo($this->deadline)) {
                $status = 'completed';
            }
        }
    
        // Mahasiswa
        if (Auth::check() && Auth::user()->role === 'mahasiswa') {
            $userId = Auth::id();
            $hasSubmitted = $this->submissions()->where('student_id', $userId)->exists();
    
            if ($hasSubmitted) {
                $status = 'completed';
            } elseif ($now->lessThan($this->deadline)) {
                $status = 'in progress';
            } elseif ($now->greaterThanOrEqualTo($this->deadline)) {
                $status = 'missed';
            }
        }
    
        return $status;
    }
}