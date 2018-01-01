<?php

namespace App\Mppl;

use App\Models\Proyek;
use App\Models\ProyekPekerjaan;
use Carbon\Carbon;

class CPM 
{
    protected $proyek_id;
    protected $node = [];

    public function __construct($proyek_id)
    {
    	$this->proyek_id = $proyek_id;
    }

    public function filter_data()
    {
        $pekerjaan = ProyekPekerjaan::where('proyek_id', $this->proyek_id)->get();
        $pekerjaan_fiter = $pekerjaan->map(function($item, $key){
            return [
                'key' => $item->id,
                'id' => $item->id,
                'kode' => $item->initial,
                'durasi' => $item->durasi,
                'pendahulu' => $item->pendahulu->map(function($val, $i){
                    return $val->id;
                })->toArray(),
                'penerus' => $item->penerus->map(function($val, $i){
                    return $val->id;
                }),
            ];
        });

        return $pekerjaan_fiter;
    }

    public function set_node()
    {
        $data = [];
        $filter_data = $this->filter_data();
        foreach ($filter_data as $i => $value) {
            $row = [];
            if ($i == 0) {
                //Initial
                $_row = [];
                $_row[] = $value['kode'];
                $_row[] = $value['durasi'];
                $_row[] = 0;
                $_row[] = 1;
                $row[] = $_row;
            }else{

                foreach ($value['pendahulu'] as $j => $pendahulu) {
                    $_row = [];
                    $_row[] = $value['kode'];
                    $_row[] = $value['durasi'];

                    $_row[] = $filter_data->firstWhere('id', $pendahulu)['key'];
                    $_row[] = $value['key'];
                    $row[] = $_row;
                }   
            }
            $data[] = $row;
        }

        // $this->node = $data;
        return collect($data)->collapse();
    }

    public function result()
    {
        // $this->set_node();
    	$data = $this->set_node();

        $data = $data->transform(function($val, $key)use($data){
            return [
                'kode' => $val[0],
                'durasi' => $val[1],
                'i' => $val[2],
                'j' => $val[3],
                'es' => 0,
                'ls' => 0,
            ];
        });
        $data = $data->map(function ($item, $key) {
            $item['durasi'];
            return $key;
        });
        // $group = $data->groupBy(function($item, $key){
        //     return $item['kode'];
        // });
        // return $data->pluck('durasi')->pipe(function($col){
        //     return $col;
        // });
        return $data->splice(0, 2);
    }
}
