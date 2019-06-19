# CHANGELOG

## vx.x.x (Released: xx-xxx-xx)
* NEW FEATURE: Libpairtwo distribution releases (use these if you don't have knowledge of composer or dependency management)
* NEW FEATURE: Soccer Kashdan (aka: kashdan using 3-1-0 scoring)
* MAJOR CHANGE: Model Classes has been removed
* CHANGE: Deprecated `sws::class` was removed
* CHANGE: Added a logo to the project
* CHANGE: Replaced PhpDoc with Doxygen
* BUGFIX: `Tournament::getParticipants()` did not return a correct value

## v1.0.2 (Released: 05-jun-2019)
* NEW FEATURE: `Player::getPlayedGames()` to return the number of played games
* BUGFIX: Calculating Buchholz tiebreak always returned 0
* BUGFIX: Calculating Mutual Result only took account of last tiebreak instead all previous

## v1.0.1 (Released: 04-jun-2019)
* BUGFIX: `Round::getBye()` did not return bye players

## v1.0  (Released: 03-jun-2019)
* Initial release