<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'id',
        'user',
        'name',
        'type',
        'budget',
        'id_catalog',
        'created_at',
        'updated_at'
    ];

    // public function categories() {
    //     return  $this->hasMany(Category::class);
    // }

    // public function childrenCategories() {
    //     return  $this->hasMany(Category::class)->with('categories');
    // }

    public static function recursive($categories, $parents = 0, $level = 1, &$listCategories ) {
        if(count($categories) > 0) {
            foreach($categories as $key=> $value) {

                if($value->id_catalog == $parents) {
                    $value->level = $level;

                    $listCategories[] = $value;
                    unset($categories[$key]);

                    $parent = $value->id;

                    self::recursive($categories, $parent , $level + 1, $listCategories);
                }
            }
        }
    }
}
