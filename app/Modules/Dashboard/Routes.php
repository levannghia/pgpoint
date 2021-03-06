<?php
//Dashboard routes
use Illuminate\Support\Facades\Route;

Route::group(['module' => 'dashboard', 'middleware' => 'web', 'namespace' => "App\Modules\Dashboard\Controllers"], function () {

    Route::get("error/login.html", ["as" => "login", "uses" => "Errorcode@index"]);

    Route::group(["prefix" => "dashboard"], function () {
        //login
        Route::get("login", ["as" => "admin.login", "uses" => "Authentication@login"]);
        Route::post("login", ["as" => "admin.login_request", "uses" => "Authentication@login_request"]);
        Route::get("logout", ["as" => "admin.logout", "uses" => "Authentication@logout"]);
        Route::get("create", ["as" => "admin.create", "uses" => "Authentication@create"]);

        Route::group(['middleware' => ['auth:admin']], function () {
            Route::get("/access", ["as" => "RolePermission.access", "uses" => "RolePermission@access"]);
            //Dashboard
            Route::get("/", ["as" => "admin.dashboard.index", "uses" => "Dashboard@index"]);

            Route::group(["prefix" => "rules"], function () {
                Route::get("/", ["as" => "admin.rules", "uses" => "Rules@index"]);
                Route::get("add", ["as" => "admin.rules.add", "uses" => "Rules@add"]);
                Route::post("add", ["as" => "admin.rules.add", "uses" => "Rules@postAdd"]);
                Route::get("edit", ["as" => "admin.rules.edit", "uses" => "Rules@edit"]);
                Route::post("edit", ["as" => "admin.rules.eidt", "uses" => "Rules@postEdit"]);
            });

            //users
            Route::group(["prefix" => "users"], function () {
                Route::get("/", ["as" => "admin.users", "uses" => "Users@index"]);
                Route::post("/", ["as" => "admin.users", "uses" => "Users@postIndex"]);
                // Route::get("add", ["as" => "admin.getAdd", "uses" => "Users@add"]);
                // Route::post("add", ["as" => "admin.postAdd", "uses" => "Users@postAdd"]);
                // Route::get("edit", ["as" => "admin.users.Edit", "uses" => "Users@edit"]);
                // Route::post("edit", ["as" => "admin.users.Eidt", "uses" => "Users@postEdit"]);
                // Route::get("edit/{id}", ["as" => "admin.users.edit", "uses" => "Users@edit"]);
                // Route::post("edit/{id}", ["as" => "admin.users.postEdit", "uses" => "Users@postEdit"]);
                // Route::get("delete/{id}", ["as" => "admin.users.delete", "uses" => "Users@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.users.status", "uses" => "Users@status"]);
                // Route::get("status-role/{id}/{status}", ["as" => "admin.users.role.status", "uses" => "Users@statusRole"]);
            });

            //admin
            Route::group(["prefix" => "admin"], function () {
                Route::get("/", ["as" => "admin.admins", "uses" => "Admins@index"]);
                Route::post("/", ["as" => "admin.admins", "uses" => "Admins@postIndex"]);
                Route::get("add", ["as" => "admin.admins.getAdd", "uses" => "Admins@add"]);
                Route::post("add", ["as" => "admin.admins.postAdd", "uses" => "Admins@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.admins.edit", "uses" => "Admins@edit"]);
                Route::post("edit/{id}", ["as" => "admin.admins.postEdit", "uses" => "Admins@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.admins.delete", "uses" => "Admins@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.admins.status", "uses" => "Admins@status"]);
                Route::get("/trash", ["as" => "admin.admins.trash", "uses" => "Admins@trash"]);
                Route::get("/trash/delete/{id}", ["as" => "admin.admins.trash", "uses" => "Admins@trashDelete"]);
            });
            //App
            Route::group(["prefix" => "app"], function () {
                Route::get("/", ["as" => "admin.app", "uses" => "App@index"]);
                Route::post("/", ["as" => "admin.app", "uses" => "App@postIndex"]);
                Route::get("add", ["as" => "admin.app.getAdd", "uses" => "App@add"]);
                Route::post("add", ["as" => "admin.app.postAdd", "uses" => "App@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.app.edit", "uses" => "App@edit"]);
                Route::post("edit/{id}", ["as" => "admin.app.postEdit", "uses" => "App@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.app.delete", "uses" => "App@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.app.status", "uses" => "App@status"]);
                Route::get("/trash", ["as" => "admin.app.trash", "uses" => "App@trash"]);
                Route::get("/trash/delete/{id}", ["as" => "admin.app.trash", "uses" => "App@trashDelete"]);
            });

            //Transaction
            Route::group(["prefix" => "transaction"], function () {
                Route::get("/", ["as" => "admin.transaction", "uses" => "TransactionHistory@index"]);
                Route::post("/", ["as" => "admin.transaction", "uses" => "TransactionHistory@postIndex"]);
                Route::get("add", ["as" => "admin.transaction.getAdd", "uses" => "TransactionHistory@add"]);
                Route::post("add", ["as" => "admin.transaction.postAdd", "uses" => "TransactionHistory@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.transaction.edit", "uses" => "TransactionHistory@edit"]);
                Route::post("edit/{id}", ["as" => "admin.transaction.postEdit", "uses" => "TransactionHistory@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.transaction.delete", "uses" => "TransactionHistory@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.transaction.status", "uses" => "TransactionHistory@status"]);
                Route::get("/trash", ["as" => "admin.transaction.trash", "uses" => "TransactionHistory@trash"]);
                Route::get("/trash/delete/{id}", ["as" => "admin.transaction.trash", "uses" => "TransactionHistory@trashDelete"]);
            });
            
            //Role
            Route::group(["prefix" => "role"], function () {
                Route::get("/", ["as" => "admin.role", "uses" => "Role@index"]);
                Route::post("/", ["as" => "admin.role", "uses" => "Role@postIndex"]);
                Route::get("add", ["as" => "admin.role.getAdd", "uses" => "Role@add"]);
                Route::post("add", ["as" => "admin.role.postAdd", "uses" => "Role@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.role.edit", "uses" => "Role@edit"]);
                Route::post("edit/{id}", ["as" => "admin.role.postEdit", "uses" => "Role@postEdit"]);
            });

            //RolePermission
            Route::group(["prefix" => "role-permission"], function () {
                Route::get("/{id}", ["as" => "admin.rolePermission", "uses" => "RolePermission@index"]);
                //Route::post("/", ["as" => "admin.rolePermission", "uses" => "RolePermission@postIndex"]);
                Route::post("add/{id}", ["as" => "admin.rolePermission.postAdd", "uses" => "RolePermission@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.rolePermission.edit", "uses" => "RolePermission@edit"]);
                Route::get("role-detail/{id}", ["as" => "admin.rolePermission.show", "uses" => "RolePermission@role_detail"]);
                Route::post("edit/{id}", ["as" => "admin.rolePermission.postEdit", "uses" => "RolePermission@postEdit"]);
                Route::get("delete/{id}/{deletes}", ["as" => "admin.rolePermission.delete", "uses" => "RolePermission@role_permission_delete"]);
                Route::get("view/{id}/{views}", ["as" => "admin.rolePermission.view", "uses" => "RolePermission@role_permission_view"]);
                Route::get("add/{id}/{adds}", ["as" => "admin.rolePermission.add", "uses" => "RolePermission@role_permission_add"]);
                Route::get("edit/{id}/{edits}", ["as" => "admin.rolePermission.edit", "uses" => "RolePermission@role_permission_edit"]);
            });

            //profile
            Route::get("myaccount", ["as" => "admin.myaccount", "uses" => "MyAccount@index"]);
            Route::get("change-password", ["as" => "admin.change_password", "uses" => "MyAccount@change_password"]);
            Route::post("change-password", ["as" => "admin.change_password_request", "uses" => "MyAccount@change_password_request"]);
            Route::post("myaccount", ["as" => "admin.myaccount.update", "uses" => "MyAccount@update"]);

            //slide
            Route::group(["prefix" => "slide"], function () {
                Route::get("/", ["as" => "admin.slide", "uses" => "Slide@index"]);
                //Route::post("/", ["as" => "admin.slide", "uses" => "Configuration@postSetting"]);
                Route::get("add", ["as" => "admin.slide.add", "uses" => "Slide@add"]);
                Route::post("add", ["as" => "admin.slide.postAdd", "uses" => "Slide@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.slide.edit", "uses" => "Slide@edit"]);
                Route::post("edit/{id}", ["as" => "admin.slide.postEdit", "uses" => "Slide@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.slide.delete", "uses" => "Slide@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.slide.status", "uses" => "Slide@status"]);
                Route::get("/trash", ["as" => "admin.slide.trash", "uses" => "Slide@trash"]);
                Route::get("/trash/delete/{id}", ["as" => "admin.slide.trash", "uses" => "Slide@trashDelete"]);
            });

            //blog
            Route::group(["prefix" => "blog"], function () {
                Route::get("/", ["as" => "admin.blog", "uses" => "Blog@index"]);
                Route::post("/", ["as" => "admin.blog", "uses" => "Blog@postIndex"]);
                Route::get("add", ["as" => "admin.blog.add", "uses" => "Blog@add"]);
                Route::post("add", ["as" => "admin.blog.postAdd", "uses" => "Blog@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.blog.edit", "uses" => "Blog@edit"]);
                Route::post("edit/{id}", ["as" => "admin.blog.postEdit", "uses" => "Blog@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.blog.delete", "uses" => "Blog@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.blog.status", "uses" => "Blog@status"]);
                Route::get("/trash", ["as" => "admin.blog.trash", "uses" => "Blog@trash"]);
                Route::get("/trash/delete/{id}", ["as" => "admin.blog.trash", "uses" => "Blog@trashDelete"]);
            });

            //Service
            Route::group(["prefix" => "service"], function () {
                Route::get("/", ["as" => "admin.service", "uses" => "Service@index"]);
                Route::post("/", ["as" => "admin.service", "uses" => "Service@postIndex"]);
                Route::get("add", ["as" => "admin.service.add", "uses" => "Service@add"]);
                Route::post("add", ["as" => "admin.service.postAdd", "uses" => "Service@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.service.edit", "uses" => "Service@edit"]);
                Route::post("edit/{id}", ["as" => "admin.service.postEdit", "uses" => "Service@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.service.delete", "uses" => "Service@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.service.status", "uses" => "Service@status"]);
                Route::get("/trash", ["as" => "admin.service.trash", "uses" => "Service@trash"]);
                Route::get("/trash/delete/{id}", ["as" => "admin.service.trash", "uses" => "Service@trashDelete"]);
            });

            //Project
            Route::group(["prefix" => "project"], function () {
                Route::get("/", ["as" => "admin.project", "uses" => "Project@index"]);
                Route::post("/", ["as" => "admin.project", "uses" => "Project@postIndex"]);
                Route::get("add", ["as" => "admin.project.add", "uses" => "Project@add"]);
                Route::post("add", ["as" => "admin.project.postAdd", "uses" => "Project@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.project.edit", "uses" => "Project@edit"]);
                Route::post("edit/{id}", ["as" => "admin.project.postEdit", "uses" => "Project@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.project.delete", "uses" => "Project@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.project.status", "uses" => "Project@status"]);
                Route::get("/trash", ["as" => "admin.project.trash", "uses" => "Project@trash"]);
                Route::get("/trash/delete/{id}", ["as" => "admin.project.trash", "uses" => "Project@trashDelete"]);
            });

            //Brand
            Route::group(["prefix" => "brand"], function () {
                Route::get("/", ["as" => "admin.brand", "uses" => "Brand@index"]);
                Route::post("/", ["as" => "admin.brand", "uses" => "Brand@postIndex"]);
                Route::get("add", ["as" => "admin.brand.add", "uses" => "Brand@add"]);
                Route::post("add", ["as" => "admin.brand.postAdd", "uses" => "Brand@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.brand.edit", "uses" => "Brand@edit"]);
                Route::post("edit/{id}", ["as" => "admin.brand.postEdit", "uses" => "Brand@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.brand.delete", "uses" => "Brand@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.brand.status", "uses" => "Brand@status"]);
                Route::get("/trash", ["as" => "admin.brand.trash", "uses" => "Brand@trash"]);
                Route::get("/trash/delete/{id}", ["as" => "admin.brand.trash", "uses" => "Brand@trashDelete"]);
            });

            //Contact
            Route::group(["prefix" => "contact"], function () {
                Route::get("/", ["as" => "admin.contact", "uses" => "Contact@index"]);
                Route::post("/", ["as" => "admin.contact", "uses" => "Contact@postIndex"]);
                Route::get("add", ["as" => "admin.contact.add", "uses" => "Contact@add"]);
                Route::post("add", ["as" => "admin.contact.postAdd", "uses" => "Contact@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.contact.edit", "uses" => "Contact@edit"]);
                Route::post("edit/{id}", ["as" => "admin.contact.postEdit", "uses" => "Contact@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.contact.delete", "uses" => "Contact@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.contact.status", "uses" => "Contact@status"]);
                Route::get("/trash", ["as" => "admin.contact.trash", "uses" => "Contact@trash"]);
                Route::get("/trash/delete/{id}", ["as" => "admin.contact.trash", "uses" => "Contact@trashDelete"]);
            });

            //blog category
            Route::group(["prefix" => "blog-category"], function () {
                Route::get("/", ["as" => "admin.blog_category", "uses" => "BlogCategory@index"]);
                Route::post("/", ["as" => "admin.blog_category", "uses" => "BlogCategory@postSetting"]);
                Route::get("add", ["as" => "admin.blog_category.add", "uses" => "BlogCategory@add"]);
                Route::post("add", ["as" => "admin.blog_category.postAdd", "uses" => "BlogCategory@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.blog_category.edit", "uses" => "BlogCategory@edit"]);
                Route::post("edit/{id}", ["as" => "admin.blog_category.postEdit", "uses" => "BlogCategory@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.blog_category.delete", "uses" => "BlogCategory@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.blog_category.status", "uses" => "BlogCategory@status"]);
            });

            //product
            Route::group(["prefix" => "product"], function () {
                Route::get("/", ["as" => "admin.product", "uses" => "Product@index"]);
                Route::post("/", ["as" => "admin.product", "uses" => "Product@postIndex"]);
                Route::get("add", ["as" => "admin.product.add", "uses" => "Product@add"]);
                Route::post("add", ["as" => "admin.product.postAdd", "uses" => "Product@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.product.edit", "uses" => "Product@edit"]);
                Route::post("edit/{id}", ["as" => "admin.product.postEdit", "uses" => "Product@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.product.delete", "uses" => "Product@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.product.status", "uses" => "Product@status"]);

                Route::post("addphoto", ["as" => "admin.product.postAddPhoto", "uses" => "Product@postAddPhoto"]);
                Route::post("editphoto", ["as" => "admin.product.postEditPhoto", "uses" => "Product@postEditPhoto"]);

                Route::get("delete/photo/{id}", ["as" => "admin.product.photo.delete", "uses" => "Product@deletePhoto"]);
                Route::get("status/photo/{id}/{status}", ["as" => "admin.product.photo.status", "uses" => "Product@statusPhoto"]);

                Route::get("/trash", ["as" => "admin.product.trash", "uses" => "Product@trash"]);
                Route::get("/trash/delete/{id}", ["as" => "admin.product.trash", "uses" => "Product@trashDelete"]);
            });

            //Product category
            Route::group(["prefix" => "product-category"], function () {
                Route::get("/", ["as" => "admin.product_category", "uses" => "ProductCategory@index"]);
                Route::post("/", ["as" => "admin.product_category", "uses" => "ProductCategory@postSetting"]);
                Route::get("add", ["as" => "admin.product_category.add", "uses" => "ProductCategory@add"]);
                Route::post("add", ["as" => "admin.product_category.postAdd", "uses" => "ProductCategory@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.product_category.edit", "uses" => "ProductCategory@edit"]);
                Route::post("edit/{id}", ["as" => "admin.product_category.postEdit", "uses" => "ProductCategory@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.product_category.delete", "uses" => "ProductCategory@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.product_category.status", "uses" => "ProductCategory@status"]);
            });


            //region - khu vuc
            Route::group(["prefix" => "region"], function () {
                Route::get("/", ["as" => "admin.region", "uses" => "Region@index"]);
                Route::post("/", ["as" => "admin.region", "uses" => "Region@postSetting"]);
                Route::get("add", ["as" => "admin.region.add", "uses" => "Region@add"]);
                Route::post("add", ["as" => "admin.region.postAdd", "uses" => "Region@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.region.edit", "uses" => "Region@edit"]);
                Route::post("edit/{id}", ["as" => "admin.region.postEdit", "uses" => "Region@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.region.delete", "uses" => "Region@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.region.status", "uses" => "Region@status"]);
            });

            //orders - don hang
            Route::group(["prefix" => "orders"], function () {
                Route::get("/", ["as" => "admin.orders", "uses" => "Orders@index"]);
                Route::post("/", ["as" => "admin.orders", "uses" => "Orders@postSetting"]);
                Route::get("add", ["as" => "admin.orders.add", "uses" => "Orders@add"]);
                Route::post("add", ["as" => "admin.orders.postAdd", "uses" => "Orders@postAdd"]);
                Route::get("edit/{id}", ["as" => "admin.orders.edit", "uses" => "Orders@edit"]);
                Route::post("edit/{id}", ["as" => "admin.orders.postEdit", "uses" => "Orders@postEdit"]);
                Route::get("delete/{id}", ["as" => "admin.orders.delete", "uses" => "Orders@delete"]);
                Route::get("status/{id}/{status}", ["as" => "admin.orders.status", "uses" => "Orders@status"]);
            });

            //config
            Route::group(["prefix" => "config"], function () {
                Route::get("/", ["as" => "admin.config", "uses" => "Config@setting"]);
                Route::post("/", ["as" => "admin.config", "uses" => "Config@postSetting"]);
                // Route::get("seo", ["as" => "admin.config.seo", "uses" => "Config@seo"]);
                // Route::post("seo", ["as" => "admin.config.postSeo", "uses" => "Config@postSeo"]);
                // Route::get("social", ["as" => "admin.config.social", "uses" => "Config@social"]);
                // Route::post("social", ["as" => "admin.config.postSocial", "uses" => "Config@postSocial"]);
            });
            //config home section 1
            Route::group(["prefix" => "home-section-1"], function () {
                Route::get("/", ["as" => "admin.home.section1", "uses" => "Home@section1"]);
                Route::post("/", ["as" => "admin.home.section1", "uses" => "Home@postSection1"]);
            });

            //config home section 2
            Route::group(["prefix" => "home-section-2"], function () {
                Route::get("/", ["as" => "admin.home.section2", "uses" => "Home@section2"]);
                Route::post("/", ["as" => "admin.home.section2", "uses" => "Home@postSection2"]);
            });

            //config home section 3
            Route::group(["prefix" => "home-section-3"], function () {
                Route::get("/", ["as" => "admin.home.section3", "uses" => "Home@section3"]);
                Route::post("/", ["as" => "admin.home.section3", "uses" => "Home@postSection3"]);
            });

            //setting
            Route::group(["prefix" => "setting"], function () {
                Route::get("/thumb", ["as" => "admin.setting.thumb", "uses" => "Setting@thumb"]);
                Route::post("/thumb", ["as" => "admin.setting.thumb", "uses" => "Setting@postThumb"]);

                Route::get("seo", ["as" => "admin.setting.seo", "uses" => "Configuration@seo"]);
                Route::post("seo", ["as" => "admin.setting.postSeo", "uses" => "Configuration@postSeo"]);
                Route::get("social", ["as" => "admin.setting.social", "uses" => "Configuration@social"]);
                Route::post("social", ["as" => "admin.setting.postSocial", "uses" => "Configuration@postSocial"]);
            });
        });
    });
});
