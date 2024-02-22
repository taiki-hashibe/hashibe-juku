<?php

namespace App\View\Components\Admin;

use App\Models\PublishLevelEnum as ModelsPublishLevelEnum;
use Illuminate\View\Component;

class PublishLevelEnum extends Component
{
    public int $level;
    public string $readable;
    public string $class = "px-2 inline-flex text-xs font-semibold ";
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(int $level)
    {
        $this->level = $level;
        $this->readable = ModelsPublishLevelEnum::readable($level);
        switch ($level) {
            case ModelsPublishLevelEnum::$ANYONE:
                $this->class .= "bg-green-100 text-green-800";
                break;
            case ModelsPublishLevelEnum::$TRIAL:
                $this->class .= "bg-gray-100 text-gray-800";
                break;
            case ModelsPublishLevelEnum::$MEMBERSHIP:
                $this->class .= "bg-orange-100 text-orange-800";
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
        return view('admin.components.publish-level-enum');
    }
}
