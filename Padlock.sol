// SPDX-License-Identifier: GPL-3.0

pragma solidity >=0.7.0 <0.9.0;

contract Padlock {

    address private owner;

    string[] private abc = ['Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','-','Z','X','C','V','B','N','M'];


    struct User{
        uint amount;
        string lock;
    }

    mapping(address => User) private users;

    modifier isOwner(){
        require(msg.sender == owner, "Unauthorized access");
        _;
    }

    constructor() payable{

        owner = msg.sender;
    }

    // Game Functions

    /*
    *   Invest BNB
    */

    function bet() payable external{

        uint amount_1percent = msg.value%100;
        uint amount = msg.value - amount_1percent;

        payable(owner).transfer(amount_1percent);

        users[msg.sender].amount = amount;
        users[msg.sender].lock = string(abi.encodePacked(abc[makeRandomnum(0)], abc[makeRandomnum(1)], abc[makeRandomnum(2)], abc[makeRandomnum(3)], abc[makeRandomnum(4)]));

    }

    /*
    *   @user recibe la address a la que enviar el pago
    *   @x recibe el numero a multiplicar
    */

    function pago(address payable user_, uint x, bool decimal) external{
        require(x == 0 || x == 1 || x == 2 || x == 4 || x == 10 || x == 50 || x == 100, "Unauthorized access");
        if(decimal == true && x == 1){
            user_.transfer((users[msg.sender].amount/2)*x);
        }else{
            user_.transfer(users[msg.sender].amount*x);
        }
        users[msg.sender].amount = 0;
    }

    function comprobarLinea(string[] memory wordNums) external view returns(string[] memory){
        // Green = 2, Yellow = 1, Gray = 0;
      
            for(uint i=0; i<5; i++){
                wordNums[i] = comprobarLetra(wordNums[i], i);
            }
    
        return wordNums;
    }

    function comprobarLetra(string memory wordNums, uint x) private view returns(string memory){
        for(uint i=0; i<5; i++){
            if( stringsEquals(  substring(users[msg.sender].lock, x, (x+1)), wordNums   ) ){
                return "2";
            }else{
                for(uint j=0; j<5; j++){
                    if( stringsEquals(  substring(users[msg.sender].lock, j, (j+1)), wordNums  )   ){
                        return "1";
                    }
                }
            }
        }
        return "0";
    }

    function makeRandomnum(uint randomix) private view returns(uint256){
        return uint(keccak256(abi.encodePacked(randomix, msg.sender, address(this), block.timestamp, block.gaslimit, block.number, block.coinbase)))%27;
    }

    // User Functions

    function getUserAmount() external view returns(uint){
        return users[msg.sender].amount;
    }

    function migrateContract(address payable contrato) external isOwner{// It is used in case you need to migrate the funds to a new contract
        contrato.transfer(address(this).balance);
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

}
