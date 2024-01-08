<?php

    function dateFormatDisplay($date)
    {
        if(!$date){ return ''; }

        return date(trans('date.format'),strtotime($date));
    }

    function timeElapsedString($datetime, $full = false) 
    {
	    $now = new \DateTime;
	    $ago = new \DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

	function getBudgetYear($date = null)
	{
		$today = $date ? Carbon\Carbon::parse($date) : Carbon\Carbon::today();
		$period = App\Models\IE\GLPeriodV::select('period_year')
							->whereDate('start_date', '<=', $today)
							->whereDate('end_date', '>=', $today)
							->first();
		
		$currentYear = $date ? date('Y', strtotime($date)) : date('Y');
	    $cycle = date('Y-m-d', strtotime($currentYear.'-9-30'));
        $now = $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');
		$offset = $now > $cycle ? 44 : 43;
        $year = substr( $period ? (int)$period->period_year + 43 : ( $date ? (int)date('y', strtotime($date)) : (int)date('y')) + $offset , -2);

		return $year;
	}
