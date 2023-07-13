<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // const LOCAL_FOLDER_STORAGE = 'public/images/';
    private $post;
    private $category;

    public function __construct(Post $post, Category $category){
        $this->post = $post;
        $this->category = $category;
    }


    public function create(){
        $all_categories = $this->category->all();
        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    public function store(Request $request){
        # Validate data first
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:1048'
        ]);

        # Save the post
        $this->post->user_id    =   Auth::user()->id;
        $this->post->image  = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->description = $request->description;
        $this->post->save();

        # Save the categories to the category_post (PIVOT Table)
        foreach ($request->category as $category_id) {
            $category_post[] = ['category_id' => $category_id];
        }

        $this->post->categoryPost()->createMany($category_post);

        return redirect()->route('index'); //homepage
    }

    public function show($id)
    {
        $post = $this->post->findOrFail($id);

        return view('users.posts.show')->with('post', $post);
    }

    public function edit($id)
    {
        $post = $this->post->findOrFail($id);
        $all_categories = $this->category->all();

        # Get all the category IDs of this post. Save in an array.
        $selected_categories = [];
        foreach ($post->categoryPost as $category_post) {
            $selected_categories[] = $category_post->category_id;
        }

        return view('users.posts.edit')
                ->with('post', $post)
                ->with('all_categories', $all_categories)
                ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id)
    {
        # 1. Validate the data from the form
        $request->validate([
            'category'      => 'required|array|between:1,3',
            'description'   => 'required|min:1|max:1000',
            'image'         => 'mimes:jpg,jpeg,png,gif|max:1048'
        ]);

        # 2. Update the post
        $post               = $this->post->findOrFail($id);

        if (Auth::user()->id != $post->user->id) {
            return redirect()->route('index'); //Homepage
        }

        $post->description  = $request->description;

        // If there is a new image...
        if ($request->image){
            $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        }
        $post->save();

        # 3. Delete all records from category_post related to this post
        $post->categoryPost()->delete();

        # 4. Save the new categories to category_post table
        # 3 --> 1, 3, 5
        foreach ($request->category as $category_id) {
            $category_post[] = [
                'category_id' => $category_id
            ];
        }

        $post->categoryPost()->createMany($category_post);

        # 5. Redirect to Show Post page
        return redirect()->route('post.show', $id);
    }

    public function destroy($id){
        $post = $this->post->findOrFail($id); // SELECT * FROM posts WHERE id = $id;
        $post->delete();
        return redirect()->route('index'); //Homepage
    }

}













