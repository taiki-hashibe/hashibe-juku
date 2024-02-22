<?php

namespace App\View\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;

/**
 * @param array<string> $containerClasses
 * @param array<string> $svgClasses
 * @param array<string> $titleClasses
 * @param array<string> $messageClasses
 */
class Alert extends Component
{
    public string $status;
    public ?string $title;
    public ?string $message;
    public string $icon = '';
    public string $closeCallback = 'open = false';

    /**
     * @var array<string>
     */
    public array $containerClasses = [];
    /**
     * @var array<string>
     */
    public array $svgClasses = [];
    /**
     * @var array<string>
     */
    public array $titleClasses = [];
    /**
     * @var array<string>
     */
    public array $messageClasses = [];

    public string $containerClass;
    public string $svgClass;
    public string $titleClass;
    public string $messageClass;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $status, ?string $title = null, ?string $message = null, ?string $closeCallback = null)
    {
        $this->status = $status;
        $this->title = $title;
        $this->message = $message;
        if ($closeCallback) {
            $this->closeCallback = $closeCallback;
        }

        if ($this->status === 'info') {
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 me-2">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
          </svg>
          ';
            $this->containerClasses[] = 'text-blue-800 dark:text-white';
            $this->svgClasses[] = 'text-blue-800 dark:text-white';
            $this->containerClasses[] = 'bg-blue-50 dark:bg-blue-800/50 border-transparent dark:border-white';
        }

        if ($this->status === 'success') {
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 me-2">
            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
          </svg>
          ';
            $this->containerClasses[] = 'text-success-600';
            $this->svgClasses[] = 'text-success-400';
            $this->containerClasses[] = 'bg-success-100';
        }

        if ($this->status === 'danger') {
            $this->icon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 me-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
          </svg>

          ';
            $this->containerClasses[] = 'text-rose-600';
            $this->svgClasses[] = 'text-rose-400';
            $this->containerClasses[] = 'bg-rose-50';
        }

        $this->containerClass = Arr::join($this->containerClasses, ' ');
        $this->svgClass = Arr::join($this->svgClasses, ' ');
        $this->titleClass = Arr::join($this->titleClasses, ' ');
        $this->messageClass = Arr::join($this->messageClasses, ' ');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
