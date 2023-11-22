<?php

namespace App\Http\Controllers\admin\asset_management;

use App\Http\Controllers\Controller;
use App\Models\AssetValueCategory;
use App\Models\AssetValueQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetManagementController extends Controller
{
    /**
     * Display a dump message for testing
     *
     * @return String
     */
    public function index()
    {

        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' => "javascript:void(0)", 'name' => __('locale.Asset Management')], ['name' => __('locale.Automated Discovery')]];
        return view('admin.content.asset_management.index', compact('breadcrumbs'));
    }

    public function assetValueSettings()
    {
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')], ['link' =>  route('admin.asset_management.index'), 'name' => __('locale.AssetValueManagement')], ['name' => __('locale.AssetValueManagement')]];
        $categories = AssetValueCategory::all();
        return view('admin.content.asset_management.settings', compact('breadcrumbs', 'categories'));
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $exist_data = AssetValueQuestion::where('asset_value_category_id', $request->category_id)->get();
            foreach ($exist_data as $index => $data) {
                $data->update([
                    'question' => $request->questions[$index]
                ]);
            }

            DB::commit();
            $response = array(
                'status' => true,
                'message' => __('locale.AssetValueQuestionsWasUpdatedSuccessfully'),
            );
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $response = array(
                'status' => false,
                'errors' => [],
                'message' => __('locale.Error'),
            );
            return response()->json($response, 502);
        }
    }
    public function store_answers(Request $request)
    {
        $result = [];
        foreach ($request->answer as $index => $answer) {
            $result[] = [
                'answer' => $answer,
                'value' => intval($request->answer_value[$index])
            ];
        }
        $jsonResult = json_encode($result);

        DB::beginTransaction();
        try {
            $exist_data = AssetValueQuestion::where('asset_value_category_id', $request->category_id)->get();
            foreach ($exist_data as $index => $data) {
                $data->update([
                    'answers' => $jsonResult
                ]);
            }
            DB::commit();
            $response = array(
                'status' => true,
                'message' => __('locale.AssetValueAnswersWasUpdatedSuccessfully'),
            );
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            $response = array(
                'status' => false,
                'errors' => [],
                'message' => __('locale.Error'),
            );
            return response()->json($response, 502);
        }
    }
}
