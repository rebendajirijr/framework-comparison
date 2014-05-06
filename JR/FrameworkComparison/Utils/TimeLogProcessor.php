<?php

namespace JR\FrameworkComparison\Utils;

use JR\FrameworkComparison\Utils\Helpers;

require_once __DIR__ . '/Helpers.php';


/**
 * Description of TimeLogProcessor
 *
 * @author RebendaJiri
 */
class TimeLogProcessor
{
	/** @var string */
	private $filepath;
	
	public function __construct($filepath)
	{
		$this->filepath = $filepath;
	}
	
	/**
	 * Returns processed time log data in following format:
	 * 
	 * array(
	 *     'logData' => array(
	 *         0 => (
	 *		       'date' => ...,
	 *		       'type' => ...,
	 *		       'time' => ...,
	 *		       'memory' => ...,
	 *         ),
	 *     ),
	 *     'stats' => array(
	 *	       'time_mean' => ...,
	 *         'time_sd' => ...,
	 *         'memory_mean' => ...,
	 *         'memory_sd' => ...,
	 *     ),
	 * );
	 * 
	 * @return array
	 */
	public function getData()
	{
		$logData = $this->readFile($this->filepath);
		
		return array(
			'logData' => $logData,
			'stats' => $this->getStats($logData),
		);
	}
	
	private function getStats(array $logData)
	{
		$stats = array();
		foreach ($logData as $type => $records) {
			$stats[$type] = array(
				'count' => count($records),
				'time_mean' => Helpers::mean(Helpers::getArrayValues($records, function ($record) {
					return $record['time'];
				}), $records),
				'time_median' => Helpers::median(Helpers::getArrayValues($records, function ($record) {
					return $record['time'];
				})),
				'time_sd' => Helpers::standardDeviation(Helpers::getArrayValues($records, function ($record) {
					return $record['time'];
				})),
				'memory_mean' => Helpers::mean(Helpers::getArrayValues($records, function ($record) {
					return $record['memory'];
				}), $records),
				'memory_median' => Helpers::median(Helpers::getArrayValues($records, function ($record) {
					return $record['memory'];
				})),
				'memory_sd' => Helpers::standardDeviation(Helpers::getArrayValues($records, function ($record) {
					return $record['memory'];
				})),
			);
		}
		return $stats;
	}
	
	private function readFile($filepath)
	{
		if (!file_exists($filepath)) {
			throw new \Exception("Timelog file '{$filepath}' not found.");
		}

		if (FALSE === ($file = @fopen($filepath, 'r'))) {
			throw new \Exception("Timelog file cannot be opened.");
		}
		
		$data = array();
		while (FALSE !== ($line = fgetcsv($file))) {
			$type = $line[1];

			$record = array(
				'date' => new \DateTime($line[0]),
				'type' => $type,
				'time' => (float) $line[2],
				'memory' => (float) $line[3],
			);

			$data[$type][] = $record;
		}

		if (FALSE === (@fclose($file))) {
			throw new \Exception("Failed to close timelog file.");
		}
		
		return $data;
	}
}