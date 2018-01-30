<?php

// helper functions for comparisons
function quality($a, $b) {
    return $b->quality - $a->quality;
}

function speed($a, $b) {
    return $b->speed - $a->speed;
}
    

class Player
{
    public $position, $quality, $speed;

    public function __construct($position, $quality, $speed) 
    {
        $this->position = $position; // 0 = goalies, 1 = defender, 2 = midfielder, 3 = striker
        $this->quality = $quality; // 0 - lowest, 100 - highest
        $this->speed = $speed;  // 0 - lowest, 100 - highest
        // $this->injured = $injured;
        // $this->inFormation = false;
    }

    // perhaps this should be a static function and take number as argument to save memory?
    public function readablePosition() {
        return ['goalie(0)', 'defender(1)', 'midfielder(2)', 'striker(3)'][$this->position];
    }

    public function listPlayerProfile() 
    {
        echo "position: " . $this->readablePosition() . ", quality: " . $this->quality . ", speed: " . $this->speed . "\n";
    }

}

class Team 
{

    protected $name;
    public $allPlayers =[];

    public function __construct($name = 'unnamed')
    {
        $this->name = $name;
    }

    // randomly adds players, position is number coded
    public function addPlayersToTeam($position = null, $numOfPlayers = 1)
    {
        $position === null ? rand(0,2) : $position; // if no position value was input, random position will be applied
        for ($i = 1; $i <= $numOfPlayers; $i++ ) {
            $this->allPlayers[] = new Player($position, rand(0,100), rand(0,100));        
        }
    }

    static public function matchInformation($message) {
        echo "================================= \n$message\n";
    }

    public function useFormation($defendersNeeded, $midfieldersNeeded, $strikersNeeded, $sortDefendersBy = 'quality', $sortMidfieldersBy = 'quality', $sortStrikersBy = 'quality') 
    {
        // $goalies = $defenders = $midfielders = $strikers = $gameLineup = [];
        // QUESTION: was considering making these arrays as their own class of objects so that 
        // I could group their sorting functions nicer, this all being one functions seems messy?
        foreach ($this->allPlayers as $player) {
                switch($player->position) {
                    case 0:
                        $goalies[] = $player;
                        break;
                    case 1:
                        $defenders[] = $player;
                        break;
                    case 2:
                        $midfielders[] = $player;
                        break;
                    case 3:
                        $strikers[] = $player;
                        break;
                }
        }

        // check if formations can still be populated due to injury losses 
        if (count($goalies) < 1 || count($defenders) < $defendersNeeded || 
            count($midfielders) < $midfieldersNeeded || count($strikers) < $strikersNeeded ) 
            {
                return "Your team doesn't have the players it needs for this match!";
            }

        // sort players by quality or speed, whichever was passed as an argument
        usort($goalies, 'quality');
        usort($defenders, $sortDefendersBy);
        usort($midfielders, $sortMidfieldersBy);
        usort($strikers, $sortStrikersBy);

        // only take the needed number of players from each array         
        $goalies = array_slice($goalies, 0, 1);
        $defenders = array_slice($defenders, 0, $defendersNeeded);
        $midfielders = array_slice($midfielders, 0, $midfieldersNeeded);
        $strikers = array_slice($strikers, 0, $strikersNeeded);

        $gameLineup = array_merge($goalies, array_merge($defenders, array_merge($midfielders, $strikers)));
        foreach ($gameLineup as $player) {
            $player->listPlayerProfile(); 
        }

        // randomize the player who got injured, announce and remove him from the team
        $injured = $gameLineup[rand(0,count($gameLineup) -1)];

        echo "The match was successful, we won! Our " . $injured->readablePosition() . " was injured. We cannot use this player anymore.\n" ;

        foreach ($this->allPlayers as $index => $player) {
            if ($player === $injured) {
                unset($this->allPlayers[$index]); 
            }
        }

    }
}