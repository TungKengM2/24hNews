<?php

function highlightWords($content, $violations = [])
{
    if (empty($violations) || ! is_array($violations)) {
        return $content;
    }

    foreach ($violations as $violation) {
        $pattern = '/\b('.preg_quote($violation, '/').')\b/i';
        $content = preg_replace(
            $pattern,
            '<span style="background: #ffcccc; color: red; padding: 2px;">$1</span>',
            $content
        );
    }

    return $content;
}
