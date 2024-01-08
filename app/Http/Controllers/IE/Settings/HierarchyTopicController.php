<?php

namespace App\Http\Controllers\IE\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Models\IE\HierarchyTopic;
use App\Models\IE\HierarchySetup;

class HierarchyTopicController extends Controller
{

    public function index(Request $request)
    {
        $topics = HierarchyTopic::orderBy('hierarchy_topic_id')->get();

        return view('ie.settings.hierarchy.topic.index', compact(
            'topics'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'code' => 'required|max:255|unique:ptw_hierarchy_topics,code',
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $topic = new HierarchyTopic;
            $topic->code = $request->code;
            $topic->name = $request->name;
            $topic->last_updated_by = getDefaultData()->user_id;
            $topic->created_by = getDefaultData()->user_id;
            $topic->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-topic.index')->with('success', 'Create Hierarchy topic Success.');
    }

    public function formEdit(Request $request, $topicId)
    {
        $topic = HierarchyTopic::findOrFail($topicId);

        return view('ie.settings.hierarchy.topic._form_edit', compact(
            'topic',
        ));
    }

    public function update(Request $request, $topicId)
    {
        $validator = Validator::make($request->all(),
        [
            'code' => [
                'required',
                'max:255',
                Rule::unique('ptw_hierarchy_topics')->ignore($topicId, 'hierarchy_topic_id')
            ],
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            $topic = HierarchyTopic::findOrFail($topicId);
            $topic->code = $request->code;
            $topic->name = $request->name;
            $topic->last_updated_by = getDefaultData()->user_id;
            $topic->save();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-topic.index')->with('success', 'Edit Hierarchy topic Success.');
    }

    public function destroy($topicId)
    {
        try {
            $topic = HierarchyTopic::findOrFail($topicId);

            $checkUse = HierarchySetup::where('hierarchy_topic_id', $topicId)->first();
            if(!!$checkUse){
                return redirect()->back()->withErrors('มีการใช้งาน Hierarchy Topic นี้อยู่');
            }

            $topic->delete();

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('ie.settings.hierarchy-topic.index')->with('success', 'Remove Hierarchy Type Success.');
    }
}
