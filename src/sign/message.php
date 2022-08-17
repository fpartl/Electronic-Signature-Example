<?php
    class Message {
        private $content;
        private $updatedContent;
        private $cryptedHash;
        private $publicKey;
        private $n;
        private $cert;
        private $state = DOESNT_EXISTS;
        
        public function __construct() {
            $this->initialize();
        }
        
        public function getContent() {
            return ($this->state != DOESNT_EXISTS) ? $this->content : UNDEFINED; 
        }
        
        public function getUpdatedContent() {
            return ($this->state >= SENT) ? $this->updatedContent : UNDEFINED;
        }

        public function getCryptedHash() {
            return ($this->state != DOESNT_EXISTS) ? $this->cryptedHash : UNDEFINED;
        }
        
        public function getPublicKey() {
            return ($this->state != DOESNT_EXISTS) ? $this->publicKey : UNDEFINED;
        }
        
        public function getModul() {
            return ($this->state != DOESNT_EXISTS) ? $this->n : UNDEFINED;
        }
        
        public function getCert() {
            return ($this->state != DOESNT_EXISTS) ? $this->cert : UNDEFINED;
        }
        
        public function getState() {
            return $this->state;
        }
        
        private function updateContent($new) {
            if ($this->state != DOESNT_EXISTS) {
                $this->updatedContent = $new;
                $_SESSION[MESSAGE]['updatedContent'] = $new;
            }
        }
        
        private function updateState($state) {
            if ($this->state != DOESNT_EXISTS) {
                $this->state = $state;
                $_SESSION[MESSAGE]['state'] = $state;
            }
        }
        
        private function initialize() {
            if (isset($_SESSION[MESSAGE])) {
                $this->content = $_SESSION[MESSAGE]['content'];
                $this->updatedContent = $_SESSION[MESSAGE]['updatedContent'];
                $this->cryptedHash = $_SESSION[MESSAGE]['crypt'];
                $this->publicKey = $_SESSION[MESSAGE]['publicKey'];
                $this->n = $_SESSION[MESSAGE]['n'];
                $this->cert = $_SESSION[MESSAGE]['cert'];
                $this->state = $_SESSION[MESSAGE]['state'];
            }
        }
        
        public function destroy() {
            if ($this->state == DOESNT_EXISTS) return;
            
            unset($_SESSION[MESSAGE]);
            $this->content = '';
            $this->updatedContent = '';
            $this->cryptedHash = '';
            $this->publicKey = '';
            $this->n = '';
            $this->cert = '';
        }
        
        public function send($content, $cryptedHash, $publicKey, $n, $cert) {
            if ($this->state != DOESNT_EXISTS) return;
            
            $this->content = $content;
            $this->cryptedHash = $cryptedHash;
            $this->publicKey = $publicKey;
            $this->n = $n;
            $this->cert = $cert;
            $this->state = SENT;
            
            $_SESSION[MESSAGE]['content'] = $content;
            $_SESSION[MESSAGE]['updatedContent'] = $content;
            $_SESSION[MESSAGE]['crypt'] = $cryptedHash;
            $_SESSION[MESSAGE]['publicKey'] = $publicKey;
            $_SESSION[MESSAGE]['n'] = $n;
            $_SESSION[MESSAGE]['cert'] = $cert;
            $_SESSION[MESSAGE]['state'] = SENT;
        }
        
        public function modify($newContent = '') {
            if ($this->state != SENT) return;
            
            if ($newContent != '') $this->updateContent($newContent);
            
            $this->updateState(PASSED);
        }
        
        public function receive() {
            if ($this->state != PASSED) return;
            
            $this->destroy();
        }
    }
?>