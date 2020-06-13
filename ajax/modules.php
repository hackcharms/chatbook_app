<?php
    function formatTime(string $var = null,$nowFlag=false)
    {

        date_default_timezone_set('Asia/Kolkata');
        $oneDay=24*60*60;
        $past_date_second=strtotime($var);
        $seconds_def=(int)((time()-$past_date_second));
        if($seconds_def<2*$oneDay && $seconds_def>$oneDay){
            $mess_time='Yesterday';
        }
        elseif($seconds_def<$oneDay){
            if($nowFlag){$mess_time=$seconds_def<(3*6)?'Online':date('h:i A',$past_date_second);
            }
            else
            $mess_time=date('h:i A',$past_date_second);

        }
        else{
            $mess_time=date('d-m-Y',$past_date_second);
        }
        return $mess_time;
    }
    // echo formatTime('2020-04-29 15:05:26',true);
    ?>