<?php

namespace App\View\Components\Admin\Content\Asset_management\Asset;

use Illuminate\View\Component;

class Form extends Component
{
    public $id;
    public $title;
    public $assetValues;
    public $assetCategories;
    public $locations;
    public $teams;
    public $tags;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $title, $assetValues,$assetCategories, $locations, $teams, $tags)
    {
        $this->id = $id;
        $this->title = $title;
        $this->assetValues = $assetValues;
        $this->assetCategories = $assetCategories;
        $this->locations = $locations;
        $this->teams = $teams;
        $this->tags = $tags;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.content.asset_management.asset.form');
    }
}
