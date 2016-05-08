##Champion Master Finder - Riot Games API Challenge 2016 Entry
###Be Fast And Find Your Best Champions!
######by Daniel BGomez (LAN: DanielGomez) & Ivan Aguilera (LAN: ScraguiGamer)

In this Web Based MiniGame, you must find your best champions *( Based on your Champions' Mastery Score )* wich are scattered in a grid that contains your top 10 champions! Only the best of the best will give you points, also the more mastery points it has, the more points you'll earn but it will be less times in the grid. For each level, the champions will worth more points, the last one will be removed and you'll have less time! 

In this game mode all the levels and games are unique, even when the summoner name is the same, since all data is printed completely random! This achieves that there is a different gaming experience for each user. 

###Live Url
> http://championmaster.danielbgomez.com/finder

### How does it Work?
To play you must enter a Summoner Name and select the region of the player to get the best Champion Mastery scores of the player.

Once the information is processed and validated, the game create cookies that store useful data and serve as control:
 - **summoner** - *Contains a JSON array that contains the name and id of the summoner.*
 - **champions** - *Contains a JSON array that contains the top 10 champions based on the score of the champion.*
 - **region** - *Contains the region selected in the Form (Only works to remember the region you selected if you want to play again).*
 - **level** - *Contains the level of the current game.*
 - **score** - *(Default = 0) Contains the previous level score of the current game.*
 - **tries** - *Contains the tries remaining of the current game (Displayed as 'Lives').*

After that, the game begins printing the game board using the next logic:
######With PHP:
 - **Maximum points:** ' 1000 * level '.
 - **Time of the Level:** ' 60 - ( ( level - 1 ) * 10 ) '.
 - ' If time < 5 Then time = 5 '.
 - **Slice Control:** ' If level > 5 Then sliceControl = 5 Else level - 1 '.
   - *( Used to remove 1 champion per level with a limit of 5 ).*
 - **Champions:** *array* That Contains:
   - **Display:** The summoner best champions from ' ( 6 - sliceControl ) to 10'.
     - *These are the ones that are displayed randomly.*
   - **Points:** The summoner best champions from ' 0 to ( 6 - sliceControl ) '.
     - *These are the ones that give you points.*
     - Each champion contains:
       - **Times:** The times that the champion will be displayed.
         - *( Based in a loop that use 'times' starting in 1, and the next value is 'times * 2'; from the best of the best).*
        - **Points:** The points that the champion will give if it's found.
           - *( Based in a loop that use 'points' starting in the 'MaximumPoints', and the next value is 'points * 0.35' (35%); from the best of the best).*
  

######With jQuery/Javascript:
 - **Update the displayed semi-static info.**
   - *Current Level*
   - *Time of the Level*
   - *Current Score*
   - *Current Lives*
 - **Champions:** Store the Champions Data JSON from the Cookie to an jQuery object variable.
   - *As for print the images the game needs the keyname and the API Query only returns the ID, the game merge the data pre-stored in a JSON file at this array.*
 - **Count Points:** Count how many champions give points.
 - **Count Display:** Count how many champions are displayed randomly.
 - **Score:** Store the previous Score.
 - **Total Time:** Store the total time of the level.
 - **Next:** (Default = false) A boolean variable that controls if the next level will be displayed if the time is up.
 - **Game Width:** Width of the game grid in pixels.
 - **Count Width:** 'If the gameWidth > 1000 Then countWidth = integrerValueof ( gameWidth / 80 ) Else countWidth = integrerValueOf ( gameWidth / 60 )'.
   - *How many images fit horizontally.*
 - **Count Height:** 'integrerValueOf ( 200 / countWidth )'.
   - *How many images fit vertically, close to 200.*
 - Using a For loop, print the inner code starting in **y = 0**, meanwhile **y < countHeight**; ( **y++** ):
   - Using a For loop, print the inner code starting in **x = 0**, **meanwhile x < countWidth**; ( **x++** ):
     - Get a random champion from the **'display'** section and print it as the summoner's head image storing the **x**, **y**, **championId** and **k** *( The key of the champion in the array )* in the attributes.
 - After both loops end printing, using a For loop, print the inner code starting in **i = ( countPoints - 1 )**, meanwhile **i >= 0**; ( **i--** ):
   - **Current Champion:** The champions that gives points starting at the one that give less points.
   - Using a For loop, print the inner code starting in **ii = currentChampion.Times**, meanwhile **ii > 0**; ( **ii--** ):
     - Select a random coordinates and replace the image that is there for the selected champion image and data.
 - After all the game board is printed, it Fades In and the timer starts.
   - If the timer reach 0:
     - *This condition uses the 'Next' variable.* 
     - If the user doesn't select any correct answer, the game ends.
     - If the user select at least 1 correct answer, the game continues to the next level.
 - If an image of the game board is clicked:
   - If that image gives points, are added to the total score.
   - If that image is a display image, the user lose a live.
     - If the lives reach 0, the game ends.

####Game Over
If the game ends, it will allow users to store their score on the leaderboard or start a new game.

###Technologies used
The core of the application is write in PHP; to print information it's html, css as if a simple website concerned, and jQuery for dynamic interactions and prints.

We also used the following jQuery scripts:
 - **[jquery-cookie](https://github.com/carhartl/jquery-cookie)**
 - **imagesLoaded**
