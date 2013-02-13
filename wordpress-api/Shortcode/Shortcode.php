<?php

namespace au\net\andrewgrant {

    class Shortcode {

        private $defaultsArray = NULL;

        public function setDefaults($defaultsArray) {
            $this->defaultsArray = $defaultsArray;
        }

        private $replacementText;

        /**
         *
         * @return type This returns the text that was used to construct this
         * instance - the shortcode tag text
         */
        public function getReplacementText() {
            return $this->replacementText;
        }

        private function setReplacementText($replacementText) {
            $this->replacementText = $replacementText;
        }

        private $shortcodeFunction;

        private function setShortcodeFunction($replacementFunction) {
            if (is_callable($replacementFunction)) {
                $this->shortcodeFunction = $replacementFunction;
            } else {
                throw new \Exception("A function was expected");
            }
        }

        /**
         *
         * @param type $replacementText This is the shortcode tag name, as
         * entered by the end user of the shortcode
         */
        function __construct($replacementText) {
            $this->setReplacementText($replacementText);
        }

        /**
         *
         * @param type $func This is the callback function: the function that
         * will be executed in place of the shortcode tag
         */
        public function renderShortcode($func) {
            add_shortcode($this->getReplacementText(), array($this, 'runFunc'));
            $this->setShortcodeFunction($func);
            $this->runFunc();
        }

        /**
         *
         * @param type $atts This will be all of the name/value pairs entered
         *  by the end user (called by the WordPress system)
         * @param type $content This is any content between the shortcode tag
         * when the form is [tagName]the content[/tagName]
         * @return type This returns the shortcode output.
         */
        public function runFunc($atts = NULL, $content = NULL) {
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