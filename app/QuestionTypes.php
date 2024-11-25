<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum QuestionTypes: string implements HasLabel
{
    case PickOneAnswer = 'pick_one_answer';

    case TrueOrFalse = 'true_or_false';

    public function getLabel(): string
    {
        return match ($this) {
            self::PickOneAnswer => 'أختر اجابة واحدة فقط',
            self::TrueOrFalse => 'ضع علامة صح أو خطأ',
        };
    }
}
