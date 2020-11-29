<?php
    class Album {
        private $albumid;
        private $albumname;
        private $artistid;
        private $releaseddate;
        private $albumimg;

        public function __construct($albumname, $artistid, $releaseddate, $albumimg) {
            $this->albumname = $albumname;
            $this->artistid = $artistid;
            $this->releaseddate = $releaseddate;
            $this->albumimg = "data:image;base64,".base64_encode($albumimg);
        }

        public function get_albumid() {
            return $this->albumid;
        }

        public function get_albumname() {
            return $this->albumname;
        }

        public function get_artistid() {
            return $this->artistid;
        }

        public function get_releaseddate() {
            return $this->releaseddate;
        }

        public function get_albumimg() {
            return $this->albumimg;
        }
    }

    class Artist {
        private $artistid;
        private $artistname;
        private $artistimage;
        private $debutyear;
        private $membernum;

        public function __construct($artistid, $artistname, $artistimage, $debutyear, $membernum) {
            $this->artistid = $artistid;
            $this->artistname = $artistname;
            $this->artistimage = "data:image;base64,".base64_encode($artistimage);
            $this->debutyear = $debutyear;
            $this->membernum = $membernum;
        }

        public function get_artistid() {
            return $this->artistid;
        }

        public function get_artistname() {
            return $this->artistname;
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

