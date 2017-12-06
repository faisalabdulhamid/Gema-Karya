<?php

namespace App\Mppl;

use App\Models\Proyek;
use App\Models\ProyekPekerjaan;
use Carbon\Carbon;

class CPM 
{
	protected $proyek_id;
	protected $kegiatan = [];
	protected $proyek;
    protected $nodeDataArray;
    protected $linkDataArray;

    public function __construct($proyek_id)
    {
    	$this->proyek_id = $proyek_id;
    }

    public function getData()
    {
    	$this->proyek = Proyek::find($this->proyek_id);

    	$pekerjaan = ProyekPekerjaan::where('proyek_id', $this->proyek_id)->get();
    	foreach ($pekerjaan as $key => $value) {
    		$nodeDataArray['key'] = $value['id'];
            $nodeDataArray['text'] = $value['initial'];
            $nodeDataArray['length'] = $value['durasi'];

            // $nodeDataArray['earlyStart'][0] = 0;
            // $nodeDataArray['lateFinish'] = 0;
    		
    		$this->nodeDataArray[] = $nodeDataArray;
    	}

        foreach ($pekerjaan as $key => $value) {
            $arr = json_decode($value['pekerjaan_sebelumnya']);
            foreach ($arr as $val) {
                $linkDataArray['from'] = $val;
                $linkDataArray['to'] = $value['id'];

                $this->linkDataArray[] = $linkDataArray;
            }
        }
    }

    public function respon_data()
    {
    	$this->getData();

    	return [
            'nodeDataArray' => $this->nodeDataArray,
            'linkDataArray' => $this->linkDataArray,
        ];
    }
}
