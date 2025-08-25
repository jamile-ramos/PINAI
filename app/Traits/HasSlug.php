<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->generateUniqueSlug();
        });

        static::updating(function (Model $model) {
            if ($model->isDirty($model->slugFrom())) {
                $model->generateUniqueSlug();
            }
        });
    }

    protected function slugFrom(): string
    {
        // Campo base para gerar o slug (ajuste por model, se necessário)
        return property_exists($this, 'slugFrom') ? $this->slugFrom : 'titulo';
    }

    protected function slugField(): string
    {
        return property_exists($this, 'slugField') ? $this->slugField : 'slug';
    }

    protected function generateUniqueSlug(): void
    {
        $from = $this->slugFrom();
        $field = $this->slugField();

        $base = Str::slug((string) $this->{$from});
        $slug = $base;

        // Garante unicidade dentro da tabela
        $i = 2;
        while (
            static::where($field, $slug)
                ->when($this->exists, fn($q) => $q->whereKeyNot($this->getKey()))
                ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        $this->{$field} = $slug;
    }
}
