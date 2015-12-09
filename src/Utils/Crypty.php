<?php

    namespace Dez\Utils;

    class Crypty {

        private $baseX      = null;

        private $setting    = -1;

        /**
         * Cryptty constructor.
         * @param BaseX $baseX
         * @param int $setting
         */
        public function __construct( BaseX $baseX, $setting = 0 )
        {
            if(! extension_loaded('bcmath')) {
                throw new \RuntimeException('BCMath extension not loaded. Require for '. Cryptty::class);
            }

            $this->setBaseX($baseX)->setSetting($setting);
        }

        /**
         * @return static
         */
        static public function instance()
        {
            static $instance = null;
            $setting    = BaseX::USE_LOWERCASE | BaseX::USE_UPPERCASE | BaseX::USE_NUMS_WO_ZERO;

            if(null === $instance ) {

                $baseX      = new BaseX($setting);
                $baseX->addCustom(['_', '-', '$']);

                $instance   = new static($baseX);
            };

            return $instance;
        }

        /**
         * @param null $data
         * @param null $secretKey
         * @return string
         */
        public function encode( $data = null, $secretKey = null )
        {
            $secretKey  = str_pad( '', strlen( $data ), $this->_hash( $secretKey ) );
            $data       = $data ^ $secretKey;

            $output     = [];

            foreach( str_split( $data, 3 ) as $chunk ) {
                $tmp        = unpack( 'H*', $this->_randSymbol() . $chunk );
                $tmp        = $this->getBaseX()->encode( base_convert( $tmp[1], 16, 10 ) );
                $output[]   = str_pad( $tmp, 7, '0', STR_PAD_LEFT );
                unset( $tmp );
            }

            return join( '', $output );
        }

        /**
         * @param null $data
         * @param null $secretKey
         * @return int|null|string
         */
        public function decode( $data = null, $secretKey = null )
        {
            $output = null;

            foreach( str_split( $data, 7 ) as $chunk ) {
                $chunk  = base_convert( $this->getBaseX()->decode( ltrim( $chunk, '0' ) ), 10, 16 );
                $output .= substr( pack( 'H*', $chunk ), 1 );
            }

            $secretKey  = $this->_hash( $secretKey );
            $output     = $output ^ str_pad( '', mb_strlen( $output ) * 2, $secretKey );

            return $output;
        }

        /**
         * @return BaseX
         */
        public function getBaseX()
        {
            return $this->baseX;
        }

        /**
         * @param BaseX $baseX
         * @return static
         */
        public function setBaseX(BaseX $baseX)
        {
            $this->baseX = $baseX;
            return $this;
        }

        /**
         * @return int
         */
        public function getSetting()
        {
            return $this->setting;
        }

        /**
         * @param int $setting
         * @return static
         */
        public function setSetting($setting)
        {
            $this->setting = $setting;
            return $this;
        }

        /**
         * @param null $data
         * @return string
         */
        private function _hash( $data = null )
        {
            return md5( $data );
        }

        /**
         * @return string
         */
        private function _randSymbol()
        {
            return chr( rand( ord( 'A' ), ord( 'z' ) ) );
        }

    }