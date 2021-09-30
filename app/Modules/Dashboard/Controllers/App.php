<?php

namespace App\Modules\Dashboard\Controllers;

use Illuminate\Http\Request;
use App\Modules\Dashboard\Models\App_Model;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\ImageManagerStatic as Image;
use App\Modules\Dashboard\Rules\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class App extends Controller{

    public function index(){
        $data = null;
        if (Cookie::get('search_app') == "") {
            // if cookie not existed
            $data = App_Model::orderBy('id', 'desc')->paginate(15);
        } else {
            // if cookie is existed
            $data = App_Model::where("name", "like", '%' . Cookie::get('search_app') . '%')->orderBy('id', 'desc')->paginate(15);
        }
        $data->setPath('app');
        $row = json_decode(json_encode([
            "title" => "App - Danh sách",
        ]));

        return view("Dashboard::app.index", compact("row", "data"));
    }

    public function postIndex(Request $request) {
        if (isset($_POST["btn_search"])) {
            Cookie::queue("search_app", $request->search, 60);
            return redirect()->route("admin.app")->with(["type" => "success", "flash_message" => "Tìm kiếm : " . $request->search]);
        }
    }

    public function add() {
        if (!Gate::allows('add', explode("\\", get_class())[4])) {
            abort(403);
        }
        $settings = config('global.settings');
        $row = json_decode(json_encode([
            "title" => "App - Thêm",
            "desc" => "Thêm mới",
        ]));
        return view("Dashboard::app.add", compact("row", "settings"));
    }

    public function postAdd(Request $request){
        $settings = config('global.settings');
        $this->validate($request, ["name" => "required"], ["name.required" => "Vui lòng nhập họ tên"]);
        $app = new App_Model;
        $app->name = $request->name;
        $app->status = $request->status;
        // if ($request->hasFile('photo')) {
        //     $file = $request->photo;
        //     $file_name = Str::slug($file->getClientOriginalName(), "-") . "-" . time() . "." . $file->getClientOriginalExtension();
        //     //resize file befor to upload large
        //     if ($file->getClientOriginalExtension() != "svg") {
        //         $image_resize = Image::make($file->getRealPath());
        //         $thumb_size = json_decode($settings["THUMB_SIZE_ADMIN"]);
        //         $image_resize->fit($thumb_size->width, $thumb_size->height);
        //         $image_resize->save('public/upload/images/admins/thumb/' . $file_name);
        //     }
        //     // close upload image
        //     $file->move("public/upload/images/admins/large", $file_name);
        //     //save database
        //     $app->photo = $file_name;
        // }
        if ($app->save()) {
            return back()->with(["type" => "success", "flash_message" => "Thêm thành công!"]);
        } else {
            return back()->withInput()->with(["type" => "danger", "flash_message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
        }
    }

    public function edit($id = 0) {
        if (!Gate::allows('edit', explode("\\", get_class())[4])) {
            abort(403);
        }
        $settings = config('global.settings');
        // $list_category = BlogCategory_Model::whereIn("status", [0, 1])->orderBy('id', 'desc')->get();
        $data = App_Model::find($id);
        $row = json_decode(json_encode([
            "title" => "App - Cập nhật",
            "desc" => "Cập nhật",
        ]));
        // return view("Dashboard::blog.edit", compact("row", "data", "list_category", "settings"));
        return view("Dashboard::app.edit", compact("row", "data", "settings"));
    }

    public function postEdit(Request $request, $id = 0) {
        $settings = config('global.settings');
        $this->validate($request, ["name" => "required" ], ["name.required" => "Vui lòng nhập họ tên"]);

        $app = App_Model::find($id);
        $app->name = $request->name;
        $app->status = $request->status;

        // if ($request->hasFile('photo')) {
        //     //delete if exist
        //     $image = str_replace("\\", "/", base_path()) . '/public/upload/images/admins/large/' . $app->photo;
        //     if (file_exists($image)) {
        //         File::delete($image);
        //     }
        //     $image_thumb = str_replace("\\", "/", base_path()) . '/public/upload/images/admins/thumb/' . $app->photo;
        //     if (file_exists($image_thumb)) {
        //         File::delete($image_thumb);
        //     }

        //     $file = $request->photo;
        //     $file_name = Str::slug(explode(".", $file->getClientOriginalName())[0], "-") . "-" . time() . "." . $file->getClientOriginalExtension();

        //     //resize file befor to upload large
        //     if ($file->getClientOriginalExtension() != "svg") {
        //         $image_resize = Image::make($file->getRealPath());

        //         $thumb_size = json_decode($settings["THUMB_SIZE_ADMIN"]);
        //         $image_resize->fit($thumb_size->width, $thumb_size->height);

        //         $image_resize->save('public/upload/images/admins/thumb/' . $file_name);
        //     }

        //     $file->move("public/upload/images/admins/large", $file_name);
        //     $app->photo = $file_name;
        // }
        if ($app->save()) {
            return back()->with(["type" => "success", "flash_message" => "Cập nhật thành công!"]);
        } else {
            return back()->withInput()->with(["type" => "danger", "flash_message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
        }
    }

    public function status($id = 0, $status = 0) {
        $app = App_Model::find($id);
        $app->status = $status;
        if ($app->save()) {
            return redirect()->route("admin.app")->with(["type" => "success", "flash_message" => "Cập nhật thành công!"]);
        } else {
            return back()->withInput()->with(["type" => "danger", "flash_message" => "Không có dữ liệu nào được cập nhật"]);
        }
    }
    public function delete($id = "") {
        if (!Gate::allows('delete', explode("\\", get_class())[4])) {
            abort(403);
        }
        $list_id = json_decode($id);
        //var_dump($list_id);
        //die();
        if (!isset($list_id[0]->id)) {
            return back()->withInput()->with(["type" => "danger", "flash_message" => "Không có dữ liệu để xóa."]);
        }
        if (count($list_id) == 1 && isset($list_id[0]->id)) {
            $app = App_Model::find($list_id[0]->id);
            $app->status = 2; //2 is trash
            if ($app->save()) {
                return redirect()->route("admin.app")->with(["type" => "success", "flash_message" => "Đã di chuyển vào thùng rác!"]);
            } else {
                return back()->withInput()->with(["type" => "danger", "flash_message" => "Đã xảy ra lỗi, vui lòng thử lại."]);
            }
        } else {
            foreach ($list_id as $key => $value) {
                $app = App_Model::find($value->id);
                $app->status = 2; //2 is trash
                $app->save();
            }
            return redirect()->route("admin.app")->with(["type" => "success", "flash_message" => "Đã di chuyển vào thùng rác!"]);
        }
    }
    public function trash() {
        if (!Gate::allows('delete', explode("\\", get_class())[4])) {
            abort(403);
        }
        $data = App_Model::where("status", 2)->orderBy('id', 'desc')->paginate(15);
        $data->setPath('trash');
        $row = json_decode(json_encode([
            "title" => "Thùng rác - App",
        ]));
        return view("Dashboard::app.trash", compact("row", "data"));
    }

    public function trashDelete($id = "") {
        //delete image first
        $list_id = json_decode($id);
        //xoa mot
        if (count($list_id) == 1) {
            $data = App_Model::where("id", $list_id[0]->id)->first();
            // $image_large = str_replace("\\", "/", base_path()) . '/public/upload/images/admins/large/' . $data->photo;
            // $image_thumb = str_replace("\\", "/", base_path()) . '/public/upload/images/admins/thumb/' . $data->photo;
            // if (file_exists($image_large)) {
            //     File::delete($image_large);
            // }
            // if (file_exists($image_thumb)) {
            //     File::delete($image_thumb);
            // }
            $slide = App_Model::find($list_id[0]->id);
            if ($slide->delete()) {
                return back()->with(["type" => "success", "flash_message" => "Xóa thành công!"]);
            } else {
                return back()->with(["type" => "danger", "flash_message" => "Không có dữ liệu nào được xóa!"]);
            }
        }
    }
}