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

    static public function GetMail_Resourse(){  //получить и розарсить письмо с веромосттьюресурсов
        $mailbox = new Mailbox(yii::$app->imap->connection);

        $mailIds = $mailbox->searchMailBox(); // Gets all Mail ids.
        
        
    
        foreach($mailIds as $mailId){
            // Returns Mail contents
            
            $mail = $mailbox->getMail($mailId);

            // Read mail parts (plain body, html body and attachments
            $mailObject = $mailbox->getMailParts($mail);
       
            
            $pattern ='/DID:\d+/i';
            preg_match($pattern,$mailObject->subject, $id_str,PREG_OFFSET_CAPTURE, 3); 
            
            $pattern ='/\d+/i';
            preg_match($pattern,$id_str[0][0], $id_obj,PREG_OFFSET_CAPTURE, 3); 
          
            
            
            if($model=Main::findOne((int)$id_obj[0][0])){
                  
                    $attachments = $mailObject->getAttachments();
                    $last_att_name='';
                    foreach($attachments as $attachment){
                        if($last_att_name!=$attachment->name){
                            
                            $last_att_name=$attachment->name;
                            $filename=mt_rand(100000,999000);
                            
                            Yii::$app->session->setFlash('success', 'файли знайдено  id '.$id_obj[0][0]);

                            preg_match('/\.[a-z]{1,4}$/i',$attachment->name, $id_name,PREG_OFFSET_CAPTURE, 3);
                            
                            $new_fil_adr=Yii::$app->params['BaseFilePath'].'/'.$id_obj[0][0].'/4/'.$filename.$id_name[0][0];
                            
                            
                            if(copy($attachment->filePath, $new_fil_adr)){
                                    //    Yii::$app->session->setFlash('success', 'файли скопійовано  id '.$id_obj[0][0]);                   
                                // сохраняем инфу поро файл в базу таблица файлов
                                
                                $dowmFile= new Files();
                                $dowmFile->name = $attachment->name;
                                $dowmFile->url = $id_obj[0][0].'/4/'.$filename.$id_name[0][0];
                                $dowmFile->data_create= time();
                                $dowmFile->id_creator=61; //id 61 пользователь mail 
                                $dowmFile->save(false);
                                
                                // сохраняем инфу в таблицу main файл ресурсов
                                
                                //$data_file=json_decode($model->file_resoyrs_report, true);
                                $data_file[]=['id'=>Files::findOne(['url'=>$id_obj[0][0].'/4/'.$filename.$id_name[0][0]])->id, 'name'=> $attachment->name , 'r_type'=>'final'];

                                $model->file_vor_final=json_encode($data_file);

                                $model->save(false);
                            }
                        }
                        // Delete attachment file
                        unlink($attachment->filePath);
                        
                    }
                    
            }
           
          $mailbox->deleteMail($mailId); // Mark a mail to delete
        }
    }
    static function TestMail(){
                $message[$send] =Yii::$app->mailer->compose();
                $message[$send]->setFrom('ppryednyanna@gmail.com');
                $message[$send]->setTo('a.butenko@oe.net.ua');
                $message[$send]->setSubject('Стандартні Тест');
                $message[$send]->setTextBody('Тест прошел успешно');
                   
                //$message[$send]->setHtmlBody("<b>У вкладеному файлі ви знайдете ");
                //$message[$send]->attach($url);
                $message[$send]->send();
    }
}