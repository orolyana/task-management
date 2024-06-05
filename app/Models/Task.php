<?php

namespace App\Models;

use App\Constants\TaskConstants;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'priority'];


    public function project(){
        return $this->belongsTo(Project::class, 'id' , 'project_id');
    }

    public function getPriorityStr(){
        return '<span class="' . TaskConstants::getPriorityBadge($this->priority) .'">' .$this->priority .'</span>';

    }

    public function saveValidatedData($validated, $projectId){
      
        $this->name = $validated['name'];
        $this->project_id =  $projectId;

        if($validated['priority'] ==  TaskConstants::Top){
            $this->changeTaskPriorityToTop(); 
        }else{
            $this->priority = $validated['priority'];
        }

        if($this->save()){
            return true;
        }

    }

    public function changeTaskPriorityToTop(){
        $result = 1;
        $currentTopTask = $this->_getCurrentTopTask();
        
        if($currentTopTask){
          $result &= $this->_changeCurrentTopTaskPriorityToDown($currentTopTask);
        }
    
       if($result){
           $result = $this->_updatePriority(TaskConstants::Top);
        }
        
        return $result;
    }

    private function _changeCurrentTopTaskPriorityToDown($currentTopTask){

        if($currentTopTask){
            if($currentTopTask->id == $this->id){
                return false;
            }

            $currentTopTask->_updatePriority(TaskConstants::Down);
            $currentTopTask->saveQuietly();
            
        
            return true;
            
       }

      return false;
            
    }

    private function _updatePriority($priority){
        $this->priority = $priority;
    }

    private function _getCurrentTopTask(){
       return self::where(['priority' => TaskConstants::Top , 'project_id' => $this->project_id])->first();
    }
}
