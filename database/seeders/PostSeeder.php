<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
use App\Models\Translate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory(20)->create()->each(function ($post) {

            foreach (config('translate.lang') as $lang) {
//                $tr = new GoogleTranslate($lang);
//                $tr->setSource(config('translate.default_lang'));
//                $tr->setTarget($lang);
                Translate::factory()->create([
                    'post_id' => $post->id,
                    'lang' => $lang,
                ]);
            }

            Image::factory(2)->create(['post_id' => $post->id]);
        });
    }
}
