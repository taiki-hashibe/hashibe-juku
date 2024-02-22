<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Button extends Component
{
    public const BASE_CLASS = 'rounded-md px-3 py-2 duration-200 font-semibold ';

    public const VARIANT_PRIMARY = 'primary';
    public const VALIANT_SECONDARY = 'secondary';
    public const VARIANT_INFO = 'info';
    public const VARIANT_ORANGE = 'orange';
    public const VARIANT_SUCCESS = 'success';
    public const VARIANT_DANGER = 'danger';
    public const VARIANT_OUTLINE_SECONDARY = 'outline-secondary';
    public const VARIANT_OUTLINE_DANGER = 'outline-danger';
    public const VARIANT_OUTLINE_ORANGE = 'outline-orange';

    /**
     * @var array<string, string>
     */
    public array $variantClassMap = [
        self::VARIANT_PRIMARY => self::BASE_CLASS . 'bg-blue-400 text-white enabled:hover:bg-blue-500 disabled:opacity-75',
        self::VALIANT_SECONDARY => self::BASE_CLASS . 'bg-gray-400 text-white enabled:hover:bg-gray-500 disabled:opacity-75',
        self::VARIANT_INFO => self::BASE_CLASS . 'bg-sky-400 text-white enabled:hover:bg-sky-500 disabled:opacity-75',
        self::VARIANT_ORANGE => self::BASE_CLASS . 'bg-orange-400 text-white enabled:hover:bg-orange-500 disabled:opacity-75',
        self::VARIANT_SUCCESS => self::BASE_CLASS . 'bg-green-400 text-white enabled:hover:bg-green-500 disabled:opacity-75',
        self::VARIANT_DANGER => self::BASE_CLASS . 'bg-rose-500 text-white enabled:hover:bg-rose-600 disabled:opacity-75',
        self::VARIANT_OUTLINE_SECONDARY => self::BASE_CLASS . 'bg-white border border-slate-500 text-slate-500 enabled:hover:bg-slate-500 enabled:hover:border-white enabled:hover:text-white disabled:opacity-75',
        self::VARIANT_OUTLINE_DANGER => self::BASE_CLASS . 'bg-white border border-rose-500 text-rose-500 enabled:hover:bg-rose-600 enabled:hover:border-white enabled:hover:text-white disabled:opacity-75',
        self::VARIANT_OUTLINE_ORANGE => self::BASE_CLASS . 'bg-white border border-orange-500 text-orange-500 enabled:hover:bg-orange-500 enabled:hover:border-white enabled:hover:text-white disabled:opacity-75',
    ];

    public string $classNames = '';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $variant, ?string $class = '')
    {
        $this->classNames = $this->variantClassMap[$variant] . " $class";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.button');
    }
}
