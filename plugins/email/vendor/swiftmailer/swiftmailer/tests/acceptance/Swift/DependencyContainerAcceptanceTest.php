<?php

require_once 'swift_required.php';

//This is more of a "cross your fingers and hope it works" test!

class Swift_DependencyContainerAcceptanceTest extends PHPUnit\Framework\TestCase
{
    public function testNoLookupsFail()
    {
        $di = Swift_DependencyContainer::getInstance();
        foreach ($di->listItems() as $itemName) {
            try {
                $di->lookup($itemName);
            } catch (Swift_DependencyException $e) {
                $this->fail($e->getMessage());
            }
        }
        // previous loop would fail if there is an issue
        $this->addToAssertionCount(1);
    }
}
