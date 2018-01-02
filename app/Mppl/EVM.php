<?php

namespace App\Mppl;

use App\Models\Proyek;
use App\Models\ProyekPekerjaan;
use Illuminate\Database\Eloquent\Collection;

class EVM 
{
	public $proyek_id;
    public $nodeDataArray = [];
    public $linkDataArray = [];

    public $kegiatan;
    public $proyek;

    public $jalur_kritis = [];

    //Bobot
    public $bobot_perhari_jalur_kritis = [];
    public $bobot_perhari_not_jalur_kritis = [];
    public $bobot_perhari_all = [];
    public $not_jalur_kritis = [];

    public $bobot_per_minggu_with_hari = [];
    public $bobot_per_minggu = [];

    public function __construct($proyek_id)
    {
    	$this->proyek_id = $proyek_id;
        $this->setProyek();
        $this->setKegiatan();
        $this->setNode();
        $this->setLink();

        $this->setJalurKritis();
        $this->setBobotJalurOrNot();
        $this->setBobotPerhari(false);
        $this->bobotPerminggu();


    }

    public function setProyek()
    {
        $this->proyek = Proyek::find($this->proyek_id);
    }

    public function setKegiatan()//Kegiatan & Perhitungan LS
    {
        $kegiatan = ProyekPekerjaan::with(['pendahulu' => function($q){
            $q->select('id', 'initial');
        }, 'penerus' => function($q){
            $q->select('id', 'initial');
        }])->where('proyek_id', $this->proyek_id)->get();

        
        //------------------------------Kegiatan
        $arr = [];
        $this->kegiatan = $kegiatan->transform(function($item, $key)use(&$arr){
            if ($key == 0) {
                $es = 0;
                $lf = $item->durasi;
                $push = [
                    'id'=>$item->id,
                    'es'=>$es,
                    'lf'=>$lf
                ];
                array_push($arr, $push);
            }else{
                $pendahulu = $item['pendahulu'];
                if (count($pendahulu) > 1) { // pendahulu > 1
                    $array_pembanding = collect($pendahulu)->transform(function($val, $key)use($arr){
                        $search = collect($arr)->firstWhere('id', $val['id']);
                        return [
                            'id' => ($search)?$search['id']: null,
                            'es' => ($search)?$search['es']: null,
                            'lf' => ($search)?$search['lf']: null,
                        ];
                    });

                    $nilai_max = $array_pembanding->max('lf');
                    $result_cari = $array_pembanding->firstWhere('lf', $nilai_max);//Cari Nilai lf tertinggi
                    
                    $es = $result_cari['es'];
                    $lf = $result_cari['lf']+$item->durasi;
                    
                    $push = [
                        'id'=> $item->id, 
                        'es'=> $es, 
                        'lf'=> $lf
                    ];
                    array_push($arr, $push);
                }else{
                    $search = collect($arr)->firstWhere('id', $pendahulu[0]['id']);
                    $es = ($search)?$search['lf']: null ;
                    $lf = ($search)?$search['lf']+$item->durasi: null ;
                    $push = [
                        'id'=> $item->id, 
                        'es'=> $es, 
                        'lf'=> $lf
                    ];
                    array_push($arr, $push);
                }
            }

            return [
                "id" => $item->id,
                "initial" => $item->initial,
                "harga" => $item->harga,
                "durasi" => $item->durasi,
                "bobot" => round(($item->harga/$this->proyek->nilai_kontrak ) * 100, 2),
                "nama_pekerjaan" => $item->nama_pekerjaan,
                "pendahulu" => $item->pendahulu->pluck('id'),
                "penerus" => $item->penerus->pluck('id'),
                "es" => isset($es)? $es: null,
                "lf" => isset($lf)?$lf: null,
                // "arr" => isset($arr)?collect($arr)->collapse(): null,
                // "array_pembanding" => isset($array_pembanding)?$array_pembanding: null,
                // "nilai_max" => isset($nilai_max)?$nilai_max: null,
            ];
        });

    }

    public function setJalurKritis()
    {
        //------------------------------Jalur Kritis
        $jalur_kritis = collect([]);
        $kegiatan = collect($this->kegiatan);
        $kegiatan->each(function($item, $key) use(&$jalur_kritis, $kegiatan){
            if ($key == 0) {
                $jalur_kritis->push($item);
            }else{
                $jalur_last = $jalur_kritis->last();
                if ($jalur_last['penerus']->count() == 1) {
                    $jalur_kritis->push($kegiatan->firstWhere('id', $jalur_last['penerus'][0]));
                }elseif($jalur_last['penerus']->count() > 1){
                    //jalur last [3,4]
                    $pembanding = collect($jalur_last['penerus']);
                    $node_penerus = $pembanding->map(function($item, $key) use($kegiatan){
                        return $kegiatan->firstWHere('id', $item);
                    });

                    $max_node = $node_penerus->max('id');
                    $jalur_kritis->push($kegiatan->firstWHere('id', $max_node));
                }
            }
        });

        $this->jalur_kritis = $jalur_kritis;
    }

