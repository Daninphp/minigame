<?php
$heroes = [
    'dp'=>"http://i.imgur.com/LVCwbf9.png",
    'tn'=>"https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/b9a404ce-fe9e-4c2f-8628-00419e78c1b1/d2t3gzh-0734563c-eef0-4cd3-b12e-bdc5565e38ae.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2I5YTQwNGNlLWZlOWUtNGMyZi04NjI4LTAwNDE5ZTc4YzFiMVwvZDJ0M2d6aC0wNzM0NTYzYy1lZWYwLTRjZDMtYjEyZS1iZGM1NTY1ZTM4YWUucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.KjR1Bs-4diS0uVmTF4otE9ZSyuLZpA6zUMuAfm-199w",
];
$hero = isset($_GET['hero'])? $heroes[$_GET['hero']]: $heroes['dp'];
?>
<body>
<div id="game" style="width: 800px;height: 600px;position: absolute;overflow: hidden;">
</div>
</body>
<script>
    var heroImage = "<?= $hero ?>";
    var game    = document.getElementById("game");

    var bg = document.createElement("img");
    bg.src      = "img/1.jpg";
    bg.width    = 800;
    bg.px       = 0;
    bg.style.cssText = "position:absolute;top:0px;left0px;";
    game.appendChild(bg);

    var bg1 = document.createElement("img");
    bg1.src   = "img/1.jpg";
    bg1.width = 800;
    bg1.px    = 800;
    bg1.style.cssText = "position:absolute;top:0px;left:800px;";
    game.appendChild(bg1);

    function bgleft(){
        bg.px -= 0.9;
        bg.style.left = bg.px + "px";
        if(bg.px<=-800){
            bg.px = 800;
        }
        bg1.px -= 0.9;
        bg1.style.left = bg1.px + "px";
        if(bg1.px<=-800){
            bg1.px = 800;
        }
    }
    function bgright(){
//        bg.px += 0.9;
//        bg.style.left = bg.px + "px";
//        if(bg.px > 800){
//            bg.px = 0;
//        }
//        bg1.px += 0.9;
//        bg1.style.left = bg1.px + "px";
//        if(bg1.px > 800){
//            bg1.px = -800;
//        }
    }

    var hero        = document.createElement("img");
    hero.src        = heroImage;
    hero.width      = 60;
    hero.px         = 0;
    hero.py         = 0;
    hero.spd        = 0.8;
    hero.cooldown   = 0.5;
    hero.isCooldown = false;
    hero.cooldownTime = 0;
    hero.style.cssText = "top:0px;left:0px;position:absolute;";
    hero.update = function(){
        if(keyPool[37]){
            bgright();
            this.px -= this.spd;
        }
        if(keyPool[39]){
            bgleft();
            this.px += this.spd;
        }
        if(keyPool[38]){
            this.py -= this.spd;
        }
        if(keyPool[40]){
            this.py += this.spd;
        }
        if(keyPool[32] && !this.isCooldown){
            this.isCooldown = true;
            this.cooldownTime = Date.now();
            fire();
        }
        if(this.isCooldown){
            var currentTime = Date.now();
            if(Date.now()-this.cooldownTime>=(this.cooldown*1000)){
                this.isCooldown = false;
            }
        }
        this.style.top  = this.py+"px";
        this.style.left = this.px+"px";
    };
    game.appendChild(hero);

    var keyPool =  {};

    function cbf_key_up(evt){
        delete keyPool[evt.keyCode];
    }
    function cbf_key_down(evt){
        keyPool[evt.keyCode] = true;
    }

    window.onkeydown    = cbf_key_down;
    window.onkeyup      = cbf_key_up;

    function fire(){
        var ball    = document.createElement("img");
        ball.width  = 32;
        ball.src    = "img/aba.png";
        ball.style.cssText= "position:absolute;";
        ball.px = hero.px +20;
        ball.py = hero.py +30;
        ball.style.left = hero.px + 20 + "px";
        ball.style.top = hero.py + 30 +"px";
        ball.spd     =  1.2;
        ball.vely    = -0.4;
        ball.update = function(){
            if(this.px>=parseInt(game.style.width)){
                allObjects.splice(allObjects.indexOf(this),1);
                this.remove();
            }
            this.py += this.vely;
            this.px += this.spd;
            this.style.left = this.px + "px";
            this.style.top = this.py + "px";
            this.vely += 0.02;
        };
        game.appendChild(ball);
        allObjects.push(ball);
    }

    var allObjects = [hero];

    function mainLoop(){
        bgleft();
        for(var i=0;i<allObjects.length;i++){
            allObjects[i].update();
        }
    }
    setInterval(mainLoop, 2);

</script>