<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'line_id',
        'status_message',
        'picture_url',
        'status'
    ];

    public function questionnaire(): HasMany
    {
        return $this->hasMany(Questionnaire::class);
    }

    public function questionnaireCompleted(): bool
    {
        $valid = true;
        foreach (Questionnaire::$routeNames as $routeName) {
            if ($this->questionnaire()->where('route_name', $routeName)->doesntExist()) {
                $valid = false;
            }
        }
        return $valid;
    }

    public function questionnaireUnCompleted(): array
    {
        $routeNames = [];
        foreach (Questionnaire::$routeNames as $routeName) {
            if ($this->questionnaire()->where('route_name', $routeName)->doesntExist()) {
                $routeNames[] = $routeName;
            }
        }
        return $routeNames;
    }
}
