<?php

use Illuminate\Database\Seeder;

class PeoyekJalan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		$pek = [ 
			['kegiatan' => 'Survey Lokasi', 'durasi' => 2],
			['kegiatan' => 'Persiapan Pekerjaan', 'durasi' => 1],
			['kegiatan' => 'Sosialisasi Masyarakat', 'durasi' => 1],
			['kegiatan' => 'Koordinasi Pengaturan Lalu lintas', 'durasi' => 1],
			['kegiatan' => 'Penandaan Jalan Rusak', 'durasi' => 2],
			['kegiatan' => 'Galian Perkerasan Berbutir', 'durasi' => 4],
			['kegiatan' => 'Mobilisasi Bahan', 'durasi' => 7],
			['kegiatan' => 'Pelapisan Pondasi Bawah Tellford', 'durasi' => 10],
			['kegiatan' => 'Lapis Pondasi Agregat kelas A', 'durasi' => 10],
			['kegiatan' => 'Campuran Aspal Panas', 'durasi' => 10],
			['kegiatan' => 'Lapis Perekat Aspal Cair', 'durasi' => 10],
			['kegiatan' => 'Laporan Akhir', 'durasi' => 2],
		];
		$res = [
			['resiko' => 'Alat yang di pakai Rusak'],
			['resiko' => 'Alat yang di pakai dicuri'],
			['resiko' => 'Kondisi Alam Tidak Mendukung'],
			['resiko' => 'Terjadi Bencana Alam'],
			['resiko' => 'Tenaga Kerja Sakit'],
		];
		$bahan = [
			['bahan'=> 'Koral', 'satuan'=> 'M3', 'harga'=> '1000000'],
			['bahan'=> 'Pasir', 'satuan'=> 'M3', 'harga'=> '750000'],
			['bahan'=> 'Aspal', 'satuan'=> 'Drum', 'harga'=> '500000'],
		];
		$pegawai = [
			'Najmi', 'Acil', 'Samin', 'Araf', 'Ihem'
		];

		foreach ($pek as $key => $value) {
			$p = new App\Models\Pekerjaan();
			$p->pekerjaan = $value['kegiatan'];
			$p->save();
		}

		foreach ($res as $key => $value) {
			$r = new App\Models\Resiko();
			$r->resiko = $value['resiko'];
			$r->save();
		}

		foreach ($bahan as $key => $value) {
			$b = new App\Models\BahanBaku();
			$b->bahan_baku = $value['bahan'];
			$b->satuan = $value['satuan'];
			$b->harga = $value['harga'];
			$b->save();
		}

		foreach ($pegawai as $key => $value) {
			$p = new App\Models\Pegawai();
			$p->nama = $value;
			$p->status = 'pegawai';
			$p->save();
		}
		

		$proy = new App\Models\Proyek();
    	$proy->nama = 'Proyek Pemeliharaan Jalan Wilayah Pameungpek';
    	$proy->nilai_kontrak = '75505000';
    	$proy->tanggal_kontrak = '2016-04-1';
    	$proy->tanggal_mulai = '2016-04-7';
    	$proy->tanggal_selesai = '2016-06-7';
    	$proy->deskripsi = 'Jalan Wilayah Pameungpek';
    	$proy->save();
    }
}
