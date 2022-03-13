

let try_ = ['','','','',''];
let abc = ['Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','-','Z','X','C','V','B','N','M'];

let v = 1;
let delete_k;
let btn_play = true;

let active_game = false;

let pgo = 0;

function write_(letra){
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

function play_(){
    document.getElementById('main3').style = 'display: none;';
    document.getElementById('main1').style = 'display: none;';
    document.getElementById('footer1').style = 'display: none;';
    document.getElementById('resumen').style = 'display: none;';
    document.getElementById('main2').style = 'display: flex;';
    clean();
}

function fin(exito, bnb){

    document.getElementById('main1').style = 'display: none;';
    document.getElementById('main2').style = 'display: none;';
    document.getElementById('footer1').style = 'display: none;';
    document.getElementById('resumen').style = 'display: none;';
    document.getElementById('main3').style = 'display: block;';
    let amount = bnb/1000000000000000000;
    document.getElementById('bnb_claim').innerHTML = amount.toString().concat(" BNB");

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

function redirect(where){
    if(where == 'twitter'){
        window.location.href = "https://twitter.com/auto_token";
    }else if(where == 'whitepaper'){
        window.location.href = "https://unlockpadlock.gitbook.io/unlock-padlock/";
    }
}

// ---------- Web3

window.addEventListener('load', function() {
    if(ethereum.selectedAddress){
        document.getElementById('walllet').innerHTML = ethereum.selectedAddress;
        document.getElementById('buy1').style = 'display:;';
        document.getElementById('buy2').style = 'display:;';
        document.getElementById('connect').style = 'display:none;';
    }else{
        document.getElementById('walllet').innerHTML = '';
        document.getElementById('connect').style = 'display:;';
    }

})

async function Connect(){
//0x38
    if(window.ethereum.chainId=='0x61'){
        if(ethereum.selectedAddress){
            cambioWallet();
        }else{
            await window.ethereum.enable();
            web3 = new Web3(window.ethereum);
            cambioWallet();
        }
    }else if(window.ethereum.chainId){
        alert(window.ethereum.chainId);
    }else{
        await window.ethereum.enable();
        web3 = new Web3(window.ethereum);
        cambioWallet();
    }
    
    return ethereum.selectedAddress;
}

function cambioWallet(){
    document.getElementById('walllet').innerHTML = ethereum.selectedAddress;
    document.getElementById('connect').style = 'display:none;';
    document.getElementById('buy1').style = 'display:;';
    document.getElementById('buy2').style = 'display:;';
}

const ABI = [
	{
		"inputs": [],
		"stateMutability": "payable",
		"type": "constructor"
	},
	{
		"inputs": [],
		"name": "bet",
		"outputs": [],
		"stateMutability": "payable",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "getLock",
		"outputs": [
			{
				"internalType": "string",
				"name": "",
				"type": "string"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [],
		"name": "getUserAmount",
		"outputs": [
			{
				"internalType": "uint256",
				"name": "",
				"type": "uint256"
			}
		],
		"stateMutability": "view",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address payable",
				"name": "contrato",
				"type": "address"
			}
		],
		"name": "migrateContract",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"inputs": [
			{
				"internalType": "address payable",
				"name": "user_",
				"type": "address"
			},
			{
				"internalType": "uint256",
				"name": "x",
				"type": "uint256"
			}
		],
		"name": "pago",
		"outputs": [],
		"stateMutability": "nonpayable",
		"type": "function"
	}
];
            const contractAddress = '0x7607633a26aaBC427f9197b0FDEECFcAC724Fdf3';
            
            async function loadContract() {
                var MyContract = new window.web3.eth.Contract(ABI, contractAddress);
                return await MyContract;//new window.web3.eth.Contract(ABI, contractAddress);
            }
            async function loadWeb3() {
                if (window.ethereum) {
                    window.web3 = new Web3(window.ethereum);
                    window.ethereum.enable();
                }
            }

            async function load() {
                await loadWeb3();
                window.contract = await loadContract();
                var account = await window.web3.eth.getAccounts();
            }
/*
                function updateStatus(status) {
                    const statusEl = document.getElementById('status');
                    statusEl.innerHTML = status;
                    console.log(status);
                }*/

            load();
            async function getCurrentAccount() {
                const accounts = await window.web3.eth.getAccounts();
                return accounts[0];
            }
/*
var myContract = new web3.eth.Contract(ABI, '0x8d557f858afAb0822a6745BCdC37c3d843B5C6DF');



    myContract.methods.getMiBeneficioBomb().call()
        .then(console.log);console.log(1);
*/  
                async function bet() { // Bet
                        const cant = document.getElementById('buy1').value;
                        const cant_ = cant * 1000000000000000000;
                        if(cant_ >= 10000000000000000 && cant_ <= 150000000000000000){
                            const account = await getCurrentAccount();
                            await window.contract.methods.bet().send({ from: account, value: cant_});
                            alert(cant_);
                            newGame();
                        }else{
                            alert("Cantidad erronea");
                        }
                }

                async function pago() { //Pago
                        const account = await getCurrentAccount();
                        await window.contract.methods.pago(account, pgo).send({ from: account });
                        document.getElementById('bnb_claim').innerHTML = "0 BNB";
                }

                async function comprobarLinea() { //Comprobar
                        pgo = 0;
                        if(try_[0] == '' || try_[1] == '' || try_[2] == '' || try_[3] == '' || try_[4] == ''){
                            // Faltan letras
                        }else{
                            let x = 1;

                            for(let i=0; i<try_.length; i++){
                                try_[i] = SHA256.generate(try_[i]);
                            }

                            for(let i=0; i<try_.length; i++){

                                let w = await getLock();

                                if(w[i] == try_[i]){
                                    document.getElementById('try'.concat(x).concat(v)).style = 'background-color:#67b956; border: solid 2px #67b956;';
                                }else{
                                    document.getElementById('try'.concat(x).concat(v)).style = 'background-color:#212121; border: solid 2px #212121;';
                                    for(let j=0; j<try_.length; j++){
                                        if(try_[i] == w[j]){
                                            document.getElementById('try'.concat(x).concat(v)).style = 'background-color:#d4d668; border: solid 2px #d4d668;';
                                        }
                                    }
                                }

                                if((try_[0] == w[0] && try_[1] == w[1] && try_[2] == w[2] && try_[3] == w[3] && try_[4] == w[4])==true){

                                    if(v == 1){
                                        pgo = 100; 
                                    }else if(v == 2){
                                        pgo = 50;
                                    }else if(v == 3){
                                        pgo = 10;
                                    }else if(v == 4){
                                        pgo = 4;
                                    }else if(v == 5){
                                        pgo = 2;
                                    }else if(v == 6){
                                        pgo = 1;
                                    }

                                    const account = await getCurrentAccount();
                                    const amount = await window.contract.methods.getUserAmount().call({ from: account });
                                    amount_ = amount*pgo;

                                    setTimeout(function(){
                                        fin(true, amount_);
                                    },3000);
                                    break;
                                    // Juego ganado
                                }else{
                                    if(v == 6 && i == 4){

                                        setTimeout(function(){
                                            fin(false, 0);
                                        },3000);

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

                async function getLock(){
                    const account = await getCurrentAccount();
                    const coolNumber = await window.contract.methods.getLock().call({ from: account });
                    let array = [];
                    for(let i=0; i<5; i++){
                        array[i] = SHA256.generate(coolNumber.substring(i, (i+1)));
                    }
                    return array;
                }
