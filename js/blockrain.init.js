(function ($, document, window) {
    $(document).ready(function(){
        var $game = $('.tetris-game');
        $game.blockrain({
            autoplay: false, // Let a bot play the game
            autoplayRestart: true, // Restart the game automatically once a bot loses
            showFieldOnStart: true, // Show a bunch of random blocks on the start screen (it looks nice)
            theme: 'gameboy', // The theme name or a theme object
            //blockWidth: 24, // How many blocks wide the field is (The standard is 10 blocks)
            autoBlockWidth: true, // The blockWidth is dinamically calculated based on the autoBlockSize. Disabled blockWidth. Useful for responsive backgrounds
            autoBlockSize: 24, // The max size of a block for autowidth mode
            difficulty: 'normal', // Difficulty (normal|nice|evil).
            speed: 20, // The speed of the game. The higher, the faster the pieces go.
            noPreview: false, // Whether to show a preview

            // Copy
            playText: 'Let\'s play some Tetris',
            playButtonText: 'Play',
            gameOverText: 'Game Over',
            restartButtonText: 'Play Again',
            scoreText: 'MyScore',

            // Basic Callbacks
            onStart: function(){
                //$(document).on( 'mousemove', function(evt) {
                //    $game.blockrain('pause');
                //});
            },
            onRestart: function(){
                $(document).on( 'mousemove', function(evt) {
                    $game.blockrain('pause');
                });
            },
            onGameOver: function(score){

            },
            onKeyPress: function(evt) {
                switch(evt.keyCode) {
                    case 27: $game.blockrain('gameover'); break;
                    case 32: $game.blockrain('pause'); break;
                }
            },
            onPreview: function(){},

            // When a line is made. Returns the number of lines, score assigned and total score
            onLine: function(lines, scoreIncrement, score){}
        });

        // Score
        //$game._$score = $(
        //    '<div class="blockrain-score-holder" style="position:absolute;">'+
        //    '<div class="blockrain-score">'+
        //    '<div class="blockrain-score-msg">'+ this.options.scoreText +'</div>'+
        //    '<div class="blockrain-score-num">0</div>'+
        //    '</div>'+
        //    '</div>').hide();
        //$game._$scoreText = game._$score.find('.blockrain-score-num');
        //$game._$gameholder.append(game._$score);

        console.log($game);
        window.wps = {
            game: $game
        };
    });

    //var $game = $('.tetris-game');
    //
    //// Start the game
    //$game.blockrain('start');
    //
    //// Restart the game
    //$game.blockrain('restart');
    //
    //// Trigger a game over
    //$game.blockrain('gameover');
    //// Pause
    //$game.blockrain('pause');
    //
    //// Resume
    //$game.blockrain('resume');
    //// Enable or Disable Autoplay (true|false)
    //$game.blockrain('autoplay', true);
    //// Enable or Disable Controls (true|false)
    //$game.blockrain('controls', true);
    //
    //
    //// THEME
    //// You can provide a theme name...
    //$game.blockrain('theme', 'vim');
    //
    //// Or a theme object. **Check out src/blockrain.jquery.themes.js** for examples.
    //$game.blockrain('theme', {
    //    background: '#ffffff',
    //    primary: '#ff7b00',
    //    secondary: '#000000'
    //});
    //
    //// Return the current score
    //var score = $game.blockrain('score');
})(jQuery, document, window);