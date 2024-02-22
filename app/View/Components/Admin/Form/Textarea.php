<?php

namespace App\View\Components\Admin\Form;

use Illuminate\View\Component;

class Textarea extends Component
{
    public string $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.form.textarea');
    }
}
