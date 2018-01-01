<?php

namespace App\Mppl;

use App\Models\Proyek;
use App\Models\ProyekPekerjaan;
use Carbon\Carbon;

class EVMBelum 
{
    protected $proyek_id;
    protected $kegiatan = [];
    protected $nodeDataArray = [];
    protected $jalur_kritis_arr = [];
    protected $jalur_kritis = [];

    // protected $jumlah_hari;
    // protected $jumlah_minggu;
    protected $proyek;

    protected $bobot_kegiatan;
    protected $bobot_perminggu;
    protected $bobot_hari;

    protected $bbn;


    public function __construct($proyek_id)
    {
        $this->proyek_id = $proyek_id;
    }

    public function getActivity()
    {
        $this->proyek = Proyek::find($this->proyek_id);

        $pekerjaan = ProyekPekerjaan::where('proyek_id', $this->proyek_id)->get();
        $i=0; $j=1;
        foreach ($pekerjaan as $key => $value) {
            $kegiatan = [];
            $kegiatan['kode'] = $value['initial'];
            $kegiatan['kegiatan'] = $value['pekerjaan']->pekerjaan;
            $kegiatan['harga'] = $value['harga'];
            $kegiatan['bobot'] = round(($value->harga/Proyek::find($this->proyek_id)->nilai_kontrak ) * 100, 2);

            $kegiatan['id'] = $value['id'];
            $kegiatan['durasi'] = $value['durasi'];
            $pendahulu = $value->pendahulu->pluck('id');
            $kegiatan['pendahulu'] = (count($pendahulu) > 0)? $pendahulu : null;

            $penerus = $value->penerus->pluck('id');
            $kegiatan['penerus'] = (count($penerus) > 0)? $penerus : null;

            $this->kegiatan[$value['id']] = $kegiatan;

            $this->setEs($key, $value['id'], $value['durasi']);
        }

        $this->setJalurKritis();
    }

    /*-------------------------------------------------------------------------*/

    public function setES($key, $id, $durasi)
    {
        if($key == 0)       {
            $this->kegiatan[$id]['es']= 0;
            $this->kegiatan[$id]['lf']= $durasi;
        }else{
            if(count($this->kegiatan[$id]['pendahulu']) > 1){
                $pendahulu = $this->kegiatan[$id]['pendahulu'];
                
                $lf = [];
                foreach ($pendahulu as $p) {
                    $r['id'] = $this->kegiatan[$p]['id'];
                    $r['lf'] = $this->kegiatan[$p]['lf'];
                    $lf[] = $r;
                }
                
                $rank_lf = 0;

                foreach ($lf as $key_1 => $l_1) {
                    foreach ($lf as $key_2 => $l_2) {
                        if($key_1 == $key_2)
                            continue;

                        if($l_1['lf'] > $l_2['lf']){
                            $rank_lf = $l_1['lf'];
                        }
                        else{
                            $rank_lf = $l_2['lf'];
                        }
                    }
                }

                // $this->kegiatan[$id]['lf_array']= $lf;
                $this->kegiatan[$id]['es']= $rank_lf;
                $this->kegiatan[$id]['lf']= $rank_lf + $durasi; 
            }else{
                $this->kegiatan[$id]['es']= $this->kegiatan[$this->kegiatan[$id]['pendahulu'][0]]['lf'];
                $this->kegiatan[$id]['lf']= $this->kegiatan[$this->kegiatan[$id]['pendahulu'][0]]['lf'] + $durasi;
                
            }
            
            
        }
    }

