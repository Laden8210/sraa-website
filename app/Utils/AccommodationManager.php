<?php

namespace App\Utils;

class AccommodationManager
{
    private $quarters = [
        'KNCHS',
        'Marbel 7 NHS',
        'Marbel 7 ES',
        'Marbel 5 CES',
        'Esperanza NHS - San Jose Campus',
        'Bacongco NHS',
        'Bacongco ES',
        'Concepcion NHS',
        'Marbel 6 ES',
        'Saravia NHS',
        'Marbel 8 ES',
        'Marbel 1 CES',
        'KCES 1',
        'Main HQ',
    ];

    private $divisions = [
        'Cotabato Province',
        'General Santos City',
        'Kidapawan City',
        'Koronadal City',
        'Saranggani',
        'South Cotabato',
        'Sultan Kudarat',
        'Tacurong City', 
        'Main HQ',
    ];

    private $events = [
        'Archery',
        'Arnis',
        'Badminton',
        'Baseball',
        'Basketball',
        'Billiards',
        'Boxing',
        'Chess',
        'Dancesport',
        'Football',
        'Futsal',
        'Gymnastics',
        'Volleyball',
        'Tennis',
        'Swimming',
        'Table Tennis',
        'Wrestling',
        'Wushu',
        'Pencak Silat',
        'Sepak Takraw',
        'Softball',
        'Taekwondo',
        'Athletics',
        'BOCCE',
        'Goalball',
    ];
    

    public function getQuarters()
    {
        return $this->quarters;
    }

    public function getDivisions()
    {
        return $this->divisions;
    }

    public function getEvents()
    {
        return $this->events;
    }
}
