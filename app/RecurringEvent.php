<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecuringEvent
 *
 * @author vlada
 */

class RecurringEvent {
    /** @var DateTime */
    protected $startDate;
    /** @var DateTime */
    protected $endDate;
    /** @var string */
    protected $timeZone;


    /** @var array */
    protected $repeatDays;
    /** @var array */
    protected $repeatWeeks;
    /** @var array */
    protected $repeatMWF;  // reapeat Monday, Wednesday, Friday
    /** @var array */
    protected $repeatMonths;
    /** @var array */
  
    
    /** @var string */
    protected $frequency;
    
    /** @var int */
    protected $interval;
    /** @var int */
    protected $repetition = 0;
    
    /** @var DateTime */
    protected $sampleDate;
    
    
    protected $enabledDays = false;
  
    protected $weekInMonths;
    protected $numDaysOfMonth;


    protected $generatedDates = array();
    
    protected $firstDayOfWeek = 0;
    
     
    protected $output = array();
    
    
    
    protected $validDays =  array('SU', 'MO', 'TU', 'WE', 'TH', 'FR', 'SA');
    protected $validFrequency = array("DAILY", "WEEKLY", "MWF", "MONTHLY", "YEARLY");
    
    public function __construct() {
        $this->repeatDays = range(0, 6); // 0 = Sunday
        $this->repeatWeeks = range(1, 54);
        $this->repeatMWF = array("MO", "WE", "FR");
        $this->repeatMonths = range(1, 12);
        
        $this->endDate = new DateTime('2100-12-31');
        
        $this->interval = 1;
        
    }
    
    public function recurr($startDate, $frequency = "daily", $timeZone = "Europe/Belgrade"){
        try {
            if(is_object($startDate)){
                $this->startDate = clone $startDate;
            }else{
                $this->startDate = new DateTime($startDate, new DateTimeZone($timeZone));
                $this->sampleDate = clone $this->startDate;
            }
        } catch (Exception $e) {
            throw new Exception("The start date isn't valid. It must be DateTime format.", $e);
        }
        
        $this->setFreq($frequency);
    }
    
    
    public function setFreq($freq){
        $freq = strtoupper($freq);
        
        if(in_array($freq, $this->validFrequency)){
            $this->frequency = $freq;
        }else{
            throw new Exception("Invalid type of freqvency");
        }
    }
    
    public function setDays(array $days){
        if(is_array($days)){
            $this->repeatDays = $days;
            $this->enabledDays = true;
            
            
            $this->weekInMonths = $this->sampleDate->format('w');
            $this->numDaysOfMonth = $this->sampleDate->format('t');
        }  else {
            throw new Exception("Invalid type of day");
        }
    }
    
    public function setMonths(array $month){
        if(is_array($month)){
            $this->repeatMonths = $month;           
        }else{
            throw new Exception("Invalid type of month");
        }
    }
    
       
    public function setWeeks(array $weeks){
        if(is_array($weeks)){
            $this->repeatWeeks = $weeks;
        }  else {
            throw new Exception("Invalid type of day");
        }
    }
    
    public function setInterval($int){
        $interval = (int) $int;

        if ($interval < 1) {
            throw new Exception('Interval must be a positive integer');
        }
        
        $this->interval =  $interval;
    }
    
    public function setRepetition($coutner){
        $coutner = (int) $coutner;

        if ($coutner < 1) {
            throw new Exception('Interval must be a positive integer');
        }
        
        $this->repetition =  $coutner;
    }
    
    public function until($date){
        try {
            if(is_object($date)){
                $this->endDate = clone $date;
            }else{
                $this->endDate = new DateTime($date);
                
            }
        } catch (Exception $e) {
            throw new Exception("The until date isn't valid. It must be DateTime format.", $e);
        }
    }
    
   
    protected function generateDates(){
 
        switch($this->frequency){

                case "WEEKLY":
                    $interval = 'week';
                    break;
                case "MWF":
                    $interval = "day";
                    break;
                case "DAILY":
                    $interval = 'day';
                    break;
                case "MONTHLY":
                    $interval = 'month';
                    break;
                case "YEARLY":
                    $interval = 'year';
                    break;
              
        }
        
        $currentDayInMonth = $this->sampleDate->format('j');
        $month = $this->sampleDate->format('n');
        $year = $this->sampleDate->format('Y');
        
        $time = $this->sampleDate->format('H:i:s');
        //var_dump($interval);
        
        if($this->frequency == "WEEKLY"){
            $this->generatedDates[] = clone $this->sampleDate;
            
            
            $tmpDay = $currentDayInMonth;
            if($this->enabledDays == true){

   
                $condition = true;
                while($condition){
                      $tmpDay++;  
                      if($tmpDay >= $this->numDaysOfMonth){

                           $condition = false;
                      }
                      
                      $currentDate = new DateTime($year."-".$month. "-". $tmpDay. " ".$time);
                      $this->generatedDates[] = clone $currentDate;
                  
                }
                
            }
           
        }elseif($this->frequency == "DAILY"){
            $this->generatedDates[] = clone $this->sampleDate;
        }elseif($this->frequency =='MWF'){
            //$interval = "day";
            $this->setDays(array("MO", "WE", "FR"));
            $this->generatedDates[] = clone $this->sampleDate;
        }elseif ($this->frequency == "MONTHLY") {
            $this->generatedDates[] = clone $this->sampleDate;
        }elseif ($this->frequency == "YEARLY") {
            $this->generatedDates[] = clone $this->sampleDate;
        }
        
        
        $this->sampleDate->modify($this->interval ." ". $interval);
    }
    
    protected function validDate($date) {
        $dayOfWeek = strtoupper(substr($date->format("l"), 0, 2));
      
        if(in_array($dayOfWeek, $this->repeatDays)){
            return true;
        }else{
            return false;
        }
        
        
    }
    
    protected function iterate() {   
      if(count($this->generatedDates) === 0)
        {
                $this->generateDates();
        }
        
        
        while(count($this->generatedDates) > 0){
                $firstDate = array_shift($this->generatedDates);

                if($firstDate > $this->endDate){
                        return false;
                }
                
                if($this->validDate($firstDate) === true){
  
                    return $firstDate;
                }else{
                        
                    if(count($this->generatedDates) === 0){   

                            $this->generateDates();
                    }
                }

               
        }
    }
    
    public function toArray(){
        $count = 0;
        while ($result = $this->iterate()){
        
            if($this->repetition != 0){
                if($count >= $this->repetition ){
                    continue;
                }
            }
           array_push($this->output, $result);
           $count++;
        }
        
        return $this->output;
    }
    
    public function toJson(){
        return json_encode($this->toArray());
    }
    
}
