<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Enums\ImageUsage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $useages=ImageUsage::cases();
        $images = [
            [
                'usage' => ImageUsage::ICON->value,
                'name' => 'Daruma Icon',
                'path' => '/images/icons/daruma.jpg',
            ],
            [
                'usage' => ImageUsage::ICON->value,
                'name' => 'Expert Icon',
                'path' => '/images/icons/expert.jpg',
            ],
            [
                'usage' => ImageUsage::ICON->value,
                'name' => 'Fox Icon',
                'path' => '/images/icons/fox.jpg',
            ],
            [
                'usage' => ImageUsage::ICON->value,
                'name' => 'Hawk Icon',
                'path' => '/images/icons/hawk.jpg',
            ],
            [
                'usage' => ImageUsage::ICON->value,
                'name' => 'Maiko Icon',
                'path' => '/images/icons/maiko.jpg',
            ],
            [
                'usage' => ImageUsage::ICON->value,
                'name' => 'Penguin Icon',
                'path' => '/images/icons/penguin.jpg',
            ],
            [
                'usage' => ImageUsage::ICON->value,
                'name' => 'Wolf Icon',
                'path' => '/images/icons/wolf.jpg',
            ],
        ];
        foreach ($images as $image) {
            Image::firstOrCreate(
                [
                    'name' => $image['name'],
                    'usage' => $image['usage'],
                    'path' => $image['path'],
                ]
            );
        }
    }
}
