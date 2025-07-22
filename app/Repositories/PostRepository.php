<?php
namespace App\Repositories;

use App\Contracts\PostRepositoryInterface;
use App\DTOs\PostFilterDTO;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class PostRepository implements PostRepositoryInterface
{
    private const CACHE_TTL = 60; // Cache for 60 seconds

    public function getFilteredPosts(PostFilterDTO $filters): LengthAwarePaginator
    {
        return Cache::remember($filters->toCacheKey(), self::CACHE_TTL, function () use ($filters) {
            $query = Post::query()->with('author');

            $this->applyFilters($query, $filters);

            return $query->paginate($filters->perPage);
        });
    }

    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function update(Post $post, array $data): Post
    {
        $post->update($data);
        return $post;
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }

    private function applyFilters(\Illuminate\Database\Eloquent\Builder $query, PostFilterDTO $filters): void
    {
        if ($filters->category) {
            $query->where('category', $filters->category);
        }

        if ($filters->author) {
            $query->where('author_id', $filters->author);
        }

        if ($filters->startDate && $filters->endDate) {
            $query->whereBetween('created_at', [$filters->startDate, $filters->endDate]);
        }

        if ($filters->search) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', "%{$filters->search}%")
                  ->orWhereHas('author', function ($q) use ($filters) {
                      $q->where('name', 'like', "%{$filters->search}%");
                  })
                  ->orWhere('category', 'like', "%{$filters->search}%");
            });
        }
    }
}
