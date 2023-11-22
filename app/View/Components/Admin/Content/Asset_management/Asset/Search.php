<?php

namespace App\View\Components\Admin\Content\Asset_management\Asset;

use Illuminate\View\Component;

class Search extends Component
{
    public $id;
    public $createModalID;
    public $assetValues;
    public $locations;
    public $assetCategories;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $createModalID, $assetValues, $locations,$assetCategories)
    {
        $this->id = $id;
        $this->createModalID = $createModalID;
        $this->assetValues = $assetValues;
        $this->locations = $locations;
        $this->assetCategories = $assetCategories;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.asset_management.asset.search');
    }
}
