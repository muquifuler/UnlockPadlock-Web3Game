<!DOCTYPE html>
<?php

    session_start();
    
    if(isset($_POST['h_wallet'])){

        for ($i = 1; $i<9; $i++) {
            for ($j = 1; $j<6; $j++) {
                unset($_SESSION["try".$j.$i]);  
            }
        }

        $address = $_POST['h_wallet'];
        $hash = $_POST['hash'];

        $_SESSION['h_wallet'] = $_POST['h_wallet'];
        unset($_SESSION['file']);
        $conexion=mysqli_connect('localhost','u505721908_muquifuler','SkDoL:&M;2*','u505721908_autotoken') or die ('Error en la conexion');  
        mysqli_select_db($conexion,'u505721908_autotoken')or die("problemas al conectar con la base de datos");
    
        $sql="INSERT INTO `UnlockPadlock`(address, hash) VALUES ('$address','$hash')";
    
        $ejecutar=mysqli_query($conexion,$sql);
        mysqli_close( $conexion );
        echo "Primera vez";
    }else{
        for ($i = 1; $i<9; $i++) {
            for ($j = 1; $j<6; $j++) {
                if(isset($_POST["_try".$j.$i])){
                    $_SESSION["try".$j.$i] = $_POST["_try".$j.$i];  
                    echo $_SESSION["try".$j.$i];
                }else{
                    $_SESSION["try".$j.$i] = '';  
                }
            }
        }
    }
    if(isset($_POST['file'])){
        $_SESSION['file'] = $_POST['file'];
        echo $_SESSION['file'];
        echo $_SESSION['h_wallet'];
    }

    $address = $_SESSION['h_wallet'];

    $mysqli = new mysqli('localhost','u505721908_muquifuler','SkDoL:&M;2*','u505721908_autotoken');
    $query = $mysqli -> query ($sql = "SELECT `hash` FROM `UnlockPadlock` WHERE address = \"$address\";");     
    $valores = mysqli_fetch_array($query);
    $hash_ = $valores[hash];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UnlockPadlock - Game</title>
    <link rel="stylesheet" href="./styles/styles-index.css">
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sha256-js-tools@1.0.2/lib/sha256.min.js"></script>
    <script src="./js/app.js"></script>
    <script>
/*
window.addEventListener('load', function() {
    for(let i=1; i<9; i++){
        if(i == <?php //echo $_SESSION['file']; ?>){
            v=i;
        }
    }
})*/

function borrar(){
    v = parseInt(document.getElementById('file').value, 10);
    if(delete_k < 1){
        // Esta todo borrado
    }else{
        document.getElementById('try'.concat(delete_k).concat(v)).innerHTML = '';
        try_[delete_k-1] = '';
        delete_k--;
    }
}

async function res(account) { //Comprobar gratis en Padlock.sol
            const res = await window.contract.methods.comprobarLinea(try_, document.getElementById('hash_').value).call({ from: account });
            return res;
        }

async function comprobarLinea() { //Comprobar
    v = parseInt(document.getElementById('file').value, 10);
    if(try_[0] == '' || try_[1] == '' || try_[2] == '' || try_[3] == '' || try_[4] == ''){

    }else{
        for(let i=1; i<6; i++){
            document.getElementById('_try'.concat(i).concat(v)).value = document.getElementById('try'.concat(i).concat(v)).innerHTML;
        }

        pgo = 0;
        const account = await getCurrentAccount();
        let res_ = await res(account);
        let x = 1;

        for(let i=0; i<try_.length; i++){
            if(res_[i] == "2"){
                document.getElementById('try'.concat(x).concat(v)).style = 'background-color:#67b956; border: solid 2px #67b956;';
            }else if(res_[i] == "1"){
                document.getElementById('try'.concat(x).concat(v)).style = 'background-color:#d4d668; border: solid 2px #d4d668;';
            }else if(res_[i] == "0"){
                document.getElementById('try'.concat(x).concat(v)).style = 'background-color:#212121; border: solid 2px #212121;';
            }
            x++;
        }

        if(res_[0] == "2" && res_[1] == "2" && res_[2] == "2" && res_[3] == "2" && res_[4] == "2"){
            if(v == 1){
                decimal = false;
                pgo = 100; 
            }else if(v == 2){
                decimal = false;
                pgo = 50;
            }else if(v == 3){
                decimal = false;
                pgo = 20;
            }else if(v == 4){
                decimal = false;
                pgo = 10;
            }else if(v == 5){
                decimal = false;
                pgo = 4;
            }else if(v == 6){
                decimal = false;
                pgo = 2;
            }else if(v == 7){
                decimal = false;
                pgo = 1;
            }else if(v == 8){
                pgo = 0.5;
                decimal = true;
            }
            const amount = await window.contract.methods.getUserAmount().call({ from: account });
            if(pgo == 0.5){
                amount_ = (amount/2)*pgo;
                pgo=1;
            }else{
                amount_ = amount*pgo;
            }
            setTimeout(function(){
                clean();
                document.getElementById('bool').value = true;
                document.getElementById('amount_').value = amount_;
                document.getElementById('decimal').value = decimal;
                document.fin.submit();
            },2000);
            // Juego ganado
        }

        if(!(res_[0] == "2" && res_[1] == "2" && res_[2] == "2" && res_[3] == "2" && res_[4] == "2") && v == 8){
            setTimeout(function(){
                clean();
                document.getElementById('bool').value = false;
                document.getElementById('amount_').value = 0;
                document.getElementById('decimal').value = false;
                document.fin.submit();
            },2000);
            // Juego perdido
        }        
        v++;
        y=v;
        document.getElementById('file').value = v;
        for(let i=0; i<try_.length; i++){
            try_[i] = '';
        }
        document.line.submit();

    }
}

