<?php


function make_slug($text): array|string|null
{
    return preg_replace('/\s+/u', '-', trim($text));
}
