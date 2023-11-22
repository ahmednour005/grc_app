<?php

namespace App\View\Components\Admin\Content\Asset_management\Asset\Form;

use Illuminate\View\Component;

class EditView extends Component
{
    public $id;
    public $assetValues;
    public $locations;
    public $teams;
    public $tags;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $assetValues, $locations, $teams, $tags)
    {
        $this->id = $id;
        $this->assetValues = $assetValues;
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
        return view('components.admin.content.asset_management.asset.form.edit-view');
    }
}
