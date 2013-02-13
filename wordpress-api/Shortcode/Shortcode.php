<?php

namespace au\net\andrewgrant {

    class Shortcode {

        private $defaultsArray = NULL;

        public function setDefaults($defaultsArray) {
            $this->defaultsArray = $defaultsArray;
        }

        private $tagText;

        /**
         *
         * @return type This returns the text that was used to construct this
         * instance - the shortcode tag text
         */
        public function getTagText() {
            return $this->tagText;
        }

        private function setTagText($tagText) {
            $this->tagText = $tagText;
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
         * @param type $tagText This is the shortcode tag name, as
         * entered by the end user of the shortcode
         */
        function __construct($tagText) {
            $this->setTagText($tagText);
        }

        /**
         *
         * @param type $func This is the callback function: the function that
         * will be executed in place of the shortcode tag
         */
        public function renderShortcode($callback) {
            add_shortcode($this->getTagText(), array($this, 'runFunc'));
            $this->setCallback($callback);
            $this->executeCallback();
        }

        /**
         *
         * @param type $atts This will be all of the name/value pairs entered
         *  by the end user (called by the WordPress system)
         * @param type $content This is any content between the shortcode tag
         * when the form is [tagName]the content[/tagName]
         * @return type This returns the shortcode output.
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