<?php

namespace App\Http\Controllers\Blog\Admin;



use App\Http\Requests\BlogCategoryCreateRequest;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Request;


/**
 * Class CategoryController
 * @package App\Http\Controllers\Blog\Admin
 */

class CategoryController extends BaseController
{

    /**
     * @return Factory|View
     * @var BlogCategoryRepository
     *
     */
    private $blogCategoryRepository;

    public function __construct()
    {
        parent::__construct();

        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }





    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()


    {
      //  $dsd = BlogCategory::all();
      //  $paginator = BlogCategory::paginate(15);

        $paginator = $this->blogCategoryRepository->getAllWithPaginate(10);


        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $item = new  BlogCategory();


        $categoryList
            = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit',
        compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogCategoryCreateRequest $request
     * @return RedirectResponse
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();

        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
           // dd($data);
        }
       // $item = new BlogCategory($data);
       // $item->save();
        $item = (new BlogCategory())->create($data);


        if ($item) {
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Успешно сохранено']);

        } else {
            return back()->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
      //   $item = BlogCategory::findOrFail($id);
        // $categoryList = BlogCategory::all();



        $item = $this->blogCategoryRepository->getEdit($id);
        if(empty($item)) {
            abort(404);
        }

        $categoryList =$this->blogCategoryRepository->getForComboBox();


        return view('blog.admin.categories.edit',
        compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BlogCategoryUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);
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


      // $item = BlogCategory::find($id);

    //   dd($item);

        if (empty($item)) {
            return back()
                ->withErrors(['msg' => "Запись id=[{$id}] не найдена"])
                ->withInput();
        }
        $data = $request->all();
      if (empty($data['slug'])) {
          $data['slug'] = \Str::slug($data['title']);
      }
        $result = $item->update($data);
//            ->fill($data)
//            ->save();



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
