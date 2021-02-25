<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

use kekaadrenalin\imap;
use kekaadrenalin\imap\Mailbox;



/**
 * UploadForm is the model behind the upload form.
 */
class Mail extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
        ];
    }

    static public function GetMail(){
        $mailbox = new Mailbox(yii::$app->imap->connection);

        $mailIds = $mailbox->searchMailBox(); // Gets all Mail ids.

        return $mailIds;
    }
}