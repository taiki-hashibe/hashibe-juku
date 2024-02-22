<?php

namespace App\View\Components\Admin;

use App\Models\StatusEnum;
use Illuminate\View\Component;

class ContentStatusBadge extends Component
{
    public string $status;
    public string $readable;
    public string $class = "px-2 inline-flex text-xs font-semibold ";
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $status)
    {
        $this->status = $status;
        $this->readable = StatusEnum::readable($status);
        switch ($status) {
            case StatusEnum::$PUBLISH:
                $this->class .= "bg-green-100 text-green-800";
                break;
            case StatusEnum::$DRAFT:
                $this->class .= "bg-gray-100 text-gray-800";
                break;
            case StatusEnum::$TRASH:
                $this->class .= "bg-red-100 text-red-800";
                break;
            case StatusEnum::$REVISION:
                $this->class .= "bg-blue-100 text-blue-800";
                break;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.content-status-badge');
    }
}
