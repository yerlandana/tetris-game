<?php 
session_start();
if (empty($_SESSION["name"])){
    header("location: index.php");
    exit;
}
?>


<style>
    * {
        /*outline: 1px dotted #F7168E; */
    }
    .empty {
        width: 50px;
        height: 50px;
        display: inline-block;
    }
    .squareShape {
        width: 50px;
        height: 50px;
        background-color:#FF1493;
        outline: 2px solid black;
        display: inline-block;
    }
    #world {
        background-color: #0B0B61;
        background-repeat: no-repeat;
        margin-left: 58px;
        margin-right: 780px;
    }
    #NScore{
        font-size: 40px;
        margin-left: 700px;
    }
    #game{
        background-repeat: no-repeat;
    }
    #sty{
        font-size: 40px;
    }
</style>


<!-- HTML Code -->
<div id="sty" align ="center">TETRIS</div>
<div id="game">
<div id='world'>
</div>
<div id="NScore">Score: 0</div>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
       <h1 align ="center"> Welcome, <?php echo htmlspecialchars($_SESSION
     ["name"]); ?></h1>
    <h2 align ="center"><a href="signout.php">Sign Out</a></h2>

   </div>
   
</body>
</html>


<!-- JavaScript Code: -->
<script>
     var Score=0;
     
     var world = [
        [0,0,0,1,1,0,0,0],
        [0,0,0,1,1,0,0,0],
        [0,0,0,0,0,0,0,0],
        [0,0,0,0,0,0,0,0],
        [0,0,0,0,0,0,0,0],
        [0,0,0,0,0,0,0,0],
        [0,0,0,0,0,0,0,0],
        [0,0,0,0,0,0,0,0],
        [0,0,0,0,0,0,0,0],
        [0,0,0,0,0,0,0,0],
        [0,0,0,0,0,0,0,0],
        [0,0,0,0,0,0,0,0],
    ];
    function drawWorld() {
        document.getElementById('world').innerHTML = "";
        for(var y=0; y<world.length; y++) {
            for(var x=0; x<world[y].length; x++) {
                if(world[y][x]=== 0){
                    document.getElementById('world').innerHTML += "<div class='empty'></div>";
                } else if(world[y][x]=== 1 || world[y][x]=== 11){
                    document.getElementById('world').innerHTML += "<div class='squareShape'></div>";
                }
            }
            document.getElementById('world').innerHTML += "<br>";
        }
    }
    function moveShapesDown() {
        canMove = true;
        for(var y=world.length-1; y>=0; y--) {
            for(var x=0; x<world[y].length; x++) {
                if(world[y][x] > 0 && world[y][x] < 10 ){
                    if(y+1 === world.length || world[y+1][x] > 10){
                        canMove = false;
                        freeze();
                    }
                }
            }
        }
        if (canMove) {
            for(var y=world.length-1; y>=0; y--) {
                for(var x=0; x<world[y].length; x++) {
                    if(world[y][x] > 0 && world[y][x] < 10 ){
                        world[y+1][x] = world[y][x];
                        world[y][x] = 0;
                    }
                }
            }
            drawWorld();
        }
        checkLines();
    }
    function moveShapesLeft() {
        canMove = true;
        for(var y=world.length-1; y>=0; y--) {
            for(var x=0; x<world[y].length; x++) {
                if(world[y][x] > 0 && world[y][x] < 10 ){
                    if(x === 0 || world[y][x-1] > 10){
                        canMove = false;
                    }
                }
            }
        }
        if (canMove) {
            for(var y=world.length-1; y>=0; y--) {
                for(var x=0; x<world[y].length; x++) {
                    if(world[y][x] > 0 && world[y][x] < 10 ){
                        world[y][x-1] = world[y][x];
                        world[y][x] = 0;
                    }
                }
            }
            drawWorld();
        }
    }
    function moveShapesRight() {
        canMove = true;
        for(var y=world.length-1; y>=0; y--) {
            for(var x=0; x<world[y].length; x++) {
                if(world[y][x] > 0 && world[y][x] < 10 ){
                    if(x === 7 || world[y][x+1] > 10){
                        canMove = false;
                    }
                }
            }
        }
        if (canMove) {
            for(var y=world.length-1; y>=0; y--) {
                for(var x=world[y].length; x>=0; x--) {
                    if(world[y][x] > 0 && world[y][x] < 10 ){
                        world[y][x+1] = world[y][x];
                        world[y][x] = 0;
                    }
                }
            }
            drawWorld();
        }
    }
    function freeze(){
        for(var y=world.length-1; y>=0; y--) {
            for(var x=0; x<world[y].length; x++) {
                if(world[y][x] > 0 && world[y][x] < 10 ){
                    world[y][x] = world[y][x] + 10;
                }
            }
        }
        checkLines();
        world[0] = [0,0,0,1,0,0,0,0]
        world[1] = [0,0,0,1,0,0,0,0]
        world[2] = [0,0,0,1,0,0,0,0]
        world[3] = [0,0,0,1,0,0,0,0]
    }
    function checkLines(){
        for(var y=world.length-1; y>=0; y--) {
            fullLine = true;
            for(var x=0; x<world[y].length; x++) {
                if(world[y][x] < 10) {
                    fullLine = false;
                }
            }
            if (fullLine) {
                world.splice(y, 1);
                world.splice(0, 0, [0,0,0,0,0,0,0,0])
                y++;
                Score=Score+1;
                document.getElementById('NScore').innerHTML=Score;
                console.log("Score", Score);
            }
        }
    }
    document.onkeydown = function(e) {
        console.log(e)
        if (e.keyCode === 37){
            moveShapesLeft(); 
        } else if (e.keyCode === 39){
            moveShapesRight();
        } else if (e.keyCode === 40){
            moveShapesDown();
        }
    }
    function gameLoop(){
        moveShapesDown();
        drawWorld();
        setTimeout(gameLoop, 100);
    }
    drawWorld();
    gameLoop();

    
</script>