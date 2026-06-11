<?php

use Carbon\Carbon;

/**
Format tanggal dalam bahasa Indonesia.*
@param string $date
@return string*/
function formatDateIndo($date)
{
    Carbon::setLocale('id');
    return Carbon::parse($date)->translatedFormat('d M Y');
}
