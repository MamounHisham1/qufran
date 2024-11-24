<?php

namespace App;

enum PostTypes: string
{
    case Video = 'video';
    case Article = 'article';
    case Audio = 'audio';
    case Photo = 'photo';
}
