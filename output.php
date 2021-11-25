<?php
/**
 * Question:
 * Create a dice game script where it can receive input N which is the number of players and input
 * M which is the number of dice for each player. These are the game rules:
 * 1. At the beginning of the game, each player would receive an M unit dice..
 * 2. Each player would throw their dice at the same time.
 * 3. Each player then would check their own dice results, and make these evaluations:
 *      a. Dice with 6 number would be removed from the game. The player would receive
 *         1 victory point.
 *      b. Dice with 1 number would be given to their neighbor player.
 *      c. Dice with 2,3,4 and 5 numbers would be kept for the next round.
 * 4. After evaluation, the player who has no dice should not play anymore. They also cannot
 *    receive dice after this round.
 * 5. If at the end of evaluation only one player has dice, the game would end.
 * 6. Players with the biggest victory point win the game. In case of tie, both players win the
 *    game.
 * Create the script using the language you are most comfortable with.
 */

class RollTheDiceGame{
    // {{{ properties
    /**
     * $player stores the number of player playing the game.
     * @var integer $player
     */
    private $player;
    /**
     * $dice stores the total number of initial dice.
     * @var integer
     */
    private $dice;
    // }}}

    /**
     * @param integer $p
     * @param integer $d
     */
    public function __construct($p,$d)
    {
        $this->player = $p;
        $this->dice = $d;
    }

    /**
     * @returns the array of the winners.
     */
    public function start(){
        /**
         * Output
         */
        echo "Player=".$this->player." Dice=".$this->dice."<br>";
        // Assign Number of Dice to Each Player
        $p= array_fill(0,$this->player,$this->dice);
        // The Default Score for Each Player is 0
        $s = array_fill(0,$this->player,0);
        $p_dice=0;

        do{
            $p_dice = 0;
            //Temporary hold the dice values for each player.
            $temp_dice = [];
            /**
             * Output
             */
            echo "###############################<br>";
            echo " Turn:<br>";
            echo "###############################<br>";
            for($i=0;$i<$this->player;$i++){
                echo "Player(".($i+1)."):";
                if($p[$i]>0){
                    //Roll The Dice and Get the Array of Numbers
                    $temp_dice[$i] = $this->roll_the_dice($p[$i]);
                    /**
                     * Output
                     */
                    foreach($temp_dice[$i] as $t){
                        echo $t.",";
                    }
                    echo "<br>";
                    $p_dice++;
                }
                else{
                    $temp_dice[$i] = [];
                    /**
                     * Output
                     */
                    foreach($temp_dice[$i] as $t){
                        echo $t.",";
                    }
                    echo "<br>";
                }
            }
            echo "........................................<br>";
            echo "Evaluation:<br>";
            echo "........................................<br>";

            //Evaluation
            for($i=0;$i<$this->player;$i++){
                if(count($temp_dice[$i])>0){
                    $temp_count = count( array_keys($temp_dice[$i], 6));
                    if($temp_count>0){
                        $p[$i]-=$temp_count;
                        $s[$i]+=$temp_count;
                    }
                    $temp_count = count(array_keys($temp_dice[$i], 1));
                    if($temp_count){
                        if($i==$this->player-1){
                            if($p[$i]>0){
                                $p[0]+=$temp_count;
                                $p[$i]--;
                            }
                        }
                        else{
                            if($p[$i]>0){
                                $p[$i+1]+=$temp_count;
                                $p[$i]--;
                            }
                        }
                    }
                }
            }
            
            for($i=0;$i<$this->player;$i++){
                echo "Player(".($i+1)."):".$p[$i]."<br>";
            }
            echo "#<br>";
            for($i=0;$i<$this->player;$i++){
                echo "Score(".($i+1)."):".$s[$i]."<br>";
            }
        }
        while($p_dice>1);
        return array_keys($s,max($s));
    }

    /**
     * $d = Total Number of dice
     * @param integer
     * @returns the array of number of dice
     */
    private function roll_the_dice($d){
        $a = [];
        for($i=0;$i<$d;$i++){
            $a[$i] = rand(1,6);
        }
        return $a;
    }
}

/**
 * Main Program
 */
$solution = new RollTheDiceGame(3,4);
// Start the code execution
$solution = $solution->start();
// Printing the output
echo "Player ";
for($i=0;$i<count($solution);$i++){
    echo $solution[$i]+1;
    echo ",";
}
echo "wins the game!";