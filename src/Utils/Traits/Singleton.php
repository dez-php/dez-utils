<?php

    namespace Dez\Utils\Traits;

    trait Singleton {

        /**
         * @var static[]
         */
        protected static $instances = [];

        /**
         * @return static
        */

        final static public function instance()
        {
            $arguments  = func_get_args();

            $hash       = sha1(json_encode(array_map(function($argument){
                return is_object($argument) ? spl_object_hash($argument) : $argument;
            }, $arguments)));

            $hash   = sha1( static::class . $hash );

            if( ! isset( static::$instances[$hash] ) ) {
                static::$instances[$hash] = ( new \ReflectionClass( static::class ) )
                    ->newInstanceArgs( $arguments );
            }

            return static::$instances[$hash];
        }

        /**
         * Singleton constructor.
         */
        public function __construct()
        {
            call_user_func_array( [ $this, 'init' ], func_get_args() );
        }

        /**
         * @return mixed
         */
        abstract protected function init();

    }