<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\UpoladFileTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GeneralSettingController extends Controller
{
    use UpoladFileTrait;

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Configure')], ['name' => __('locale.GeneralSettings')]];

        $generalSettings = Setting::whereIn('name', ['APP_NAME', 'APP_AUTHOR_EN', 'APP_AUTHOR_AR', 'APP_AUTHOR_ABBR_EN', 'APP_AUTHOR_ABBR_AR', 'APP_AUTHOR_WEBSITE', 'APP_OWNER_EN', 'APP_OWNER_AR', 'APP_LOGO', 'APP_FAVICON'])->pluck('value', 'name');

        return view('admin.content.configure.general_setting.edit', compact('breadcrumbs', 'generalSettings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'APP_NAME' => ['required', 'string'],
            'APP_AUTHOR_EN' => ['required', 'string'],
            'APP_AUTHOR_AR' => ['required', 'string'],
            'APP_AUTHOR_ABBR_EN' => ['required', 'string'],
            'APP_AUTHOR_ABBR_AR' => ['required', 'string'],
            'APP_AUTHOR_WEBSITE' => ['required', 'string'],
            'APP_OWNER_EN' => ['required', 'string'],
            'APP_OWNER_AR' => ['required', 'string'],
            'APP_LOGO' => ['nullable', 'file', 'image', 'max:1024'],
            'APP_FAVICON' => ['nullable', 'file', 'max:1024', 'mimes:ico'],
        ]);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('configure.ThereWasAProblemUpdatingTheAboutData') . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            try {
                Setting::where('name', 'APP_NAME')->update(
                    ['value' => $request->APP_NAME]
                );
                Setting::where('name', 'APP_AUTHOR_EN')->update(
                    ['value' => $request->APP_AUTHOR_EN]
                );
                Setting::where('name', 'APP_AUTHOR_AR')->update(
                    ['value' => $request->APP_AUTHOR_AR]
                );
                Setting::where('name', 'APP_AUTHOR_ABBR_EN')->update(
                    ['value' => $request->APP_AUTHOR_ABBR_EN]
                );
                Setting::where('name', 'APP_AUTHOR_ABBR_AR')->update(
                    ['value' => $request->APP_AUTHOR_ABBR_AR]
                );
                Setting::where('name', 'APP_AUTHOR_WEBSITE')->update(
                    ['value' => $request->APP_AUTHOR_WEBSITE]
                );
                Setting::where('name', 'APP_OWNER_EN')->update(
                    ['value' => $request->APP_OWNER_EN]
                );
                Setting::where('name', 'APP_OWNER_AR')->update(
                    ['value' => $request->APP_OWNER_AR]
                );

                if ($request->hasFile('APP_LOGO')) {
                    $logoName = '1666803246'; // logo file name on server (for default value)

                    if ('images/logo/' . $logoName . '.png' != getSystemSetting('APP_LOGO')) {
                        $filePath = $this->storeFile(
                            $request->file('APP_LOGO'),
                            'images/logo',
                            public_path() . '/' . getSystemSetting('APP_LOGO')
                        );
                    } else {
                        $filePath = $this->storeFile(
                            $request->file('APP_LOGO'),
                            'images/logo'
                        );
                    }

                    Setting::where('name', 'APP_LOGO')->update(
                        ['value' => $filePath]
                    );
                }

                if ($request->hasFile('APP_FAVICON')) {
                    $filePath = $this->storeFile(
                        $request->file('APP_FAVICON'),
                        'images/ico',
                        null,
                        'favicon'
                    );

                    // dd($filePath, public_path() . '/' . getSystemSetting('APP_FAVICON'));
                    // Setting::where('name', 'APP_FAVICON')->update(
                    //     ['value' => $filePath]
                    // );
                }

                $response = array(
                    'status' => true,
                    'reload' => true,
                    'message' => __('configure.AboutDataWasUpdatedSuccessfully'),
                );
                return response()->json($response, 200);
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }
    }
}
