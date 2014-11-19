<?php
/**
 * Created by PhpStorm.
 * User: Develop
 * Date: 09.09.14
 * Time: 15:14
 */

namespace unid\view\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\FlashMessenger;

class ShowMessages extends AbstractHelper
{
    public function __invoke()
    {
        $messenger = new FlashMessenger();

        $error_messages = $messenger->getErrorMessages();
        $success_messages =  $messenger->getSuccessMessages();
        $messages = $messenger->getMessages();

        $result = '';
        if (count($error_messages)) {
            $result .= '<div class="alert alert-error">
            <button id="<?php echo $new->id; ?>" type="button" class="close" data-dismiss="alert">&times;</button>
            ';
            foreach ($error_messages as $message) {
                $result .= '<li>' . $message . '</li>';
            }
            $result .= '</div>';
        }

        if (count($messages)) {
            $result .= '<div class="alert alert-info">
            <button id="<?php echo $new->id; ?>" type="button" class="close" data-dismiss="alert">&times;</button>
            ';
            foreach ($messages as $message) {
                $result .= '<li>' . $message . '</li>';
            }
            $result .= '</div>';
        }

        if(count($success_messages)){
            $result .= '<div class="alert alert-success">
            <button id="<?php echo $new->id; ?>" type="button" class="close" data-dismiss="alert">&times;</button>
            ';
            foreach ($success_messages as $message) {
                $result .= '<li>' . $message . '</li>';
            }
            $result .= '</div>';
        }
        return $result;
    }
}