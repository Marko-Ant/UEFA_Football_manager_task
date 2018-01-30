<?php 

require 'models.php';

echo "Welcome, randomly generating your starting team\n";

$beasties = new Team('Beasties');

$beasties->addPlayersToTeam(0,2); // add 2 goalies
$beasties->addPlayersToTeam(1,6); // add 6 defenders
$beasties->addPlayersToTeam(2,10); // add 10 midfielders
$beasties->addPlayersToTeam(3,4); // add 4 strikers

// game 1
Team::matchInformation("First game against a stronger opponent. Using 5-4-1 formation with the fastest striker!");
$beasties->useFormation(5,4,1,'quality','quality','speed');
// game 2
Team::matchInformation("Second game against an opponent of similar skill. Using 4-4-2 formation with our best players!");
$beasties->useFormation(4,4,2); // defaulting to just quality
// game 3
Team::matchInformation("Third game against a weaker opponent. Using 3-4-3 formation with focus on quality.");
$beasties->useFormation(3,4,3); // defaulting to just quality
