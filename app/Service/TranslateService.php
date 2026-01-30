<?php

namespace App\Service;

use App\Contract\TranslateInterface;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateService implements TranslateInterface
{

    public function translate($text, $to)
    {
        // TODO: Implement translate() method.
        $tr = new GoogleTranslate($to);
        $tr->setSource(config('translate.default_lang'));
        $tr->setTarget($to);
        return $tr->translate($text);
    }
}
