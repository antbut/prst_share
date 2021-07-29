<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;


use app\models\Main;
use app\models\Organizations;

use kekaadrenalin\imap;
use kekaadrenalin\imap\Mailbox;


/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CronController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }
    
  
    public function  actionDroppidrfromobject(){
        
            $models= Main::find()->where(['!=','data_add_dok_poj',0])->all();
           
      
            echo "start ". date('H:i d.M.Y',time()). " \n ";
            foreach ($models as $key => $data) {
                       
                        if(time()- $data->data_add_dok_poj<432000 ){
                            
                                $secs=  ($data->data_add_dok_poj+432000)- time();
                                $res = array();
    
                                $res['days'] = floor($secs / 86400);
                                $secs = $secs % 86400;
                                
                                $res['hours'] = floor($secs / 3600);
                                $secs = $secs % 3600;
                             
                                $res['minutes'] = floor($secs / 60);
                                $res['secs'] = $secs % 60;
                            
                //            return $res['days'].' д '.$res['hours'].' г';
                        }else{
                             if($data->status_pidr!=1 && $data->status_objekt<2){
                                if($data->status_pidr!=3){

                                    $model_org= Organizations::findOne($data->pidr);
                                  //  $model_org->kill_deny_porj=$model_org->kill_deny_porj+1;
                                    $model_org->save();
                                    
                                    $data->pidr=0;
                                    $data->status_pidr=2;
                                    $data->data_add_dok_poj=0;

                                    $data->save(false);
                                    echo $data->n_dogoovor.' Час вичерпано '."\n" ;
                                }
                             }

                              
                        }
            }
                    
            return ExitCode::OK;
    }

    public function  actionGetmailvor(){ //получить письмо с подписью от проверяющего
        

     //   $mailbox = new Mailbox(yii::$app->imap->connection);

       // $mailIds = $mailbox->searchMailBox(); // Gets all Mail ids.
                $mailIds=Mail::GetMail();
       // print_r($mailIds);
        /*
        
        foreach($mailIds as $mailId){
            // Returns Mail contents
            $mail = $mailbox->getMail($mailId);

            // Read mail parts (plain body, html body and attachments
            $mailObject = $mailbox->getMailParts($mail);

            // Array with IncomingMail objects
           // print_r($mailObject);


            //обработка письма

            echo '<br>Дата '. $mailObject->date ;
            echo '<br>Тема '.$mailObject->subject ;

            // Returns mail attachements if any or else empty array

            $attachments = $mailObject->getAttachments();
            foreach($attachments as $attachment){
                echo ' Attachment:' . $attachment->name . PHP_EOL;
                echo ' ' . $attachment->filePath . PHP_EOL;

                // Delete attachment file
                unlink($attachment->filePath);
            }
            $mailbox->deleteMail($mailId); // Mark a mail to delete

        }

        //$mailbox->expungeDeletedMails(); // Deletes all marked mails
*/
        return ExitCode::OK;

    }

    
	
   
    
}