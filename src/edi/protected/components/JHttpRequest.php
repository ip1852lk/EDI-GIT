<?php

/**
 * This class prevents CSRF attacts based on a valid session instead of cookies.
 *
 * @author Jongbeom
 */
class JHttpRequest extends CHttpRequest
{

    private $_csrfToken;

    public function getCsrfToken()
    {
        if ($this->_csrfToken === null) {
            $session = Yii::app()->session;
            $csrfToken = $session->itemAt($this->csrfTokenName);
            if ($csrfToken === null) {
                $csrfToken = sha1(uniqid(mt_rand(), true));
                $session->add($this->csrfTokenName, $csrfToken);
            }
            $this->_csrfToken = $csrfToken;
        }
        return $this->_csrfToken;
    }

    public function validateCsrfToken($event)
    {
        if ($this->getIsPostRequest()) {
            $session = Yii::app()->session;
            if ($session->contains($this->csrfTokenName) && isset($_POST[$this->csrfTokenName])) {
                $tokenFromSession = $session->itemAt($this->csrfTokenName);
                $tokenFromPost = $_POST[$this->csrfTokenName];
                $valid = $tokenFromSession === $tokenFromPost;
            } else
                $valid = false;
            if (isset($event)) {
                // 
            }
            if (!$valid) {
                throw new CHttpException(400, Yii::t('app', 'Invalid Request'));
            }
        }
    }

}

?>
