<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MenuItem extends Model
{

    protected $table = 'menu_items';

    public static function getMenuItems($parentId = null): Collection
    {
        $menuItems = self::where('parent_id', $parentId)
            ->orderBy('id')
            ->get();

        foreach ($menuItems as $menuItem) {
            $menuItem->children = self::getMenuItems($menuItem->id);
        }

        return $menuItems;
    }
}