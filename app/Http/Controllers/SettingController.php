<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index() {
        $title      = __('pages.profile-menu.settings');
        $user       = Auth::user();
        $timezones  = DB::table("timezones")->get();
        $currencies = DB::table("currencies")->get();
        $accounts = DB::table('accounts')->where('user', $user->id)->orderByDesc("id")->get();
        $categories = DB::table('categories')->where('user',$user->id)->orderByDesc("id")->get();
        $categories1 = $this->getCategories();
        return view('setting.index', compact("user", "title", "timezones", "currencies","accounts","categories","categories1"));
    }

    public function getCategories() {
        $user = Auth::user();
        $categories = DB::table('categories')->where('user', $user->id)->where('categories.type', 'expense')->where('categories.id_catalog', 0)->get();
 
        $listCategories = [];
        Category::recursive($categories, $parents = 0, $level = 1, $listCategories );
     
        return  $listCategories;
    }


    public function add() {
        if(request('category') == null || request('category') == '00') {
            $id_catalog = 0;
        } else {
            $id_catalog = request('category');
        }
     
        $data = [
            'user' => Auth::user()->id,
            'name' => request('name'),
            'type' => request('type'),
            'budget' =>0,
            'id_catalog' => $id_catalog
        ];


        DB::table('categories')->insert($data);

      return redirect()->route('setting.index')->with('success', 'Thêm hạng mục thành công');
    }

    public function deleteCategory() {
        DB::table('categories')->where('id', request('categoryid'))->delete();

        return response()->json([
            'status' => 'success',
            'message' => __('settings.messages.category-deleted'),
            'data' => __('settings.messages.category-delete-success')
        ]);
    }

    public function updateCategoryView() {
        $category = DB::table('categories')->where('id', request('categoryid'))->first();

        return view('includes.ajax.editcategory', compact('category'));
    }

    public function updateCategory() {
        $data = [
            'name' => request('category'),
            'type' => request('type')
        ];

        DB::table('categories')->where('id', request('categoryid'))->update($data);

        return response()->json([
            'status' => 'success',
            'message' => __('pages.messages.alright'),
            'data' => __('settings.messages.category-edit-success')
        ]);
    }

}
