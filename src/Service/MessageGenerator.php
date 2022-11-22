<?php
namespace App\Service;
class MessageGenerator
{
    public function getHappyMeassage():string
    {
        $message=[
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',    
        ];
        $index = array_rand($message);
        return $message[$index];
    }
}