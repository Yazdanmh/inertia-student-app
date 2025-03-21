<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\ListSectionRequest;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function __invoke(ListSectionRequest $request)
    {
        $class_id = $request->class_id;

        $sections = Section::where('class_id', $class_id)->get();

        return SectionResource::collection($sections);
    }
}
