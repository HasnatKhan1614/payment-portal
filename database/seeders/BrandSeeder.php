<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $source = public_path('assets/img/dummy-logo-square.svg');
        $relativePath = 'logo/dummy-brand-logo.svg';

        if (File::exists($source)) {
            Storage::disk('public')->put($relativePath, File::get($source));
        }

        $brands = [
            ['name' => 'Acme Commerce', 'logo_path' => $relativePath],
            ['name' => 'Blue Peak Store', 'logo_path' => $relativePath],
            ['name' => 'Northwind Retail', 'logo_path' => $relativePath],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['name' => $brand['name']],
                ['logo_path' => $brand['logo_path']]
            );
        }
    }
}
