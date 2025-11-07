<?php

namespace Database\Seeders;
use App\Models\ContentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contentTypes = [
            [ 'name' => 'success', 'is_active' => true],
            [ 'name' => 'fail', 'is_active' => true],
            [ 'name' => 'neutral', 'is_active' => true],
        ];

        foreach($contentTypes as $contentType){
            ContentType::firstOrCreate(
                ['name' =>$contentType['name']],
                ['is_active' =>$contentType['is_active']],
            );
        }
    }
}
