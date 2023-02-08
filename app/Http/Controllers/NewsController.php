<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\News;
use App\Rules\ExceptSymbol;
use App\Rules\MaxFileSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::orderBy('id', 'desc')->get();

        return view('news.news', compact('news'));
    }

    public function detail(Request $request, $id)
    {
        $news = News::find($id);
        return view('news.detail', compact('news', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = [
            'title' => ['required', 'min:10', new ExceptSymbol()],
            'category' => ['required', 'in:news,announcement'],
            'highlight_status' => ['required', 'in:0,1'],
            'highlight_image' => ['required_if:highlight_status,1', 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:10240', 'dimensions:min_width=1025,min_height=400'],
            'images' => ['nullable', new MaxFileSize(10)],
            'images.*' => ['image', 'mimes:jpg,png,jpeg,gif,svg'],
            'videos' => ['nullable', 'array', 'max:2', new MaxFileSize(40)],
            'videos.*' => ['file', 'mimes:mp4,mpeg,x-m4v,mov'],
            'files' => ['nullable', new MaxFileSize(20)],
            'files.*' => ['file', 'mimes:xlsx,xls,doc,docx,ppt,pptx,txt,pdf'],
        ];

        $messages = [
            // 'title.required' => 'Title harus diisi',
            // 'title.min' => 'Title harus lebih dari 10 karakter',
            // 'category.required' => 'Category harus diisi',
            // 'category.in' => 'Category hanya bisa News/Announcement',
            // 'highlight.required' => 'Highlight harus diisi',
            // 'highlight_status.in' => 'Highlight hanya bisa 0/1',
            // 'highlight_image.required_if' => 'Highlight Image harus diisi',
            // 'highlight_image.image' => 'Highlight Image harus bertipe image',
            // 'highlight_image.mimes' => 'Highlight Image harus berformat: jpg, png, jpeg, gif, svg',
            // 'highlight_image.max' => 'Ukuran Highlight Image harus kurang dari 2 MB',
            // 'highlight_image.dimensions' => 'Minimal ukuran Highlight Image harus lebih dari 225 x 225',
            // 'videos.max' => 'Jumlah Video tidak boleh lebih dari 2',
            'highlight_image.required_if' => 'The highlight image field is required when highlight status is checked.',
            'highlight_image.max' => 'The highlight image must be less than 10 MB.',
        ];

        // if ($request->has('images')) {
        //     foreach ($request->file('images') as $key => $val) {
        //         $no = $key+1;
        //         $messages['images.'.$key.'.image'] = "Image $no harus bertipe image";
        //         $messages['images.'.$key.'.mimes'] = "Image $no harus berformat: jpg, png, jpeg, gif, svg";
        //     }
        // }

        // if ($request->has('videos')) {
        //     foreach ($request->file('videos') as $key => $val) {
        //         $no = $key+1;
        //         $messages['videos.'.$key.'.file'] = "Video $no harus bertipe file";
        //         $messages['videos.'.$key.'.mimes'] = "Video $no harus berformat: mp4, mpeg, x-m4v, mov";
        //     }
        // }

        // if ($request->has('files')) {
        //     foreach ($request->file('files') as $key => $val) {
        //         $no = $key+1;
        //         $messages['files.'.$key.'.file'] = "Video $no harus bertipe file";
        //     }
        // }

        request()->validate($validations, $messages);

        $nameHighlightImage = '';
        $nameImages = [];
        $nameVideos = [];
        $nameFiles = [];

        // if ($request->has('foto')) {
        //     $file = $request->file('foto');
        //     $path = Storage::disk('public')->put('news/' . Auth::user()->id, $file);
        // }

        if ($request->highlight_status == 1 && $request->has('highlight_image')) {
            $image = $request->file('highlight_image');

            $random = Str::random(40);
            $imageName = date('dmy_H_s_i') . Auth::user()->id . $random;
            $extension = strtolower($image->getClientOriginalExtension());
            $imageFullName = $imageName . '.' . $extension;
            $nameHighlightImage = $imageFullName;

            Storage::putFileAs('public/news', $image, $imageFullName);
        }

        if ($request->has('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $random = Str::random(40);
                $imageName = date('dmy_H_s_i') . Auth::user()->id . $random;
                $extension = strtolower($image->getClientOriginalExtension());
                $imageFullName = $imageName . '.' . $extension;
                $nameImages[] = $imageFullName;

                Storage::putFileAs('public/news', $image, $imageFullName);
            }
        }

        if ($request->has('videos')) {
            $videos = $request->file('videos');

            foreach ($videos as $video) {
                $random = Str::random(40);
                $videoName = date('dmy_H_s_i') . Auth::user()->id . $random;
                $videoFullName = $videoName . '.' . 'mp4';
                $nameVideos[] = $videoFullName;

                Storage::putFileAs('public/news', $video, $videoFullName);
            }
        }

        if ($request->has('files')) {
            $files = $request->file('files');

            foreach ($files as $file) {
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . date('dmyHsi');
                $extension = strtolower($file->getClientOriginalExtension());
                $fileFullName = $fileName . '.' . $extension;
                $nameFiles[] = $fileFullName;

                Storage::putFileAs('public/news', $file, $fileFullName);
            }
        }

        $news = new News();
        $news->category = $request->category;
        $news->title = $request->title;
        $news->isi = $request->body_text;
        $news->images = json_encode($nameImages);
        $news->videos = json_encode($nameVideos);
        $news->files = json_encode($nameFiles);
        $news->user_id = Auth::user()->id;
        $news->department_id = null;
        $news->tgl_terbit = date('Y-m-d h:i:s');
        $news->highlight_status = $request->highlight_status;
        $news->highlight_image = $nameHighlightImage != '' ? $nameHighlightImage : null;
        $news->save();

        return ResponseFormatter::success(['id' => $news->id], 'News data successfully added');
    }

    public function list(Request $request)
    {

        $news = News::get();
        return DataTables::of($news)
            ->addIndexColumn()
            ->addColumn('isi', function ($row) {
                return penjelasan_singkat($row['isi'], 100);
            })
            ->rawColumns(['action'])
            ->addColumn('image', function ($row) {
                return "<img src='" . url('storage/' . $row['image']) . "' width='50px' height='50px'/>";
            })
            ->rawColumns(['image'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $news = News::where('id', $id)
            ->has('user')
            ->with('user')
            ->first();

        if (!isset($news)) {
            return ResponseFormatter::error(null, 'News/Announcement data not found');
        }

        return ResponseFormatter::success($news);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $news)
    {
        return view('news.create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validations = [
            'title' => ['required', 'min:10', new ExceptSymbol()],
            'category' => ['required', 'in:news,announcement'],
            'highlight_status' => ['required', 'in:0,1'],
            'images' => ['nullable', new MaxFileSize(10)],
            'images.*' => ['image', 'mimes:jpg,png,jpeg,gif,svg'],
            'videos' => ['nullable', 'array', 'max:2', new MaxFileSize(40)],
            'videos.*' => ['file', 'mimes:mp4,mpeg,x-m4v,mov'],
            'files' => ['nullable', new MaxFileSize(20)],
            'files.*' => ['file', 'mimes:xlsx,xls,doc,docx,ppt,pptx,txt,pdf'],
        ];

        $messages = [
            // 'title.required' => 'Title harus diisi',
            // 'title.min' => 'Title harus lebih dari 10 karakter',
            // 'category.required' => 'Category harus diisi',
            // 'category.in' => 'Category hanya bisa News/Announcement',
            // 'highlight.required' => 'Highlight harus diisi',
            // 'highlight_status.in' => 'Highlight hanya bisa 0/1',
            // 'highlight_image.required_if' => 'Highlight Image harus diisi',
            // 'highlight_image.image' => 'Highlight Image harus bertipe image',
            // 'highlight_image.mimes' => 'Highlight Image harus berformat: jpg, png, jpeg, gif, svg',
            // 'highlight_image.max' => 'Ukuran Highlight Image harus kurang dari 2 MB',
            // 'highlight_image.dimensions' => 'Miniml ukuran Highlight Image harus lebih dari 225 x 225',
            // 'videos.max' => 'Jumlah Video tidak boleh lebih dari 2',
            'highlight_image.required_if' => 'The highlight image field is required when highlight status is checked.',
            'highlight_image.max' => 'The highlight image must be less than 10 MB.',
        ];

        $news = News::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if (!isset($news)) {
            return ResponseFormatter::error(null, 'News/Announcement not found');
        }

        if ($request->has('highlight_image')  || !isset($news->highlight_image)) {
            $validations['highlight_image'] = ['required_if:highlight_status,1', 'image', 'mimes:jpg,png,jpeg,gif,svg', 'max:10240', 'dimensions:min_width=1025,min_height=400'];
        }

        // if ($request->has('images')) {
        //     foreach ($request->file('images') as $key => $val) {
        //         $no = $key+1;
        //         $messages['images.'.$key.'.image'] = "Image $no harus bertipe image";
        //         $messages['images.'.$key.'.mimes'] = "Image $no harus berformat: jpg, png, jpeg, gif, svg";
        //     }
        // }

        // if ($request->has('videos')) {
        //     foreach ($request->file('videos') as $key => $val) {
        //         $no = $key+1;
        //         $messages['videos.'.$key.'.file'] = "Video $no harus bertipe file";
        //         $messages['videos.'.$key.'.mimes'] = "Video $no harus berformat: mp4, mpeg, x-m4v, mov";
        //     }
        // }

        // if ($request->has('files')) {
        //     foreach ($request->file('files') as $key => $val) {
        //         $no = $key+1;
        //         $messages['files.'.$key.'.file'] = "Video $no harus bertipe file";
        //     }
        // }

        request()->validate($validations, $messages);

        $nameImages = json_decode($news->images);
        $nameVideos = json_decode($news->videos);
        $nameFiles = json_decode($news->files);
        $tempImages = json_decode($news->images);
        $tempVideos = json_decode($news->videos);
        $tempFiles = json_decode($news->files);
        $currentHighlightImage = $news->highlight_image;
        $nameHighlightImage = '';

        if ($request->highlight_status == 1 && $request->has('highlight_image')) {
            $image = $request->file('highlight_image');

            $random = Str::random(40);
            $imageName = date('dmy_H_s_i') . Auth::user()->id . $random;
            $extension = strtolower($image->getClientOriginalExtension());
            $imageFullName = $imageName . '.' . $extension;
            $nameHighlightImage = $imageFullName;

            Storage::putFileAs('public/news', $image, $imageFullName);
        }

        if ($request->has('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $random = Str::random(40);
                $imageName = date('dmy_H_s_i') . Auth::user()->id . $random;
                $extension = strtolower($image->getClientOriginalExtension());
                $imageFullName = $imageName . '.' . $extension;

                if (count($nameImages) > 0) {
                    array_unshift($nameImages, $imageFullName);
                } else {
                    $nameImages[] = $imageFullName;
                }


                Storage::putFileAs('public/news', $image, $imageFullName);
            }
        }

        if ($request->has('videos')) {
            $videos = $request->file('videos');

            foreach ($videos as $video) {
                $random = Str::random(40);
                $videoName = date('dmy_H_s_i') . Auth::user()->id . $random;
                $videoFullName = $videoName . '.' . 'mp4';

                if (count($nameVideos) > 0) {
                    array_unshift($nameVideos, $videoFullName);
                } else {
                    $nameVideos[] = $videoFullName;
                }


                Storage::putFileAs('public/news', $video, $videoFullName);
            }
        }

        if ($request->has('files')) {
            $files = $request->file('files');

            foreach ($files as $file) {
                $random = Str::random(10);
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . date('dmy_H_s_i') . $random;
                $extension = strtolower($file->getClientOriginalExtension());
                $fileFullName = $fileName . '.' . $extension;

                if (count($nameFiles) > 0) {
                    array_unshift($nameFiles, $fileFullName);
                } else {
                    $nameFiles[] = $fileFullName;
                }

                Storage::putFileAs('public/news', $file, $fileFullName);
            }
        }

        if ($request->has('deleted_images')) {
            foreach ($request->deleted_images as $image) {
                $nameImages = array_filter($nameImages, function ($value) use ($image) {
                    return $value != $image;
                });
                $nameImages = array_values($nameImages);
            }
        }

        if ($request->has('deleted_videos')) {
            foreach ($request->deleted_videos as $video) {
                $nameVideos = array_filter($nameVideos, function ($value) use ($video) {
                    return $value != $video;
                });
                $nameVideos = array_values($nameVideos);
            }
        }

        if ($request->has('deleted_files')) {
            foreach ($request->deleted_files as $file) {
                $nameFiles = array_filter($nameFiles, function ($value) use ($file) {
                    return $value != $file;
                });
                $nameFiles = array_values($nameFiles);
            }
        }

        $news->category = $request->category;
        $news->title = $request->title;
        $news->isi = $request->body_text;
        $news->images = json_encode($nameImages);
        $news->videos = json_encode($nameVideos);
        $news->files = json_encode($nameFiles);
        $news->user_id = Auth::user()->id;
        $news->department_id = null;
        $news->tgl_terbit = date('Y-m-d h:i:s');
        $news->highlight_status = $request->highlight_status;
        $news->highlight_image = $nameHighlightImage != '' ? $nameHighlightImage : $news->highlight_image;
        $news->save();

        if ($request->has('highlight_image')) {
            if (Storage::exists('public/news/' . $currentHighlightImage)) {
                Storage::delete('public/news/' . $currentHighlightImage);
            }
        }

        if ($request->has('deleted_images')) {
            foreach ($request->deleted_images as $image) {
                if (in_array($image, $tempImages) && Storage::exists('public/news/' . $image)) {
                    Storage::delete('public/news/' . $image);
                }
            }
        }

        if ($request->has('deleted_videos')) {
            foreach ($request->deleted_videos as $video) {
                if (in_array($video, $tempVideos) && Storage::exists('public/news/' . $video)) {
                    Storage::delete('public/news/' . $video);
                }
            }
        }

        if ($request->has('deleted_files')) {
            foreach ($request->deleted_files as $file) {
                if (in_array($file, $tempFiles) && Storage::exists('public/news/' . $file)) {
                    Storage::delete('public/news/' . $file);
                }
            }
        }

        return ResponseFormatter::success(null, 'News/Announcement data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $news = News::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if (!isset($news)) {
            return ResponseFormatter::error(null, 'News/Announcement data not found');
        }

        $news->delete();

        return ResponseFormatter::success(null, 'News/Announcement successfully deleted');
    }

    public function list1()
    {
        $news = News::orderBy('id', 'desc')->has('user')->with('user')->get();

        return ResponseFormatter::success($news);
    }

    public function list1_v2(Request $request)
    {
        request()->validate([
            'page' => ['required', 'numeric'],
        ], []);

        $news = News::orderBy('id', 'desc')
            ->has('user')
            ->with('user')
            ->paginate(10, ['*'], 'page', $request->page);

        return ResponseFormatter::success($news);
    }

    public function list_home()
    {
        $news = News::orderBy('id', 'desc')->with('user')->limit(5)->get();

        return ResponseFormatter::success($news);
    }
}
