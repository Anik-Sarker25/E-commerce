<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdsStoreRequest;
use App\Models\AdvertiseBanner;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PageSettingsController extends Controller
{
    public function index() {
        $social = SocialMedia::where('id', 1)->first();
        $pageTitle = "Page settings";
        $breadcrumbs = [
            ['url' => route('admin.settings.pages.index'), 'title' => 'settings'],
            ['url' => route('admin.settings.pages.index'), 'title' => 'page settings'],
        ];
        return view('admin.settings.page_settings', compact('social', 'pageTitle', 'breadcrumbs'));
    }

    public function banners($type) {
        $banners = AdvertiseBanner::where('banner_type', $type)->get();
        return response()->json($banners);
    }
    public function storeHomepageBanner(Request $request){
        $request->validate([
            'home_banner' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        ]);
        // Handle banner_1 uploads
        if ($request->hasFile('home_banner')) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('home_banner'));
            $assign_name = "home_banner-".date('his').".".$request->file('home_banner')->getClientOriginalExtension();
            $image->resize(666, 453);
            $image->save(base_path('public/uploads/banner/'.$assign_name, 80, 'png'));
            $homeBannerPath = '/uploads/banner/'.$assign_name;
        }
        $data = AdvertiseBanner::create([
            'image' => $homeBannerPath,
            'banner_type' => Constant::BANNER_TYPE['home_banner'],
        ]);

        return response()->json([$data, $data->id, $data->image]);
    }

    public function storeAdsBanner1(Request $request){
        $data = AdvertiseBanner::find($request->up_id);
        if($data) {
            $image_rule = $request->hasFile('banner_1') ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'] : ['nullable'];
            $request->validate([
                'url_1' => ['nullable','url','max:2048'],
                'banner_1' => $image_rule,
            ]);
            $status = 'updated';
        } else {
            $data = new AdvertiseBanner();
            $request->validate([
                'url_1' => ['nullable','url','max:2048'],
                'banner_1' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
            ]);
            $status = 'created';
        }
        // Handle banner_1 uploads
        if ($request->hasFile('banner_1')) {
            if($data) {
                if($data->image != null){
                    $old_img = public_path($data->image);
                    if (file_exists($old_img)) {
                        unlink($old_img);
                    }
                }
            }
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('banner_1'));
            $assign_name = "banner_1-".date('his').".".$request->file('banner_1')->getClientOriginalExtension();
            $image->resize(584, 65);
            $image->save(base_path('public/uploads/banner/'.$assign_name, 80, 'png'));
            $banner1Path = '/uploads/banner/'.$assign_name;
            $image_status = 'created';
        } else {
            $banner1Path = $data->image;
            $image_status = 'updated';
        }

        $data->url = $request->url_1;
        $data->image = $banner1Path;
        $data->banner_type = Constant::BANNER_TYPE['ads_banner1'];
        $data->save();

        return response()->json([$data, $data->id, $data->image, $status, $image_status]);
    }

    public function storeAdsBanner2(Request $request) {
        $data = AdvertiseBanner::find($request->up_id);

        if($data) {
            $image_rule = $request->hasFile('banner_2') ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'] : ['nullable'];
            $request->validate([
                'url_2' => ['nullable','url','max:2048'],
                'banner_2' => $image_rule,
            ]);
            $status = 'updated';
        } else {
            $data = new AdvertiseBanner();
            $request->validate([
                'url_2' => ['nullable','url','max:2048'],
                'banner_2' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
            ]);
            $status = 'created';
        }

        // Handle banner_2 uploads
        if ($request->hasFile('banner_2')) {
            if($data) {
                if($data->image != null){
                    $old_img = public_path($data->image);
                    if (file_exists($old_img)) {
                        unlink($old_img);
                    }
                }
            }
            $manager2 = new ImageManager(new Driver());
            $image2 = $manager2->read($request->file('banner_2'));
            $assign_name2 = "banner_2-".date('his').".".$request->file('banner_2')->getClientOriginalExtension();
            $image2->resize(584, 65);
            $image2->save(base_path('public/uploads/banner/'.$assign_name2, 80, 'png'));
            $banner2Path = '/uploads/banner/'.$assign_name2;
            $image_status = 'created';
        } else {
            $banner2Path = $data->image;
            $image_status = 'updated';
        }

        $data->url = $request->url_2;
        $data->image = $banner2Path;
        $data->banner_type = Constant::BANNER_TYPE['ads_banner2'];
        $data->save();

        return response()->json([$data, $data->id, $data->image, $status, $image_status]);
    }

    public function storeAdsBanner3(Request $request) {
        $data = AdvertiseBanner::find($request->up_id);

        if($data) {
            $image_rule = $request->hasFile('banner_2') ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'] : ['nullable'];
            $request->validate([
                'url_3' => ['nullable','url','max:2048'],
                'banner_3' => $image_rule,
            ]);
            $status = 'updated';
        } else {
            $data = new AdvertiseBanner();
            $request->validate([
                'url_3' => ['nullable','url','max:2048'],
                'banner_3' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
            ]);
            $status = 'created';
        }

        // Handle banner_3 uploads
        if ($request->hasFile('banner_3')) {
            if($data) {
                if($data->image != null){
                    $old_img = public_path($data->image);
                    if (file_exists($old_img)) {
                        unlink($old_img);
                    }
                }
            }
            $manager3 = new ImageManager(new Driver());
            $image3 = $manager3->read($request->file('banner_3'));
            $assign_name3 = "banner_3-".date('his').".".$request->file('banner_3')->getClientOriginalExtension();
            $image3->resize(584, 65);
            $image3->save(base_path('public/uploads/banner/'.$assign_name3, 80, 'png'));
            $banner3Path = '/uploads/banner/'.$assign_name3;
            $image_status = 'created';
        } else {
            $banner3Path = $data->image;
            $image_status = 'updated';
        }
        $data->url = $request->url_3;
        $data->image = $banner3Path;
        $data->banner_type = Constant::BANNER_TYPE['ads_banner3'];
        $data->save();

        return response()->json([$data, $data->id, $data->image, $status, $image_status]);
    }

    public function storeAdsBanner4(Request $request) {
        $data = AdvertiseBanner::find($request->up_id);

        if($data) {
            $image_rule = $request->hasFile('banner_2') ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'] : ['nullable'];
            $request->validate([
                'url_4' => ['nullable','url','max:2048'],
                'banner_4' => $image_rule,
            ]);
            $status = 'updated';
        } else {
            $data = new AdvertiseBanner();
            $request->validate([
                'url_4' => ['nullable','url','max:2048'],
                'banner_4' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
            ]);
            $status = 'created';
        }

        // Handle formal_image uploads
        if ($request->hasFile('banner_4')) {
            if($data) {
                if($data->image != null){
                    $old_img = public_path($data->image);
                    if (file_exists($old_img)) {
                        unlink($old_img);
                    }
                }
            }
            $manager4 = new ImageManager(new Driver());
            $image4 = $manager4->read($request->file('banner_4'));
            $assign_name4 = "banner_4-".date('his').".".$request->file('banner_4')->getClientOriginalExtension();
            $image4->resize(570, 120);
            $image4->save(base_path('public/uploads/banner/'.$assign_name4, 80, 'png'));
            $banner4Path = '/uploads/banner/'.$assign_name4;
            $image_status = 'created';
        } else {
            $banner4Path = $data->image;
            $image_status = 'updated';
        }
        $data->url = $request->url_4;
        $data->image = $banner4Path;
        $data->banner_type = Constant::BANNER_TYPE['ads_banner4'];
        $data->save();

        return response()->json([$data, $data->id, $data->image, $status, $image_status]);
    }

    public function storeOrUpdateSocialMedia(Request $request)
    {
        $request->validate([
           'facebook' => 'nullable|url|max:255',
           'twitter' => 'nullable|url|max:255',
           'instagram' => 'nullable|url|max:255',
           'linkedin' => 'nullable|url|max:255',
           'youtube' => 'nullable|url|max:255',
           'tumblr' => 'nullable|url|max:255',
           'pinterest' => 'nullable|url|max:255',
           'discord' => 'nullable|url|max:255',
        ]);

        // Get the settings
        $data = SocialMedia::first();
        if (!$data) {
            $data = new SocialMedia();
        }

        // Update social media fields
        $socialFields = [
           'facebook' =>'facebook', // this are model fields
           'twitter' =>'twitter',
           'instagram' =>'instagram',
           'linkedin' =>'linkedin',
           'youtube' =>'youtube',
           'tumblr' =>'tumblr',
           'pinterest' =>'pinterest',
           'discord' =>'discord',
        ];
        foreach ($socialFields as $requestField => $modelField) {
            if ($request->has($requestField)) {
                $data->$modelField = $request->input($requestField); // Save only non-null values
            }
        }
        $data->user_id = auth()->user()->id;
        $data->save();

        return response()->json($data);
    }

    public function removeBanner($id) {
        try {
            $banner = AdvertiseBanner::findOrFail($id);

            if ($banner->image != null) {
                $old_img = public_path($banner->image);
                if (file_exists($old_img)) {
                    unlink($old_img);
                }
            }
            $banner->delete();
            return response()->json();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error removing banner: ' . $e->getMessage()], 500);
        }
    }

}
