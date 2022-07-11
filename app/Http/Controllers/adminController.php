<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Mockery\Generator\StringManipulation\Pass\Pass;
use Illuminate\Support\Facades\Storage;
use Exception;

class adminController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function all_info_product()
    {

        $commodity = DB::table('commodity')
            ->join('commodity_image', 'commodity.id', '=', 'commodity_image.commodity_id')
            ->get();
        return response()->json($commodity);
    }
    // public function update_commodity(Request $request)
    // {
    //     $id = $request->input('id');

    //     $commodity = DB::table('commodity')
    //         ->join('commodity_image', 'commodity.id', '=', 'commodity_image.commodity_id')
    //         ->where('id', $id)
    //         ->first();;
    //         return response()->json($commodity);


    // }
    public function delete_commodity(Request $request)
    {
        $id = $request->input('id');
      
        //$id = $request->input('id');
        //DB::table('commodity')->where('id', $id)->first()->delete();
        DB::delete('delete from commodity where commodity.id = ?',[$id]);
        Storage::deleteDirectory('/public/image/commodity/'.$id);
        return response()->json([
            'status' => 'success',
            

        ], 200);
        
    }
    public function update_commodity_save(Request $request)
    {
        $input = $request->all();
        DB::transaction(function ()  use ($input) {

            $old_image = DB::table('commodity_image')->where('commodity_id', $input['id'])->first();
            

            if ($input['image']['path1'] != $old_image->path1) { //PATH1不為空

                $path1_url = '../storage/image/commodity/' . $input['id'] . '/' . $input['id'] . '_1.jpg'; //儲存在資料庫的路徑
                if (!is_null($input['image']['path1'])) { //判斷是否有上傳照片


                    //若存在舊得照片舊刪除，上傳新照片，否則直接上傳
                    if (Storage::exists('/public/image/commodity/' . $input['id'] . '/' . $input['id'] . '_1.jpg')) {
                        Storage::delete('/public/image/commodity/' . $input['id'] . '/' . $input['id'] . '_1.jpg');
                        Storage::putFileAs('/public/image/commodity/' . $input['id'] . '/', $input['image']['path1'], $input['id'] . '_1.jpg');
                    }
                    // } else { //$input['path1'] 是null ，且原本有照片
                    //     Storage::delete('/public/image/commodity/' . $input['id'] . '/' . $input['id'] . '_2.jpg');
                    //     DB::table('commodity_image')->where('commodity_id', $input['id'])->update(['path2' => NULL]);
                    // }
                }
            };

            if ($input['image']['path2'] != $old_image->path2) {

                $path2_url = '../storage/image/commodity/' . $input['id'] . '/' . $input['id'] . '_2.jpg'; //儲存在資料庫的路徑
                if (!is_null($input['image']['path2'])) { //判斷是否有上傳照片


                    //若存在舊得照片舊刪除，上傳新照片，否則直接上傳
                    if (Storage::exists('/public/image/commodity/' . $input['id'] . '/' . $input['id'] . '_2.jpg')) {
                        Storage::delete('/public/image/commodity/' . $input['id'] . '/' . $input['id'] . '_2.jpg');
                        Storage::putFileAs('/public/image/commodity/' . $input['id'] . '/', $input['image']['path2'], $input['id'] . '_2.jpg');
                    } else {
                        Storage::putFileAs('/public/image/commodity/' . $input['id'] . '/', $input['image']['path2'], $input['id'] . '_2.jpg');
                        DB::table('commodity_image')->where('commodity_id', $input['id'])->update(['path2' => $path2_url]);
                    }
                } else { //$input['path1'] 是null ，且原本有照片
                    Storage::delete('/public/image/commodity/' . $input['id'] . '/' . $input['id'] . '_2.jpg');
                    DB::table('commodity_image')->where('commodity_id', $input['id'])->update(['path2' => NULL]);
                }
            };
            if ($input['image']['path3'] != $old_image->path3) {

                $path3_url = '../storage/image/commodity/' . $input['id'] . '/' . $input['id'] . '_3.jpg'; //儲存在資料庫的路徑
                if (!is_null($input['image']['path3'])) { //判斷是否有上傳照片


                    //若存在舊得照片舊刪除，上傳新照片，否則直接上傳，
                    if (Storage::exists('/public/image/commodity/' . $input['id'] . '/' . $input['id'] . '_3.jpg')) {
                        Storage::delete('/public/image/commodity/' . $input['id'] . '/' . $input['id'] . '_3.jpg');
                        Storage::putFileAs('/public/image/commodity/' . $input['id'] . '/', $input['image']['path3'], $input['id'] . '_3.jpg');
                    } else {
                        Storage::putFileAs('/public/image/commodity/' . $input['id'] . '/', $input['image']['path3'], $input['id'] . '_3.jpg');
                        DB::table('commodity_image')->where('commodity_id', $input['id'])->update(['path3' => $path3_url]);
                    }
                } else { //$input['path1'] 是null ，且原本有照片
                    Storage::delete('/public/image/commodity/' . $input['id'] . '/' . $input['id'] . '_3.jpg');
                    DB::table('commodity_image')->where('commodity_id', $input['id'])->update(['path3' => NULL]);
                }
            };
            if ($input['image']['path4'] != $old_image->path4) {

                $path4_url = '../storage/image/commodity/' . $input['id'] . '/' . $input['id'] . '_4.jpg'; //儲存在資料庫的路徑
                if (!is_null($input['image']['path2'])) { //判斷是否有上傳照片


                    //若存在舊得照片舊刪除，上傳新照片，否則直接上傳
                    if (Storage::exists('/public/image/commodity/' . $input['id'] . '/' . $input['id'] . '_4.jpg')) {
                        Storage::delete('/public/image/commodity/' . $input['id'] . '/' . $input['id'] . '_4.jpg');
                        Storage::putFileAs('/public/image/commodity/' . $input['id'] . '/', $input['image']['path4'], $input['id'] . '_4.jpg');
                    } else {
                        Storage::putFileAs('/public/image/commodity/' . $input['id'] . '/', $input['image']['path4'], $input['id'] . '_4.jpg');
                        DB::table('commodity_image')->where('commodity_id', $input['id'])->update(['path4' => $path4_url]);
                    }
                } else { //$input['path1'] 是null ，且原本有照片
                    Storage::delete('/public/image/commodity/' . $input['id'] . '/' . $input['id'] . '_4.jpg');
                    DB::table('commodity_image')->where('commodity_id', $input['id'])->update(['path4' => NULL]);
                }
            };
            DB::table('commodity')->where('id', $input['id'])->update(['class' => $input['class'], 'name' => $input['name'], 'content' => $input['content'], 'price' => $input['price'], 'number' => $input['number'], 'status' => $input['status']]);
        });


        return response()->json([
            'status' => 'success',

        ], 200);
    }
    public function add_commodity_save(Request $request)
    {
        $input = $request->all();


        $commodity_all_id = DB::table('commodity')->pluck('id')->toArray();
        if (in_array($input['id'],$commodity_all_id)){
            return response()->json([
                'status' => 'error',
                'msg' =>'商品id已存在',200
    
            ]);

        }
        
            DB::transaction(function ()  use ($input) {

                DB::insert('insert into commodity  values (?, ?, ?, ?, ?,?,?)', [$input['id'], $input['name'], $input['class'], $input['content'], $input['price'], $input['number'],$input['status']]);


                if (!is_null($input['image']['path1'])) { //判斷是否有上傳照片
                    $path1_url = '../storage/image/commodity/' . $input['id'] . '/' . $input['id'] . '_1.jpg'; //儲存在資料庫的路徑



                    Storage::putFileAs('/public/image/commodity/' . $input['id'] . '/', $input['image']['path1'], $input['id'] . '_1.jpg');
                }
                if (!is_null($input['image']['path2'])) { //判斷是否有上傳照片
                    $path2_url = '../storage/image/commodity/' . $input['id'] . '/' . $input['id'] . '_2.jpg'; //儲存在資料庫的路徑



                    Storage::putFileAs('/public/image/commodity/' . $input['id'] . '/', $input['image']['path2'], $input['id'] . '_2.jpg');
                } else {
                    $path2_url = $input['image']['path2'];
                }
                if (!is_null($input['image']['path3'])) { //判斷是否有上傳照片
                    $path3_url = '../storage/image/commodity/' . $input['id'] . '/' . $input['id'] . '_3.jpg'; //儲存在資料庫的路徑



                    Storage::putFileAs('/public/image/commodity/' . $input['id'] . '/', $input['image']['path3'], $input['id'] . '_3.jpg');
                } else {
                    $path3_url = $input['image']['path3'];
                }
                if (!is_null($input['image']['path4'])) { //判斷是否有上傳照片
                    $path4_url = '../storage/image/commodity/' . $input['id'] . '/' . $input['id'] . '_4.jpg'; //儲存在資料庫的路徑



                    Storage::putFileAs('/public/image/commodity/' . $input['id'] . '/', $input['image']['path4'], $input['id'] . '_4.jpg');
                } else {
                    $path4_url = $input['image']['path4'];
                }


                DB::insert('insert into commodity_image (commodity_id, path1, path2, path3, path4) values (?, ?, ?, ?, ?)', [$input['id'], $path1_url, $path2_url, $path3_url, $path4_url]);
            });
        
        return response()->json([
            'status' => 'success',
            

        ], 200);
    }
}
