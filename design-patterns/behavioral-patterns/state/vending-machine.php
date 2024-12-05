<?php
/*
 * Project: state
 * File: /vending-machine.php
 * File Created: 2024-12-05, 10:15:44
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-12-05, 11:37:49
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

// 1. Interfejs dla stanu
interface VendingMachineState {
    public function insertCoin(): string;
    public function pressButton(): string;
    public function dispense(): string;
}

// 2. Klasy reprezentujące różne stany automatu
class ReadyState implements VendingMachineState 
{
    private VendingMachine $machine;

    public function __construct(VendingMachine $machine) {
        $this->machine = $machine;
    }

    public function insertCoin(): string {
        $this->machine->setState($this->machine->getHasCoinState());
        return "Moneta przyjęta.\n";
    }

    public function pressButton(): string {
        return "Nie można nacisnąć przycisku bez monety.\n";
    }

    public function dispense(): string {
        return "Najpierw włóż monetę.\n";
    }
}

class HasCoinState implements VendingMachineState 
{
    private VendingMachine $machine;

    public function __construct(VendingMachine $machine) {
        $this->machine = $machine;
    }

    public function insertCoin(): string {
        return "Moneta została już przyjęta.\n";
    }

    public function pressButton(): string {
         $this->machine->setState($this->machine->getSoldState());
        return "Przycisk naciśnięty. Wydawanie produktu...\n";
    }

    public function dispense(): string {
        return "Naciśnij przycisk, aby otrzymać produkt.\n";
    }
}

class SoldState implements VendingMachineState
{
    private VendingMachine $machine;


    public function __construct(VendingMachine $machine) 
    {
        $this->machine = $machine;
    }

    public function insertCoin(): string {
        return "Proszę czekać na zakończenie poprzedniej transakcji.\n";
    }

    public function pressButton(): string {
        return "Produkt już wydany. Poczekaj chwilę.\n";
    }

    public function dispense(): string {
        $this->machine->setState($this->machine->getReadyState());
        return "Produkt wydany. Przełączenie na stan gotowy.\n";
    }
}

// 3. Klasa VendingMachine, która przechowuje aktualny stan
class VendingMachine 
{
    private $readyState;
    private $hasCoinState;
    private $soldState;
    private $currentState;

    public function __construct() {
        $this->readyState = new ReadyState($this);
        $this->hasCoinState = new HasCoinState($this);
        $this->soldState = new SoldState($this);
        $this->currentState = $this->readyState;
    }

    public function setState(VendingMachineState $state) {
        $this->currentState = $state;
    }

    public function getReadyState() {
        return $this->readyState;
    }

    public function getHasCoinState() {
        return $this->hasCoinState;
    }

    public function getSoldState() {
        return $this->soldState;
    }

    public function insertCoin() {
        $this->currentState->insertCoin();
    }

    public function pressButton() {
        $this->currentState->pressButton();
    }

    public function dispense() {
        $this->currentState->dispense();
    }
}

// 4. Przykładowe użycie
$machine = new VendingMachine();

$machine->insertCoin();   // Moneta przyjęta.
$machine->pressButton();  // Przycisk naciśnięty. Wydawanie produktu...
$machine->dispense();     // Produkt wydany. Przełączenie na stan gotowy.
