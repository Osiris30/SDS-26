<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'category_id', 'user_id', 'title', 'slug', 'excerpt', 'body', 'authors',
        'activity_date', 'activity_details', 'image_path', 'is_published', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'activity_date' => 'date',
            'activity_details' => 'array',
        ];
    }

    public static function activityFieldSets(): array
    {
        return [
            'ponencias' => [
                'speaker' => ['label' => 'Persona expositora', 'placeholder' => 'Nombre y cargo de la persona expositora.', 'type' => 'text', 'max' => 180],
            ],
            'talleres' => [
                'tools' => ['label' => 'Herramientas', 'placeholder' => '¿Qué herramientas o materiales utilizaron?'],
                'procedure' => ['label' => 'Procedimiento', 'placeholder' => 'Describe los pasos principales.'],
                'practice' => ['label' => 'Práctica realizada', 'placeholder' => '¿Qué hicieron las personas participantes?'],
                'results' => ['label' => 'Resultados', 'placeholder' => '¿Qué lograron o aprendieron?'],
            ],
            'bingo' => [
                'dynamics' => ['label' => 'Dinámica', 'placeholder' => '¿Cómo se desarrolló el bingo?'],
                'experience' => ['label' => 'Experiencia', 'placeholder' => 'Describe el ambiente y los momentos destacados.'],
                'participation' => ['label' => 'Participación', 'placeholder' => '¿Cómo se involucró la comunidad?'],
            ],
            'feria-de-proyectos' => [
                'projects' => ['label' => 'Proyectos visitados', 'placeholder' => 'Menciona los proyectos o áreas destacadas.'],
                'technologies' => ['label' => 'Tecnologías', 'placeholder' => '¿Qué tecnologías o soluciones conocieron?'],
                'innovation' => ['label' => 'Innovación', 'placeholder' => '¿Qué aportes novedosos observaron?'],
            ],
            'comelona-de-pizza' => [
                'development' => ['label' => 'Desarrollo de la actividad', 'placeholder' => '¿Cómo se organizó y desarrolló?'],
                'convivencia' => ['label' => 'Convivencia', 'placeholder' => '¿Cómo compartió la comunidad?'],
                'experience' => ['label' => 'Experiencia', 'placeholder' => '¿Qué momento recuerdan?'],
            ],
            'torneo-de-futbol-sala' => [
                'development' => ['label' => 'Desarrollo del torneo', 'placeholder' => 'Resume partidos y momentos destacados.'],
                'teams' => ['label' => 'Equipos', 'placeholder' => '¿Qué equipos participaron?'],
                'participation' => ['label' => 'Participación', 'placeholder' => 'Describe la experiencia como jugador o espectador.'],
            ],
            'parrillada' => [
                'description' => ['label' => 'Descripción de la actividad', 'placeholder' => '¿Cómo se desarrolló la jornada?'],
                'convivencia' => ['label' => 'Convivencia', 'placeholder' => '¿Cómo compartieron estudiantes y docentes?'],
                'reflection' => ['label' => 'Reflexión', 'placeholder' => '¿Qué reflexión deja esta experiencia?'],
            ],
        ];
    }

    public function activityDetailsForDisplay(): array
    {
        $fields = self::activityFieldSets()[$this->category?->slug] ?? [];
        $details = $this->activity_details ?? [];
        $display = [];

        foreach ($fields as $key => $field) {
            $value = trim((string) ($details[$key] ?? ''));
            if ($value !== '') {
                $display[] = ['label' => $field['label'], 'value' => $value];
            }
        }

        return $display;
    }

    protected static function booted(): void
    {
        static::saving(function (Post $post) {
            $post->slug = Str::slug($post->slug ?: $post->title);
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class)->orderBy('position');
    }
}
