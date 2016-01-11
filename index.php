<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Celia's Tic Tac Toe Game</title>
    </head>
    <body>
        <?php
        if (!isset($_GET['board'])) {
            $squares = '---------';
        } else {
            $squares = $_GET['board'];
        }

        $game = new Game($squares); //creates a game 

        

        if ($game->winner('x')) {
            echo 'You win.';
        } else if ($game->winner('o')) {
            echo 'I win.';
        } else {
            echo 'No winner yet, but you are losing.';
            $game->pick_move();
        }

        $game->display(); //displays the board *
        
        
        class Game {

            //board position property
            var $position;

            //constructor to take a position parameter
            function __construct($squares) {
                $this->position = str_split($squares);
            }

            //winning conditions
            function winner($token) {
                $won = false;

                //checking diagonal tokens
                if (($this->position[0] == $token) && ($this->position[4] == $token) && ($this->position[8] == $token)) {
                    $won = true;
                } else if (($this->position[2] == $token) && ($this->position[4] == $token) && ($this->position[6] == $token)) {
                    $won = true;
                }
                //checking left to right tokens
                for ($row = 0; $row < 3; $row++) {
                    if (($this->position[3 * $row] == $token) && ($this->position[3 * $row + 1] == $token) && ($this->position[3 * $row + 2] == $token)) {
                        $won = true;
                    }
                }
                //checking up to down tokens
                for ($col = 0; $col < 3; $col++) {
                    if (($this->position[$col] == $token) && ($this->position[$col + 3] == $token) && ($this->position[$col + 6] == $token)) {
                        $won = true;
                    }
                }
                return $won;
            }

            function display() {
                echo '<p>Welcome to George, the evil Tic-Tac-Toe Game.</p>';
                echo '<table cols="3" style="font-size:large; font-weight:bold;">';
                echo '<tr>'; //open the first row
                for ($pos = 0; $pos < 9; $pos++) {
                    echo $this->show_cell($pos);
                    if ($pos % 3 == 2) {
                        echo '</tr><tr>';
                    } //start a new row for the next square
                }
                    echo '</tr>'; //close the last row
                    echo '</table><br>';
                
            }

            function show_cell($which) {
                $token = $this->position[$which]; //deal with the easy case
                if ($token <> '-') {
                    return '<td>' . $token . '</td>';
                }
                //now the hard case
                $this->newposition = $this->position; //copy the original
                $this->newposition[$which] = 'o'; // this would be their move
                $move = implode($this->newposition); //make a string from the board array
                $link = '?board=' . $move; //this is what we want the link to be
                // so return a cell containing an anchor and showing a hyphen
                return '<td><a href="' . $link . '">-</a></td>';
            }
            
            function pick_move() {
                $win = false;
                do { 
                    //finds an empty spot and makes a move
                    $move = rand(0, 8);
                    if ($this->position[$move] == '-') {
                        $this->position[$move] = 'x';
                        $win = true;
                    }
                }
                // keeps moving until a winner is reached.
                while (!$win);
            }

        }
        ?>
    </body>
</html>
