<?php
/*
 * Project: state
 * File: /order-status.php
 * File Created: 2024-12-05, 11:35:50
 * Author: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Last Modified: 2024-12-05, 20:51:45
 * Modified By: Wojciech Sobczak (wsobczak@gmail.com)
 * -----
 * Copyright © 2021 - 2024 by vbert
 */

// 1. Interfejs stanu zamówienia
interface OrderState {
    public function proceedToNext(Order $order): string;
    public function cancel(Order $order): string;
    public function getStatus(): string;
}

// 2. Klasy reprezentujące różne stany zamówienia
class NewOrderState implements OrderState 
{
    public function proceedToNext(Order $order): string {
        $order->setState(new ProcessingOrderState());
        return "Zamówienie jest teraz przetwarzane.\n";
    }

    public function cancel(Order $order): string {
        $order->setState(new CancelledOrderState());
        return "Anulowanie nowego zamówienia.\n";
    }

    public function getStatus(): string {
        return "Nowe";
    }
}

class ProcessingOrderState implements OrderState 
{
    public function proceedToNext(Order $order): string {
         $order->setState(new CompletedOrderState());
         return "Zamówienie zostało zrealizowane.\n";
    }

    public function cancel(Order $order): string {
        return "Nie można anulować zamówienia w trakcie przetwarzania.\n";
    }

    public function getStatus(): string {
        return "Przetwarzane";
    }
}

class CompletedOrderState implements OrderState 
{
    public function proceedToNext(Order $order): string {
        return "Zamówienie zostało już zrealizowane. Dalsze działania są zbędne.\n";
    }

    public function cancel(Order $order): string {
        return "Nie można anulować zamówienia, które zostało zrealizowane.\n";
    }

    public function getStatus(): string {
        return "Zrealizowane";
    }
}

class CancelledOrderState implements OrderState 
{
    public function proceedToNext(Order $order): string {
        return "Zamówienie jest anulowane. Nie można przejść do kolejnych kroków.\n";
    }

    public function cancel(Order $order): string {
        return "Zamówienie jest już anulowane.\n";
    }

    public function getStatus(): string {
        return "Anulowane";
    }
}

// 3. Klasa Order, która przechowuje aktualny stan zamówienia
class Order 
{
    private OrderState $state;

    // Domyślny stan nowego zamówienia
    public function __construct(OrderState $state) {
        $this->state = $state;
    }

    public function setState(OrderState $state) {
        $this->state = $state;
    }

    public function proceedToNext() {
        $this->state->proceedToNext($this);
    }

    public function cancel() {
        $this->state->cancel($this);
    }

    public function getStatus(): string {
        return $this->state->getStatus();
    }
}

// 4. Przykładowe użycie
$newOrderState = new NewOrderState();
$order = new Order($newOrderState);
echo "Aktualny stan zamówienia: " . $order->getStatus() . "\n"; // Nowe
$order->proceedToNext();                                        // Przejście do przetwarzania
echo "Aktualny stan zamówienia: " . $order->getStatus() . "\n"; // Przetwarzane
$order->proceedToNext();                                        // Przejście do zrealizowania
echo "Aktualny stan zamówienia: " . $order->getStatus() . "\n"; // Zrealizowane
$order->cancel();                                               // Próbujemy anulować zrealizowane zamówienie
