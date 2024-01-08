<?php

    function canEnter($menuUrl)
    {
        $menu = getMenu($menuUrl);
        if (is_null($menu)) {
            return false;
        }
        return true;
        $permisionCode = $menu->permission_code;
        return Gate::check($permisionCode. '_ENTER');
    }

    function canView($menuUrl)
    {
        $menu = getMenu($menuUrl);
        if (is_null($menu)) {
            return false;
        }

        return true;
        $permisionCode = $menu->permission_code;
        return Gate::check($permisionCode. '_VIEW');
    }