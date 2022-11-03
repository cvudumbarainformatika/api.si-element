<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        AppSetting::create([
            'nama' => 'Si-Element',
            'infos' => [
                'nama' => 'Sistem Informasi Lipa Mitra Nusa',
                'alamat' => 'alamat belum di isi',
                'tlp' => 'nomor telepon belum ada'
            ],
            'themes' => [
                [
                    "name" => "primary",
                    "value" => "#1976d2"
                ],
                [
                    "name" => "secondary",
                    "value" => "#06b8b8"
                ],
                [
                    "name" => "accent",
                    "value" => "#d511f7"
                ],
                [
                    "name" => "dark",
                    "value" => "#0d101a"
                ],
                [
                    "name" => "positive",
                    "value" => "#198754"
                ],
                [
                    "name" => "negative",
                    "value" => "#c10015"
                ],
                [
                    "name" => "info",
                    "value" => "#0a6afa"
                ],
                [
                    "name" => "warning",
                    "value" => "#d6a100"
                ],
                [
                    "name" => "danger",
                    "value" => "#eb0909"
                ],
            ],
            'menus' => [
                ['name' => 'dashboard', 'icon' => 'icon-mat-dashboard', 'link' => 'dashboard', 'submenus' => []],
                [
                    'name' => 'master',
                    'icon' => 'icon-mat-dataset',
                    'link' => 'master',
                    'submenus' => [
                        ['name' => 'Satuan', 'icon' => 'icon-mat-gas_meter', 'link' => 'satuan', 'value' => 'satuan'],


                    ]
                ],
                [
                    'name' => 'transaksi',
                    'icon' => 'icon-mat-sync_alt',
                    'link' => 'transaksi',
                    'submenus' => [
                        ['name' => 'Pembelian', 'value' => 'pembelian', 'icon' => 'icon-mat-inventory_2', 'link' => '/pembelian/PBL-'],


                    ]
                ],
                [
                    'name' => 'history',
                    'icon' => 'icon-mat-history',
                    'link' => 'history',
                    'submenus' => [
                        ['name' => 'Seluruhnya', 'value' => 'all', 'icon' => 'icon-mat-density_small'],
                    ]
                ],
                ['name' => 'laporan', 'icon' => 'icon-mat-description', 'link' => 'laporan', 'submenus' => []],
                [
                    'name' => 'setting',
                    'icon' => 'icon-mat-settings',
                    'link' => 'setting',
                    'submenus' => [
                        ['name' => 'User', 'value' => 'user', 'icon' => 'icon-mat-density_small'],
                    ]
                ]
            ]
        ]);
    }
}