function clean(){
    try_ = ['','','','',''];
    v = 1;

    for(let i=1; i<9; i++){
        for(let k=1; k<6; k++){
            document.getElementById('try'.concat(k).concat(i)).innerHTML = '';
            document.getElementById('try'.concat(k).concat(i)).style = 'border: solid 2px #404040; background-color:transparent;';
        }
    }
}

function _write(letra){
    v = parseInt(document.getElementById('file').value, 10);
    if((try_[0] == '' || try_[1] == '' || try_[2] == '' || try_[3] == '' || try_[4] == '')  && ( y == v )){
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

</script>
</head>
<body>
    <input type="hidden" name="hash_" id="hash_" value="<?php echo $hash_ ?>">
    <header>
        <div style="display: flex; margin-top: 2vh; margin-bottom: 2vh;">
            <div style="margin-left: auto;">
                <img onclick="redirect('whitepaper')" class="ico" src="https://img.icons8.com/fluency-systems-regular/50/000000/news.png"/>
                <img onclick="alert('tutorial')" class="ico" src="https://img.icons8.com/fluency-systems-regular/50/000000/idea.png"/>
            </div>
            <span class="title" onclick="redirect('index')">Unlock Padlock</span>
            <div style="margin-right: auto;">
                <img onclick="alert('comprar una pista, proximamente')" class="ico" src="https://img.icons8.com/fluency-systems-regular/50/000000/key.png"/>
                <img onclick="redirect('github')" class="ico" src="https://img.icons8.com/small/512/000000/github.png"/>
            </div>
        </div>
        <hr style="margin-bottom: 2vh;">
    </header>

    <form method="post" action="./claim.php" name="fin" id="fin">
        <input type="hidden" name="bool">
        <input type="hidden" name="amount_">
        <input type="hidden" name="decimal">
    </form>

    <main id="main1">
        <table class="table1">
            <form method="post" action="./game.php" name="line" id="line">
            <input type="hidden" name="file" id="file" value="<?php if(isset($_SESSION['file'])){ echo $_SESSION['file']; } else {?>1 <?php } ?>">
            <tr>
                <input type="hidden" name="_try11" id="_try11"><td class="td1" id="try11"><?php if(isset($_SESSION['try11'])){ echo $_SESSION['try11']; }?></td></input>
                <input type="hidden" name="_try21" id="_try21"><td class="td1" id="try21"><?php if(isset($_SESSION['try21'])){ echo $_SESSION['try21']; }?></td></input>
                <input type="hidden" name="_try31" id="_try31"><td class="td1" id="try31"><?php if(isset($_SESSION['try31'])){ echo $_SESSION['try31']; }?></td></input>
                <input type="hidden" name="_try41" id="_try41"><td class="td1" id="try41"><?php if(isset($_SESSION['try41'])){ echo $_SESSION['try41']; }?></td></input>
                <input type="hidden" name="_try51" id="_try51"><td class="td1" id="try51"><?php if(isset($_SESSION['try51'])){ echo $_SESSION['try51']; }?></td></input>
                <td class="x">x100</td> 
            </tr>
            <tr>
                <input type="hidden" name="_try12" id="_try12"><td class="td1" id="try12"><?php if(isset($_SESSION['try12'])){ echo $_SESSION['try12']; }?></td></input>
                <input type="hidden" name="_try22" id="_try22"><td class="td1" id="try22"><?php if(isset($_SESSION['try22'])){ echo $_SESSION['try22']; }?></td></input>
                <input type="hidden" name="_try32" id="_try32"><td class="td1" id="try32"><?php if(isset($_SESSION['try32'])){ echo $_SESSION['try32']; }?></td></input>
                <input type="hidden" name="_try42" id="_try42"><td class="td1" id="try42"><?php if(isset($_SESSION['try42'])){ echo $_SESSION['try42']; }?></td></input>
                <input type="hidden" name="_try52" id="_try52"><td class="td1" id="try52"><?php if(isset($_SESSION['try52'])){ echo $_SESSION['try52']; }?></td></input>
                <td class="x">x50</td>
            </tr>
            <tr>
                <input type="hidden" name="_try13" id="_try13"><td class="td1" id="try13"><?php if(isset($_SESSION['try13'])){ echo $_SESSION['try13']; }?></td></input>
                <input type="hidden" name="_try23" id="_try23"><td class="td1" id="try23"><?php if(isset($_SESSION['try23'])){ echo $_SESSION['try23']; }?></td></input>
                <input type="hidden" name="_try33" id="_try33"><td class="td1" id="try33"><?php if(isset($_SESSION['try33'])){ echo $_SESSION['try33']; }?></td></input>
                <input type="hidden" name="_try43" id="_try43"><td class="td1" id="try43"><?php if(isset($_SESSION['try43'])){ echo $_SESSION['try43']; }?></td></input>
                <input type="hidden" name="_try53" id="_try53"><td class="td1" id="try53"><?php if(isset($_SESSION['try53'])){ echo $_SESSION['try53']; }?></td></input>
                <td class="x">x20</td>
            </tr>
            <tr>
                <input type="hidden" name="_try14" id="_try14"><td class="td1" id="try14"><?php if(isset($_SESSION['try14'])){ echo $_SESSION['try14']; }?></td></input>
                <input type="hidden" name="_try24" id="_try24"><td class="td1" id="try24"><?php if(isset($_SESSION['try24'])){ echo $_SESSION['try24']; }?></td></input>
                <input type="hidden" name="_try34" id="_try34"><td class="td1" id="try34"><?php if(isset($_SESSION['try34'])){ echo $_SESSION['try34']; }?></td></input>
                <input type="hidden" name="_try44" id="_try44"><td class="td1" id="try44"><?php if(isset($_SESSION['try44'])){ echo $_SESSION['try44']; }?></td></input>
                <input type="hidden" name="_try54" id="_try54"><td class="td1" id="try54"><?php if(isset($_SESSION['try54'])){ echo $_SESSION['try54']; }?></td></input>
                <td class="x">x10</td>
            </tr>
            <tr>
                <input type="hidden" name="_try15" id="_try15"><td class="td1" id="try15"><?php if(isset($_SESSION['try15'])){ echo $_SESSION['try15']; }?></td></input>
                <input type="hidden" name="_try25" id="_try25"><td class="td1" id="try25"><?php if(isset($_SESSION['try25'])){ echo $_SESSION['try25']; }?></td></input>
                <input type="hidden" name="_try35" id="_try35"><td class="td1" id="try35"><?php if(isset($_SESSION['try35'])){ echo $_SESSION['try35']; }?></td></input>
                <input type="hidden" name="_try45" id="_try45"><td class="td1" id="try45"><?php if(isset($_SESSION['try45'])){ echo $_SESSION['try45']; }?></td></input>
                <input type="hidden" name="_try55" id="_try55"><td class="td1" id="try55"><?php if(isset($_SESSION['try55'])){ echo $_SESSION['try55']; }?></td></input>
                <td class="x">x4</td>
            </tr>
            <tr>
                <input type="hidden" name="_try16" id="_try16"><td class="td1" id="try16"><?php if(isset($_SESSION['try16'])){ echo $_SESSION['try16']; }?></td></input>
                <input type="hidden" name="_try26" id="_try26"><td class="td1" id="try26"><?php if(isset($_SESSION['try26'])){ echo $_SESSION['try26']; }?></td></input>
                <input type="hidden" name="_try36" id="_try36"><td class="td1" id="try36"><?php if(isset($_SESSION['try36'])){ echo $_SESSION['try36']; }?></td></input>
                <input type="hidden" name="_try46" id="_try46"><td class="td1" id="try46"><?php if(isset($_SESSION['try46'])){ echo $_SESSION['try46']; }?></td></input>
                <input type="hidden" name="_try56" id="_try56"><td class="td1" id="try56"><?php if(isset($_SESSION['try56'])){ echo $_SESSION['try56']; }?></td></input>
                <td class="x">x2</td>
            </tr>
            <tr>
                <input type="hidden" name="_try17" id="_try17"><td class="td1" id="try17"><?php if(isset($_SESSION['try17'])){ echo $_SESSION['try17']; }?></td></input>
                <input type="hidden" name="_try27" id="_try27"><td class="td1" id="try27"><?php if(isset($_SESSION['try27'])){ echo $_SESSION['try27']; }?></td></input>
                <input type="hidden" name="_try37" id="_try37"><td class="td1" id="try37"><?php if(isset($_SESSION['try37'])){ echo $_SESSION['try37']; }?></td></input>
                <input type="hidden" name="_try47" id="_try47"><td class="td1" id="try47"><?php if(isset($_SESSION['try47'])){ echo $_SESSION['try47']; }?></td></input>
                <input type="hidden" name="_try57" id="_try57"><td class="td1" id="try57"><?php if(isset($_SESSION['try57'])){ echo $_SESSION['try57']; }?></td></input>
                <td class="x">x1</td>
            </tr>
            <tr>
                <input type="hidden" name="_try18" id="_try18"><td class="td1" id="try18"><?php if(isset($_SESSION['try18'])){ echo $_SESSION['try18']; }?></td></input>
                <input type="hidden" name="_try28" id="_try28"><td class="td1" id="try28"><?php if(isset($_SESSION['try28'])){ echo $_SESSION['try28']; }?></td></input>
                <input type="hidden" name="_try38" id="_try38"><td class="td1" id="try38"><?php if(isset($_SESSION['try38'])){ echo $_SESSION['try38']; }?></td></input>
                <input type="hidden" name="_try48" id="_try48"><td class="td1" id="try48"><?php if(isset($_SESSION['try48'])){ echo $_SESSION['try48']; }?></td></input>
                <input type="hidden" name="_try58" id="_try58"><td class="td1" id="try58"><?php if(isset($_SESSION['try58'])){ echo $_SESSION['try58']; }?></td></input>
                <td class="x">x0.5</td>
            </tr>
            </form>
        </table>
    </main>
    <footer id="footer1">
        <div class="buttons">
            <div class="teclado">
                <button onclick="_write('Q')" >Q</button>
                <button onclick="_write('W')" >W</button>
                <button onclick="_write('E')" >E</button>
                <button onclick="_write('R')" >R</button>
                <button onclick="_write('T')" >T</button>
                <button onclick="_write('Y')" >Y</button>
                <button onclick="_write('U')" >U</button>
                <button onclick="_write('I')" >I</button>
                <button onclick="_write('O')" >O</button>
                <button onclick="_write('P')" >P</button>
            </div>
            <div class="teclado">
                <button onclick="_write('A')">A</button>
                <button onclick="_write('S')">S</button>
                <button onclick="_write('D')">D</button>
                <button onclick="_write('F')">F</button>
                <button onclick="_write('G')">G</button>
                <button onclick="_write('H')">H</button>
                <button onclick="_write('J')">J</button>
                <button onclick="_write('K')">K</button>
                <button onclick="_write('L')">L</button>
                <button onclick="_write('-')">-</button>
            </div>
            <div class="teclado">
                <button style="width: 15%;" onclick="comprobarLinea()">SEND</button>
                <button onclick="_write('Z')">Z</button>
                <button onclick="_write('X')">X</button>
                <button onclick="_write('C')">C</button>
                <button onclick="_write('V')">V</button>
                <button onclick="_write('B')">B</button>
                <button onclick="_write('N')">N</button>
                <button onclick="_write('M')">M</button>
                <button style="width: 15%;" onclick="borrar()"><</button>
            </div>
        </div>
    </footer>
</body>
</html>