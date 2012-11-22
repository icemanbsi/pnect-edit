<?php
class WLocationHelper extends USystemWorklet
{
	/**
	 * @return array list of all supported locations (countries, states, cities)
	 */
	public function taskLocations()
	{
		// trying to return cached value
		$cacheKey = 'location';
		if($locations = $this->cacheGet($cacheKey)!==false)
			return $locations;
		
		$countries = array();
		$states = array();
		$cities = array();
		
		// loading all countries
		$countries = $this->loadCountries();
		
		// building states list
		foreach($countries as $code=>$name)
		{
			// loading states for a country
			// and setting cities to "true" for all states
			$st = $this->loadStates($code);
			if($st)
			{
				$states[$code] = $st;
				foreach($states[$code] as $c=>$s)
					$cities[$code.'_'.$c] = true;
			}
			else
				$cities[$code.'_0'] = true;
		}
		
		// building array and saving data into the cache
		$locations = array($countries,$states,$cities);
		$this->cacheSet($cacheKey,$locations);
		
		return $locations;
	}
	
	/**
	 * @param MLocation location model
	 * @return string location as string
	 */
	public function taskLocationAsText($model,$address=false,$zipCode=false,$newLine='<br />')
	{
		$addressPart = '';
		if($address)
			$addressPart.= $address.$newLine;
			
		$cityPart = $model->cityName;
		if($model->state != '0')
			$cityPart.= ', '.$this->state($model->country,$model->state);
		if($zipCode)
			$cityPart.= ' '.$zipCode;
		$cityPart.= $newLine . $this->country($model->country);
		return $addressPart.$cityPart;
	}
	
	/**
	 * @param array location data
	 * @param boolean whether to auto-add new location if it doesn't exist
	 * @return integer location ID
	 */
	public function taskDataToLocation($data,$addMissing=true)
	{
		static $locations = array();
		
		if(!is_array($data))
			return;
		
		$key = serialize($data);
		if(!isset($locations[$key]))		
		{
			if(!$this->loadStates($data['country']))
				$data['state'] = '0';
			$location = MLocation::model()->findByAttributes($data);
			if(!$location && $addMissing)
			{
				$location = new MLocation;
				$location->attributes = $data;
				$location->save();
				
				$cityASCII = $this->cityToASCII($location->city);
				if(!trim($cityASCII))
					$cityASCII = $location->id;
				$location->cityASCII = $cityASCII;
				$location->save();
			}
			$locations[$key] = $location?$location->id:false;
		}
		return $locations[$key];
	}
	
	/**
	 * @param integer location ID
	 * @return array location data
	 */
	public function taskLocationToData($location, $asModel=false)
	{
		static $locations = array();
		
		if(!$location)
			return;
		
		if(!isset($locations[$location.'-'.$asModel]))
		{		
			$model = MLocation::model()->findByPk($location);
			$locations[$location] = $model ? $model : null;
		}
		return $asModel
			? $locations[$location]
			: ($locations[$location] !== null ? $locations[$location]->attributes : array());
	}
	
	/**
	 * @param string country ID
	 * @return string country name
	 */
	public function taskCountry($id)
	{
		$countries = $this->loadCountries();
		return isset($countries[$id])?$countries[$id]['name']:null;
	}
	
	/**
	 * @param string country ID
	 * @param string state ID
	 * @return string state name
	 */
	public function taskState($country,$id)
	{
		$states = $this->loadStates($country);
		return isset($states[$id])?$states[$id]:null;
	}
	
	/**
	 * @param string city name
	 * @return string city name transformed into ASCII - special characters replaced with latin ones
	 */
	public function taskCityToASCII($city)
	{
		return @preg_replace('/[^A-Za-z| ]/','',
			iconv('ASCII','UTF-8',
				iconv('UTF-8','ASCII//TRANSLIT',$city))
		);
	}

	/**
	 * Loads countries list from a file.
	 * @return array countries list
	 */
	public function loadCountries()
	{
		$countriesFile = Yii::getPathOfAlias('application.data.countries') . '.php';
		return include(app()->findLocalizedFile($countriesFile));
	}
	
	/**
	 * Loads states list from a file.
	 * @param string country ID
	 * @return array states list
	 */
	public function loadStates($country)
	{
		$statesFile = Yii::getPathOfAlias('application.data.states.'.$country).'.php';
		if(file_exists($statesFile))
			return include(app()->findLocalizedFile($statesFile));
		else
			return false;
	}
}