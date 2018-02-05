<?php

namespace Acme\StoreBundle\Document;


class UploadedFile
{

    private $path;

    /**
     * @param $value
     * @return $this
     */
    public function setPath($value) {
        $this->path = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath() {
        return $this->path;
    }

}