<?php
namespace App\Http\Traits;

use App\Models\Asset;
use App\Models\FrameworkControl;
use App\Models\Mitigation;
use App\Models\MitigationToControl;
use App\Models\Risk;
use Illuminate\Support\Facades\DB;
trait RiskAssetTrait
{

    /**
     * check type
     *
     * @return true
     */
    public function RiskAsset($type, $filter = [])
    {
        $row = [];
        if ($type == 0) {
            //RisksByAsset
            return $this->RisksByAsset($filter);
        } else {
            //AssetsByRisk
            return $this->AssetsByRisk();
        }
    }

    public function RisksByAsset($filters)
    {

        $assets=Asset::all();
        return $assets; 
    }
    public function AssetsByRisk(){

        $risks=Risk::all();
        return $risks;
    }


}
