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
        $parentCategory1 = Category::create([
            'user' =>  $user->id,
            'name' =>  'Ăn uống',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

          // Tạo các hạng mục con
        $childCategories1 = ['Đi chợ','Ăn tiệm', 'Cafe', 'Ăn sáng'];
        foreach ($childCategories1 as $childName) {
            Category::create([
                'user' =>  $user->id,
                'name' =>  $childName,
                'type' =>  'Expense',
                'budget' =>  0,
                'id_catalog' => $parentCategory1->id, 
            ]);
        }

        $parentCategory2 = Category::create([
            'user' =>  $user->id,
            'name' =>  'Dịch vụ sinh hoạt',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

          // Tạo các hạng mục con
          $childCategories2 = ['Điện','Nước', 'Internet', 'Điện thoại di động','Gas','Truyền hình','Thuê giúp việc'];
          foreach ($childCategories2 as $childName) {
              Category::create([
                  'user' =>  $user->id,
                  'name' =>  $childName,
                  'type' =>  'Expense',
                  'budget' =>  0,
                  'id_catalog' =>  $parentCategory2->id, 
              ]);
          }

        $parentCategory3 = Category::create([
            'user' =>  $user->id,
            'name' =>  'Đi lại',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

          // Tạo các hạng mục con
          $childCategories3 = ['Xăng xe','Bảo hiểm xe', 'Sửa chữa, bảo dưỡng xe', 'Rửa xe','Gửi xe','Taxi/Thuê xe'];
          foreach ($childCategories3 as $childName) {
              Category::create([
                  'user' =>  $user->id,
                  'name' =>  $childName,
                  'type' =>  'Expense',
                  'budget' =>  0,
                  'id_catalog' =>  $parentCategory3->id, 
              ]);
          }

        $parentCategory4 = Category::create([
            'user' =>  $user->id,
            'name' =>  'Con cái',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

          // Tạo các hạng mục con
          $childCategories4 = ['Học phí','Sách vở','Sữa','Đồ chơi','Tiền tiêu vặt'];
          foreach ($childCategories4 as $childName) {
              Category::create([
                  'user' =>  $user->id,
                  'name' =>  $childName,
                  'type' =>  'Expense',
                  'budget' =>  0,
                  'id_catalog' =>  $parentCategory4->id, 
              ]);
          }


        $parentCategory5 = Category::create([
            'user' =>  $user->id,
            'name' =>  'Trang phục',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

           // Tạo các hạng mục con
           $childCategories5 = ['Quần áo','Giày dép','Phụ kiện khác'];
           foreach ($childCategories5 as $childName) {
               Category::create([
                   'user' =>  $user->id,
                   'name' =>  $childName,
                   'type' =>  'Expense',
                   'budget' =>  0,
                   'id_catalog' =>  $parentCategory5->id, 
               ]);
           }
 

        $parentCategory6 = Category::create([
            'user' =>  $user->id,
            'name' =>  'Hiếu hỉ',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        // Tạo các hạng mục con
        $childCategories6 = ['Cưới xin','Ma chay','Thăm hỏi'];
        foreach ($childCategories6 as $childName) {
            Category::create([
                'user' =>  $user->id,
                'name' =>  $childName,
                'type' =>  'Expense',
                'budget' =>  0,
                'id_catalog' => $parentCategory6->id, 
            ]);
        }
 

        $parentCategory7 = Category::create([
            'user' =>  $user->id,
            'name' =>  'Sức khỏe',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        // Tạo các hạng mục con
        $childCategories7 = ['Khám chữa bệnh','Thuốc men','Thể thao'];
        foreach ($childCategories7 as $childName) {
            Category::create([
                'user' =>  $user->id,
                'name' =>  $childName,
                'type' =>  'Expense',
                'budget' =>  0,
                'id_catalog' => $parentCategory7->id, 
            ]);
        }

        $parentCategory8 = Category::create([
            'user' =>  $user->id,
            'name' =>  'Nhà cửa',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        // Tạo các hạng mục con
        $childCategories8 = ['Mua sắm đồ đạc','Sửa chữa nhà cửa','Thuê nhà'];
        foreach ($childCategories8 as $childName) {
            Category::create([
                'user' =>  $user->id,
                'name' =>  $childName,
                'type' =>  'Expense',
                'budget' =>  0,
                'id_catalog' => $parentCategory8->id, 
            ]);
        }

        $parentCategory9 = Category::create([
            'user' =>  $user->id,
            'name' =>  'Hưởng thụ',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        // Tạo các hạng mục con
        $childCategories9 = ['Vui chơi giải trí','Du lịch','Làm đẹp'];
        foreach ($childCategories9 as $childName) {
            Category::create([
                'user' =>  $user->id,
                'name' =>  $childName,
                'type' =>  'Expense',
                'budget' =>  0,
                'id_catalog' => $parentCategory9->id, 
            ]);
        }

        $parentCategory10 = Category::create([
            'user' =>  $user->id,
            'name' =>  'Phát triển bản thân',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);

        $childCategories10 = ['Học hành','Giao lưu quan hệ'];
        foreach ($childCategories10 as $childName) {
            Category::create([
                'user' =>  $user->id,
                'name' =>  $childName,
                'type' =>  'Expense',
                'budget' =>  0,
                'id_catalog' => $parentCategory10->id, 
            ]);
        }

        $parentCategory11 = Category::create([
            'user' =>  $user->id,
            'name' =>  'Ngân hàng',
            'type' =>  'Expense',
            'budget' =>  0,
            'id_catalog' =>  0,
        ]);
        $childCategories11 = ['Phí chuyển khoảng','Phí thường niên'];
        foreach ($childCategories11 as $childName) {
            Category::create([
                'user' =>  $user->id,
                'name' =>  $childName,
                'type' =>  'Expense',
                'budget' =>  0,
                'id_catalog' => $parentCategory11->id, 
            ]);
        }

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
