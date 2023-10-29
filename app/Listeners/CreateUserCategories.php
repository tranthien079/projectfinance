<?php

namespace App\Listeners;

use App\Models\Category;
use App\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUserCategories
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        $user = $event->user;

        // Tạo các hạng mục tiêu dùng cho tài khoản người dùng
        Category::create([
            'user' =>  $user->id,
            'name' =>  'Ăn uống',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Dịch vụ sinh hoạt',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Đi lại',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Con cái',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Trang phục',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Hiếu hỉ',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Sức khỏe',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Nhà cửa',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Hưởng thụ',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Phát triển bản thân',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Ngân hàng',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Lương',
            'type' =>  'Income',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Thưởng',
            'type' =>  'Income',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Được cho/tặng',
            'type' =>  'Income',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Tiền lãi',
            'type' =>  'Income',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Khác',
            'type' =>  'Income',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        Category::create([
            'user' =>  $user->id,
            'name' =>  'Lãi tiết kiệm',
            'type' =>  'Income',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);
        // Thêm các hạng mục khác nếu cần
    }
}
