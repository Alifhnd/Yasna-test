<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Post\Entities\Post;
use Modules\Post\Entities\Tag;

class DummyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->poststable();
        $this->tagstable();
        $this->postTagstable();

        // $this->call("OthersTableSeeder");
    }



    /**
     * @param int $total
     *
     */
    public function postsTable($total = 10)
    {
        $i=1;
        while ($i<$total){
            $i++;

            Post::create([
                 'post_title' => dummy()::persianTitle(),
                 'post_content'=>dummy()::persianText(1),
                 'post_author'=> 1,
            ]);
        }
    }



    /**
     * @param int $total
     */
    public function tagsTable($total = 10)
    {

        for ($i=1 ; $i<=$total ;$i++){
            Tag::create([
                    'title'=>dummy()::persianWord()
            ]);

        }
    }



    /**
     * @param int $total
     */
    public function postTagsTable($total = 10)
    {
        for ($i = 1; $i <= $total; $i++) {
            $random_post = model('post')->inRandomOrder()->first();
            $random_tag = model('tag')->inRandomOrder()->first();

            $random_post->tags()->save($random_tag) ;
        }
    }


}
