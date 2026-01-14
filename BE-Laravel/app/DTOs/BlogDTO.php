<?php
namespace App\DTOs;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\BlogRequest;

class BlogDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $des,
        public readonly string $detail,
        public readonly string $category,
        public readonly string $public,
        public readonly string $data_public,
        public readonly array $position,
        public readonly ?UploadedFile $thumbs = null,
    ) {}

    public static function fromRequest(BlogRequest $request): self
    {
        return new self(
            title: $request->validated('title'),
            des: $request->validated('des'),
            detail: $request->validated('detail'),
            category: $request->validated('category'),
            public: $request->validated('public'),
            data_public: $request->validated('data_public'),
            position: $request->validated('position'),
            thumbs: $request->validated('thumbs'),
        );
    }

    // Create DTO from Array
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            des: $data['des'],
            detail: $data['detail'],
            category: $data['category'],
            public: $data['public'],
            data_public: $data['data_public'],
            position: $data['position'],
            thumbs: $data['thumbs']?? null,
        );
    }

    // Convert DTO to Array
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'des' => $this->des,
            'detail' => $this->detail,
            'category' => $this->category,
            'public' => $this->public,
            'data_public' => $this->data_public,
            'position' => $this->position,
            // 'thumbs' => $this->thumbs,
        ];
    }

    public function handleImageUpload(string $directory = 'blogs'): ?string
    {
        if (!$this->thumbs) {
            return null;
        }

        return $this->thumbs->store($directory, 'public');
    }
}
