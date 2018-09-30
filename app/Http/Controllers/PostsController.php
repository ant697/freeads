<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Post;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Middleware\CheckMessages;

class PostsController extends Controller
{
    private $keyword;
    private $user;
    private $price;
    private $picture;
    const MATCHING_CONTENT = 1;
    const MATCHING_TITLE = 2;

    /**
     * PostsController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 50;
        $category = $request->get('category');
        $user = $request->get('user');
        $this->keyword = $keyword;
        $this->price = ['min' => $request->get('priceMin'), 'max' => $request->get('priceMax')];
        $this->picture = $request->get('picture');
        if (!empty($keyword) || !empty($category) || !empty($user) ||
            (!empty($this->price['min']) && !empty($this->price['max'])) ||
            $this->picture) {
            return $this->search($request, $perPage);
        } else {
            $posts = Post::latest()->paginate($perPage);
        }
        return view('posts.index', compact('posts'));
    }

    public function contact()
    {
        return view('messages.create');
    }

    public function search(Request $request, $perPage)
    {
        $this->keyword = $request->get('search');
        $category = $request->get('category');
        $this->user = $request->get('user');
        $posts = Post::where('category', 'LIKE', "%$category%")
            ->where(function ($query) {
                if (!empty($this->user)) {
                    $query->where('user_id', '=', $this->user);
                } else {
                    $query->where('title', 'LIKE', '%%');
                }
            })->where(function ($query) {
                if (!empty($this->price['min']) && !empty($this->price['max'])) {
                    $query->whereBetween('price', [$this->price['min'], $this->price['max']]);
                } else {
                    $query->where('title', 'LIKE', '%%');
                }
            })->where(function ($query) {
                if ($this->picture) {
                    $query->whereNotNull('picture1')
                        ->orWhereNotNull('picture2')
                        ->orWhereNotNull('picture3')
                        ->orWhereNotNull('picture4')
                        ->orWhereNotNull('picture5');
                } else {
                    $query->where('title', 'LIKE', '%%');
                }
            })->latest()->paginate($perPage);
        if (!empty($this->keyword)) {
            $totalPosts = $posts;
            $posts = $this->searchMatching($posts, $this->keyword);
        } else {
            $totalPosts = $posts;
            $posts = [1 => $posts];
        }
        return view('posts.search', compact('posts', 'totalPosts'));
    }

    private function searchMatching($posts, $search)
    {
        $newPost = [];
        foreach ($posts as $post) {
            $data = [explode(' ', $search), explode(' ', $post->content), explode(' ', $post->title), 0, []];
            list($searchs, $content, $title, $matching, $savedWord) = $data;
            foreach ($searchs as $searchedWord) {
                $searchedWord = $this->changeWord($searchedWord);
                $words = ['listWords' => $title, 'searchedWord' => $searchedWord, 'savedWord' => $savedWord];
                $matching = $this->checkWord($words, $matching, 'TITLE');
                $words = ['listWords' => $content, 'searchedWord' => $searchedWord, 'savedWord' => $savedWord];
                $matching = $this->checkWord($words, $matching, 'CONTENT');
            }
            $newPost[$matching][] = $post;
        }
        arsort($newPost);
        return $newPost;
    }

    private function checkWord($data, $matching, $context)
    {
        foreach ($data['listWords'] as $word) {
            $word = $this->changeWord($word);
            if ($data['searchedWord'] === $word && !in_array($word, $data['savedWord'])) {
                $data['savedWord'][] = $word;
                $matching += constant("self::MATCHING_$context");
            }
        }
        return $matching;
    }

    private function changeWord($word)
    {
        $new = iconv('UTF-8', 'us-ascii//TRANSLIT//IGNORE', $word);
        return preg_replace('/[\"\\\'\`\^]/', '', $new);
    }

    private function fonctionComparaison($a, $b) {
        return $a['val'] > $b['val'];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        if ($this->getRefererPerm()) {
            return $this->checkReferer('posts', 'Unauthorized Access');
        }
        $this->checkReferer($request);
        $this->validate($request, [
        'title' => 'required',
        'content' => 'required',
        'price' => 'required'
        ]);
        $requestData = $request->all();
        $requestData['user_id'] = Auth::id();
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile('picture' . $i)) {
                $requestData['picture' . $i] = $request->file('picture' . $i)
                    ->store('uploads', 'public');
            }
        }
        Post::create($requestData);
        return redirect('posts')->with('flash_message', 'Post added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $user = User::findOrFail($post->user_id);
        return view('posts.show', compact('post', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if (!$this->checkRight($post->user_id) || $this->getRefererPerm()) {
            return redirect('posts')->with('flash_message', 'Unauthorized Access');
        }
        $this->validate($request, [
        'title' => 'required',
        'content' => 'required',
        'price' => 'required'
        ]);
        $requestData = $request->all();
        for ($i = 1; $i <= 5; $i++) {
            if ($request->hasFile('picture' . $i)) {
                $requestData['picture' . $i] = $request->file('picture' . $i)
                    ->store('uploads', 'public');
            }
        }
        $post = Post::findOrFail($id);
        $post->update($requestData);
        return redirect('posts')->with('flash_message', 'Post updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if (!$this->checkRight($post->user_id) || $this->getRefererPerm()) {
            return redirect('posts')->with('flash_message', 'Unauthorized Access');
        }
        Post::destroy($id);

        return redirect('posts')->with('flash_message', 'Post deleted!');
    }
}
