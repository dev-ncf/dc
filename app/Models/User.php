<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles; // Adicionar esta linha
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles; // Adicionar esta linha

    // Regra para permitir quem pode entrar no painel administrativo
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->is_active; // Apenas usuários ativos entram
        }
        return true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
         'orcid',
        'phone', 
        'organic_unit_id', 
        'user_type',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function posts() {
        return $this->hasMany(Post::class);
    }
     // Relacionamento com a Faculdade/Campus
    public function organicUnit()
    {
        return $this->belongsTo(OrganicUnit::class, 'organic_unit_id');
    }
    // Produção Científica do utilizador
    public function publications(){ return $this->hasMany(Publication::class); }

    // Projetos que o docente coordena
    public function coordinatedProjects() { 
        return $this->hasMany(ResearchProject::class, 'coordinator_id'); 
    }

    // Projetos onde o utilizador é apenas membro da equipa
    public function researchTeams() {
        return $this->belongsToMany(ResearchProject::class, 'project_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
