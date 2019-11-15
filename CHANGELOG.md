# CHANGELOG

## v2.0 (Release: aa-bbb-cccc)
* NEW FEATURE: `Game::Board` for getting the board number of the game
* MAJOR CHANGE: Getter and setter methods have been removed. (Please see [0d8a325](https://github.com/JeroenED/libpairtwo/commit/0d8a325eb501b775830f68fa6f600f9f4ca5588c) for more info)
* CHANGE: Some fields has been renamed to match coding guideline (Please see [1ab96fa](https://github.com/JeroenED/libpairtwo/commit/1ab96fa04782c1b0f2b6bb9d1bac8397a74ab38e) for more info)
* CHANGE: Logo has been redesigned
* REMOVED: `Tiebreak::American` and all its uses were removed (Please see [a6015ae](https://github.com/JeroenED/libpairtwo/commit/a6015ae8169f0973f4937605d0f807aacc233630) for more info)

## v1.2 (Release: 28-sep-2019)
* NEW READER: `Readers\Swar-4` for reading out files created with SWAR version 4.
* NEW FEATURE: `Tournament::getArbiters()` for multiple arbiters in 1 tournament
* ENHANCEMENT: `Class::getBinaryData()` methods return null if field is non-existent
* ENHANCEMENT: The template in distributions provides a more usable starting implementation
* ENHANCEMENT: The template in distributions is renamed to template.php
* CHANGE: `Tournament::getArbiter()` accepts a `int` parameter representing the order of the arbiters
* BUGFIX: `Player:getId()` returned elo instead of id
* BUGFIX: `Tournament::calculateBuchholz()` did not return the correct score when player had unplayed rounds
* BUGFIX: `Tournament::calculateMutualResult()` returned NULL if result was invalid
* BUGFIX: `Tournament::calculateBaumbach()` treated bye as won
* BUGFIX: `Tournament::calculateAverageRating()` returned NaN if no games were played
* BUGFIX: Distributions could be created from a branch other than master

## v1.1.2 (Release: 21-jun-2019)
* ENHANCEMENT: Added update section to dist/readme.md
* MAJOR BUGFIX: `Game::GetResult` threw fatal error `Cannot access parent:: when current class scope has no parent`

## v1.1.1 (Released: 20-jun-2019)
* NEW FEATURE: Added clean-dist and clean-dev targets
* ENHANCEMENT: Better Docs generation
* ENHANCEMENT: Resized logo in Doxygen for better fit
* ENHANCEMENT: Doxygen takes branch name or version tag as `PROJECT_NUMBER`
* CHANGE: Version tag directly put in distribution filename
* CHANGE: `Tournament::GameExists()` renamed to `Tournament::gameExists()`
* CHANGE: Updated composer metadata
* CHANGE: Some setters changed to fluent setters. (More info: [7aca350](https://github.com/JeroenED/libpairtwo/commit/7aca35057c10d2b982f93a698499c0c01df2fdc5))
* CHANGE: Kashdan and Soccer Kashdan are combined in 1 function
* BUGFIX: Tagging did not work

## v1.1 (Released: 20-jun-2019)
* NEW FEATURE: Libpairtwo distribution releases (use these if you don't have knowledge of composer or dependency management)
* NEW FEATURE: Soccer Kashdan (aka: kashdan using 3-1-0 scoring)
* MAJOR CHANGE: Model Classes has been removed
* CHANGE: Deprecated `sws::class` was removed
* CHANGE: Added a logo to the project
* CHANGE: Replaced PhpDoc with Doxygen
* BUGFIX: `Tournament::getParticipants()` did not return a correct value

## v1.0.2 (Released: 05-jun-2019)
* NEW FEATURE: `Player::getPlayedGames()` to return the number of played games
* BUGFIX: `Tournament::calculateBuchholz()` always returned 0
* BUGFIX: `Tournament::calculateMutualResult()` only took account of last tiebreak instead all previous

## v1.0.1 (Released: 04-jun-2019)
* BUGFIX: `Round::getBye()` did not return bye players

## v1.0  (Released: 03-jun-2019)
* Initial release