    public function setBobotJalurOrNot()
    {
        $jalur_kritis = collect($this->jalur_kritis);
        $kegiatan = collect($this->kegiatan);
        $gabungan = collect([]);
        //Bobot Perhari
        $bobot_perhari_jalur_kritis = collect([]);
        $hari_ke = 1;
        $jalur_kritis->each(function($item, $key)use(&$bobot_perhari_jalur_kritis, &$hari_ke, &$gabungan){
            for ($i=0; $i < $item['durasi']; $i++) { 
                $ga = $item['pendahulu']->concat($item['penerus'])->implode('');

                $row['hari_ke'] = $hari_ke;
                $row['id'] = $item['id'];
                $row['bobot'] = round($item['bobot']/$item['durasi'], 4);
                $row['pendahulu'] = $item['pendahulu'];
                $row['penerus'] = $item['penerus'];
                $row['gabungan'] = $ga;
                $bobot_perhari_jalur_kritis->push($row);
                $gabungan->push($row);
                $hari_ke = $hari_ke + 1;
            }
        });
        $this->bobot_perhari_jalur_kritis = $bobot_perhari_jalur_kritis;

        //not jalur
        $not_jalur_kritis = $kegiatan->whereNotIn('id', $jalur_kritis->pluck('id'));
        $bobot_perhari_not_jalur_kritis = collect([]);
        $not_jalur_kritis->each(function($item, $key) use(&$bobot_perhari_not_jalur_kritis, &$gabungan){
            for ($i=0; $i <$item['durasi'] ; $i++) { 
                $ga = $item['pendahulu']->concat($item['penerus'])->implode('');

                $row['id'] = $item['id'];
                $row['bobot'] = round($item['bobot']/$item['durasi'], 4);
                $row['pendahulu'] = $item['pendahulu'];
                $row['penerus'] = $item['penerus'];
                $row['gabungan'] = $ga;
                $bobot_perhari_not_jalur_kritis->push($row);
                $gabungan->push($row);
            }
        });
        $this->bobot_perhari_not_jalur_kritis = $bobot_perhari_not_jalur_kritis;

        // $collection_gabungan =  $gabungan;//->groupby('gabungan')->collapse();
    }

    public function setBobotPerhari($ulang, $bobot_perhari_jalur_kritis = '', $not_jalur_kritis='', $result='')
    {
        if ($ulang) {
            $bobot_perhari_jalur_kritis = $bobot_perhari_jalur_kritis;
            $not_jalur_kritis = $not_jalur_kritis;
            $result = $result;
        }else{
            $bobot_perhari_jalur_kritis = collect($this->bobot_perhari_jalur_kritis);
            $not_jalur_kritis = collect($this->bobot_perhari_not_jalur_kritis);
            $result =  collect($bobot_perhari_jalur_kritis);  //penggabunganabungan
        }
        
        $bobot_perhari_jalur_kritis->each(function($item, $key) use(&$not_jalur_kritis, &$result){
            //jalur[gabungan] == not_jalur[gabungan ]
            $dumm_not_jalur = $not_jalur_kritis->firstWHere('gabungan', $item['gabungan']);

            $when_true = ($item['gabungan'] === $dumm_not_jalur['gabungan']);
            $push = [
                'hari_ke' => $item['hari_ke'],
                'id' => $dumm_not_jalur['id'],
                'bobot' => $dumm_not_jalur['bobot'],
                'pendahulu' => $dumm_not_jalur['pendahulu'],
                'penerus' => $dumm_not_jalur['penerus'],
                'gabungan' => $dumm_not_jalur['gabungan'],
            ];

            $result->when($when_true, function($collection)use($push, &$not_jalur_kritis){
                $not_jalur_kritis->splice(0,1);  //Membuang node pertama di not_jalur_kritis

                return $collection->push($push);
            });
        });

        if ($not_jalur_kritis->isNotEmpty()) {
            $this->setBobotPerhari(true, $bobot_perhari_jalur_kritis, $not_jalur_kritis, $result);
            $this->not_jalur_kritis = $not_jalur_kritis;
        }else{
            $this->not_jalur_kritis = $not_jalur_kritis;
            $this->bobot_perhari_all = $result;
        }
    }


    public function bobotPerminggu()
    {
        $groupby = $this->bobot_perhari_all->groupby('hari_ke');
        $chuck = $groupby->map(function($item, $key){
            if (collect($item)->count() === 1) {
                $collapse = $item->collapse();
                return [
                    'hari_ke' => $collapse['hari_ke'],
                    'id' => $collapse['id'],
                    'bobot' => $collapse['bobot'],
                ];
            }else{
                $node = collect($item);
                $bobot = $node->reduce(function ($carry, $item) {
                    return $carry + $item['bobot'];
                });
                $res = $node->first();
                return [
                    'hari_ke' => $res['hari_ke'],
                    'id' => $res['id'],
                    'bobot' => $bobot,
                ];

            }
        });
        $this->bobot_per_minggu_with_hari = $bobot_per_minggu = $chuck->chunk(6);

        $this->bobot_per_minggu = $bobot_per_minggu->map(function($item, $key){
            $node = collect($item);
            $bobot = $node->reduce(function ($carry, $item) {
                return $carry + $item['bobot'];
            });
            return [
                'minggu_ke' => $key+1,
                'bobot' => $bobot,
                'kontak' => $this->proyek->nilai_kontrak,//round(($this->proyek->nilai_kontrak * $bobot)),
                'budget' => round($this->proyek->nilai_kontrak * ($bobot/100))//round(($this->proyek->nilai_kontrak * $bobot)),
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
                $data['durasi'] = $kegiatan['durasi'];
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

    public function result_evm()
    {
        return $this->bobot_per_minggu;
    }
}
