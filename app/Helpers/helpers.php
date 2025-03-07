<?php

function highlightWords($content, $violations)
{
    foreach ($violations as $violation) {
        $content = preg_replace(
            '/\b('.preg_quote($violation, '/').')\b/i',
            '<span style="background-color: red; color: white; padding: 2px;">$1</span>',
            $content
        );
    }

    return $content;
}
