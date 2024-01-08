<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GetPageTitle extends Component
{
    public $menu;
    public $url;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($menu, $url)
    {
        $this->menu = $menu;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->menu) {
            $getMenu = $this->menu;
        } else {
            $getMenu = getMenu($this->url);
        }
        // dd($getMenu);
        return view('components.get-page-title', compact('getMenu'));
    }
}
