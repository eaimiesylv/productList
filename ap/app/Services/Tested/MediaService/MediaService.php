<?php

namespace App\Services\Tested\MediaService;

use App\Services\Tested\MediaService\MediaRepository;

class MediaService
{
    protected $mediaRepository;

    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    public function index()
    {
        return $this->mediaRepository->index();
    }

    public function show($id)
    {
        return $this->mediaRepository->show($id);
    }

    public function store($data)
    {
        return $this->mediaRepository->store($data);
    }

    public function update($data, $id)
    {
        return $this->mediaRepository->update($data, $id);
    }

    public function destroy($id)
    {
        return $this->mediaRepository->destroy($id);
    }
}
