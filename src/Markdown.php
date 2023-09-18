<?php

namespace App;

use Majkel\Mathdown\Mathdown;

class Markdown extends Mathdown
{
    public function __construct()
    {
        $this->InlineTypes['\\'][]= 'Macro';

        $this->inlineMarkerList .= '\\';

        $this->InlineTypes['-'][]= 'Dash';

        $this->inlineMarkerList .= '-';

        parent::__construct();
    }

    protected function inlineMacro($excerpt)
    {
        $matches = [];
        if (!preg_match('/^\\\([a-zA-Z][a-z0-9A-Z]*)/', $excerpt['text'], $matches)) {
            return;
        }

        return [
            'extent' => strlen($matches[0]),
            'element' => match ($matches[1]) {
                'ale' => [
                    'name' => 'strong',
                    'text' => 'ALE'
                ],
                'ne' => [
                    'name' => 'strong',
                    'text' => 'ne',
                ],
            }
        ];
    }

    protected function inlineDash($excerpt)
    {
        if (str_starts_with($excerpt['text'], '--')) {
            return [
                'extent' => 2,
                'element' => [
                    'name' => 'span',
                    'rawHtml' => '&#45;',
                ],
            ];
        }
    }
}
