<?php

    function getMenu($menuUrl)
    {
        $menu = \App\Models\Menu::where('url', $menuUrl)->first();
        return $menu;
    }

    function getProgramCode($menuUrl)
    {
        $menu = getMenu($menuUrl);
        if (is_null($menu)) {
            return null;
        }
        return $menu->program_code;
    }

    function getProgramCodeView($menu)
    {
        return view('components.get-program-code', compact('menu'));
    }