    public function setJalurKritis()
    {
        foreach ($this->kegiatan as $key => $value) {
            if(is_null($this->kegiatan[$key]["pendahulu"])){
                $this->jalur_kritis_arr[$key] = $this->kegiatan[$key]["id"];
            }else{
                if(isset($this->kegiatan[$key]["penerus"])){
                    //penerus > 1
                    if (count( $this->kegiatan[$key]["penerus"]) > 1) {
                        $this->jalur_kritis_arr[$key] = $this->kegiatan[$key]["id"];//$this->kegiatan[$key]["penerus"];
                        // $this->jalur_kritis_arr[$key]["penerus"] = $this->kegiatan[$key]["penerus"];
                        $lf_penerus = [];
                        foreach ($this->kegiatan[$key]["penerus"] as $id_penerus) {
                            $row = [];
                            $row['lf'] = $this->kegiatan[$id_penerus]["lf"];
                            $row['id'] = $this->kegiatan[$id_penerus]["id"];
                            $lf_penerus[] = $row;
                        }
                        // $this->jalur_kritis_arr[$key]["lf_____"] = $lf_penerus;

                        $rank_lf = [];
                        foreach ($lf_penerus as $key_1 => $value_1) {
                            foreach ($lf_penerus as $key_2 => $value_2) {
                                if($key_1 == $key_2)
                                    continue;

                                if($value_1['lf'] > $value_2['lf']){
                                    $rank_lf = $value_1;
                                }else{
                                    $rank_lf = $value_2;
                                }
                            }
                        }
                        // $this->jalur_kritis_arr[$key]["lf_mmmmm"] = $rank_lf['id'];
                        $this->jalur_kritis_arr[$rank_lf['id']] = $rank_lf['id'];
                        
                    }elseif(count($this->kegiatan[$key]["pendahulu"]) > 1){
                        $this->jalur_kritis_arr[$key] = $this->kegiatan[$key]["id"];
                        
                    }else{

                        if(
                            count($this->kegiatan[ $this->kegiatan[$key]["pendahulu"][0]]["penerus"]) == 1 &&
                            count($this->kegiatan[ $this->kegiatan[$key]["penerus"][0]]["pendahulu"]) == 1
                        ){
                            $this->jalur_kritis_arr[$key] = $this->kegiatan[$key]["id"];
                        }
                        // $this->jalur_kritis_arr[$key]["pendahulu"] = $this->kegiatan[$key]["pendahulu"];
                        // $this->jalur_kritis_arr[$key]["penerus"] = $this->kegiatan[$key]["penerus"];

                        // $this->jalur_kritis_arr[$key]["pendahulu_______"] = $this->kegiatan[ $this->kegiatan[$key]["pendahulu"][0]]["penerus"];
                        // $this->jalur_kritis_arr[$key]["penerus_______"] = $this->kegiatan[ $this->kegiatan[$key]["penerus"][0]]["pendahulu"];
                    }
                    
                }else{//Last 
                    $this->jalur_kritis_arr[$key] = $this->kegiatan[$key]["id"];
                }
                
            }
        }

        $this->jalur_kritis = array_values($this->jalur_kritis_arr);
    }

    // public function cpm()
    // {
    //     $this->getActivity();

    //     $pekerjaan = $this->kegiatan;
    //     foreach ($pekerjaan as $key => $value) {
    //         $nodeDataArray['key'] = $value['id'];
    //         $nodeDataArray['text'] = $value['kode'];
    //         $nodeDataArray['length'] = $value['durasi'];

    //         $nodeDataArray['earlyStart'] = $value['es'];
    //         $nodeDataArray['lateFinish'] = $value['lf'];
            
    //         $this->nodeDataArray[] = $nodeDataArray;
    //     }

    //     foreach ($pekerjaan as $key => $value) {
    //         $arr = $this->kegiatan[$key]['pendahulu'];
            
    //         if(!is_null($arr)){
    //             foreach ($arr as $val) {
    //                 $linkDataArray['from'] = $val;
    //                 $linkDataArray['to'] = $value['id'];

    //                 $this->linkDataArray[] = $linkDataArray;
    //             }   
    //         }
    //     }
    // }

    // public function respon_cpm()
    // {
    //     $this->cpm();

    //     return [
    //         'nodeDataArray' => $this->nodeDataArray,
    //         'linkDataArray' => $this->linkDataArray,
    //     ];
    // }

    /*-------------------------------------------------------------------------*/


    /*-------------------------------------------------------------------------*/
    public function jumlah_hari()
    {
        end($this->kegiatan);
        $last = $this->kegiatan[key($this->kegiatan)];

        return $last['lf'];
    }

    public function jumlah_minggu()
    {
        return ceil($this->jumlah_hari()/6);
    }

