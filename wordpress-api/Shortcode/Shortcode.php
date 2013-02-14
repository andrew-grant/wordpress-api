<?php

namespace au\net\andrewgrant {

    /**
     *
     * @author Andrew Grant
     */
    class Shortcode {

        /**
         *
         * @param string $tag
         */
        public static function removeShortcode($tag) {
            remove_shortcode($tag);
        }

        /**
         * Remove all previously defined shortcodes
         * @return none
         */
        public static function removeAllShortcodes() {
            remove_all_shortcodes();
        }

        /**
         *
         * @param string $tagThe tag text (shortcode name)
         * @param function $callback The function you want executed when the
         *  tag text is encountered
         */
        public static function addShortcode($tag, $callback) {
            add_shortcode($tag, $callback);
        }

        private $defaultsArray = NULL;

        public function setDefaults($defaultsArray) {
            $this->defaultsArray = $defaultsArray;
        }

        private $tag;

        /**
         *
         * @return string The tag text used to construct an instance
         */
        public function getTag() {
            return $this->tag;
        }

        private function setTag($tagText) {
            $this->tag = $tagText;
        }

        private $shortcodeFunction;

        private function setCallback($callback) {
            if (is_callable($callback)) {
                $this->shortcodeFunction = $callback;
            } else {
                throw new \Exception("A function was expected");
            }
        }

        /**
         *
         * @param string $tag This is the shortcode tag
         *  text, as typed by the end user of the shortcode
         */
        function __construct($tag) {
            $this->setTag($tag);
        }

        /**
         *
         * @param type function This is the callback function: the function
         * that will be executed in place of the shortcode tag
         */
        public function renderShortcode($callback) {
            add_shortcode($this->getTag(), array($this, 'runFunc'));
            $this->setCallback($callback);
            $this->executeCallback();
        }

        /**
         *
         * @param array $atts This will be all of the name/value pairs entered
         *  by the end user (called by the WordPress system)
         * @param string $content This is any content between the shortcode tag
         * when the form is [tagName]the content[/tagName]
         * @return string This returns the shortcode output.
         */
        public function executeCallback($atts = NULL, $content = NULL) {
            // The incoming attributes could contain arbitrary key/values.
            // Apply the defaults now if a defaults array has been set
            if (!is_null($this->defaultsArray)) {
                $atts = shortcode_atts($this->defaultsArray, $atts);
            }
            return call_user_func($this->shortcodeFunction, $atts, $content);
        }

    }

}
?>