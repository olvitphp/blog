<?php

namespace App\Http\Controllers\Blog\Admin;


use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;


class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()


    {
      //  $dsd = BlogCategory::all();
        $paginator = BlogCategory::paginate(15);
//      dd($dsd, $paginator);
        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        dd(__METHOD__);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        dd(__METHOD__);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $item = BlogCategory::findOrFail($id);
        $categoryList = BlogCategory::all();

        return view('blog.admin.categories.edit',
        compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
//        $rules = [
//            'title'         =>  'required|min:5|max:200',
//            'slug'          =>  'max:200',
//            'description'   =>  'string|max:500|min:3',
//            'parent_id'     =>  'required|integer|exists:blog_categories,id',
//        ];

      // $validateData = $this->validate($request, $rules);
       // $validateData = $request->validate($rules);
      //  $validateData = \Validator::make($request->all(), $rules);

      //  dd($validateData);


       $item = BlogCategory::find($id);

    //   dd($item);
        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }
        $data = $request->all();
      //  dd($data);
        $result = $item
            ->fill($data)
            ->save();



        if ($result) {
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'Успешно сохранено']);

        }else{
            return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();

        }
    }


}
