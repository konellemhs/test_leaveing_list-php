<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii2\validators\DateValidator;
class RequestForm extends Model
{
	public $date_start;
	public $date_finish;
    public $test;
	public $fixied;
   
    private $date_s;
    private $date_f;

  


    public function rules(){
        return [

            [['date_start', 'date_finish'],  'required' ],
            [['date_start', 'date_finish'], 'validateDate'],

        ];
    }


    
	public function attributeLabels() {
        return [
            'test'         => 'sggdsg',
            'date_start'   => 'Дата началa отпуска',
            'date_finish'  => 'Дата окончания отпуска',
           
        ];
    }

    			//сравниваем даты(начало должно быть раньше конца)
    public function validateDate(){
     $start = date_parse_from_format("d.m.Y", $this->date_start);
     $end = date_parse_from_format("d.m.Y", $this->date_finish);



        if ($end['year'] > $start['year']) {
          
            return true;

        }elseif ($end['year'] == $start['year']) {
            
            if ($end['month'] > $start['month']) {

                return true;

            }elseif ($end['month'] == $start['month']) {

                if ($end['day'] > $start['day']) {

                   return true;

                }else{

                        $this->addError('date_start', '"Проверьте дату окончания"');
                         $this->addError('date_finish', '"Дата окончания", не может быть раньше "даты начала"');
                         return false;
                }
            }else{
                     $this->addError('date_start', '"Проверьте дату окончания"');
                     $this->addError('date_finish', '"Дата окончания", не может быть раньше "даты начала"');
                     return false;

            }
        }else{
             $this->addError('date_start', '"Проверьте дату окончания"');
             $this->addError('date_finish', '"Дата окончания", не может быть раньше "даты начала"');
             return false;
        }

    }


    public function request(){

               if (!$this->validateDate()) {
                    return false;
                } 
                $date_s = $this->date_start;
                $date_f = $this->date_finish;
                 $user =User::findIdentity(Yii::$app->user->identity->id);
            
                $user->date_start = $date_s;
                $user->date_finish= $date_f;
              

                return $user->save();

    }
}