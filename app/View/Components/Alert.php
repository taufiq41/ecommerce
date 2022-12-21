<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $isWarning;
    public $title;
    public $text;
    public function __construct($isWarning = null, $title = '', $text = '')
    {
        $this->isWarning = $isWarning;
        $this->title = $title;
        $this->text = $text;
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
