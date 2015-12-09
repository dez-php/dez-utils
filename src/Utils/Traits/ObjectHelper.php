<?php

    namespace Dez\Utils\Traits;

    trait ObjectHelper {

        /**
         * @return string
         */
        public function getClassName()
        {
            return get_class( $this );
        }

        /**
         * @param null $name
         * @return bool
         */
        public function canGetProperty( $name = null )
        {
            return $this->hasMethod( $this->getterName( $name ) ) && property_exists( $this, $name );
        }

        /**
         * @param null $name
         * @return bool
         */
        public function canSetProperty( $name = null )
        {
            return $this->hasMethod( $this->setterName( $name ) ) && property_exists( $this, $name );
        }

        /**
         * @param null $methodName
         * @return bool
         */
        public function hasMethod( $methodName = null )
        {
            return method_exists( $this, $methodName );
        }

        /**
         * @param null $propertyName
         * @return string
         */
        private function setterName( $propertyName = null )
        {
            return 'set'. ucfirst( strtolower( $propertyName ) );
        }

        /**
         * @param null $propertyName
         * @return string
         */
        private function getterName( $propertyName = null )
        {
            return 'get'. ucfirst( strtolower( $propertyName ) );
        }

    }