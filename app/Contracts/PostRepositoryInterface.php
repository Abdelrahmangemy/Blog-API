<?php
namespace App\Contracts;

use App\DTOs\PostFilterDTO;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function getFilteredPosts(PostFilterDTO $filters): LengthAwarePaginator;
    public function create(array $data): Post;
    public function update(Post $post, array $data): Post;
    public function delete(Post $post): bool;
}
