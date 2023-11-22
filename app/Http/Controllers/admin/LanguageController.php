<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JoeDixon\Translation\Drivers\Translation;
use JoeDixon\Translation\Http\Requests\LanguageRequest;

class LanguageController extends Controller
{

    private $translation;

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function index(Request $request)
    {
        $languages = $this->translation->allLanguages();
        return view('admin.language.translation.languages.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.language.translation.languages.create');
    }

    public function store(LanguageRequest $request)
    {
        $this->translation->addLanguage($request->locale, $request->name);

        return redirect()
            ->route('admin.languages.index')
            ->with('success', __('translation::translation.language_added'));
    }
}
