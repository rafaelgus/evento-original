<?php

function array_beautifier($array)
{
    if (!is_array($array)) {
        return null;
    }
    $output = '';
    if (!empty($array)) {
        $output .= '<dl class="dl-horizontal" style="margin-left:15px;">';
        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $output .= array_beautifier($value);
            } else {
                $output .= '<dt style="text-align:left;">' . $key . '</dt><dd> ' . (!empty($value) ? $value : '&nbsp;') . '</dd>';
            }
        }
        $output .= '</dl>';
    }

    return $output;
}
