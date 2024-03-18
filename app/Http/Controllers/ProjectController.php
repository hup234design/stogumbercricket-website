<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index() : View
    {
        $page = Page::indexPages()->whereSlug('projects')->firstOrFail();

        $projects = Project::visible()->get();

        return view('projects', [
            'page'  => $page,
            'projects' => $projects,
        ]);
    }

    public function project($slug) : View
    {
        $project = Project::visible()->whereSlug($slug)->firstOrFail();

        return view('project', [
            'page' => $project
        ]);
    }
}
