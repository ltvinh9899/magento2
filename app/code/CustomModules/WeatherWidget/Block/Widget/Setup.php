<?php

namespace CustomModules\WeatherWidget\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Setup extends Template implements BlockInterface
{
    protected $_template = "widget/index.phtml";

    function getCurrentData($region, $coutry_name, $access_key) {
		$location = $region . "," . $coutry_name . "&units=metric";
		$array_json = "http://api.openweathermap.org/data/2.5/weather?q=" . $location . $access_key;
		$json = file_get_contents($array_json);
		$obj = json_decode($json);
		return $obj;
	}
	
	function getForecastData($city_id, $access_key) {
		$array_json = "http://api.openweathermap.org/data/2.5/forecast?id=" . $city_id . "&units=metric" . $access_key;
		$json = file_get_contents($array_json);
		$obj = json_decode($json);
		return $obj;
	}
}
