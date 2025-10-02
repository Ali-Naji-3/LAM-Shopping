<?php

namespace App\Http\Controllers;

use App\Models\Setting;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //       $setting = Setting::first(); // أو أي طريقة تناسبك لجلب الإعدادات
    // return view('frontend.index-2', compact('setting'));
    // }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $setting = Setting::first();
        return view('admin.settings.edit', compact('setting'));
    }


    public function update(Request $request)
    {
        $setting = Setting::first() ?? new Setting();
        $section = $request->input('section');
        switch ($section) {
            case 'header':
                $menu = [];
                $labels = $request->menu_labels ?? [];
                $links = $request->menu_links ?? [];
                foreach ($labels as $key => $label) {
                    $menu[] = [
                        'label' => $label,
                        'link' => $links[$key] ?? ''
                    ];
                }
                $setting->menu_items = json_encode($menu);

                $setting->name = $request->name;
                $setting->phone = $request->phone;


                if ($request->hasFile('logo')) {
                    $setting->logo = $request->file('logo')->store('settings', 'public');
                }


                break;

            case 'hero':
                $setting->hero_title = $request->input('hero_title');
                $setting->hero_sub_title = $request->input('hero_sub_title');
                $setting->hero_button_text = $request->input('hero_button_text');

                if ($request->hasFile('hero_background')) {
                    $file = $request->file('hero_background');

                    $allowedExtensions = ['mp4', 'webm', 'ogg'];
                    $extension = strtolower($file->getClientOriginalExtension());

                    if (in_array($extension, $allowedExtensions)) {

                        if (!empty($setting->hero_background) && \Storage::disk('public')->exists($setting->hero_background)) {
                            \Storage::disk('public')->delete($setting->hero_background);
                        }

                        $path = $file->store('settings', 'public');
                        $setting->hero_background = $path;

                    } else {
                        return back()->with('error', 'Only mp4, webm, ogg videos are allowed.');
                    }
                }
                break;

            case 'content':
                $slidersData = [];

                if ($request->has('sliders')) {
                    foreach ($request->sliders as $index => $slider) {

                        if ($request->hasFile("sliders.$index.image")) {
                            $file = $request->file("sliders.$index.image");

                            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

                            $file->storeAs('public/sliders', $filename);
                            $imagePath = $filename;
                        } else {
                            $imagePath = $slider['image'] ?? null;
                        }

                        $slidersData[] = [
                            'image' => $imagePath,
                            'text' => $slider['text'] ?? '',
                            'link' => $slider['link'] ?? '',
                        ];
                    }

                    $setting->sliders = json_encode($slidersData, JSON_UNESCAPED_UNICODE);

                }
                break;
            case 'footer':
                if ($request->hasFile('footer_logo')) {
                    $setting->footer_logo = $request->file('footer_logo')->store('settings', 'public');
                }

                // Footer Links
                $footerLinks = [];
                $linksInput = $request->input('footer_links', []);
                foreach ($linksInput as $index => $link) {
                    $footerLinks[] = [
                        'title' => $link['title'] ?? '',
                        'url' => $link['url'] ?? '',
                    ];
                }
                $setting->footer_links = json_encode($footerLinks);

                // Footer Categories
                $footerCategories = [];
                $categoriesInput = $request->input('footer_categories', []);
                foreach ($categoriesInput as $index => $category) {
                    $footerCategories[] = [
                        'title' => $category['title'] ?? '',
                        'url' => $category['url'] ?? '',
                    ];
                }
                $setting->footer_categories = json_encode($footerCategories);

                $setting->contact_name = $request->contact_name;
                $setting->contact_phone = $request->contact_phone;
                $setting->contact_email = $request->contact_email;
                $setting->contact_address = $request->contact_address;
                $setting->footer_copyright = $request->footer_copyright;

                break;


            case 'other':
                $setting->language = $request->language;
                $setting->currency = $request->currency;
                $setting->payment_methods = $request->payment_methods;
                break;

            default:
                return back()->with('error', 'Invalid section.');
        }

        $setting->save();


        return redirect()->back()->with('success', ucfirst($section) . ' settings updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
