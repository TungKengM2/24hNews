<?php

function highlightWords($content, $violations)
{
    if (empty($violations)) {
        return $content;
    }

    foreach ($violations as $violation) {
        $violation = trim($violation);

        $pattern = '/\b('.preg_quote($violation, '/').')\b/i';

        $content = preg_replace(
            $pattern,
            '<span style="background-color: red; color: white; font-weight: bold; padding: 2px;">$1</span>',
            $content
        );
    }
    //    var_dump($content);
    //    exit();

    return $content;
}
