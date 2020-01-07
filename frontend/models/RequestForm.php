<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Leave;
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
     $end   = date_parse_from_format("d.m.Y", $this->date_finish);



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
    /*
        Метод getLeave  проверяет есть ли заявка у данного юзера
        Принимает в параметры сущность user
        Возвращает завку из бд или новую, созданную им 
     */
    private function getLeave($user){
        
        switch ($user->status) {

            case User::STATUS_NONE :

               $leave = new Leave();
                break;

           case User::STATUS_WAIT :
                // echo '///////////';
                $leave= Leave::findByUserid($user->id);
                // User::print($leave);
                break;

        }

        return $leave;

    }

            /*
            
            */
    public function request(){

               if (!$this->validateDate()) {
                    return false;
                }
                
                $user =User::findIdentity(Yii::$app->user->identity->id);
                // User::print($user->status);
                $leave = $this->getLeave($user);
                // User::print($leave);
                
                $leave->user_id         = $user->id;
                $leave->user_first_name = $user->first_name;
                $leave->user_last_name  = $user->last_name;
                $leave->date_start      = $this->date_start;
                $leave->date_finish     = $this->date_finish;
                
                $user->status           = User::STATUS_WAIT;
                $user->save();
               
                return $leave->save();

    }
}