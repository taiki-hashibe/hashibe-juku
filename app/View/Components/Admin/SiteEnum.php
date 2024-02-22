<?php

namespace App\View\Components\Admin;

use App\Models\SiteEnum as ModelSiteEnum;
use Illuminate\View\Component;

class SiteEnum extends Component
{
    public string $site;
    public string $readable;
    public string $class = "px-2 inline-flex text-xs font-semibold ";
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $site)
    {
        $this->site = $site;
        $this->readable = ModelSiteEnum::readable($site);
        switch ($site) {
            case ModelSiteEnum::$ALL:
                $this->class .= "bg-green-100 text-green-800";
                break;
            case ModelSiteEnum::$WEB:
                $this->class .= "bg-gray-100 text-gray-800";
                break;
            case ModelSiteEnum::$SALES:
                $this->class .= "bg-red-100 text-red-800";
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
        return view('admin.components.site-enum');
    }
}
