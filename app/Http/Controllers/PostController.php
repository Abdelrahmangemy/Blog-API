<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\PostIndexRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use App\DTOs\PostFilterDTO;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        private PostRepository $postRepository
    ) {}

    public function index(PostIndexRequest $request): \Illuminate\Http\Resources\Json\ResourceCollection
    {
        $filters = PostFilterDTO::fromRequest($request);
        $posts = $this->postRepository->getFilteredPosts($filters);

        return PostResource::collection($posts);
    }

    public function store(CreatePostRequest $request): PostResource
    {
        $post = $this->postRepository->create([
            'title' => $request->title,
            'content' => $request->content,
            'author_id' => auth('api')->id(),
            'category' => $request->category,
        ]);

        return new PostResource($post);
    }

    public function show(\App\Models\Post $post): PostResource
    {
        $post->load('author');
        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, \App\Models\Post $post): PostResource
    {
        $this->authorize('update', $post);
        $post = $this->postRepository->update($post, $request->validated());
        return new PostResource($post);
    }

    public function destroy(\App\Models\Post $post): \Illuminate\Http\JsonResponse
    {
        $this->authorize('delete', $post);
        $this->postRepository->delete($post);
        return response()->json(['message' => 'Post deleted']);
    }
}
