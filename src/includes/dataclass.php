<?php
    class Album implements JsonSerializable {
        private $albumid;
        private $albumname;
        private $artistname;
        private $releaseddate;
        private $albumimg;

        public function __construct($albumname, $artistname, $releaseddate, $albumimg) {
            $this->albumname = $albumname;
            $this->artistname = $artistname;
            $this->releaseddate = $releaseddate;
            $this->albumimg = "data:image;base64,".base64_encode($albumimg);
        }

        public function set_albumid($id) {
            $this->albumid = $id;
        }

        public function get_albumid() {
            return $this->albumid;
        }

        public function get_albumname() {
            return $this->albumname;
        }

        public function get_artistname() {
            return $this->artistname;
        }

        public function get_releaseddate() {
            return $this->releaseddate;
        }

        public function get_albumimg() {
            return $this->albumimg;
        }

        public function jsonSerialize() {
            return [
                  'albumid' => $this->albumid,
                  'albumname' => $this->albumname,
                  'artistname' => $this->artistname,
                  'releaseddate' => $this->releaseddate,
                  'albumimg' => $this->albumimg
            ];
        }
    }

    class Artist {
        private $artistid;
        private $artistname;

        public function __construct($artistid, $artistname) {
            $this->artistid = $artistid;
            $this->artistname = $artistname;
        }

        public function set_artistid($id) {
            $this->artistid = $id;
        }

        public function get_artistid() {
            return $this->artistid;
        }

        public function get_artistname() {
            return $this->artistname;
        }
    }
    class ArtistDetail extends Artist {
        private $artistimage;
        private $debutyear;
        private $membernum;


        public function _construct($artistid, $artistname, $artistimage, $debutyear, $membernum) {
            parent::__construct($artistid, $artistname);
            $this->artistimage = "data:image;base64,".base64_encode($artistimage);
            $this->debutyear = $debutyear;
            $this->membernum = $membernum;
        }

        public function get_artistimage() {
            return $this->artistimage;
        }

        public function get_debutyear() {
            return $this->debutyear;
        }

        public function get_membernum() {
            return $this->membernum;
        }
    }

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
?>
