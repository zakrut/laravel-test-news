<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = \App\User::create([
            'name'      => 'admin',
            'email'     => 'admin@test.ru',
            'password'  => Hash::make('admin'),
        ]);
        $admin->role()->create(['name' => 'admin']);
        $editor = \App\User::create([
            'name'      => 'editor',
            'email'     => 'editor@test.ru',
            'password'  => Hash::make('editor'),
        ]);
        $editor->role()->create(['name' => 'editor']);
        $category = \App\Category::create(['name' => 'Политика']);
        $editor->posts()->create([
                'title'    => 'Faucibus interdum posuere lorem ipsum dolor sit.',
                'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'content'  => 'Quis lectus nulla at volutpat diam ut venenatis tellus. Nunc sed blandit libero volutpat sed cras ornare arcu dui. Tempor orci dapibus ultrices in. Dolor sit amet consectetur adipiscing elit. A arcu cursus vitae congue mauris rhoncus aenean. In aliquam sem fringilla ut morbi tincidunt. Accumsan in nisl nisi scelerisque eu ultrices. Nibh nisl condimentum id venenatis a condimentum vitae. Sit amet purus gravida quis. Aliquam faucibus purus in massa tempor. ',
                'status'   => 'pub',
            ]);
        $editor->posts()->create([
                'title'    => 'Praesent semper feugiat nibh sed.',
                'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'content'  => 'Quis lectus nulla at volutpat diam ut venenatis tellus. Nunc sed blandit libero volutpat sed cras ornare arcu dui. Tempor orci dapibus ultrices in. Dolor sit amet consectetur adipiscing elit. A arcu cursus vitae congue mauris rhoncus aenean. In aliquam sem fringilla ut morbi tincidunt. Accumsan in nisl nisi scelerisque eu ultrices. Nibh nisl condimentum id venenatis a condimentum vitae. Sit amet purus gravida quis. Aliquam faucibus purus in massa tempor. ',
                'status'   => 'pub',
                'category_id' => $category->id
            ]);
        $admin->posts()->create([
                'title'    => 'Sed viverra tellus in hac habitasse.',
                'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'content'  => 'Quis lectus nulla at volutpat diam ut venenatis tellus. Nunc sed blandit libero volutpat sed cras ornare arcu dui. Tempor orci dapibus ultrices in. Dolor sit amet consectetur adipiscing elit. A arcu cursus vitae congue mauris rhoncus aenean. In aliquam sem fringilla ut morbi tincidunt. Accumsan in nisl nisi scelerisque eu ultrices. Nibh nisl condimentum id venenatis a condimentum vitae. Sit amet purus gravida quis. Aliquam faucibus purus in massa tempor. ',
                'status'   => 'pub',
            ]);
    }
}
