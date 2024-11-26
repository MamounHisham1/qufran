<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum PostTypes: string implements HasLabel
{
    case Video = 'video';
    case Article = 'article';
    case Audio = 'audio';
    case Photo = 'photo';
    case Lesson = 'lesson';

    public function getLabel(): string
    { 
        return match ($this) {
            self::Video => 'فيديو',
            self::Article => 'مقال',
            self::Audio => 'صوتي',
            self::Photo => 'صورة',
            self::Lesson => 'درس',
        };
    }
}
