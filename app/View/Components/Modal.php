<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public string|null $backdropClass;
    public string|null $modalClass;
    public string|null $cardClass;
    public string $key;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $key, string $backdropClass = null, string $modalClass = null, string $cardClass = null)
    {
        $this->backdropClass = $backdropClass;
        $this->modalClass = $modalClass;
        $this->cardClass = $cardClass;
        $this->key = $key;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
