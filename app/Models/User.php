<?php

namespace App\Models;

use ForestAdmin\LaravelForestAdmin\Services\Concerns\ForestCollection;
use ForestAdmin\LaravelForestAdmin\Services\SmartFeatures\SmartField;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, ForestCollection;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return SmartField
     */
    public function creditCard(): SmartField
    {
        return $this->smartField(['type' => 'String'])
            ->get(
                fn() => '<div class="card-wrapper">
                    <div class="card-container"
                        style="font-size: 14px; border-radius: 10px; width: 250px; height: 140px; background-color: #444857; color: white; padding: 10px">
                        <div class="card-number-container" style="margin-top: 5px">
                            <div class="card-info-title" style="color: #9399af; ">card number</div>
                            <div class="card-info-value" style="font-size: 12px">' . $this->name . '</div>
                        </div>
                        <div class="card-name-date-container" style="display: flex; margin-top: 20px">
                            <div class="card-name-container">
                                <div class="card-info-title" style="color: #9399af; ">card holder</div>
                                <div class="card-info-value" style="font-size: 12px">' . $this->name . '</div>
                            </div>
                            <div class="card-date-container" style="margin: auto">
                                <div class="card-info-title" style="color: #9399af; ">expires at</div>
                                <div class="card-info-value" style="font-size: 12px">' . $this->created_at . '</div>
                            </div>
                        </div>
                    </div>
                </div>'
        );
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
