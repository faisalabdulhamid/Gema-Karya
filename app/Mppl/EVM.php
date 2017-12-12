<?php

namespace App\Mppl;

use App\Models\Proyek;
use App\Models\ProyekPekerjaan;

class EVM 
{
	protected $proyek_id;
    protected $nodeDataArray = [];
    protected $linkDataArray = [];

    protected $kegiatan;
    protected $proyek;

    protected $jalur_kritis = [];//Sesuai ID
    protected $bobot_perhari = [];

    public function __construct($proyek_id)
    {
    	$this->proyek_id = $proyek_id;
        $this->setProyek();
        $this->setKegiatan();
        $this->setNode();
        $this->setLink();
        $this->setBobotPerhari();
    }

    public function setProyek()
    {
        $this->proyek = Proyek::find($this->proyek_id);
    }

    public function setKegiatan()
    {
        $kegiatan = ProyekPekerjaan::with(['pendahulu' => function($q){
            $q->select('id', 'initial');
        }, 'penerus' => function($q){
            $q->select('id', 'initial');
        }])->where('proyek_id', $this->proyek_id)->get();

        $this->kegiatan = $kegiatan->map(function($item, $key){
           return [
            "id" => $item->id,
            "initial" => $item->initial,
            "harga" => $item->harga,
            "durasi" => $item->durasi,
            "bobot" => round(($item->harga/$this->proyek->nilai_kontrak ) * 100, 2) ,
            "nama_pekerjaan" => $item->nama_pekerjaan,
            "pendahulu" => $item->pendahulu->pluck('id'),
            "penerus" => $item->penerus->pluck('id'),
           ];
        });
    }

    /*-------------------------------------------------------------------------*/

    public function setNode()
    {
        $data = [];
        foreach ($this->kegiatan as $key => $kegiatan) {
            $earlyStart = 0;
            $lateFinish = 0;
            $critical = false;

            if (count($kegiatan['pendahulu']) == 1) {
                $earlyStart = $this->nodeDataArray[$kegiatan['pendahulu'][0]]['lateFinish'];
                $lateFinish = $earlyStart;
            }elseif (count($kegiatan['pendahulu']) > 1) {
                $early = [];
                foreach ($kegiatan['pendahulu'] as $key => $pendahulu) { //array id
                    $pend = [];
                    $pend['id'] = $pendahulu;
                    $pend['earlyStart'] = $this->nodeDataArray[$pendahulu]['lateFinish'];
                    $early[] = $pend;
                }

                foreach ($early as $key_1 => $val_1) {
                    foreach ($early as $key_2 => $val_2) {
                        if ($val_1['earlyStart'] > $val_2['earlyStart']) {
                            $earlyStart = $val_1['earlyStart'];
                            $lateFinish = $val_1['earlyStart'];

                        }else{
                            $earlyStart = $val_2['earlyStart'];
                            $lateFinish = $val_2['earlyStart'];
                        }
                    }
                }

            }

            if (count($kegiatan['penerus']) > 1 && count($kegiatan['pendahulu']) > 1) {
                $critical = false;
            }
            
            $row = [];
            $row['key'] = $kegiatan['id'];
            $row['text'] = $kegiatan['initial'];
            $row['length'] = $kegiatan['durasi'];
            $row['earlyStart'] = $earlyStart;
            $row['lateFinish'] = $lateFinish + $kegiatan['durasi'];
            $row['critical'] = $critical;

            $this->nodeDataArray[$kegiatan['id']] = $row;
        }
    }

    public function setLink()
    {   
        $data = [];
        foreach ($this->kegiatan as $kegiatan) {
            foreach ($kegiatan['penerus'] as $penerus) {
                $data['from'] = $kegiatan['id'];
                $data['to'] = $penerus;
                $this->linkDataArray[] = $data;
            }
        }
    }

    public function result_cpm()
    {	
    	return [
            'nodeDataArray' => array_values($this->nodeDataArray),
            'linkDataArray' => $this->linkDataArray,
        ];
    }
    /*-------------------------------------------------------------------------*/
    public function setJalurKritis()
    {
        
    }

    public function setBobotPerhari()
    {
        foreach ($this->kegiatan as $key => $kegiatan) {
            
            for ($i=0; $i < $kegiatan['durasi']; $i++) { 
                $row= [];
                $row['bobot'] = round($kegiatan['bobot']/$kegiatan['durasi'], 4);
                $row['id'] = $key;
                $this->bobot_perhari[$kegiatan['id']][$key][] = $row;
            }
        }
    }

    public function result_evm()
    {
        return [
            'kegiatan' => $this->kegiatan,
            'bobot_perhari' => $this->bobot_perhari
        ];
    }
}
