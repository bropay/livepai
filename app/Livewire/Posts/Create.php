<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

class Create extends Component
{
    use WithFileUploads;

    #[Rule('required', message: 'Masukan Gambar Post')]
    #[Rule('image', message: 'File Harus Gambar')]
    #[Rule('max:1024', message: 'Ukuran File Maksimal 1MB')]
    public $image;

    #[Rule('required', message: 'Masukan Judul Post')]
    public $title;

    #[Rule('required', message: 'Masukan Isi Post')]
    #[Rule('min:3', message: 'Isi Post Minimal 3 Karakter')]
    public $content;

    /**
     * store
     * 
     * @return void
     */

     public function store()
     {
        $this->validate();

        //store image in storage/app/public/posts
        $this->image->storeAs('public/posts', $this->image->hashName());
        
        //create post
        Post::create([
            'image' => $this->image->hashName(),
            'title' => $this->title,
            'content' => $this->content,
     ]);
     
        //flash message
        session()->flash('message', 'Data Berhasil Disimpan.');
        
        //redirect
        return redirect()->route('posts.index');
}

/**
* render
*
* @return void
*/
    public function render()
    {
        return view('livewire.posts.create');
    }
}