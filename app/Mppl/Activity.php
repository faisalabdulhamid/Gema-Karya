<?php
namespace App\Mppl;

class Activity
{
	private $id;
	private $deskripisi;
	private $duration;
    private $est;
    private $lst;
    private $eet;
    private $let;

    private $successors = [];
    private $predecessors = [];

    public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}

	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			$this->$property = $value;
		}

		return $this;
	}

	public function CheckActivity($list, $id, $i)
	{
		for ($j=0; $j < $i; $j++) { 
			if($list[$j]->id == $id)
				return $list[$j];
		}
		return null;
	}

	public function GetIndex($list, $aux, $i)
	{
		for ($j=1; $j < $i; $j++) { 
			if($list[$j]->id == $aux['id'])
				return $j;
		}
		return 0;
	}

	public function SetSuccessors($aux, $activity)
	{

	}
}