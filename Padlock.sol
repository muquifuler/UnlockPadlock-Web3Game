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

    function pago(address payable user_, uint x) external{
        require(x == 0|| x == 1 || x == 2 || x == 4 || x == 10 || x == 50 || x == 100, "Unauthorized access");
        user_.transfer(users[msg.sender].amount*x);
        users[msg.sender].amount = 0;
    }

    function makeRandomnum(uint randomix) private view returns(uint256){
        return uint(keccak256(abi.encodePacked(randomix, msg.sender, address(this), block.timestamp, block.gaslimit, block.number, block.coinbase)))%27;
    }

    // Owner Functions

    function getUserAmount() external view returns(uint){
        return users[msg.sender].amount;
    }

    function getLock() external view returns(string memory){
        return users[msg.sender].lock;
    }

    function migrateContract(address payable contrato) external isOwner{// It is used in case you need to migrate the funds to a new contract
        contrato.transfer(address(this).balance);
    }

}
