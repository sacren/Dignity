<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PostManager extends Component
{
    public $title = '';
    public $body = '';

    protected $rules = [
        'title' => [
            'required',
            'min:3',
            'max:255',
        ],

        'body'  => [
            'required',
            'min:10',
        ],
    ];

    public function savePost()
    {
        $this->validate();

        Auth::user()->posts::create([
            'title' => $this->title,
            'body'  => $this->body,
        ]);

        // Flash message (optional, for UX)
        session()->flash('message', 'Post created successfully!');

        // Reset form fields
        $this->reset(['title', 'body']);

        // Optionally emit an event so other components (like PostList) can react
        $this->dispatch('post-created');
    }

    public function render()
    {
        return view('livewire.post-manager');
    }
}
