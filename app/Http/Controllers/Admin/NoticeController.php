<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Constant;
use App\Helpers\Traits\RowIndex;
use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Yajra\DataTables\Facades\DataTables;

class NoticeController extends Controller
{
    use RowIndex;
    public function index() {
        $pageTitle = "Page Notice";
        $breadcrumbs = [
            ['url' => route('admin.settings.notices.index'), 'title' => 'settings'],
            ['url' => route('admin.settings.notices.index'), 'title' => 'page notice'],
        ];

        if (request()->ajax()) {
            $data = Notice::orderBy('id', 'DESC')->get();

            return DataTables::of($data)
                ->addColumn('sl', function ($row) {
                    return $this->dt_index($row);
                })
                ->addColumn('notice_video', function ($row) {
                    if ($row->notice_video) {
                        $video = '<video width="100%" class="rounded" controls><source src="'. asset($row->notice_video). '" type="video/mp4"></video>';
                    } else {
                        $video = '---';
                    }
                    return $video;
                })
                ->addColumn('content', function ($row) {
                    if ($row->content) {
                        $cardArrow = view('components.card-arrow')->render();
                        $content = '
                            <div class="card">
                                <div class="card-body" style="height: 90px; overflow-y: scroll;">
                                    ' . $row->content . '
                                </div>
                                ' . $cardArrow . '
                            </div>
                        ';
                    } else {
                        $content = '---';
                    }
                    return $content;
                })
                ->addColumn('status', function ($row) {
                    if($row->status ==  Constant::STATUS['active']) {
                        $status = '<button type="button" class="btn btn-sm btn-outline-success">Active</button>';
                    }else {
                        $status = '<button type="button" class="btn btn-sm btn-outline-warning">Deactive</button>';
                    }
                    return $status;
                })
                ->addColumn('action', function ($row) {
                    $btn1 = '<button onclick="edit(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-success me-2 mb-2"><i class="fas fa-edit me-2"></i>Edit</button>';
                    $btn2 = '<button onclick="destroy(' . $row->id . ')" type="button" class="btn btn-sm btn-outline-danger mb-2"><i class="fas fa-trash-alt me-2"></i>Delete</button>';
                    return $btn1.$btn2;
                })
                ->rawColumns(['sl', 'notice_video', 'content', 'status', 'action'])
                ->make(true);
        }

        return view('admin.settings.notice', compact('pageTitle', 'breadcrumbs'));
    }

    public function store(Request $request) {
        $video_rule = $request->hasFile('notice_video') ? ['nullable', 'file', 'mimes:mp4,mov,avi', 'max:10240'] : ['nullable'];

        $request->validate([
            'notice_video' => $video_rule,
            'description' => ['nullable', 'string', 'max:5000'],
            'status' => ['nullable'],
        ]);

        try {
            $videoPath = '';

            if ($request->hasFile('notice_video')) {
                $assign_name = "notice_video-" . time() . "." . $request->file('notice_video')->getClientOriginalExtension();
                $request->file('notice_video')->move(public_path('uploads/notice'), $assign_name);
                $videoPath = '/uploads/notice/' . $assign_name;
            }

            // Create the notice in the database
            Notice::create([
                'user_id' => auth()->user()->id,
                'notice_video' => $videoPath,
                'content' => $request->description,
                'status' => $request->status,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function edit($id){
        $data = Notice::find($id);
        return response()->json($data);
    }

    public function update(Request $request, $id){
        $video_rule = $request->hasFile('notice_video') ? ['nullable', 'file', 'mimes:mp4,mov,avi', 'max:10240'] : ['nullable'];

        $request->validate([
            'notice_video' => $video_rule,
            'description' => ['nullable','string','max:5000'],
            'status' => ['nullable'],
        ]);

        try {
            $notice = Notice::find($id);
            $notice->user_id = auth()->user()->id;

            if ($request->hasFile('notice_video')) {
                // unlink first
                if($notice->notice_video && file_exists(public_path($notice->notice_video))){
                    unlink(public_path($notice->notice_video));
                }

                $assign_name = "notice_video-" . time() . "." . $request->file('notice_video')->getClientOriginalExtension();
                $request->file('notice_video')->move(public_path('uploads/notice'), $assign_name);
                $videoPath = '/uploads/notice/' . $assign_name;
            }
            $notice->notice_video = $videoPath ?? $notice->notice_video;
            $notice->content = $request->description;
            $notice->status = $request->status;
            $notice->save();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }

    public function removeVideo($id) {
        $notice = Notice::find($id);
        if($notice->notice_video && file_exists(public_path($notice->notice_video))){
            unlink(public_path($notice->notice_video));
            $notice->notice_video = '';
            $notice->save();
        }
        return response()->json(['success' => true]);
    }

    public function destroy($id){
        try {
            $notice = Notice::find($id);
            if($notice->notice_video && file_exists(public_path($notice->notice_video))){
                unlink(public_path($notice->notice_video));
            }
            $notice->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false,'message' => $e->getMessage()]);
        }
    }
}