    public function evm()
    {
        $this->getActivity();

        $bobot_perhari = [];

        $j = 1;
        foreach ($this->kegiatan as $key => $value) {
            $row = [];
            $row['kode'] = $value['kode'];
            $row['kegiatan'] = $value['kegiatan'];
            $row['harga'] = $value['harga'];
            $row['bobot'] = $value['bobot'];
            $this->bobot_kegiatan[] = $row;

            for ($i=0; $i< $value['durasi']; $i++) {
                

                if (in_array($value['id'], $this->jalur_kritis)) {
                    $_row = [];
                    $_row['id'] = $value['id'];
                    $_row['hari_ke'] = $j;
                    $_row['bobot'] = $value['bobot']/$value['durasi'];

                    
                    $bobot_perhari[$j][] = $_row;

                    if (isset($value['penerus'])) {
                        if (count($value['penerus']) > 1) {
                            // $bobot_perhari[$j][]["as"] = "Hell";
                            foreach ($value['penerus'] as $key_penerus => $value_penerus) {
                                $bobot_perhari[$j ][] = $this->kegiatan[$value_penerus]['id'];
                            }
                        }
                    }

                    
                    
                    $j++;
                }
            }
        }

        $this->bobot_hari = $bobot_perhari;


        // $jumlah_minggu = $this->jumlah_minggu();
        // for ($i=0; $i < $jumlah_minggu; $i++) { 
        //  $row = [];
            
        //  $row['bobot'] = 1;
        //  $row['budget'] = $this->proyek['nilai_kontrak'] * ($row['bobot']/100);

        //  $this->bobot_perminggu[$i] = $row;
        // }

        // $this->bobot_hari = $bobot_perhari;
        // $bobot_ = 0;
        // $i= 1;
        // //Jalur Kritis Add Data
        // foreach ($bobot_perhari as $key => $value) {
        //  if (in_array($value['id'], $this->jalur_kritis)) {
        //      $this->bobot_hari[$i][$value['id']] = $value;
        //      $i++;
        //  }
        // }

        // //Not Jalur Kritis
        // $i=1;
        // foreach ($this->bobot_hari as $key => $value) {
        //  // if (!in_array($value['id'], $this->jalur_kritis)) {
        //  //  $this->bobot_hari[$i][$value['id']] = $value;
        //  // }
        //  $i++;
        // }

        // $jumlah_minggu = $this->jumlah_minggu();
        // $hari_2 = 1;
        // for ($minggu=1; $minggu <= $jumlah_minggu; $minggu++) { 
        //  $row = [];

        //  for ($hari=$hari_2; $hari <= ($minggu*6); $hari++) {

        //      $row['minggu'] = $minggu;

        //      $row['bobot'][] = $this->bobot_hari[$hari];
        //      $row['hari'][] = $hari;
        //      $hari_2++;
        //  }
        //  $this->bobot_perminggu[$minggu] = $row;
        // }
        // $this->bobot_perminggu = $jumlah_minggu;

        // for ($i=0; $i < count($this->jalur_kritis); $i++) {
        //  $bobot_m = 0;
        //  for ($k=$j; $k < 6; $k++) { 
        //      $bobot_m = $bobot_m + $this->bobot_hari[$i]['bobot'];
        //  }
        //  $row = [];
        //  $row['i'] = $i;
        //  $row['j'] = $j;
        //  $row['idx'] = $idx;
        //  $row['bobot'] = $bobot_m;

            
        //  $j = $j + 6;
        //  $idx++;
        // }

    }



    public function respon_data()
    {
        $this->evm();
        
        return [
            // 'kegiatan' => $this->kegiatan,
            // 'jalur' => $this->jalur_kritis,
            // 'bobot_kegiatan' => $this->bobot_kegiatan,
            'hari' => $this->bobot_hari,
            // 'bcws_idx' => array_keys($this->bobot_hari),
            // 'bobot_hari' => $this->jalur_kritis_arr,
            
            // 'kegiatan_sebelumnya' => count($this->kegiatan[4]['kegiatan_sebelumnya'])
        ];
    }
    /*-------------------------------------------------------------------------*/
    


    public function setJalurKritis()
    {
        $kegiatan = collect($this->kegiatan);
        $jalur_kritis = [];
        $this->jalur_kritis = $kegiatan->map(function($item, $key)use(&$jalur_kritis, $kegiatan){
            if ($item['pendahulu']->isEmpty()) {
                array_push($jalur_kritis, $item['initial']);
            }else{
                if (isset($item['penerus'])) {
                    if ($item['penerus']->count() > 1) { //Penerus > 1
                        array_push($jalur_kritis, $item['initial']);

                        $penerus = $item['penerus']->map(function($val, $key)use($kegiatan){//val cuma id penerus
                            return $kegiatan->firstWhere('id', $val);
                        });
                        $max_penerus = $penerus->max('lf');
                        $result_cari = $penerus->firstWhere('lf', $max_penerus);

                        array_push($jalur_kritis, $result_cari['initial']);
                    }elseif ($item['pendahulu']->count() > 1) {
                        array_push($jalur_kritis, $item['initial']);
                        
                    }else{
                        // array_push($jalur_kritis, $key);
                        if (
                            $kegiatan[$kegiatan[$key]['pendahulu'][0]]['penerus']->count() == 1 &&
                            $kegiatan[$kegiatan[$key]['penerus'][0]]['pendahulu']->count() == 1 
                        ) {
                            array_push($jalur_kritis, $kegiatan[$key]['id']);
                        }
                        
                    }
                }elseif($item['penerus']->isEmpty()){
                    array_push($jalur_kritis, $item['initial']);
                }
            }
        });
        $this->jalur_kritis = $jalur_kritis;
    }
}
