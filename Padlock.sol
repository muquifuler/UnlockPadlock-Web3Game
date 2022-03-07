// SPDX-License-Identifier: GPL-3.0

pragma solidity >=0.7.0 <0.9.0;

contract Padlock {

    address private owner;

    bool game=false;

    string private wordLock;
    string private word;
    string[] private abc = ['Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','-','Z','X','C','V','B','N','M'];

    event receive_(address from, address to, uint amount);

    mapping(address => uint) users;

    modifier isOwner(){
        require(msg.sender == owner, "Unauthorized access");
        _;
    }

    constructor() payable{

        owner = msg.sender;

    }
    
    // Game Functions

    function apuesta(uint amount) payable external{
        require(amount >= 1000000 && amount <= 5000000000 && game == false, "Incorrect amount");
        uint amount_1percent = amount%100;
        payable(owner).transfer(amount_1percent);
        amount -= amount_1percent;
        users[msg.sender] = amount;
        wordLock = generateWord();
        game = true;
    }

    /*
    *   @user recibe la addres a la que enviar el pago
    *   @x recibe el numero a multiplicar
    */

    function pago(address payable user, uint x) external{
        require(game == true && (x == 0|| x == 1 || x == 2 || x == 4 || x == 10 || x == 50 || x == 100) , "Unauthorized access");
        user.transfer(users[msg.sender]*x);
        users[msg.sender] = 0;
        game = false;
    }

    // Settings Functions

    function stringsEquals(string memory s1, string memory s2) private pure returns (bool) {
        bytes memory b1 = bytes(s1);
        bytes memory b2 = bytes(s2);
        uint256 l1 = b1.length;
        if (l1 != b2.length) return false;
        for (uint256 i=0; i<l1; i++) {
            if (b1[i] != b2[i]) return false;
        }
        return true;
    }

    function substring(string memory str, uint startIndex, uint endIndex) private pure returns (string memory) {

        bytes memory strBytes = bytes(str);
        bytes memory result = new bytes(endIndex-startIndex);

        for(uint i = startIndex; i < endIndex; i++) {
            result[i-startIndex] = strBytes[i];
        }

        return string(result);
    }

    function comprobarLinea(string memory word_) external view returns(string memory){
        // Green = 2, Yellow = 1, Gray = 0;

        string[] memory wordNums;

        if(stringsEquals(word_, wordLock)){

            for(uint i=0; i<5; i++){
                wordNums[i] = "2";
            }

        }else{
            string[] memory word_Array;
            string[] memory wordLock_Array;

            for(uint i=0; i<5; i++){
                word_Array[i] = substring(word_, i, (i+1));
                wordLock_Array[i] = substring(wordLock, i, (i+1));

                if(stringsEquals(word_Array[i], wordLock_Array[i])){
                    wordNums[i] = "2";
                }else{
                    wordNums[i] = "0";
                    for(uint j=0; j<5; j++){
                        if(stringsEquals(word_Array[i], wordLock_Array[j])){
                            wordNums[i] = "1";
                        }
                    }
                }
            }
        }
        return string(abi.encodePacked(wordNums[0], wordNums[1], wordNums[2], wordNums[3], wordNums[4]));
    }

    function makeRandomnum() private view returns(uint256){
        return uint(keccak256(abi.encodePacked(block.difficulty, msg.sender, address(this), block.timestamp, block.gaslimit, block.number, block.coinbase)))%100;
    }

    function generateWord() private view returns (string memory){

            string[] memory wordLock_;

            for(uint i=0; i<5; i++){
                uint numRandom = makeRandomnum();
                wordLock_[i] = abc[numRandom];
            }
        
        return string(abi.encodePacked(wordLock_[0], wordLock_[1], wordLock_[2], wordLock_[3], wordLock_[4]));
    }

    // Owner Functions

    function withdraw(address payable owner_, uint x) external isOwner{
        owner_.transfer(x);
    }

    function getAmount() external view isOwner returns(uint x){
        return address(this).balance;
    }

}
