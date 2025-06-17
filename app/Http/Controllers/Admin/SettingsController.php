<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingsStoreOrUpdateRequest;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SettingsController extends Controller
{
    public function index() {
        $data = GeneralSettings::where('id', 1)->first();
        $pageTitle = "general settings";
        $breadcrumbs = [
            ['url' => route('admin.settings.index'), 'title' => 'settings'],
            ['url' => route('admin.settings.index'), 'title' => 'general settings'],
        ];
        return view('admin.settings.general_settings', compact('data', 'pageTitle', 'breadcrumbs'));
    }



    public function storeOrUpdate(SettingsStoreOrUpdateRequest $request)
    {
        try {
            $data = GeneralSettings::first();
            if (!$data) {
                $data = new GeneralSettings();
            }
            $status = '';
            // Handle logo uploads
            if ($request->hasFile('logo')) {
                if($data->site_logo != null){
                    $old_img = public_path($data->site_logo);
                    if (file_exists($old_img)) {
                        unlink($old_img);
                    }
                }
                $manager = new ImageManager(new Driver());
                $image = $manager->read($request->file('logo'));
                $assign_name = "logo-".date('his').".".$request->file('logo')->getClientOriginalExtension();
                $image->resize(193, 44);
                $image->save(base_path('public/uploads/settings/'.$assign_name, 80, 'png'));
                $logoPath = '/uploads/settings/'.$assign_name;
                $data->site_logo = $logoPath;
                $status = 'logo';
            }

            // Handle favicon uploads
            if ($request->hasFile('favicon')) {
                if($data->favicon != null){
                    $old_img2 = public_path($data->favicon);
                    if (file_exists($old_img2)) {
                        unlink($old_img2);
                    }
                }
                $manager2 = new ImageManager(new Driver());
                $image2 = $manager2->read($request->file('favicon'));
                $assign_name2 = "favicon-".date('his').".".$request->file('favicon')->getClientOriginalExtension();
                $image2->resize(64, 64);
                $image2->save(base_path('public/uploads/settings/'.$assign_name2, 80, 'png'));
                $faviconPath = '/uploads/settings/'.$assign_name2;
                $data->favicon = $faviconPath;
                $status = 'favicon';
            }

            // Handle introduction_image uploads
            if ($request->hasFile('admin_logo')) {
                if($data->admin_logo != null){
                    $old_img3 = public_path($data->admin_logo);
                    if (file_exists($old_img3)) {
                        unlink($old_img3);
                    }
                }
                $manager3 = new ImageManager(new Driver());
                $image3 = $manager3->read($request->file('admin_logo'));
                $assign_name3 = "admin_logo-".date('his').".".$request->file('admin_logo')->getClientOriginalExtension();
                $image3->resize(200, 200);
                $image3->save(base_path('public/uploads/settings/'.$assign_name3, 80, 'png'));
                $adminImagePath = '/uploads/settings/'.$assign_name3;
                $data->admin_logo = $adminImagePath;
                $status = 'admin_logo';
            }

            // Handle formal_image uploads
            if ($request->hasFile('meta_image')) {
                if($data->meta_image != null){
                    $old_img4 = public_path($data->meta_image);
                    if (file_exists($old_img4)) {
                        unlink($old_img4);
                    }
                }
                $manager4 = new ImageManager(new Driver());
                $image4 = $manager4->read($request->file('meta_image'));
                $assign_name4 = "meta_image-".date('his').".".$request->file('meta_image')->getClientOriginalExtension();
                // $image4->resize(460, 288);
                $image4->save(base_path('public/uploads/settings/'.$assign_name4, 80, 'png'));
                $metaImagePath = '/uploads/settings/'.$assign_name4;
                $data->meta_image = $metaImagePath;
                $status = 'meta_image';
            }

            // Update other fields

            $fields = [
                'company_name'  => 'company_name',
                'company_motto' => 'company_motto',
                'phone_number'  => 'phone',
                'email'         => 'email',
                'address'       => 'address',
                'delivery_partner'       => 'delivery_partner',
                'map'           => 'map',
                'timezone'      => 'timezone',
                'system_name'   => 'system_name',
                'site_title'    => 'site_title',
                'copyright'     => 'copyright',
                'meta_description' => 'meta_description',
                'meta_keywords' => 'meta_keywords',
                'about_company' => 'about_company',
            ];

            foreach ($fields as $requestField => $modelField) {
                if ($request->has($requestField)) {
                    $data->$modelField = $request->input($requestField); // Save only non-null values
                }
            }

            $data->save();

            return response()->json([$data, $status]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function removeImage(Request $request)
    {
        // Validate the request
        $request->validate([
            'image_type' => 'required|string|in:site_logo,favicon,admin_logo,meta_image',
        ]);

        // Get the GeneralSettings
        $data = GeneralSettings::first();
        if (!$data) {
            return response()->json(['message' => 'No data found.'], 404);
        }

        // Determine which image to remove based on the input
        $imageType = $request->input('image_type');
        $imagePath = $data->$imageType; // e.g., $data->logo

        // Check if the image exists and delete it
        if ($imagePath) {
            $fullPath = public_path($imagePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            // Remove the image path from the database
            $data->$imageType = null;
            $data->save();

            return response()->json(['message' => ucfirst(str_replace('_', ' ', $imageType)) . ' removed successfully.']);
        }

        return response()->json(['message' => ucfirst(str_replace('_', ' ', $imageType)) . ' not found.'], 404);
    }
}


