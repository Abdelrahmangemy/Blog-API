<?php
namespace App\DTOs;

use Illuminate\Http\Request;

class PostFilterDTO
{
    public function __construct(
        public ?string $category = null,
        public ?int $author = null,
        public ?string $startDate = null,
        public ?string $endDate = null,
        public ?string $search = null,
        public int $perPage = 10
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            category: $request->input('category'),
            author: $request->input('author'),
            startDate: $request->input('start_date'),
            endDate: $request->input('end_date'),
            search: $request->input('search'),
            perPage: $request->input('per_page', 10)
        );
    }

    public function toCacheKey(): string
    {
        return 'posts_' . md5(json_encode([
            'category' => $this->category,
            'author' => $this->author,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'search' => $this->search,
            'per_page' => $this->perPage,
        ]));
    }
}
