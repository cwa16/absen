<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'absent_code',
        'nik',
        'name',
        'status',
        'grade',
        'dept',
        'jabatan',
        'kemandoran',
        'sex',
        'ttl',
        'no_baju',
        'gol_darah',
        'start',
        'pendidikan',
        'agama',
        'domisili',
        'no_ktp',
        'no_telpon',
        'kis',
        'kpj',
        'bank',
        'no_bank',
        'suku',
        'no_sepatu_safety',
        'latitude',
        'longitude',
        'work_hour_id',
        'start_work_user',
        'end_work_user',
        'loc',
        'sistem_absensi',
        'aktual_cuti',
        'status_pernikahan',
        'istri_suami',
        'anak_1',
        'anak_2',
        'anak_3',
        'access_by',
        'image_url',
        'role_app',
        'active',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function absen()
    {
      return $this->hasMany(Absen::class);
    }

    public function absen_reg()
    {
      return $this->hasMany(AbsenReg::class, 'user_id', 'nik');
    }

    public function absen_reg_test()
    {
      return $this->hasMany(TestingAbsen::class, 'user_id', 'nik');
    }

    public function absen_reg_input()
    {
      return $this->hasMany(AbsenRegInput::class);
    }

    public function leave_budget()
    {
      return $this->hasMany(LeaveBudget::class, 'user_id', 'nik');
    }

    public function leave()
    {
      return $this->hasMany(Leave::class, 'user_id', 'nik');
    }

    public function mandor()
    {
      return $this->hasMany(MandorTapper::class, 'user_sub', 'nik');
    }

    public function mandors()
    {
      return $this->hasMany(MandorTapper::class, 'user_id', 'nik');
    }

    public function trainings()
    {
      return $this->hasMany(AttTraining::class, 'nik', 'nik');
    }

}
