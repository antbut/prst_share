<?php

namespace app\models;

use Yii;
use app\models\Files;
use app\models\ObjektLog;
/**
 * This is the model class for table "main".
 *
 * @property int $id
 * @property string $title
 * @property string $adress
 * @property string $n_dogoovor
 * @property float $price_dogovor
 * @property float $price_pidr
 * @property float $price_pidr_end
 * @property int $pidr
 * @property int|null $status_pidr
 * @property int $status_objekt
 * @property int $id_obl
 * @property int $date_create
 * @property string $files_pojekt
 * @property int $id_project_type
 * @property string $file_resoyrs_report
 */
class Main extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'main';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'adress','customer', 'id_district'], 'required'],
            [['title', 'adress', 'files_pojekt', 'file_resoyrs_report'], 'string'],
            [['price_dogovor', 'price_pidr', 'price_pidr_end', 'price_dogovor_end'], 'number'],
            [['pidr', 'status_pidr', 'status_objekt', 'id_obl',  'id_project_type'], 'integer'],
            [['n_dogoovor'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Назва обєкта'),
            'adress' => Yii::t('app', 'Адреса'),
            'n_dogoovor' => Yii::t('app', '№ Проекта'),
            'price_dogovor' => Yii::t('app', 'Ціна договору початкова'),
            'price_pidr' => Yii::t('app', 'Ціна підрядника початкова'),
            'price_dogovor_end' => Yii::t('app', 'Ціна договору остаточна'),
            'price_pidr_end' => Yii::t('app', 'Ціна підрядника остаточна'),
            'pidr' => Yii::t('app', 'Підрядник'),
            'customer' => Yii::t('app', 'Замовник'),
            'status_pidr' => Yii::t('app', 'Рішення підрядника'),
            'status_objekt' => Yii::t('app', 'Статус обєкта'),
            'id_obl' => Yii::t('app', 'Обленерго'),
            'date_create' => Yii::t('app', 'Дата створення'),
            'files_pojekt' => Yii::t('app', 'Files Pojekt'),
            'id_project_type' => Yii::t('app', 'Тип проекту'),
            'file_resoyrs_report' => Yii::t('app', 'File Resoyrs Report'),
	       'date_last_update' => Yii::t('app', 'Останнє оновлення'),
            'id_district'=> Yii::t('app', 'Район'),
			'date_norm_run_work'=> Yii::t('app', 'Нормативна дата виконання роботи')
        ];
    }

    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {

            $this->date_last_update=time(); //дата последнего изминения обєкта
            // смена статуса обєкта
            

            if($this->status_objekt==4 && $this->files_smeta!=null && $this->price_pidr!=0 && $this->price_dogovor!=0 ){

                foreach (json_decode($this->files_smeta, true) as $key => $value) {
                    if($value['s_type']=='p'){
                        foreach (json_decode($this->files_smeta, true) as $key => $value) {
                            if($value['s_type']=='d'){
                                $this->status_objekt=5;
                                break;
                            }
                        }
                        break;
                    }
                }

            }
            if($this->status_objekt==5){

                if($this->price_dogovor_end!=0 && $this->price_pidr_end!=0 && $this->status_pidr_pd==1){
                    $this->status_objekt=6;
                }
            }
        }
        return true;

    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    
    //    Yii::$app->session->setFlash('success', 'Данні по обєкту змінені '.$this->id);


        



        $SendTo=[];
 
       // $model = $this->findModel($id);
        
        if($this->status_objekt==1){   // Россылка что обэкт создан

          //  echo 'pidr '.;
            $pidr=User::find()->where(['id_organization'=>$this->pidr])->all(); // підрядники
            foreach ($pidr as $key => $value) {
               $SendTo[]=$value->email;
            }

            $dir_sc=User::find()->where(['id_organization'=>$this->id_obl])->all(); // директора сервісного центру
            foreach ($dir_sc as $key => $value) {
               if(AuthAssignment::findOne(['user_id'=>$value->id, 'item_name'=>'Oblenergo'])){
                    $SendTo[]=$value->email;
               }
            }

            foreach ($SendTo as $send){
                $message[$send] =Yii::$app->mailer->compose();
                $message[$send]->setFrom('ppryednyanna@gmail.com');
                $message[$send]->setTo($send);
                $message[$send]->setSubject('Стандартні приєднання ');
                $message[$send]->setTextBody('Додані нові обєкти на порталі'. $this->n_dogoovor);
                   
                //$message[$send]->setHtmlBody("<b>У вкладеному файлі ви знайдете ");
                //$message[$send]->attach('/var/www/html/temp_data/'.$key.' '.$month.'.pdf');
                $message[$send]->send();
                
                //  unset($message);
               // echo "Mail is send  $send \n";
            }
        }


        // ---- логирование- происходящего c обєктом

        $log_model= new ObjektLog();
        $log_model->date=time();
        $log_model->id_obl=$this->id_obl;
        $log_model->id_objekt=$this->id;
        $log_model->changet_colum=json_encode($changedAttributes);

        $log_model->id_user=Yii::$app->user->id;

        $log_model->id_pidr=$this->pidr;

        if($this->status_objekt!=null){       
            $log_model->priority=$this->status_objekt;
        }else{
            $log_model->priority=0;
        }
        
        if($changedAttributes['pidr']!=0 && $this->pidr==0){
            $log_model->id_pidr=$changedAttributes['pidr'];
        }
        if($changedAttributes['pidr']!=0 && $this->pidr!=0){
            $log_model->id_pidr=$changedAttributes['pidr'];
        }


        if($this->status_objekt==0 && $changedAttributes['title']==null && isset($changedAttributes['status_objekt'])){
            $log_model->coment = 'обєкт створено';
        }

        if($this->close_objekt==1){
            $log_model->coment = 'обєкт закрито';
        }

        
           
        

        if(isset($changedAttributes['status_objekt'])){
            $log_model->priority=10;
        }

        if(isset($changedAttributes['pidr'])){
            $log_model->priority=2;
            if($this->pidr==0 && $changedAttributes['pidr']!=0){
                $log_model->coment = $log_model->coment.'підрядника скинуто в корзину';
            }
            if($this->pidr!=0 && $changedAttributes['pidr']==0){
                $log_model->coment = $log_model->coment.'обєкт забрано з корзини';
            }
        }



        $log_model->save(false);


        /*
        if($this->status_objekt==3){  // розсылка ведомости обема работ реальной

             $SendTo=['a.butenko@oe.net.ua'];
             $SendTo=explode(",", SysParam::GetParam('mail_info_vor'));
             foreach (json_decode ($this->file_resoyrs_report,true) as  $value) {
                        //echo '<p>'. $value['name'];
                        if( $value['r_type']=='d'){
                           $url=Yii::$app->params['BaseFilePath'].'/'.Files::findOne($value['id'])->url;
                        }

                        
                      }

            foreach ($SendTo as $send){
                $message[$send] =Yii::$app->mailer->compose();
                $message[$send]->setFrom('ppryednyanna@gmail.com');
                $message[$send]->setTo($send);
                $message[$send]->setSubject('DID:'.$this->id. ' Стандартні приєднання');
                $message[$send]->setTextBody('Вам надіслано Відомість обєму робіт по договору '. $this->n_dogoovor);
                   
                //$message[$send]->setHtmlBody("<b>У вкладеному файлі ви знайдете ");
                $message[$send]->attach($url);
                $message[$send]->send();
                
                //  unset($message);
               // echo "Mail is send  $send \n";
            }

        }
        if($this->status_objekt==4 && $this->tupe_prodj_work==2){

            if(!$insert){
                
                if(isset($changedAttributes['tupe_prodj_work'])){                    

                    $SendTo=['a.butenko@oe.net.ua'];

                    $SendTo=explode(",", SysParam::GetParam('mail_info_d2'));
                    foreach ($SendTo as $send){
                        $message[$send] =Yii::$app->mailer->compose();
                        $message[$send]->setFrom('ppryednyanna@gmail.com');
                        $message[$send]->setTo($send);
                        $message[$send]->setSubject('Стандартні приєднання Проект по Д2');
                        $message[$send]->setTextBody('Договір №'. $this->n_dogoovor. 'Пішов по напрямку Д2 ' );
                           
                        //$message[$send]->setHtmlBody("<b>У вкладеному файлі ви знайдете ");
                        //$message[$send]->attach($url);
                        $message[$send]->send();
                        
                        //  unset($message);
                       // echo "Mail is send  $send \n";
                    }
                }
            }
        }*/



        

    }
}
