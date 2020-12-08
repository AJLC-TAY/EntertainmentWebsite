<?php

class Track implements JsonSerializable {
    private $trackid;
    private $albumid;
    private $trackname;
    private $filepath;

    /**
     * Track constructor.
     * @param $albumid
     * @param $trackname
     * @param $filepath
     */
    public function __construct($trackid,$albumid, $trackname) {
        $this->trackid = $trackid;
        $this->albumid = $albumid;
        $this->trackname = $trackname;
    }

    /**
     * @return mixed
     */
    public function getTrackid()
    {
        return $this->trackid;
    }

    /**
     * @param mixed $trackid
     */
    public function setTrackid($trackid)
    {
        $this->trackid = $trackid;
    }


    /**
     * @return mixed
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * @param mixed $filepath
     */
    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;
    }

    /**
     * @return mixed
     */
    public function getAlbumid()
    {
        return $this->albumid;
    }

    /**
     * @param mixed $albumid
     */
    public function setAlbumid($albumid)
    {
        $this->albumid = $albumid;
    }

    /**
     * @return mixed
     */
    public function getTrackname()
    {
        return $this->trackname;
    }

    /**
     * @param mixed $trackname
     */
    public function setTrackname($trackname)
    {
        $this->trackname = $trackname;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->filepath;
    }

    /**
     * @param mixed $filepath
     */
    public function setFile($filepath)
    {
        $this->file = $filepath;
    }


    public function jsonSerialize() {
        return [
            "trackid" => $this->getTrackid(),
            "albumid" => $this->getAlbumid(),
            "trackname" => $this->getTrackname(),
            "filepath" => $this->getFilepath()
        ];
    }
}