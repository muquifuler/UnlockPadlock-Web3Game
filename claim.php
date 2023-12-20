<!DOCTYPE html>
<?php

    session_start();

    for ($i = 1; ; $i++) {
        for ($j = 1; ; $j++) {
            $_SESSION["try".$j.$i] = '';
        }
    }
    
    $_SESSION['bool'] = $_POST['bool'];
    $_SESSION['amount_'] = $_POST['amount_'];
    $_SESSION['decimal'] = $_POST['decimal'];

    $address = $_SESSION['h_wallet'];

    $mysqli = new mysqli('localhost','u505721908_muquifuler','SkDoL:&M;2*','u505721908_autotoken');

    $query = $mysqli -> query ($sql = "UPDATE `UnlockPadlock` SET `hash`=\"\" WHERE address = \"$address\";");
    $valores = mysqli_fetch_array($query);
    
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>UnlockPadlock - Claim</title>
        <link rel="stylesheet" href="./styles/styles-index.css">
        <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sha256-js-tools@1.0.2/lib/sha256.min.js"></script>
        <script src="./js/app.js"></script>
        <script>
 
            let amount = <?php echo $_SESSION['amount_']; ?>/1000000000000000000;
            if($_SESSION['decimal'] == true){
                amount /= 2;
            }
            document.getElementById('bnb_claim').innerHTML = amount.toString().concat(" BNB");

            if(<?php echo $_SESSION['bool']; ?> == true){
                document.getElementById('exito').innerHTML = 'Congratulations!';
            }else{
                document.getElementById('exito').innerHTML = 'You almost got it!';
            }

            async function pago() { //Pago

                const account = await getCurrentAccount();
                await window.contract.methods.pago(account, amount, <?php echo $_SESSION['bool']; ?>).send({ from: account });
                document.getElementById('bnb_claim').innerHTML = "0 BNB";

            }

        </script>
    </head>
    <body>
    
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
            <span id="resumen" class="tutorial">Multiply your investment when opening the lock, if you hit the letter it is marked yellow and if you hit<br> the letter and position in green, mark all in green to win. Good luck!</span>
        </header>

        <main id="main3" style="text-align: center;">
            <ul style="margin-left: auto; margin-right: auto; width: 35%; text-align: center; padding:0; padding-top: 1vh;">
                <li id="exito" class="li-reward" style="font-size: 55px;">Congratulations!</li>
                <li class="li-reward">Claim your reward</li>
                <li class="li-reward">
                    <span class="bnb" id="bnb_claim">0 BNB</span>
                    <button class="pay" onclick="pago()">Claim</button>
                </li>
                <li class="li-reward">Another try?</li>
                <li class="li-reward"><button class="pay" onclick="redirect('index')">Go</button></li>
                <li class="li-reward">Share your game on social networks.</li>
                <li class="li-reward">
                    <img src="https://img.icons8.com/fluency/48/000000/facebook.png"/>
                    <img src="https://img.icons8.com/fluency/48/000000/instagram-new.png"/>
                    <img src="https://img.icons8.com/fluency/48/000000/twitter.png"/>
                    <img src="https://img.icons8.com/fluency/50/000000/whatsapp.png"/>
                    <img src="https://img.icons8.com/fluency/50/000000/reddit.png"/>
                </li>
            </ul>
        </main>
    </body>
</html>