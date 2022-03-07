
let wordFinal = ['','','','',''];
let try_ = ['','','','',''];
let abc = ['Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','Ñ','Z','X','C','V','B','N','M'];

let v = 1;
let blean = false;
let delete_k;
let btn_play = true;

function write_(letra){
    if(blean == true){
        if(try_[0] == '' || try_[1] == '' || try_[2] == '' || try_[3] == '' || try_[4] == ''){
            for(let i=0; i<abc.length; i++){
                if(abc[i]==letra){
                    let k=1;
                    for(let j=0; j<try_.length; j++){
                        if(try_[j]==''){
                            try_[j] = letra;
                            document.getElementById('try'.concat(k).concat(v)).innerHTML = letra;
                            delete_k = k;
                            break;
                        }
                        k++;
                    }
                }
            }
        }
    }
}

function comprobar(){
    if(blean == true){
        if(try_[0] == '' || try_[1] == '' || try_[2] == '' || try_[3] == '' || try_[4] == ''){
            // Faltan letras
        }else{
            let x = 1;
            let win=1;
            for(let i=0; i<try_.length; i++){
                if(try_[i] == wordFinal[i]){
                    win++;
                    document.getElementById('try'.concat(x).concat(v)).style = 'background-color:#67b956; border: solid 2px #67b956;';
                    if(win == 6){
                        blean = false;
                        fin(true);
                        // Juego ganado
                    }
                }else{
                    for(let k=0; k<try_.length; k++){
                        if(try_[i] == wordFinal[k]){
                            document.getElementById('try'.concat(x).concat(v)).style = 'background-color:#d4d668; border: solid 2px #d4d668;';
                        }else{
                            document.getElementById('try'.concat(x).concat(v)).style = 'background-color:#212121; border: solid 2px #212121;';
                        }
                    }
                    if(v == 6 && i == 4){
                        blean = false;
                        fin(false);
                        break;
                        // Juego perdido
                    }
                }
                x++;
            }
            v++;

            for(let i=0; i<try_.length; i++){
                try_[i] = '';
            }

        }
    }
}

function play_(){
    document.getElementById('main3').style = 'display: none;';
    document.getElementById('main1').style = 'display: none;';
    document.getElementById('footer1').style = 'display: none;';
    document.getElementById('resumen').style = 'display: none;';
    document.getElementById('main2').style = 'display: flex;';
    clean();
}

function fin(exito){

    document.getElementById('main1').style = 'display: none;';
    document.getElementById('main2').style = 'display: none;';
    document.getElementById('footer1').style = 'display: none;';
    document.getElementById('resumen').style = 'display: none;';
    document.getElementById('main3').style = 'display: block;';
    
    if(exito == true){
        document.getElementById('exito').innerHTML = 'Congratulations!';
    }else{
        document.getElementById('exito').innerHTML = 'You almost got it!';
    }
}

function newGame(){
    document.getElementById('main3').style = 'display: none;';
    document.getElementById('play_').style = 'display: none;';
    document.getElementById('main2').style = 'display: none;';
    document.getElementById('main1').style = 'display: flex;';
    document.getElementById('footer1').style = 'display: block;';
    document.getElementById('resumen').style = 'display: block;';

    
    clean();
    generarClave();

}

function clean(){
    try_ = ['','','','',''];
    v = 1;

    for(let i=1; i<7; i++){
        for(let k=1; k<6; k++){
            document.getElementById('try'.concat(k).concat(i)).innerHTML = '';
            document.getElementById('try'.concat(k).concat(i)).style = 'border: solid 2px #404040; background-color:transparent;';
        }
    }
}

function borrar(){
    if(delete_k < 1){
        // Esta todo borrado
    }else{
        document.getElementById('try'.concat(delete_k).concat(v)).innerHTML = '';
        try_[delete_k-1] = '';
        delete_k--;
    }
}

// Funcion provisional, se hará con el contrato al hacer la apuesta para que pague el gas el jugador y sean ilimitados los intentos y limitar la apuesta.
function generarClave(){
    if(blean == false){
        blean = true;

        for(let i=0; i<wordFinal.length; i++){
            let numRandom = Math.floor(Math.random()*abc.length+1);
            wordFinal[i] = abc[numRandom];
            if(wordFinal[i] == undefined){
                i--;
            }
        }

        //Ver clave
        let clave = '';
        for(let i=0; i<wordFinal.length; i++){
            clave = clave + wordFinal[i];
        }

        //alert(clave);
    }
}

function redirect(where){
    if(where == 'twitter'){
        window.location.href = "https://twitter.com/auto_token";
    }else if(where == 'whitepaper'){
        window.location.href = "https://unlockpadlock.gitbook.io/unlock-padlock/";
    }
}
