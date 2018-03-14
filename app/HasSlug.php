<?php

namespace App;

trait HasSlug
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootHasSlug()
    {
        static::creating(function ($model) {
            if (! $model->slug) {
                $model->generateSlug();
            }
        });
    }

    /**
     * Generate slug.
     *
     * @return void
     */
    protected function generateSlug()
    {
        $slug = str_slug($this->name);

        $slugCount = $this->where('slug', $slug)
                        ->orWhere('slug', 'like', $slug.'-%')
                        ->where('id', '<>', $this->id)
                        ->get()
                        ->count();

        $this->slug = ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }
}
