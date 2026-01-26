<?php

namespace Database\Seeders;

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
            $translate = ['en', 'ja', 'fr'];

            foreach ($translate as $lang) {
                $tr = new GoogleTranslate($lang);
                $tr->setSource('vi');
                $tr->setTarget($lang);
                Translate::create([
                    'post_id' => $post->id,
                    'lang' => $lang,
                    'title' => $tr->translate($post->title),
                    'content' => $tr->translate($post->content),
                ]);
            }
        });
    }
}
