<?php

use JR\FrameworkComparison\Utils\Helpers,
	JR\FrameworkComparison\Utils\TimeLogProcessor;

require __DIR__ . '/JR/FrameworkComparison/Utils/Helpers.php';
require __DIR__ . '/JR/FrameworkComparison/Utils/TimeLogProcessor.php';

/**
 * Returns new array with values based on given callback.
 * 
 * @param array $values
 * @param callable $callback
 * @return array
 */
function getArrayValues(array $values, $callback) {
	return Helpers::getArrayValues($values, $callback);
}

/**
 * Returns mean of given array values.
 * 
 * @param array $values
 * @return float
 */
function mean(array $values) {
	return Helpers::mean($values);
}

/**
 * Calculates standard deviation of array values.
 * 
 * @see http://cad.cx/blog/2008/06/30/single-pass-standard-deviation-in-php/
 * @param array $array
 * @return float
 */
function standardDeviation($array) {
	return Helpers::standardDeviation($array);
}

/**
 * Converts bytes to megabytes.
 * 
 * @param int $bytes
 * @return float
 */
function toMb($bytes) {
	return Helpers::toMb($bytes);
}

/**
 * Returns non-mantissa rounded representation of given float value.
 * 
 * @param float $value
 * @param int $precision
 * @return string
 */
function roundFloat($value, $precision = 5) {
	return Helpers::roundFloat($value, $precision);
}

$inputFiles = array(
	'1' => array(
		'name' => 'overall performance',
		'filepath' => __DIR__ . '/JR/FrameworkComparison/_results/timelog.csv',
	),
	'2' => array(
		'name' => 'overall performance with OPcache',
		'filepath' => __DIR__ . '/JR/FrameworkComparison/_results/opcache/timelog.csv',
	),
	'3' => array(
		'name' => 'db performance',
		'filepath' => __DIR__ . '/JR/FrameworkComparison/_results/db/timelog.csv',
	),
	'4' => array(
		'name' => 'db performance with OPcache',
		'filepath' => __DIR__ . '/JR/FrameworkComparison/_results/db/opcache/timelog.csv',
	),
);

$filepath = __DIR__ . '/JR/FrameworkComparison/_results/timelog.csv';
if (isset($_GET['input-file'])) {
	if (array_key_exists($_GET['input-file'], $inputFiles)) {
		$filepath = $inputFiles[$_GET['input-file']]['filepath'];
	}
}

$timeLogProcessor = new TimeLogProcessor($filepath);
$data = $timeLogProcessor->getData();

$logData = $data['logData'];
$stats = $data['stats'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Framework comparison results</title>
		<style>
			table{border-collapse:collapse;border:1px solid #000000;}
			td{padding:2px 6px;}
			thead{font-weight:bold;}
			tfoot td{border:1px solid #000000;}
		</style>
	</head>
	<body>
		<p><a href="/">Back to root</a></p>
		<hr>
		<form id="input-file-form" method="GET" action="results.php">
			<label for="input-file">Input file:</label>
			<select id="input-file" name="input-file" onchange="document.getElementById('input-file-form').submit();">
				<?php foreach ($inputFiles as $key => $inputFile): ?>
				<option value="<?php echo $key; ?>" <?php echo isset($_GET['input-file']) && $_GET['input-file'] == $key ? 'selected="selected"' : NULL; ?>><?php echo $inputFile['name']; ?></option>
				<?php endforeach; ?>
			</select>
			<noscript><input type="submit" value="Load"></noscript>
		</form>
		<hr>
		<h1>Overall stats</h1>
		<table>
			<thead>
				<tr>
					<td>Measured parameter</td>
					<?php foreach ($stats as $type => $typeStats): ?>
					<td><a href="#type-<?php echo $type; ?>"><?php echo $type; ?></td>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Count</td>
					<?php foreach ($stats as $type => $typeStats): ?>
					<td><?php echo $typeStats['count']; ?></td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Total time mean</td>
					<?php foreach ($stats as $type => $typeStats): ?>
					<td><?php echo round($typeStats['time_mean'] * 1000, 5); ?></td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Total time median</td>
					<?php foreach ($stats as $type => $typeStats): ?>
					<td><?php echo round($typeStats['time_median'] * 1000, 5); ?></td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Total time standard deviation</td>
					<?php foreach ($stats as $type => $typeStats): ?>
					<td><?php echo round($typeStats['time_sd'] * 1000, 5); ?></td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Memory peak usage mean</td>
					<?php foreach ($stats as $type => $typeStats): ?>
					<td><?php echo roundFloat(toMb($typeStats['memory_mean']), 5); ?></td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Memory peak usage median</td>
					<?php foreach ($stats as $type => $typeStats): ?>
					<td><?php echo roundFloat(toMb($typeStats['memory_median']), 5); ?></td>
					<?php endforeach; ?>
				</tr>
				<tr>
					<td>Memory peak usage standard deviation</td>
					<?php foreach ($stats as $type => $typeStats): ?>
					<td><?php echo roundFloat(toMb($typeStats['memory_sd']), 5); ?></td>
					<?php endforeach; ?>
				</tr>
			</tbody>
		</table>
		<hr>
		<h2>Results</h2>
		<?php foreach ($logData as $type => $records): ?>
		<h3 id="type-<?php echo $type; ?>"><?php echo $type; ?></h3>
		<table>
			<thead>
				<tr>
					<td>#</td>
					<td>Datetime</td>
					<td>Total time (ms)</td>
					<td>Memory peak usage (MB)</td>
				</tr>
			</thead>
			<tbody>
				<?php $i = 0; ?>
				<?php foreach ($records as $record): ?>
				<tr>
					<td><?php echo ++$i; ?>.</td>
					<td><?php echo $record['date']->format('Y-m-d H:i:s'); ?></td>
					<td><?php echo round($record['time'] * 1000, 5); ?></td>
					<td><?php echo roundFloat(toMb($record['memory']), 5); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">Mean</td>
					<td><?php echo round($stats[$type]['time_mean'] * 1000, 5); ?></td>
					<td><?php echo roundFloat(toMb($stats[$type]['memory_mean']), 5); ?></td>
				</tr>
				<tr>
					<td colspan="2">Median</td>
					<td><?php echo round($stats[$type]['time_median'] * 1000, 5); ?></td>
					<td><?php echo roundFloat(toMb($stats[$type]['memory_median']), 5); ?></td>
				</tr>
				<tr>
					<td colspan="2">Standard deviation</td>
					<td><?php echo round($stats[$type]['time_sd'] * 1000, 5); ?></td>
					<td><?php echo roundFloat(toMb($stats[$type]['memory_sd']), 5); ?></td>
				</tr>
			</tfoot>
		</table>
		<?php endforeach; ?>
	</body>
</html>