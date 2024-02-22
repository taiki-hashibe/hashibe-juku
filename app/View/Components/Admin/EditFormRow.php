<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class EditFormRow extends Component
{
    public bool $required;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(bool $required = false)
    {
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.edit-form-row');
    }
}
