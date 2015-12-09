<?php

    namespace Dez\Utils;

    use Dez\Utils\Traits\Singleton;

    class Text {

        use Singleton;

        const RANDOM_NUM    = 1;

        const RANDOM_LOWER  = 2;

        const RANDOM_UPPER  = 4;

        const RANDOM_ALL    = self::RANDOM_LOWER
                                | self::RANDOM_LOWER
                                | self::RANDOM_UPPER;

        protected $cryptty;

        protected $salt     = '4c_q%@8p$9a2RtTGaf?X_!EtVF8tDtX6ZcxC@KChLd?mex&cVEsSnTs2rfCeBSLfX_rdzd$ZTxdVU';

        /**
         * @param int $length
         * @param int $setting
         * @return string
         */
        public static function random($length = 12, $setting = self::RANDOM_NUM)
        {
            $map = [];

            if($setting & self::RANDOM_NUM) {
                $map    = array_merge(range('0', '9'), $map);
            }

            if($setting & self::RANDOM_LOWER) {
                $map    = array_merge(range('a', 'z'), $map);
            }

            if($setting & self::RANDOM_UPPER) {
                $map    = array_merge(range('A', 'Z'), $map);
            }

            $random = '';

            for($i = 0; $i < $length; $i++) {
                $random .= $map[array_rand($map)];
            }

            return $random;
        }

        /**
         * @param null $salt
         */
        protected function init($salt = null)
        {
            if(null !== $salt) {
                $this->setSalt($salt);
            }

            $this->setCryptty(Crypty::instance());
        }

        /**
         * @param string $data
         * @return string
         */
        public function cryptString($data = '')
        {
            return $this->getCryptty()->encode($data, $this->getSalt());
        }

        /**
         * @param string $data
         * @return int|null|string
         */
        public function decryptString($data = '')
        {
            return $this->getCryptty()->decode($data, $this->getSalt());
        }

        /**
         * @param string $data
         * @return string
         */
        public static function encrypt($data = '')
        {
            return static::instance()->cryptString($data);
        }

        /**
         * @param string $data
         * @return int|null|string
         */
        public static function decrypt($data = '')
        {
            return static::instance()->decryptString($data);
        }

        /**
         * @param $string
         * @return string
         */
        public static function camelize($string)
        {
            return lcfirst(implode('', array_map('ucfirst', array_map('strtolower', explode('_', $string)))));
        }

        /**
         * @param $string
         * @return string
         */
        public static function underscore($string)
        {
            return implode('_', array_map('strtolower', preg_split('/([A-Z]{1}[^A-Z]*)/', $string, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY)));
        }

        /**
         * @return Crypty
         */
        public function getCryptty()
        {
            return $this->cryptty;
        }

        /**
         * @param Crypty $cryptty
         * @return static
         */
        public function setCryptty(Crypty $cryptty)
        {
            $this->cryptty = $cryptty;
            return $this;
        }

        /**
         * @return string
         */
        public function getSalt()
        {
            return $this->salt;
        }

        /**
         * @param string $salt
         * @return static
         */
        public function setSalt($salt)
        {
            $this->salt = $salt;
            return $this;
        }

    }