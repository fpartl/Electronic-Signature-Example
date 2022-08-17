<?php
    define('SESSION_EVENT_PREFIX', 'event_');
    define('NOT_EXITSTS', '');
    
    class Event {
        private $exists = false;
        private $type;
        private $message;
        
        public function __construct() {
            $this->initialize();
        }
        
        public function isExisting() {
            return $this->exists;
        }
        
        public function getType() {
            return ($this->exists) ? $this->type : NOT_EXITSTS;
        }
        
        public function getMessage() {
            return ($this->exists) ? $this->message : NOT_EXITSTS;
        }
        
        public function set($type, $message, $linkToRedirect = '') {
            if ($message != '') {
                $this->exists = true;
                $_SESSION[SESSION_EVENT_PREFIX . 'type'] = $type;
                $_SESSION[SESSION_EVENT_PREFIX . 'message'] = $message;
            }

            header('Location:' . SELF_HTTP_ADDR . $linkToRedirect);
            die();
        }
        
        public function destroy() {
            $this->exists = false;
            unset($_SESSION[SESSION_EVENT_PREFIX . 'type']);
            unset($_SESSION[SESSION_EVENT_PREFIX . 'message']);
        }
        
        private function initialize() {
            if (isset($_SESSION[SESSION_EVENT_PREFIX . 'type'])) {
                $this->exists = true;
                $this->type = $_SESSION[SESSION_EVENT_PREFIX . 'type'];
                $this->message = $_SESSION[SESSION_EVENT_PREFIX . 'message'];
            }
        }
    }
?>