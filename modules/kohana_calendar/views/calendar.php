<?php defined('SYSPATH') OR die('No direct access allowed.');

// Get the day names
$days = Calendar::days(10);

// Previous and next month timestamps
$next = mktime(0, 0, 0, $month + 1, 1, $year);
$prev = mktime(0, 0, 0, $month - 1, 1, $year);

// Import the GET query array locally and remove the day
$qs = $_GET;
unset($qs['day']);

// Previous and next month query URIs
$path_info = Arr::get($_SERVER, 'PATH_INFO');
$prev = '/ajax/calendar/'.date('n', $prev).'/'.date('Y', $prev).'/';
$next = '/ajax/calendar/'.date('n', $next).'/'.date('Y', $next).'/';
?>
			<header id="calendar-top">
				<a href="<?php echo $prev; ?>" class="calendarlink"><img src="/layout/icons/small/arrow_left.png" alt="<" /></a>
				<h3><?php echo strftime('%B', mktime(0, 0, 0, $month, 1, $year)).strftime(' %Y', mktime(0, 0, 0, $month, 1, $year)); ?></h3>
				<a href="<?php echo $next; ?>" class="calendarlink"><img src="/layout/icons/small/arrow_right.png" alt=">" /></a>
			</header>
			<section id="calendar-content">
				<ol id="calendar-static">
					<li></li>
					<li>mån</li>
					<li>tis</li>
					<li>ons</li>
					<li>tor</li>
					<li>fre</li>
					<li>lör</li>
					<li>sön</li>
				</ol>
<?php foreach ($weeks as $week): ?>
				<ol>
<?php if(isset($week[0])): ?>
					<li><?php
			 $monthnr = ((isset($week[0][1]) && ($week[0][1] == 1))) ? $month : $month-1;
			 echo date("W", mktime(0,0,0,$monthnr,$week[0][0],$year)); 			 
			 ?></li>
<?php endif; ?>
<?php foreach ($week as $day):
				list($number, $current, $data) = $day;
				
				$output = NULL;
				$classes = array();
				if (is_array($data))
				{
					$classes = $data['classes'];
					if ( ! empty($data['output']))
					{
						$output = '<li>'.implode('</li><li>', $data['output']).'</li>';
					}
				}
?>
					<li class="<?php echo implode(' ', $classes) ?>" data-value="<?php echo date("Y-m-d", mktime(0, 0, 0, $month, $day[0], $year)); ?>"><?php echo $day[0] ?>
						<ol>
						<?php echo $output ?>
						</ol>
<?php endforeach ?> 
				</ol>
<?php endforeach ?>
