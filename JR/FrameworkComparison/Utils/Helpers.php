<?php

namespace JR\FrameworkComparison\Utils;

/**
 * Description of Helpers
 *
 * @author RebendaJiri
 */
class Helpers
{
	public function __construct()
	{
		throw new \RuntimeException('Static class cannot be instanciated.');
	}
	
	/**
	 * Returns new array with values based on given callback.
	 * 
	 * @param array $values
	 * @param callable $callback
	 * @return array
	 */
	public static function getArrayValues(array $values, $callback)
	{
	   $sum = array();
	   foreach ($values as $val) {
		   $sum[] = $callback($val);
	   }
	   return $sum;
   }

	/**
	 * Returns mean of given array values.
	 * 
	 * @param array $values
	 * @return float
	 */
	public static function mean(array $values)
	{
		$sum = array_sum($values);
		$count = count($values);
		return $sum / $count;
	}
	
	/**
	 * Returns median of given array values.
	 * 
	 * @see http://codereview.stackexchange.com/questions/220/calculate-a-median-too-much-code/223#223
	 * @param array $values
	 * @return mixed
	 * @throws \DomainException
	 */
	public static function median(array $values)
	{
		$iCount = count($values);
		if ($iCount == 0) {
		  throw new \DomainException('Median of an empty array is undefined');
		}
		$middle_index = floor($iCount / 2);
		sort($values, SORT_NUMERIC);
		$median = $values[$middle_index];
		if ($iCount % 2 == 0) {
			$median = ($median + $values[$middle_index - 1]) / 2;
		}
		return $median;
	}

	/**
	 * Calculates standard deviation of array values.
	 * 
	 * @see http://cad.cx/blog/2008/06/30/single-pass-standard-deviation-in-php/
	 * @param array $array
	 * @return float
	 */
	public static function standardDeviation($array)
	{
		$n = 0;
		$mean = 0;
		$M2 = 0;
		foreach ($array as $x) {
			$n++;
			$delta = $x - $mean;
			$mean = $mean + $delta/$n;
			$M2 = $M2 + $delta*($x - $mean);
		}
		if ($n <= 1) {
			return 0;
		}
		$variance = $M2 / ($n - 1);
		return sqrt($variance);
	}

	/**
	 * Converts bytes to megabytes.
	 * 
	 * @param int $bytes
	 * @return float
	 */
	public static function toMb($bytes)
	{
		return $bytes / 1024 / 1024;
	}

	/**
	 * Returns non-mantissa rounded representation of given float value.
	 * 
	 * @param float $value
	 * @param int $precision
	 * @return string
	 */
	public static function roundFloat($value, $precision = 5)
	{
	   return rtrim(rtrim(sprintf('%.' . $precision . 'F', round($value, $precision)), '0'), '.');
	}
}